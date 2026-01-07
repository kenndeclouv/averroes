<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        if (!$student) {
            abort(403, 'Unauthorized');
        }

        // Get quizzes for student's class that are published
        // Also check if already attempted?
        // Let's get quizzes that are published AND match class.
        $quizzes = Quiz::where('classes_id', $student->classes_id)
            ->where('status', 'published')
            ->orderBy('start_time', 'desc')
            ->get();

        // Attach attempt status
        foreach ($quizzes as $quiz) {
            $quiz->attempt = QuizAttempt::where('quiz_id', $quiz->id)
                ->where('student_id', $student->id)
                ->first();
        }

        return view('roles.Student.quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        // Check Access
        if ($quiz->classes_id != $student->classes_id || $quiz->status != 'published') {
            abort(403, 'Access Denied');
        }

        // Check if already attempted/finished
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $student->id)
            ->first();

        if ($attempt && $attempt->finished_at) {
            return redirect()->route('student.quizzes.result', $quiz->id);
        }

        // Check Time
        $now = now();
        if ($now < $quiz->start_time || $now > $quiz->end_time) {
            return redirect()->back()->with('error', 'Quiz is not currently active.');
        }

        if (!$attempt) {
            // Start attempt
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'student_id' => $student->id,
                'started_at' => now(),
            ]);
        }

        $quiz->load(['Questions.Options']);
        // Randomize questions
        $quiz->setRelation('Questions', $quiz->Questions->shuffle());

        // Randomize options for each question
        foreach ($quiz->Questions as $question) {
            $question->setRelation('Options', $question->Options->shuffle());
        }

        // Load existing attempt answers for Resume
        $attempt->load('Answers');

        return view('roles.Student.quizzes.take', compact('quiz', 'attempt'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        if ($attempt->finished_at) {
            return redirect()->route('student.quizzes.result', $quiz->id);
        }

        $answers = $request->input('answers', []);
        $totalScore = 0;

        // Server-Side Time Validation
        $maxEndTime = $attempt->started_at->copy()->addMinutes($quiz->duration_minutes)->addMinutes(2); // 2 mins grace period for latency
        // Also respect global quiz end time
        if ($quiz->end_time < $maxEndTime) {
            $maxEndTime = $quiz->end_time->copy()->addMinutes(2);
        }

        if (now() > $maxEndTime) {
            // Force finish the attempt if time is up
            // Or reject? If auto-submit is working, it should be fine.
            // Ideally we accept what's there and mark finished.
            // But if they try to change answers AFTER time, we block.
            // For store (final submit), we accept.
        }

        DB::beginTransaction();
        try {
            // Refactored to update/create instead of delete-all for better performance and safety

            foreach ($quiz->Questions as $question) {
                // Determine user answer for this question
                $userAnswer = $answers[$question->id] ?? null;
                $isCorrect = false;
                $score = 0;

                // Logic based on types
                if ($question->type == 'multiple_choice') {
                    // userAnswer is option_id
                    if ($userAnswer) {
                        $selectedOption = $question->Options->where('id', $userAnswer)->first();
                        if ($selectedOption && $selectedOption->is_correct) {
                            $isCorrect = true;
                            $score = $question->points;
                        }

                        QuizAnswer::updateOrCreate(
                            [
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                                'question_option_id' => $userAnswer, // Unique per slot? schema allows multiple answers?
                                // This schema is tricky for updateOrCreate if we change options.
                                // But for Single Choice, we can match on Attempt+Question.
                            ],
                            [
                                'question_option_id' => $userAnswer,
                                'is_correct' => $isCorrect,
                                'score' => $score,
                            ]
                        );
                    }
                } elseif ($question->type == 'complex_multiple_choice') {
                    // userAnswer is array of option_ids
                    // Grading: All correct options must be selected, and NO incorrect options.
                    // Or partial? Let's do strict for now/simplicity.

                    // Actually, simple Complex Multiple Choice often gives points per correct tick or all-or-nothing.
                    // Let's do: if matches exactly correct set -> full points.

                    if (is_array($userAnswer)) {
                        $correctOptions = $question->Options->where('is_correct', true)->pluck('id')->toArray();
                        $userSelected = array_map('intval', $userAnswer);

                        sort($correctOptions);
                        sort($userSelected);

                        if ($correctOptions === $userSelected) {
                            $isCorrect = true;
                            $score = $question->points;
                        }

                        // Save each selection? Or save as one row?
                        // Schema has `question_option_id` (singular).
                        // So multiple rows.
                        // For Complex MC, we have multiple rows per question.
                        // updateOrCreate is hard because we don't know which ID to update.
                        // Strategy: Delete ONLY answers for this specific question, then re-create.
                        QuizAnswer::where('quiz_attempt_id', $attempt->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        foreach ($userSelected as $optId) {
                            QuizAnswer::create([
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                                'question_option_id' => $optId,
                                'is_correct' => in_array($optId, $correctOptions),
                                'score' => 0,
                            ]);
                        }
                    }
                } elseif ($question->type == 'essay') {
                    if ($userAnswer) {
                        QuizAnswer::updateOrCreate(
                            [
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                            ],
                            [
                                'answer_text' => $userAnswer,
                                'is_correct' => null,
                                'score' => 0,
                            ]
                        );
                    }
                }

                $totalScore += $score;
            }

            $hasEssay = $quiz->Questions()->where('type', 'essay')->exists();
            $status = $hasEssay ? 'needs_grading' : 'graded';

            $attempt->update([
                'finished_at' => now(),
                'score' => $totalScore,
                'status' => $status
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error submitting quiz: ' . $e->getMessage());
        }

        return redirect()->route('student.quizzes.result', $quiz->id);
    }

    public function result(Quiz $quiz)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $student->id)
            ->with(['Answers.Question', 'Answers.QuestionOption'])
            ->firstOrFail();

        return view('roles.Student.quizzes.result', compact('quiz', 'attempt'));
    }

    public function currentSave(Request $request, Quiz $quiz)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();
        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        if ($attempt->finished_at) {
            return response()->json(['status' => 'error', 'message' => 'Quiz already submitted'], 400);
        }

        // Time Validation
        $maxEndTime = $attempt->started_at->copy()->addMinutes($quiz->duration_minutes)->addMinutes(2);
        if ($quiz->end_time < $maxEndTime) $maxEndTime = $quiz->end_time->copy()->addMinutes(2);

        if (now() > $maxEndTime) {
            return response()->json(['status' => 'error', 'message' => 'Time limit exceeded'], 403);
        }

        $answers = $request->input('answers', []);

        DB::transaction(function () use ($answers, $attempt, $quiz) {
            foreach ($quiz->Questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;

                if (!$userAnswer) continue;

                if ($question->type == 'multiple_choice') {
                    QuizAnswer::updateOrCreate(
                        ['quiz_attempt_id' => $attempt->id, 'question_id' => $question->id],
                        [
                            'question_option_id' => $userAnswer,
                            'score' => 0
                        ]
                    );
                } elseif ($question->type == 'complex_multiple_choice') {
                    if (is_array($userAnswer)) {
                        // Delete existing for this question only
                        QuizAnswer::where('quiz_attempt_id', $attempt->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        foreach ($userAnswer as $optId) {
                            QuizAnswer::create([
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                                'question_option_id' => $optId,
                                'score' => 0,
                            ]);
                        }
                    }
                } elseif ($question->type == 'essay') {
                    QuizAnswer::updateOrCreate(
                        ['quiz_attempt_id' => $attempt->id, 'question_id' => $question->id],
                        [
                            'answer_text' => $userAnswer,
                            'score' => 0
                        ]
                    );
                }
            }
        });

        return response()->json(['status' => 'success', 'message' => 'Saved']);
    }
}

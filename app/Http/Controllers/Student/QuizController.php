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
                                // For Single Choice, we match Attempt+Question.
                                // We do NOT include option_id here, otherwise it creates new rows for new choices.
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
                    if (is_array($userAnswer)) {
                        $correctOptions = $question->Options->where('is_correct', true)->pluck('id')->toArray();
                        $userSelected = array_map('intval', $userAnswer);

                        sort($correctOptions);
                        sort($userSelected);

                        // Strict grading: Exact match required for points
                        if ($correctOptions === $userSelected) {
                            $isCorrect = true;
                            $score = $question->points;
                        }

                        // Delete existing for this question
                        QuizAnswer::where('quiz_attempt_id', $attempt->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        // Save new selections
                        foreach ($userSelected as $optId) {
                            // Check if this specific option is correct (for detail view)
                            $thisOptionCorrect = in_array($optId, $correctOptions);

                            QuizAnswer::create([
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                                'question_option_id' => $optId,
                                'is_correct' => $thisOptionCorrect, // Save individual correctness
                                'score' => 0, // Score is usually total per question, not per option in this schema?
                                // Schema has 'score' column. If we split points, do it here.
                                // But logic above calc total score for question.
                                // Let's store 0 here and maybe store total score in first record?
                                // Or just Attempt score is enough.
                                // But Teacher view might look at Answer->score.
                            ]);
                        }
                        // If strict grading, add score to total.
                        // But we didn't save score in DB rows above.
                        // Let's UPDATE the first row with the score if needed, or rely on Attempt Score.
                        // Teacher View uses $answer->score.
                        // So we should distribute or assign score.
                        // Assigning to all? Or just first?
                        // Let's assign to first.
                        $firstAns = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                            ->where('question_id', $question->id)
                            ->first();
                        if ($firstAns && $isCorrect) {
                            $firstAns->update(['score' => $score]);
                        }
                    }
                } elseif ($question->type == 'true_false') {
                    // Similar to multiple_choice
                    if ($userAnswer) {
                        $selectedOption = $question->Options->where('id', $userAnswer)->first();
                        if ($selectedOption && $selectedOption->is_correct) {
                            $isCorrect = true;
                            $score = $question->points;
                        }

                        QuizAnswer::updateOrCreate(
                            ['quiz_attempt_id' => $attempt->id, 'question_id' => $question->id],
                            [
                                'question_option_id' => $userAnswer,
                                'is_correct' => $isCorrect,
                                'score' => $score,
                            ]
                        );
                    }
                } elseif ($question->type == 'short_answer') {
                    if ($userAnswer) {
                        // Check against any option that is marked correct (or all provided options)
                        // Case insensitive comparison
                        $isCorrect = $question->Options->contains(function ($opt) use ($userAnswer) {
                            return strcasecmp(trim($opt->option_text), trim($userAnswer)) === 0;
                        });

                        if ($isCorrect) {
                            $score = $question->points;
                        }

                        QuizAnswer::updateOrCreate(
                            ['quiz_attempt_id' => $attempt->id, 'question_id' => $question->id],
                            [
                                'answer_text' => $userAnswer,
                                'is_correct' => $isCorrect,
                                'score' => $score,
                            ]
                        );
                    }
                } elseif ($question->type == 'matching') {
                    // userAnswer expected to be array [option_id => matched_value_string/id]
                    if (is_array($userAnswer)) {
                        $correctPairsCount = 0;
                        $totalPairs = $question->Options->count();

                        // Delete previous answers to handle re-submission strictly?
                        // Or updateOrCreate per pair?
                        // Schema limitation: QuizAnswer has ONE question_option_id per row?
                        // Or we need multiple rows for matching?
                        // Yes, one row per pair connection.

                        // First clean up old answers for this question
                        QuizAnswer::where('quiz_attempt_id', $attempt->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        $firstAnswerId = null;
                        foreach ($userAnswer as $optId => $matchValue) {
                            $option = $question->Options->where('id', $optId)->first();
                            if ($option) {
                                $pairCorrect = ($option->matched_pair == $matchValue);
                                if ($pairCorrect) $correctPairsCount++;

                                $ans = QuizAnswer::create([
                                    'quiz_attempt_id' => $attempt->id,
                                    'question_id' => $question->id,
                                    'question_option_id' => $optId, // Left side
                                    'answer_text' => $matchValue,   // Right side (selected)
                                    'is_correct' => $pairCorrect,
                                    'score' => 0
                                ]);

                                if (!$firstAnswerId) $firstAnswerId = $ans->id;
                            }
                        }

                        // Calculate score: Proportional or All-or-Nothing?
                        // Usually proportional for Matching.
                        if ($totalPairs > 0) {
                            $score = ($correctPairsCount / $totalPairs) * $question->points;
                        }


                        // Assign score to first answer row so sum() works
                        if ($firstAnswerId && $score > 0) {
                            QuizAnswer::where('id', $firstAnswerId)->update(['score' => $score]);
                        }

                        // Update score on the first answer row or handle it in total calc
                        // Since we sum $totalScore += $score at loop end, this works for the Attempt total.
                        // But individual Answer rows have 0 score.
                        // Let's rely on Attempt score for now.
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
                                'is_correct' => null, // Needs manual grading
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
                            // We don't calc score in auto-save, we trust store() or leave it 0
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
                } elseif ($question->type == 'true_false') {
                    QuizAnswer::updateOrCreate(
                        ['quiz_attempt_id' => $attempt->id, 'question_id' => $question->id],
                        [
                            'question_option_id' => $userAnswer,
                            'score' => 0
                        ]
                    );
                } elseif ($question->type == 'short_answer') {
                    QuizAnswer::updateOrCreate(
                        ['quiz_attempt_id' => $attempt->id, 'question_id' => $question->id],
                        [
                            'answer_text' => $userAnswer,
                            'score' => 0
                        ]
                    );
                } elseif ($question->type == 'matching') {
                    if (is_array($userAnswer)) {
                        QuizAnswer::where('quiz_attempt_id', $attempt->id)
                            ->where('question_id', $question->id)
                            ->delete();

                        foreach ($userAnswer as $optId => $matchText) {
                            if (empty($matchText)) continue;
                            QuizAnswer::create([
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                                'question_option_id' => $optId,
                                'answer_text' => $matchText,
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

    public function review(Quiz $quiz)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        $attempt = QuizAttempt::where('quiz_id', $quiz->id)
            ->where('student_id', $student->id)
            ->with(['Answers'])
            ->firstOrFail();

        // Only allow review if graded
        if ($attempt->status !== 'graded') {
            return redirect()->route('student.quizzes.result', $quiz->id)->with('error', 'Review not available yet.');
        }

        $quiz->load(['Questions.Options']);

        return view('roles.Student.quizzes.review', compact('quiz', 'attempt'));
    }
}

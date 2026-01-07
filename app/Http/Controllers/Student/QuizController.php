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

        $quiz->load(['Questions' => function ($q) {
            $q->inRandomOrder()->with('Options'); // Randomize questions and options?
        }]);

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

        DB::beginTransaction();
        try {
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

                        QuizAnswer::create([
                            'quiz_attempt_id' => $attempt->id,
                            'question_id' => $question->id,
                            'question_option_id' => $userAnswer,
                            'is_correct' => $isCorrect,
                            'score' => $score,
                        ]);
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
                        foreach ($userSelected as $optId) {
                            QuizAnswer::create([
                                'quiz_attempt_id' => $attempt->id,
                                'question_id' => $question->id,
                                'question_option_id' => $optId,
                                'is_correct' => in_array($optId, $correctOptions), // Mark each individual choice
                                'score' => 0, // We assign score globally to one answer or split it?
                                // This schema design is a bit limited for complex MC grading storage.
                                // Let's store 0 here and maybe update attempt total manually.
                            ]);
                        }
                    }
                } elseif ($question->type == 'essay') {
                    if ($userAnswer) {
                        QuizAnswer::create([
                            'quiz_attempt_id' => $attempt->id,
                            'question_id' => $question->id,
                            'answer_text' => $userAnswer,
                            'is_correct' => null, // Needs manual grading
                            'score' => 0,
                        ]);
                    }
                }

                $totalScore += $score;
            }

            $attempt->update([
                'finished_at' => now(),
                'score' => $totalScore
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
}

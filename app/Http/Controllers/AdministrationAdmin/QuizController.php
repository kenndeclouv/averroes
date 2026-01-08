<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Quiz;
use App\Models\Semester;
use App\Models\Teacher;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = Quiz::with(['Teacher.user', 'Classes', 'Semester']);

        // Filters
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }
        if ($request->filled('classes_id')) {
            $query->where('classes_id', $request->classes_id);
        }

        $quizzes = $query->latest()->get();

        $teachers = Teacher::with('user')->get();
        $semesters = Semester::latest()->get();
        $classes = Classes::all();

        return view('roles.AdministrationAdmin.quizzes.index', compact('quizzes', 'teachers', 'semesters', 'classes'));
    }

    public function show(Quiz $quiz)
    {
        // Reuse results view logic but for admin?
        // Or just basic info? Admins usually want to see results.
        // Let's redirect to a results method similar to Teacher's but without ownership check.
        return $this->results($quiz);
    }

    public function results(Quiz $quiz)
    {
        $quiz->load(['Attempts.Student.User', 'Classes.Students', 'Questions.Answers']);
        $attempts = $quiz->Attempts()->with('Student.User')->orderBy('score', 'desc')->get();

        // Analytics Logic (Simplified copy from TeacherController)
        $analytics = [];
        $totalAttempts = $attempts->count();
        if ($totalAttempts > 0) {
            foreach ($quiz->Questions as $question) {
                $correctCount = 0;
                $totalScoreForQuestion = 0;
                foreach ($attempts as $attempt) {
                    $ans = $attempt->Answers->where('question_id', $question->id)->first();
                    if ($ans && $ans->is_correct) {
                        $correctCount++;
                    }
                    if ($ans) $totalScoreForQuestion += $ans->score;
                }
                $difficultyIndex = $correctCount / $totalAttempts * 100;
                $avgScore = $totalScoreForQuestion / $totalAttempts;
                if ($question->type == 'essay') {
                    $difficultyIndex = ($avgScore / $question->points) * 100;
                }
                $analytics[] = [
                    'question_id' => $question->id,
                    'content' => $question->content,
                    'type' => $question->type,
                    'correct_count' => $correctCount,
                    'difficulty_index' => round($difficultyIndex, 1),
                    'avg_score' => round($avgScore, 1),
                ];
            }
        }

        return view('roles.AdministrationAdmin.quizzes.results', compact('quiz', 'attempts', 'analytics'));
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('administrationadmin.quizzes.index')->with('success', 'Admin deleted quiz.');
    }
}

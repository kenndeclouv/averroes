<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Semester;
use App\Models\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            return abort(403, 'Unauthorized');
        }

        $semesters = Semester::latest()->get();
        $query = Quiz::where('teacher_id', $teacher->id)->with(['Classes', 'Semester']);

        if ($request->has('semester_id') && $request->semester_id != '') {
            $query->where('semester_id', $request->semester_id);
        } else {
            // Default to active semester if exists, else show all?
            // Better show all or active. Let's default to active if not filtered?
            // Actually, standard behavior is usually "All" unless filtered.
            // But user said "Ready to use", usually default is active.
            $activeSemester = Semester::active()->first();
            if ($activeSemester) {
                // Optional: Force filter default? Or just highlight?
                // For now let's just show all but allow filter.
            }
        }

        $quizzes = $query->latest()->get();

        return view('roles.Teacher.quizzes.index', compact('quizzes', 'semesters'));
    }

    public function create()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        $classes = Classes::all();
        $semesters = Semester::latest()->get();
        $activeSemester = Semester::active()->first();

        return view('roles.Teacher.quizzes.create', compact('classes', 'semesters', 'activeSemester'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'classes_id' => 'required|exists:classes,id',
            'semester_id' => 'required|exists:semesters,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();

        $quiz = Quiz::create([
            'teacher_id' => $teacher->id,
            'semester_id' => $request->semester_id,
            'classes_id' => $request->classes_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_minutes' => $request->duration_minutes,
            'status' => 'draft',
        ]);

        return redirect()->route('teacher.quizzes.edit', $quiz->id)->with('success', 'Quiz created successfully. Now add questions.');
    }

    public function edit(Quiz $quiz)
    {
        // Authorization check
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        $quiz->load('Questions.Options');
        $classes = Classes::all();
        $semesters = Semester::latest()->get();
        return view('roles.Teacher.quizzes.edit', compact('quiz', 'classes', 'semesters'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        // Authorization check
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'classes_id' => 'required|exists:classes,id',
            'semester_id' => 'required|exists:semesters,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz->update($request->only(['title', 'classes_id', 'semester_id', 'description', 'start_time', 'end_time', 'duration_minutes', 'status']));

        return redirect()->back()->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        $quiz->delete();
        return redirect()->route('teacher.quizzes.index')->with('success', 'Quiz deleted.');
    }

    // Question Management Methods

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        // Validation logic for creating a question
        $request->validate([
            'type' => 'required|in:multiple_choice,complex_multiple_choice,essay',
            'content' => 'required|string',
            'points' => 'required|integer|min:0',
            // Options validation if MC
            'options' => 'required_if:type,multiple_choice,complex_multiple_choice|array',
            'options.*.text' => 'required_with:options|string',
            'options.*.is_correct' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $question = $quiz->Questions()->create([
                'type' => $request->type,
                'content' => $request->input('content'),
                'points' => $request->points,
            ]);

            if (in_array($request->type, ['multiple_choice', 'complex_multiple_choice'])) {
                foreach ($request->options as $optionData) {
                    $question->Options()->create([
                        'option_text' => $optionData['text'],
                        'is_correct' => isset($optionData['is_correct']) ? $optionData['is_correct'] : false,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Question added.');
    }

    public function destroyQuestion(Question $question)
    {
        // Add auth check
        $question->delete();
        return redirect()->back()->with('success', 'Question deleted.');
    }

    public function results(Quiz $quiz)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        $quiz->load(['Attempts.Student.User', 'Classes.Students']);
        $attempts = $quiz->Attempts()->with('Student.User')->orderBy('score', 'desc')->get(); // Added .User for name access

        return view('roles.Teacher.quizzes.results', compact('quiz', 'attempts'));
    }

    public function showAttempt(QuizAttempt $attempt)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        // Check ownership of quiz
        $quiz = $attempt->Quiz;
        if ($quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        $attempt->load(['Answers.Question', 'Answers.QuestionOption', 'Student.User']);

        return view('roles.Teacher.quizzes.show_attempt', compact('attempt', 'quiz'));
    }

    public function gradeAttempt(Request $request, QuizAttempt $attempt)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($attempt->Quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        // We expect scores for essays in request
        // e.g. scores[answer_id] = value
        $scores = $request->input('scores', []);

        DB::transaction(function () use ($scores, $attempt) {
            foreach ($scores as $answerId => $score) {
                // Update answer score
                // Verify answer belongs to attempt?
                $answer = \App\Models\QuizAnswer::where('id', $answerId)->where('quiz_attempt_id', $attempt->id)->first();
                if ($answer) {
                    $answer->update([
                        'score' => $score,
                        'is_correct' => $score > 0 // Logic could be more complex, but fine for now
                    ]);
                }
            }

            // Recalculate total score
            $totalScore = $attempt->Answers()->sum('score');

            $attempt->update([
                'score' => $totalScore,
                'status' => 'graded'
            ]);
        });

        return redirect()->route('teacher.quizzes.results', $attempt->quiz_id)->with('success', 'Nilai berhasil disimpan.');
    }
}

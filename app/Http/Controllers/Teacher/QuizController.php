<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            return abort(403, 'Unauthorized');
        }

        $quizzes = Quiz::where('teacher_id', $teacher->id)->with('Classes')->latest()->get();

        return view('roles.Teacher.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        $classes = Classes::all(); // Or filtered by what teacher teaches if relation exists
        // Filter classes? Teacher has `classes_id` but that might be homeroom.
        // For now, let's assume teacher can assign to any class or use logic.
        // Let's just pass all classes for flexibility for now.

        return view('roles.Teacher.quizzes.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'classes_id' => 'required|exists:classes,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();

        $quiz = Quiz::create([
            'teacher_id' => $teacher->id,
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
        return view('roles.Teacher.quizzes.edit', compact('quiz', 'classes'));
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
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $quiz->update($request->only(['title', 'classes_id', 'description', 'start_time', 'end_time', 'duration_minutes', 'status']));

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

        // Fetch attempts with student info
        // We might want to see all students in the class, even if they haven't taken it.
        // For now, let's just show attempts.
        $quiz->load(['Attempts.Student.User', 'Classes.Students']);

        // Let's get list of students in class to show who hasn't taken it?
        // Optional polish. For now, list attempts.
        $attempts = $quiz->Attempts()->with('Student')->orderBy('score', 'desc')->get();

        return view('roles.Teacher.quizzes.results', compact('quiz', 'attempts'));
    }
}

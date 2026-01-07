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
            'type' => 'required|in:multiple_choice,complex_multiple_choice,essay,true_false,short_answer,matching',
            'content' => 'required|string',
            'points' => 'required|integer|min:0',
            // Options validation
            'options' => 'required_if:type,multiple_choice,complex_multiple_choice,true_false,short_answer,matching|array',
            'options.*.text' => 'required_with:options|string',
            'options.*.matched_pair' => 'required_if:type,matching|string|nullable',
            'options.*.is_correct' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $quiz) {
            $question = $quiz->Questions()->create([
                'type' => $request->type,
                'content' => $request->input('content'),
                'points' => $request->points,
            ]);

            if (in_array($request->type, ['multiple_choice', 'complex_multiple_choice', 'true_false', 'short_answer', 'matching'])) {
                foreach ($request->options as $optionData) {
                    $question->Options()->create([
                        'option_text' => $optionData['text'],
                        'is_correct' => isset($optionData['is_correct']) ? $optionData['is_correct'] : false,
                        'matched_pair' => $optionData['matched_pair'] ?? null,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Question added.');
    }

    public function updateQuestion(Request $request, Quiz $quiz, Question $question)
    {
        // 1. Authorization
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($quiz->teacher_id !== $teacher->id || $question->quiz_id !== $quiz->id) {
            abort(403);
        }

        // 2. Validation
        $request->validate([
            'type' => 'required|in:multiple_choice,complex_multiple_choice,essay,true_false,short_answer,matching',
            'content' => 'required|string',
            'points' => 'required|integer|min:0',
            // Options validation
            'options' => 'required_if:type,multiple_choice,complex_multiple_choice,true_false,short_answer,matching|array',
            'options.*.id' => 'nullable|exists:question_options,id', // Allow ID for update
            'options.*.text' => 'required_with:options|string',
            'options.*.matched_pair' => 'required_if:type,matching|string|nullable',
            'options.*.is_correct' => 'boolean',
        ]);

        DB::transaction(function () use ($request, $question) {
            // 3. Update Question
            $question->update([
                'type' => $request->type,
                'content' => $request->input('content'),
                'points' => $request->points,
            ]);

            // 4. Handle Options
            if (in_array($request->type, ['multiple_choice', 'complex_multiple_choice', 'true_false', 'short_answer', 'matching'])) {
                $submittedOptions = $request->options ?? [];
                $keptOptionIds = [];

                foreach ($submittedOptions as $optionData) {
                    $optionId = $optionData['id'] ?? null;

                    if ($optionId) {
                        // Update existing option
                        $option = $question->Options()->find($optionId);
                        if ($option) {
                            $option->update([
                                'option_text' => $optionData['text'],
                                'is_correct' => isset($optionData['is_correct']) ? $optionData['is_correct'] : false,
                                'matched_pair' => $optionData['matched_pair'] ?? null,
                            ]);
                            $keptOptionIds[] = $optionId;
                        }
                    } else {
                        // Create new option
                        $newOption = $question->Options()->create([
                            'option_text' => $optionData['text'],
                            'is_correct' => isset($optionData['is_correct']) ? $optionData['is_correct'] : false,
                            'matched_pair' => $optionData['matched_pair'] ?? null,
                        ]);
                        $keptOptionIds[] = $newOption->id;
                    }
                }

                // Delete removed options
                // Get all current option IDs belonging to this question
                // and delete those NOT in $keptOptionIds
                $question->Options()->whereNotIn('id', $keptOptionIds)->delete();
            } else {
                // If type is essay, remove all options?
                // Yes, essay has no options.
                $question->Options()->delete();
            }
        });

        return redirect()->back()->with('success', 'Question updated.');
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

        $quiz->load(['Attempts.Student.User', 'Classes.Students', 'Questions.Answers']);
        $attempts = $quiz->Attempts()->with('Student.User')->orderBy('score', 'desc')->get(); // Added .User for name access

        // Analytics Logic
        $analytics = [];
        $totalAttempts = $attempts->count();

        if ($totalAttempts > 0) {
            foreach ($quiz->Questions as $question) {
                // Determine 'correct' count
                // For manual graded (essay), maybe avg score relative to max points?
                // For MC, is_correct count.

                $correctCount = 0;
                $totalScoreForQuestion = 0;

                foreach ($attempts as $attempt) {
                    // This is N+1 if we don't eager load answers properly or loop efficiently.
                    // Better to query Answer model directly or use the relation we loaded.
                    // Let's use relation on $question (inverse) if defined, or $attempt->Answers.
                    // Efficient approach: $question->Answers (if relation exists)
                    // But we haven't defined Question->Answers relation in model yet? Let's check.
                    // If not, we iterate attempts.

                    $ans = $attempt->Answers->where('question_id', $question->id)->first();
                    if ($ans) {
                        if ($ans->is_correct) {
                            $correctCount++;
                        }
                        $totalScoreForQuestion += $ans->score;
                    }
                }

                $difficultyIndex = $correctCount / $totalAttempts * 100; // % Check
                $avgScore = $totalScoreForQuestion / $totalAttempts;

                // For essay, difficulty is AvgScore / MaxPoints * 100
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

        return view('roles.Teacher.quizzes.results', compact('quiz', 'attempts', 'analytics'));
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
        $quiz->load('Questions.Options');

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

    public function resetAttempt(QuizAttempt $attempt)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if ($attempt->Quiz->teacher_id !== $teacher->id) {
            abort(403);
        }

        DB::transaction(function () use ($attempt) {
            // Delete answers first (cascade usually handles this, but robust to be explicit)
            $attempt->Answers()->delete();
            $attempt->delete();
        });

        return redirect()->route('teacher.quizzes.results', $attempt->quiz_id)->with('success', 'Ujian siswa berhasil di-reset. Siswa dapat mengerjakan ulang.');
    }
}

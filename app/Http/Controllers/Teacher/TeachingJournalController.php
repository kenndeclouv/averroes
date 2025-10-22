<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachingJournalController extends Controller
{
    public function index()
    {
        // Ambil teacher_id dari user yang sedang login
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        // Hanya ambil jurnal yang milik teacher ini saja
        $journals = TeachingJournal::with('teacher')
            ->where('teacher_id', $teacher->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('roles.Teacher.journals.index', compact('journals'));
    }

    public function show(TeachingJournal $journal)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        // Cegah akses jurnal milik orang lain
        if ($journal->teacher_id != $teacher->id) {
            abort(403, 'Unauthorized');
        }
        $journal->load('teacher');
        return view('roles.Teacher.journals.show', compact('journal'));
    }

    public function create()
    {
        // Tidak perlu pilih teacher, auto saja
        return view('roles.Teacher.journals.create');
    }

    public function store(Request $request)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
            'date' => 'required|date',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'string|max:255',
            'total_regular_hours' => 'required|integer|min:0',
            'total_replacement_hours' => 'required|integer|min:0',
            'regular_hour_description' => 'required|string',
            'replacement_hour_description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['subjects'] = json_encode($validated['subjects']);
        $validated['teacher_id'] = $teacher->id;  // set otomatis teacher id

        TeachingJournal::create($validated);

        return redirect()
            ->route('teacher.journals.index')
            ->with('success', 'Teaching journal created successfully.');
    }

    public function edit(TeachingJournal $journal)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        if ($journal->teacher_id != $teacher->id) {
            abort(403, 'Unauthorized');
        }

        // Tidak perlu pilihan teachers
        return view('roles.Teacher.journals.edit', compact('journal'));
    }

    public function update(Request $request, TeachingJournal $journal)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        if ($journal->teacher_id != $teacher->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'date' => 'required|date',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'string|max:255',
            'total_regular_hours' => 'required|integer|min:0',
            'total_replacement_hours' => 'required|integer|min:0',
            'regular_hour_description' => 'required|string',
            'replacement_hour_description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['subjects'] = json_encode($validated['subjects']);
        // teacher_id tidak update di sini (tetap yg punya)

        $journal->update($validated);

        return redirect()
            ->route('teacher.journals.index')
            ->with('success', 'Teaching journal updated successfully.');
    }

    public function destroy(TeachingJournal $journal)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        if ($journal->teacher_id != $teacher->id) {
            abort(403, 'Unauthorized');
        }

        $journal->delete();

        return redirect()
            ->route('teacher.journals.index')
            ->with('success', 'Teaching journal deleted successfully.');
    }
}

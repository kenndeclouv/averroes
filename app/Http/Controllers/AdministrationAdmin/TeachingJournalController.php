<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeachingJournal;
use App\Models\TeachingJournalSubject;
use App\Models\TeachingSubject;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeachingJournalController extends Controller
{
    public function index(Request $request)
    {
        $monthYear = $request->input('month');
        if (!$monthYear || !preg_match('/^\d{4}-\d{2}$/', $monthYear)) {
            $monthYear = \Carbon\Carbon::now()->format('Y-m');
        }

        [$year, $month] = explode('-', $monthYear);

        $journals = TeachingJournal::with(['teacher', 'teachingSubjects'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        return view('roles.AdministrationAdmin.journals.index', compact('journals', 'monthYear'));
    }

    public function show(TeachingJournal $journal)
    {
        $journal->load(['teacher', 'teachingSubjects']);
        return view('roles.AdministrationAdmin.journals.show', compact('journal'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $subjects = TeachingSubject::all();
        return view('roles.AdministrationAdmin.journals.create', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:teaching_subjects,id',
            'total_regular_hours' => 'required|integer|min:0',
            'total_replacement_hours' => 'required|integer|min:0',
            'regular_hour_description' => 'required|string',
            'replacement_hour_description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $journal = TeachingJournal::create([
            'teacher_id' => $validated['teacher_id'],
            'date' => $validated['date'],
            'total_regular_hours' => $validated['total_regular_hours'],
            'total_replacement_hours' => $validated['total_replacement_hours'],
            'regular_hour_description' => $validated['regular_hour_description'],
            'replacement_hour_description' => $validated['replacement_hour_description'],
            'notes' => $validated['notes'],
        ]);

        foreach ($validated['subjects'] as $subjectId) {
            TeachingJournalSubject::create([
                'teaching_journal_id' => $journal->id,
                'teaching_subject_id' => $subjectId,
            ]);
        }

        return redirect()->route('administrationadmin.journals.index')
            ->with('success', 'Teaching journal created successfully.');
    }

    public function edit(TeachingJournal $journal)
    {
        $teachers = Teacher::all();
        $subjects = TeachingSubject::all();
        $selectedSubjects = $journal->teachingSubjects->pluck('id')->toArray();
        return view('roles.AdministrationAdmin.journals.edit', compact('journal', 'teachers', 'subjects', 'selectedSubjects'));
    }

    public function update(Request $request, TeachingJournal $journal)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'date' => 'required|date',
            'subjects' => 'required|array|min:1',
            'subjects.*' => 'exists:teaching_subjects,id',
            'total_regular_hours' => 'required|integer|min:0',
            'total_replacement_hours' => 'required|integer|min:0',
            'regular_hour_description' => 'required|string',
            'replacement_hour_description' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $journal->update([
            'teacher_id' => $validated['teacher_id'],
            'date' => $validated['date'],
            'total_regular_hours' => $validated['total_regular_hours'],
            'total_replacement_hours' => $validated['total_replacement_hours'],
            'regular_hour_description' => $validated['regular_hour_description'],
            'replacement_hour_description' => $validated['replacement_hour_description'],
            'notes' => $validated['notes'],
        ]);

        // Delete existing subjects
        TeachingJournalSubject::where('teaching_journal_id', $journal->id)->delete();

        // Create new subjects
        foreach ($validated['subjects'] as $subjectId) {
            TeachingJournalSubject::create([
                'teaching_journal_id' => $journal->id,
                'teaching_subject_id' => $subjectId,
            ]);
        }

        return redirect()->route('administrationadmin.journals.index')
            ->with('success', 'Teaching journal updated successfully.');
    }

    public function destroy(TeachingJournal $journal)
    {
        $journal->delete();

        return redirect()->route('administrationadmin.journals.index')
            ->with('success', 'Teaching journal deleted successfully.');
    }
}

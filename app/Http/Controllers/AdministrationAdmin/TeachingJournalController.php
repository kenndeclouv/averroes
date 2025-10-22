<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeachingJournal;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeachingJournalController extends Controller
{
    public function index()
    {
        $journals = TeachingJournal::with('teacher')->get();
            
        return view('roles.AdministrationAdmin.journals.index', compact('journals'));
    }

    public function show(TeachingJournal $journal)
    {
        $journal->load('teacher');
        return view('roles.AdministrationAdmin.journals.show', compact('journal'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        return view('roles.AdministrationAdmin.journals.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
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

        TeachingJournal::create($validated);

        return redirect()->route('administrationadmin.journals.index')
            ->with('success', 'Teaching journal created successfully.');
    }

    public function edit(TeachingJournal $journal)
    {
        $teachers = Teacher::all();
        return view('roles.AdministrationAdmin.journals.edit', compact('journal', 'teachers'));
    }

    public function update(Request $request, TeachingJournal $journal)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
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

        $journal->update($validated);

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

<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeachingJournal;
use App\Models\TeachingJournalSubject;
use App\Models\TeachingSubject;
use App\Models\Teacher;
use App\Models\TeachingJournalException;
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

        $query = TeachingJournal::with(['teacher', 'teachingSubjects'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month);
            
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }

        $journals = $query->orderBy('date', 'desc')->get();
        $teachers = Teacher::all();

        $isLocked = TeachingJournal::isLocked($month, $year);

        return view('roles.AdministrationAdmin.journals.index', compact('journals', 'monthYear', 'teachers', 'isLocked'));
    }

    public function export(Request $request)
    {
        $monthYear = $request->input('month');
        if (!$monthYear || !preg_match('/^\d{4}-\d{2}$/', $monthYear)) {
            $monthYear = \Carbon\Carbon::now()->format('Y-m');
        }

        [$year, $month] = explode('-', $monthYear);

        $query = TeachingJournal::with(['teacher', 'teachingSubjects'])
            ->whereYear('date', $year)
            ->whereMonth('date', $month);
            
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->input('teacher_id'));
        }

        $journals = $query->orderBy('date', 'desc')->get();
        $dateFormatted = \Carbon\Carbon::parse($monthYear)->locale('id')->translatedFormat('F Y');
        
        $fileName = 'Jurnal_Mengajar_' . str_replace(' ', '_', $dateFormatted) . '.xlsx';

        if ($request->input('per_teacher') == '1' && !$request->filled('teacher_id')) {
            $journalsByTeacher = $journals->groupBy(function ($journal) {
                return $journal->teacher->name;
            });
            
            return \Maatwebsite\Excel\Facades\Excel::download(
                new \App\Exports\TeachingJournalMultipleSheetsExport($journalsByTeacher, $dateFormatted), 
                $fileName
            );
        }

        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TeachingJournalExport($journals, $dateFormatted), $fileName);
    }

    public function show(TeachingJournal $journal)
    {
        $journal->load(['teacher', 'teachingSubjects']);
        $journalDate = \Carbon\Carbon::parse($journal->date);
        $isLocked = TeachingJournal::isLocked($journalDate->month, $journalDate->year);
        
        return view('roles.AdministrationAdmin.journals.show', compact('journal', 'isLocked'));
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
            'replacement_hour_description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $journalDate = \Carbon\Carbon::parse($validated['date']);
        if (TeachingJournal::isLocked($journalDate->month, $journalDate->year)) {
            return back()->with('error', 'Bulan ini telah dikunci. Anda tidak dapat menambahkan jurnal.');
        }

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
        $journalDate = \Carbon\Carbon::parse($journal->date);
        if (TeachingJournal::isLocked($journalDate->month, $journalDate->year)) {
            return back()->with('error', 'Bulan ini telah dikunci. Anda tidak dapat mengubah jurnal ini.');
        }

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
            'replacement_hour_description' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $journalDate = \Carbon\Carbon::parse($journal->date);
        if (TeachingJournal::isLocked($journalDate->month, $journalDate->year)) {
            return back()->with('error', 'Bulan ini telah dikunci. Anda tidak dapat mengubah jurnal ini.');
        }

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
        $journalDate = \Carbon\Carbon::parse($journal->date);
        if (TeachingJournal::isLocked($journalDate->month, $journalDate->year)) {
            return back()->with('error', 'Bulan ini telah dikunci. Anda tidak dapat menghapus jurnal ini.');
        }

        $journal->delete();

        return redirect()->route('administrationadmin.journals.index')
            ->with('success', 'Teaching journal deleted successfully.');
    }

    public function toggleLock(Request $request)
    {
        $request->validate([
            'monthYear' => 'required|date_format:Y-m',
        ]);

        [$year, $month] = explode('-', $request->input('monthYear'));
        
        $exception = TeachingJournalException::firstOrCreate(
            ['month' => $month, 'year' => $year],
            ['is_unlocked' => false]
        );

        $autoLockDate = \Carbon\Carbon::createFromDate($year, $month, 1)->addMonth()->addDay(1)->startOfDay();
        $isAutoLocked = \Carbon\Carbon::now()->greaterThanOrEqualTo($autoLockDate);

        if ($isAutoLocked) {
            // If it's naturally locked, we toggle the exception
            $exception->update([
                'is_unlocked' => !$exception->is_unlocked
            ]);
            $msg = $exception->is_unlocked ? 'Kunci bulan ini berhasil dibuka.' : 'Bulan ini berhasil dikunci kembali.';
        } else {
            // It's not auto-locked yet. The admin can't force lock it earlier than auto-lock date with this logic,
            // but we can just say it's not locked yet.
            return back()->with('error', 'Bulan ini belum masuk periode kunci otomatis.');
        }

        return back()->with('success', $msg);
    }
}

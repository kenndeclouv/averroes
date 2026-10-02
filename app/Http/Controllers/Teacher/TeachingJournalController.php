<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeachingJournal;
use App\Models\TeachingJournalSubject;
use App\Models\TeachingSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeachingJournalController extends Controller
{
    public function index(Request $request)
    {
        // Ambil teacher_id dari user yang sedang login
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        $monthYear = $request->input('month');
        if (!$monthYear || !preg_match('/^\d{4}-\d{2}$/', $monthYear)) {
            $now = \Carbon\Carbon::now();
            $monthYear = ($now->day == 1) ? $now->copy()->subMonth()->format('Y-m') : $now->format('Y-m');
        }

        [$year, $month] = explode('-', $monthYear);

        // Hanya ambil jurnal yang milik teacher ini saja
        $journals = TeachingJournal::with(['teacher', 'teachingSubjects'])
            ->where('teacher_id', $teacher->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        $isLocked = TeachingJournal::isLocked($month, $year);

        return view('roles.Teacher.journals.index', compact('journals', 'monthYear', 'isLocked'));
    }

    public function export(Request $request)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        $monthYear = $request->input('month');
        if (!$monthYear || !preg_match('/^\d{4}-\d{2}$/', $monthYear)) {
            $now = \Carbon\Carbon::now();
            $monthYear = ($now->day == 1) ? $now->copy()->subMonth()->format('Y-m') : $now->format('Y-m');
        }

        [$year, $month] = explode('-', $monthYear);

        $journals = TeachingJournal::with(['teacher', 'teachingSubjects'])
            ->where('teacher_id', $teacher->id)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        $dateFormatted = \Carbon\Carbon::parse($monthYear)->locale('id')->translatedFormat('F Y');
        
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\TeachingJournalExport($journals, $dateFormatted), 'Jurnal_Mengajar_' . str_replace(' ', '_', $dateFormatted) . '.xlsx');
    }

    public function show(TeachingJournal $journal)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        // Cegah akses jurnal milik orang lain
        if ($journal->teacher_id != $teacher->id) {
            abort(403, 'Unauthorized');
        }
        $journal->load(['teacher', 'teachingSubjects']);
        
        $journalDate = \Carbon\Carbon::parse($journal->date);
        $isLocked = TeachingJournal::isLocked($journalDate->month, $journalDate->year);
        
        return view('roles.Teacher.journals.show', compact('journal', 'isLocked'));
    }

    public function create()
    {
        // Tidak perlu pilih teacher, auto saja
        $subjects = TeachingSubject::all();
        return view('roles.Teacher.journals.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();

        $validated = $request->validate([
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
            'teacher_id' => $teacher->id,
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

        $journalDate = \Carbon\Carbon::parse($journal->date);
        if (TeachingJournal::isLocked($journalDate->month, $journalDate->year)) {
            return back()->with('error', 'Bulan ini telah dikunci. Anda tidak dapat mengubah jurnal ini.');
        }

        // Tidak perlu pilihan teachers
        $subjects = TeachingSubject::all();
        $selectedSubjects = $journal->teachingSubjects->pluck('id')->toArray();
        return view('roles.Teacher.journals.edit', compact('journal', 'subjects', 'selectedSubjects'));
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

        $journalDate = \Carbon\Carbon::parse($journal->date);
        if (TeachingJournal::isLocked($journalDate->month, $journalDate->year)) {
            return back()->with('error', 'Bulan ini telah dikunci. Anda tidak dapat menghapus jurnal ini.');
        }

        $journal->delete();

        return redirect()
            ->route('teacher.journals.index')
            ->with('success', 'Teaching journal deleted successfully.');
    }
}

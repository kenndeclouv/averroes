<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeachingSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeachingSubjectController extends Controller
{
    public function index()
    {
        $subjects = TeachingSubject::all();
        return view('roles.AdministrationAdmin.teaching_subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('roles.AdministrationAdmin.teaching_subjects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teaching_subjects,name',
        ]);

        TeachingSubject::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('administrationadmin.teaching-subjects.index')
            ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    public function edit(TeachingSubject $teaching_subject)
    {
        return view('roles.AdministrationAdmin.teaching_subjects.edit', compact('teaching_subject'));
    }

    public function update(Request $request, TeachingSubject $teaching_subject)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teaching_subjects,name,' . $teaching_subject->id,
        ]);

        $teaching_subject->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('administrationadmin.teaching-subjects.index')
            ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    public function destroy(TeachingSubject $teaching_subject)
    {
        $teaching_subject->delete();
        return redirect()->route('administrationadmin.teaching-subjects.index')
            ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}

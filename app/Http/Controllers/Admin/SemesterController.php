<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Semester;


class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::latest()->get();
        return view('roles.AdministrationAdmin.semesters.index', compact('semesters'));
    }

    public function create()
    {
        return view('roles.AdministrationAdmin.semesters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'academic_year' => 'required|string',
            'type' => 'required|in:ganjil,genap',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->has('is_active') && $request->is_active) {
            Semester::where('is_active', true)->update(['is_active' => false]);
        }

        Semester::create($request->all());

        return redirect()->route('administrationadmin.semesters.index')->with('success', 'Semester berhasil ditambahkan.');
    }

    public function edit(Semester $semester)
    {
        return view('roles.AdministrationAdmin.semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $request->validate([
            'academic_year' => 'required|string',
            'type' => 'required|in:ganjil,genap',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        if ($request->has('is_active') && $request->is_active) {
            Semester::where('id', '!=', $semester->id)->update(['is_active' => false]);
        }

        $semester->update($request->all());

        return redirect()->route('administrationadmin.semesters.index')->with('success', 'Semester berhasil diperbaharui.');
    }

    public function destroy(Semester $semester)
    {
        $semester->delete();
        return redirect()->route('administrationadmin.semesters.index')->with('success', 'Semester berhasil dihapus.');
    }
}

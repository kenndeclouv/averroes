<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\TeachingSubject;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $query = Material::with(['Classes', 'TeachingSubject', 'Semester', 'Teacher']);

        // Filters
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        }

        if ($request->filled('teaching_subject_id')) {
            $query->where('teaching_subject_id', $request->teaching_subject_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $materials = $query->latest()->get();

        $semesters = Semester::latest()->get();
        $subjects = TeachingSubject::all();
        $teachers = Teacher::with('user')->get();

        return view('roles.AdministrationAdmin.materials.index', compact('materials', 'semesters', 'subjects', 'teachers'));
    }

    public function show(Material $material)
    {
        // Admin can view any material
        return view('roles.AdministrationAdmin.materials.show', compact('material'));
    }

    public function destroy(Material $material)
    {
        // Admin authorization assumed via middleware
        if ($material->file_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        return redirect()->route('administrationadmin.materials.index')->with('success', 'Material deleted successfully by Admin.');
    }
}

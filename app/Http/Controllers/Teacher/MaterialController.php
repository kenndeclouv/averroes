<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Classes;
use App\Models\Material;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\TeachingSubject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        $query = Material::where('teacher_id', $teacher->id)
            ->with(['Classes', 'TeachingSubject', 'Semester']);

        // Filters
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        } else {
            // Default to active semester if no filter? Or show all?
            // Quizzes index shows "Semua Semester" by default option value=""
            // But usually we want active by default?
            // The reference code:
            // <option value="" {{ request('semester_id') == $semester->id ? ... }}>
            // If request is empty, it shows all. Let's stick to showing all if empty.
        }

        if ($request->filled('teaching_subject_id')) {
            $query->where('teaching_subject_id', $request->teaching_subject_id);
        }

        $materials = $query->latest()->get(); // Client-side DataTables

        $semesters = Semester::latest()->get();
        $subjects = TeachingSubject::all();

        return view('roles.Teacher.materials.index', compact('materials', 'semesters', 'subjects'));
    }

    public function create()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        // Load classes and subjects for dropdowns
        $classes = Classes::all(); // Or filter by teacher's classes if applicable
        $subjects = TeachingSubject::all();

        return view('roles.Teacher.materials.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $activeSemester = Semester::active()->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'classes_id' => 'required|exists:classes,id',
            'teaching_subject_id' => 'required|exists:teaching_subjects,id',
            'type' => 'required|in:text,document,image,video',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4|max:20480', // 20MB max
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $filename, 'public');
        }

        Material::create([
            'teacher_id' => $teacher->id,
            'semester_id' => $activeSemester->id,
            'classes_id' => $request->classes_id,
            'teaching_subject_id' => $request->teaching_subject_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return redirect()->route('teacher.materials.index')->with('success', 'Materi berhasil diunggah.');
    }

    public function edit(Material $material)
    {
        // Authorization check?
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        $classes = Classes::all();
        $subjects = TeachingSubject::all();

        return view('roles.Teacher.materials.edit', compact('material', 'classes', 'subjects'));
    }

    public function update(Request $request, Material $material)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'classes_id' => 'required|exists:classes,id',
            'teaching_subject_id' => 'required|exists:teaching_subjects,id',
            'type' => 'required|in:text,document,image,video',
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png,mp4|max:20480',
        ]);

        $filePath = $material->file_path;
        if ($request->hasFile('file')) {
            // Delete old file
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $filename, 'public');
        }

        $material->update([
            'classes_id' => $request->classes_id,
            'teaching_subject_id' => $request->teaching_subject_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $request->content,
            'file_path' => $filePath,
        ]);

        return redirect()->route('teacher.materials.index')->with('success', 'Materi diperbarui.');
    }

    public function destroy(Material $material)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        if ($material->teacher_id !== $teacher->id) {
            abort(403);
        }

        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return redirect()->route('teacher.materials.index')->with('success', 'Materi dihapus.');
    }
}

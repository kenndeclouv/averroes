<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Classes;
use App\Models\Material;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        // Ensure student has a class
        if (!$student->classes_id) {
            return redirect()->back()->with('error', 'Anda belum terdaftar dalam kelas.');
        }

        $activeSemester = Semester::active()->firstOrFail();

        // Get materials for student's class and active semester
        // Eager load relationships for optimized query
        $materials = Material::where('classes_id', $student->classes_id)
            ->where('semester_id', $activeSemester->id)
            ->with(['Teacher', 'TeachingSubject'])
            ->latest()
            ->paginate(12);

        return view('roles.Student.materials.index', compact('materials'));
    }

    public function show(Material $material)
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->firstOrFail();

        // Authorization: Material must belong to student's class
        if ($material->classes_id !== $student->classes_id) {
            abort(403, 'Access Denied');
        }

        return view('roles.Student.materials.show', compact('material'));
    }
}

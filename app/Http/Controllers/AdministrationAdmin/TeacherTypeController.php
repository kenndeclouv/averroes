<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\TeacherType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherTypeController extends Controller
{
    public function index()
    {
        $teacherTypes = TeacherType::orderBy('type')->orderBy('name')->get();
        return view('roles.AdministrationAdmin.teachertype.index', compact('teacherTypes'));
    }

    public function create()
    {
        return view('roles.AdministrationAdmin.teachertype.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:functional_position,teaching_mandatory',
        ], [
            'name.required' => 'Nama Jabatan / Amanah tidak boleh kosong!',
            'type.required' => 'Kategori tidak boleh kosong!',
            'type.in'       => 'Kategori tidak valid!',
        ]);

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;

        // Ensure unique slug
        $count = 1;
        while (TeacherType::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        $validated['slug'] = $slug;

        TeacherType::create($validated);

        return redirect()->route('administrationadmin.teachertype.index')->with('success', 'Master Jabatan / Amanah berhasil ditambahkan!');
    }

    public function edit(TeacherType $teachertype)
    {
        return view('roles.AdministrationAdmin.teachertype.edit', compact('teachertype'));
    }

    public function update(Request $request, TeacherType $teachertype)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:functional_position,teaching_mandatory',
        ], [
            'name.required' => 'Nama Jabatan / Amanah tidak boleh kosong!',
            'type.required' => 'Kategori tidak boleh kosong!',
            'type.in'       => 'Kategori tidak valid!',
        ]);

        if ($validated['name'] !== $teachertype->name) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;

            $count = 1;
            while (TeacherType::where('slug', $slug)->where('id', '!=', $teachertype->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $validated['slug'] = $slug;
        }

        $teachertype->update($validated);

        return redirect()->route('administrationadmin.teachertype.index')->with('success', 'Master Jabatan / Amanah berhasil diubah!');
    }

    public function destroy(TeacherType $teachertype)
    {
        // Detach relations in pivot table teacher_has_types if any
        $teachertype->teachers()->detach();
        $teachertype->delete();

        return redirect()->route('administrationadmin.teachertype.index')->with('success', 'Master Jabatan / Amanah berhasil dihapus!');
    }
}

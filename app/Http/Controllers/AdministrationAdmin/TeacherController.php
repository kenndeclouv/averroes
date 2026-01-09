<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherHasTypeRequest;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UserRequest;
use App\Models\Classes;
use App\Models\Role;
use App\Models\Room;
use App\Models\Teacher;
use App\Models\TeacherHasType;
use App\Models\TeacherType;
use App\Models\User;
use Illuminate\Http\Request;


class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return view('roles.AdministrationAdmin.teacher.index', compact('teachers'));
    }

    public function show(Teacher $teacher)
    {
        return view('roles.AdministrationAdmin.teacher.show', compact('teacher'));
    }

    public function create()
    {
        $classes = Classes::all();
        $rooms = Room::all();
        $FNOtherTypeId = TeacherType::where('slug', 'functional_position-lainnya')->value('id');
        $TMOtherTypeId = TeacherType::where('slug', 'teaching_mandatory-lainnya')->value('id');
        $FNTypes = TeacherType::where('type', 'functional_position')
            ->get();
        $TMTypes = TeacherType::where('type', 'teaching_mandatory')
            ->get();
        $lastNip = Teacher::selectRaw("nip, CAST(REGEXP_SUBSTR(nip, '[0-9]+') AS UNSIGNED) as nip_number")
            ->orderByDesc('nip_number')
            ->first()
            ?->nip;

        $roles = Role::whereIn('id', [3, 7, 8])->get();

        return view('roles.AdministrationAdmin.teacher.create', compact('classes', 'rooms', 'FNOtherTypeId', 'TMOtherTypeId', 'FNTypes', 'TMTypes', 'lastNip', 'roles'));
    }

    public function store(UserRequest $requestUser, TeacherRequest $teacherRequest, TeacherHasTypeRequest $request)
    {
        // The original logic looks correct: you create the User first, then set 'user_id' on the Teacher.
        // If user_id is null in the database, possible reasons:
        // 1. The 'user_id' field is not in the $fillable property of the Teacher model.
        // 2. The 'user_id' field is nullable in the DB and not being saved correctly.
        // 3. There may be an issue in the request validation excluding 'user_id'.
        // 4. An event or observer may be modifying Teacher creation.
        // To address the most common problem, ensure 'user_id' is in $fillable in the Teacher model.

        $validatedUser = $requestUser->validated();
        $validatedTeacher = $teacherRequest->validated();

        $user = User::create($validatedUser);
        $user->roles()->attach($validatedTeacher['roles']);

        // Make sure 'user_id' is fillable in Teacher model!
        $validatedTeacher['user_id'] = $user->id;
        $teacher = Teacher::create($validatedTeacher);

        // Validasi input fn_type & tm_type
        $validatedTeacherHasType = $request->validated();

        $fn_type_id = TeacherType::where('slug', 'functional_position-lainnya')->value('id');
        $tm_type_id = TeacherType::where('slug', 'teaching_mandatory-lainnya')->value('id');

        // Simpan fn_type_lainnya_des kalau ada
        foreach ($validatedTeacherHasType['fn_type'] ?? [] as $fn_type) {
            if ($fn_type == $fn_type_id) {
                TeacherHasType::create([
                    'teacher_id' => $teacher->id,
                    'teacher_type_id' => $fn_type,
                    'description' => $validatedTeacherHasType['fn_type_lainnya_des'],
                ]);
                continue;
            } else {
                TeacherHasType::create([
                    'teacher_id' => $teacher->id,
                    'teacher_type_id' => $fn_type,
                ]);
            }
        }
        foreach ($validatedTeacherHasType['tm_type'] ?? [] as $tm_type) {
            if ($tm_type == $tm_type_id) {
                TeacherHasType::create([
                    'teacher_id' => $teacher->id,
                    'teacher_type_id' => $tm_type,
                    'description' => $validatedTeacherHasType['tm_type_lainnya_des'],
                ]);
            } else {
                TeacherHasType::create([
                    'teacher_id' => $teacher->id,
                    'teacher_type_id' => $tm_type,
                ]);
            }
        }
        return redirect()->route('administrationadmin.teacher.index')->with('success', 'Data Pegawai berhasil ditambahkan');
    }


    public function edit(Teacher $teacher)
    {
        $classes = Classes::all();
        $rooms = Room::all();
        // Ambil semua jenis jabatan dan amanah mengajar
        $FNTypes = TeacherType::where('type', 'functional_position')->get();
        $TMTypes = TeacherType::where('type', 'teaching_mandatory')->get();

        // Ambil ID dari "lainnya"
        $FNOtherTypeId = TeacherType::where('slug', 'functional_position-lainnya')->value('id');
        $TMOtherTypeId = TeacherType::where('slug', 'teaching_mandatory-lainnya')->value('id');

        // Ambil jabatan & amanah mengajar yang sudah dipilih
        $selectedFNs = $teacher->teacherTypes->where('type', 'functional_position')->pluck('id')->toArray();
        $selectedTMs = $teacher->teacherTypes->where('type', 'teaching_mandatory')->pluck('id')->toArray();

        // Ambil deskripsi untuk "lainnya" jika dipilih
        $selectedFNDescription = $teacher->teacherTypes->where('id', $FNOtherTypeId)->first()->pivot->description ?? '';
        $selectedTMDescription = $teacher->teacherTypes->where('id', $TMOtherTypeId)->first()->pivot->description ?? '';
        $nipFormat = generateNIP();

        $roles = Role::whereIn('id', [3, 7, 8])->get();

        return view('roles.AdministrationAdmin.teacher.edit', compact('teacher', 'classes', 'rooms', 'FNTypes', 'TMTypes', 'FNOtherTypeId', 'TMOtherTypeId', 'selectedFNs', 'selectedTMs', 'selectedFNDescription', 'selectedTMDescription', 'nipFormat', 'roles'));
    }

    public function update(UserRequest $userRequest, TeacherRequest $teacherRequest, TeacherHasTypeRequest $teacherHasTypeRequest, Teacher $teacher)
    {
        $validatedUser = $userRequest->validated();
        $validatedTeacher = $teacherRequest->validated();

        $validatedTeacherHasType = $teacherHasTypeRequest->validated();
        // Validasi input fn_type & tm_type
        $validatedTeacherHasType = $teacherHasTypeRequest->validated();

        $fn_type_id = TeacherType::where('slug', 'functional_position-lainnya')->value('id');
        $tm_type_id = TeacherType::where('slug', 'teaching_mandatory-lainnya')->value('id');

        // Hapus semua relasi lama
        TeacherHasType::where('teacher_id', $teacher->id)->delete();

        // Simpan ulang fn_type & tm_type
        foreach ($validatedTeacherHasType['fn_type'] ?? [] as $fn_type) {
            TeacherHasType::create([
                'teacher_id' => $teacher->id,
                'teacher_type_id' => $fn_type,
                'description' => $fn_type == $fn_type_id ? $validatedTeacherHasType['fn_type_lainnya_des'] : null,
            ]);
        }

        foreach ($validatedTeacherHasType['tm_type'] ?? [] as $tm_type) {
            TeacherHasType::create([
                'teacher_id' => $teacher->id,
                'teacher_type_id' => $tm_type,
                'description' => $tm_type == $tm_type_id ? $validatedTeacherHasType['tm_type_lainnya_des'] : null,
            ]);
        }
        $teacher->update($validatedTeacher);
        $teacher->User->update($validatedUser);
        $teacher->User->roles()->sync($validatedTeacher['roles']);

        return redirect()->route('administrationadmin.teacher.index')->with('success', 'Data Pegawai berhasil diubah');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->User) {
            $teacher->User->delete();
        }
        return redirect()->route('administrationadmin.teacher.index')->with('success', 'Data Pegawai berhasil dihapus');
    }

    public function nipIndex()
    {
        $teachers = Teacher::all();
        $lastNip = Teacher::selectRaw("nip, CAST(REGEXP_SUBSTR(nip, '[0-9]+') AS UNSIGNED) as nip_number")
            ->orderByDesc('nip_number')
            ->first()
            ?->nip;
        return view('roles.AdministrationAdmin.teacher.nip', compact('teachers', 'lastNip'));
    }

    public function nipUpdate(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nip' => 'nullable|string|unique:teachers,nip,' . $teacher->id,
        ], [
            'nip.unique' => 'NIP sudah ada',
        ]);
        $teacher->update([
            'nip' => $request->nip,
        ]);
        return redirect()->route('administrationadmin.teacher.nip.index')->with('success', 'NIP pegawai berhasil diperbarui');
    }

    public function nipDestroy(Teacher $teacher)
    {
        $teacher->update([
            'nip' => null,
        ]);
        return redirect()->route('administrationadmin.teacher.nip.index')->with('success', 'NIP pegawai berhasil dihapus');
    }

    public function nipAutoGenerate(Teacher $teacher, Request $request)
    {
        $request['nip'] = generateNIP();
        $validated = $request->validate([
            'nip' => 'required|unique:teachers,nip,' . $teacher->id,
        ], [
            'nip.required' => 'NIP Harus diisi',
            'nip.unique' => 'NIP sudah ada',
        ]);
        $teacher->update([
            'nip' => generateNIP(),
        ]);
        return redirect()->route('administrationadmin.teacher.nip.index')->with('success', 'NIP pegawai berhasil di generate');
    }
}

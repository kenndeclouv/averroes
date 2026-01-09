<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRequest;
use App\Models\Classes;
use App\Models\Room;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all()->where('is_graduate', false);
        return view('roles.AdministrationAdmin.student.index', compact('students'));
    }

    public function show(Student $student)
    {
        return view('roles.AdministrationAdmin.student.show', compact('student'));
    }

    public function create()
    {
        $classes = Classes::all();
        $rooms = Room::all();
        $lastNis = Student::selectRaw("nis, CAST(REGEXP_SUBSTR(nis, '[0-9]+') AS UNSIGNED) as nis_number")
            ->orderByDesc('nis_number')
            ->first()
            ?->nis;

        return view('roles.AdministrationAdmin.student.create', compact('classes', 'rooms', 'lastNis'));
    }

    public function store(StudentRequest $studentRequest, UserRequest $userRequest)
    {
        // Validasi data dari masing-masing Request
        $validatedUser = $userRequest->validated();
        $validatedStudent = $studentRequest->validated();

        // Buat user baru
        $user = User::create(array_merge($validatedUser, [
            'is_active' => true,
        ]));
        $user->roles()->attach(4);

        if (empty($validatedStudent['nis'])) {
            $validatedStudent['nis'] = generateNIS();
        }
        // Proses file upload jika ada
        if ($studentRequest->hasFile('attachment_family_register')) {
            $file = $studentRequest->file('attachment_family_register');
            $validatedStudent['attachment_family_register'] = uploadFile($file, 'uploads/family_registers');
        }
        if ($studentRequest->hasFile('attachment_birth_certificate')) {
            $file = $studentRequest->file('attachment_birth_certificate');
            $validatedStudent['attachment_birth_certificate'] = uploadFile($file, 'uploads/birth_certificates');
        }
        if ($studentRequest->hasFile('attachment_diploma')) {
            $file = $studentRequest->file('attachment_diploma');
            $validatedStudent['attachment_diploma'] = uploadFile($file, 'uploads/diplomas');
        }
        if ($studentRequest->hasFile('attachment_father_identity_card')) {
            $file = $studentRequest->file('attachment_father_identity_card');
            $validatedStudent['attachment_father_identity_card'] = uploadFile($file, 'uploads/father_identity_cards');
        }
        if ($studentRequest->hasFile('attachment_mother_identity_card')) {
            $file = $studentRequest->file('attachment_mother_identity_card');
            $validatedStudent['attachment_mother_identity_card'] = uploadFile($file, 'uploads/mother_identity_cards');
        }

        // Buat student baru
        Student::create(array_merge(
            $validatedStudent,
            [
                'user_id' => $user->id,
                'attachment_family_register' => $validatedStudent['attachment_family_register'] ?? null,
                'attachment_birth_certificate' => $validatedStudent['attachment_birth_certificate'] ?? null,
                'attachment_diploma' => $validatedStudent['attachment_diploma'] ?? null,
                'attachment_father_identity_card' => $validatedStudent['attachment_father_identity_card'] ?? null,
                'attachment_mother_identity_card' => $validatedStudent['attachment_mother_identity_card'] ?? null
            ]
        ));

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('administrationadmin.student.index')->with('success', 'Data santri berhasil ditambahkan');
    }

    public function edit(Student $student)
    {
        $classes = Classes::all();
        $rooms = Room::all();
        $nisFormat = generateNIS();
        return view('roles.AdministrationAdmin.student.edit', compact('student', 'classes', 'rooms', 'nisFormat'));
    }

    public function update(StudentRequest $studentRequest, UserRequest $userRequest, Student $student)
    {
        // Validasi data dari masing-masing Request
        $validatedUser = $userRequest->validated();
        $validatedStudent = $studentRequest->validated();

        // Update data user
        $student->User->update($validatedUser);

        // Proses file upload jika ada dan hapus file lama
        if ($studentRequest->hasFile('attachment_family_register')) {
            $file = $studentRequest->file('attachment_family_register');
            // Hapus file lama jika ada
            if ($student->attachment_family_register) {
                deleteFile('uploads/family_registers/' . basename($student->attachment_family_register));
            }
            $validatedStudent['attachment_family_register'] = uploadFile($file, 'uploads/family_registers');
        }

        if ($studentRequest->hasFile('attachment_birth_certificate')) {
            $file = $studentRequest->file('attachment_birth_certificate');
            // Hapus file lama jika ada
            if ($student->attachment_birth_certificate) {
                deleteFile('uploads/birth_certificates/' . basename($student->attachment_birth_certificate));
            }
            $validatedStudent['attachment_birth_certificate'] = uploadFile($file, 'uploads/birth_certificates');
        }

        if ($studentRequest->hasFile('attachment_diploma')) {
            $file = $studentRequest->file('attachment_diploma');
            // Hapus file lama jika ada
            if ($student->attachment_diploma) {
                deleteFile('uploads/diplomas/' . basename($student->attachment_diploma));
            }
            $validatedStudent['attachment_diploma'] = uploadFile($file, 'uploads/diplomas');
        }
        if ($studentRequest->hasFile('attachment_father_identity_card')) {
            $file = $studentRequest->file('attachment_father_identity_card');
            // Hapus file lama jika ada
            if ($student->attachment_father_identity_card) {
                deleteFile('uploads/identity_cards/' . basename($student->attachment_father_identity_card));
            }
            $validatedStudent['attachment_father_identity_card'] = uploadFile($file, 'uploads/identity_cards');
        }

        if ($studentRequest->hasFile('attachment_mother_identity_card')) {
            $file = $studentRequest->file('attachment_mother_identity_card');
            // Hapus file lama jika ada
            if ($student->attachment_mother_identity_card) {
                deleteFile('uploads/identity_cards/' . basename($student->attachment_mother_identity_card));
            }
            $validatedStudent['attachment_mother_identity_card'] = uploadFile($file, 'uploads/identity_cards');
        }

        // Update data student
        $student->update(array_merge(
            $validatedStudent,
            [
                'attachment_family_register' => $validatedStudent['attachment_family_register'] ?? $student->attachment_family_register,
                'attachment_birth_certificate' => $validatedStudent['attachment_birth_certificate'] ?? $student->attachment_birth_certificate,
                'attachment_diploma' => $validatedStudent['attachment_diploma'] ?? $student->attachment_diploma,
                'attachment_father_identity_card' => $validatedStudent['attachment_father_identity_card'] ?? $student->attachment_father_identity_card,
                'attachment_mother_identity_card' => $validatedStudent['attachment_mother_identity_card'] ?? $student->attachment_mother_identity_card,
            ]
        ));

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('administrationadmin.student.index')->with('success', 'Data santri berhasil diperbarui');
    }


    public function destroy(Student $student)
    {
        $student->User->delete();
        return redirect()->route('administrationadmin.student.index')->with('success', 'Data santri berhasil dihapus');
    }


    public function graduateIndex()
    {
        $students = Student::all()->where('is_graduate', true);
        return view('roles.AdministrationAdmin.student.graduate', compact('students'));
    }

    public function graduate(Student $student)
    {
        $student->update([
            'is_graduate' => true,
        ]);
        return redirect()->route('administrationadmin.student.index')->with('success', 'Santri ' . $student->name . ' diluluskan!');
    }
    public function undoGraduate(Student $student)
    {
        $student->update([
            'is_graduate' => false,
        ]);
        return redirect()->route('administrationadmin.student.graduate.index')->with('success', 'Santri ' . $student->name . ' dibatalkan lulus!');
    }

    public function nisIndex()
    {
        $students = Student::all();
        $lastNis = Student::selectRaw("nis, CAST(REGEXP_SUBSTR(nis, '[0-9]+') AS UNSIGNED) as nis_number")
            ->orderByDesc('nis_number')
            ->first()
            ?->nis;
        return view('roles.AdministrationAdmin.student.nis', compact('students', 'lastNis'));
    }

    public function nisUpdate(Request $request, Student $student)
    {
        $request->validate([
            'nis' => 'nullable|string|unique:students,nis,' . $student->id,
        ], [
            'nis.unique' => 'NIS sudah ada',
        ]);
        $student->update([
            'nis' => $request->nis,
        ]);
        return redirect()->route('administrationadmin.student.nis.index')->with('success', 'NIS santri berhasil diperbarui');
    }

    public function nisDestroy(Student $student)
    {
        $student->update([
            'nis' => null,
        ]);
        return redirect()->route('administrationadmin.student.nis.index')->with('success', 'NIS santri berhasil dihapus');
    }

    public function nisAutoGenerate(Student $student)
    {
        $student->update([
            'nis' => generateNIS(),
        ]);
        return redirect()->route('administrationadmin.student.nis.index')->with('success', 'NIS santri berhasil di generate');
    }
}

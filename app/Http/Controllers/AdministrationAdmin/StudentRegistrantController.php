<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Student;
use App\Models\StudentRegistrant;
use App\Models\User;

class StudentRegistrantController extends Controller
{
    public function indexUser()
    {
        $studentRegistrants = User::where('role_id', '=', 5)->get();
        return view('roles.AdministrationAdmin.student_registrant.indexuser', compact('studentRegistrants'));
    }
    public function createUser()
    {
        return view('roles.AdministrationAdmin.student_registrant.createuser');
    }
    public function storeUser(UserRequest $request)
    {
        $validated = $request->validated();

        $validated['role_id'] = 5;
        $validated['is_active'] = true;
        User::create($validated);
        return redirect()->route('administrationadmin.studentregistrant.index-user')->with('success', 'User calon santri berhasil dibuat.');
    }
    public function editUser(User $user)
    {
        return view('roles.AdministrationAdmin.student_registrant.edituser', compact('user'));
    }
    public function updateUser(UserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->update($validated);
        return redirect()->route('administrationadmin.studentregistrant.index-user')->with('success', 'User calon santri berhasil diubah.');
    }
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('administrationadmin.studentregistrant.index-user')->with('success', 'User calon santri berhasil dihapus.');
    }

    public function index()
    {
        $studentRegistrants = StudentRegistrant::all();
        return view('roles.AdministrationAdmin.student_registrant.index', compact('studentRegistrants'));
    }
    public function show(StudentRegistrant $studentRegistrant)
    {
        return view('roles.AdministrationAdmin.student_registrant.show', compact('studentRegistrant'));
    }
    public function approve(StudentRegistrant $studentRegistrant)
    {
        if (!$studentRegistrant) {
            return back()->with('error', 'Student registrant not found.');
        }

        // Update user role
        $studentRegistrant->User()->update([
            "role_id" => 4
        ]);
        $studentRegistrant->update([
            'status' => "approved"
        ]);
        Student::create([
            "name" => $studentRegistrant->name,
            "nis" => generateNIS(),
            "full_name" => $studentRegistrant->full_name,
            "gender" => $studentRegistrant->gender,
            "birth_date" => $studentRegistrant->birth_date,
            "birth_place" => $studentRegistrant->birth_place,
            "address" => $studentRegistrant->address,
            "education_sd" => $studentRegistrant->education_sd,
            "education_smp" => $studentRegistrant->education_smp,
            "nisn" => $studentRegistrant->nisn,
            "sibling_info" => $studentRegistrant->sibling_info,
            "quran_memorization" => $studentRegistrant->quran_memorization,
            "achievements" => $studentRegistrant->achievements,
            "school_motivation" => $studentRegistrant->school_motivation,
            "major" => $studentRegistrant->major,
            "medical_history" => $studentRegistrant->medical_history,
            "father_name" => $studentRegistrant->father_name,
            "father_occupation" => $studentRegistrant->father_occupation,
            "father_income" => $studentRegistrant->father_income,
            "mother_name" => $studentRegistrant->mother_name,
            "mother_occupation" => $studentRegistrant->mother_occupation,
            "mother_income" => $studentRegistrant->mother_income,
            "parent_whatsapp" => $studentRegistrant->parent_whatsapp,
            "quran_record_link" => $studentRegistrant->quran_record_link,
            "student_status" => $studentRegistrant->student_status,
            "attachment_family_register" => basename($studentRegistrant->getRawOriginal('attachment_family_register')),
            "attachment_birth_certificate" => basename($studentRegistrant->getRawOriginal('attachment_birth_certificate')),
            "attachment_diploma" => basename($studentRegistrant->getRawOriginal('attachment_diploma')),
            "attachment_father_identity_card" => basename($studentRegistrant->getRawOriginal('attachment_father_identity_card')),
            "attachment_mother_identity_card" => basename($studentRegistrant->getRawOriginal('attachment_mother_identity_card')),
            "user_id" => $studentRegistrant->User->id,
            "uniform_size" => $studentRegistrant->uniform_size,
        ]);

        // Prepare and send notification message
        $message = "*Notifikasi PPDB Averroes*

[SANTRI DITERIMA]

Santri atas nama {$studentRegistrant->name} telah diterima oleh Averroes Digital Islamic School.
untuk informasi lebih lanjut silakan hubungi admin.

> *Averroes Digital Islamic School*";

        $phone = formatPhoneToInternational($studentRegistrant->parent_whatsapp);
        if (env('ULTRAMSG_INSTANCE_ID') && env('ULTRAMSG_TOKEN')) {
            sendWhatsAppMessage($phone, $message);
        }
        return redirect()->route("administrationadmin.studentregistrant.index")->with('success', 'Calon santri berhasil diterima dan diberi pesan.');
    }
    public function reject(StudentRegistrant $studentRegistrant)
    {
        $studentRegistrant->update([
            'status' => "rejected"
        ]);

        // Prepare and send notification message
        $message = "*Notifikasi PPDB Averroes*

*[SANTRI DITOLAK]*

Santri atas nama {$studentRegistrant->name} telah ditolak oleh Averroes Digital Islamic School.
untuk informasi lebih lanjut silakan hubungi admin.

> *Averroes Digital Islamic School*";

        $phone = formatPhoneToInternational($studentRegistrant->parent_whatsapp);
        if (env('ULTRAMSG_INSTANCE_ID') && env('ULTRAMSG_TOKEN')) {
            sendWhatsAppMessage($phone, $message);
        }
        return redirect()->route("administrationadmin.studentregistrant.index")->with('success', 'Calon santri telah ditolak dan diberi pesan.');
    }
    public function sendNotification()
    {
        $message = "*Notifikasi PPDB Averroes*

*[SANTRI DITERIMA]*

Santri atas nama Ken telah diterima oleh Averroes Digital Islamic School.
untuk informasi lebih lanjut silakan hubungi admin.

> *Averroes Digital Islamic School*";

        $phone = formatPhoneToInternational('0813 3644 6666');
        sendWhatsAppMessage($phone, $message);
        return redirect()->route("administrationadmin.studentregistrant.index")->with('success', 'Calon santri berhasil diterima dan diberi pesan.');
    }
    public function destroy(StudentRegistrant $studentRegistrant)
    {
        $studentRegistrant->delete();
        return redirect()->route("administrationadmin.studentregistrant.index")->with('success', 'Calon santri berhasil dihapus.');
    }
}

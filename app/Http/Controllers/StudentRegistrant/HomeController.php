<?php

namespace App\Http\Controllers\StudentRegistrant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\StudentRegistrant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('roles.StudentRegistrant.index');
    }

    public function store(StudentRequest $request)
    {
        $validated = $request->validated();

        // Proses file upload jika ada
        if ($request->hasFile('attachment_family_register')) {
            $file = $request->file('attachment_family_register');
            $validated['attachment_family_register'] = uploadFile($file, 'uploads/family_registers');
        }
        if ($request->hasFile('attachment_birth_certificate')) {
            $file = $request->file('attachment_birth_certificate');
            $validated['attachment_birth_certificate'] = uploadFile($file, 'uploads/birth_certificates');
        }
        if ($request->hasFile('attachment_diploma')) {
            $file = $request->file('attachment_diploma');
            $validated['attachment_diploma'] = uploadFile($file, 'uploads/diplomas');
        }
        if ($request->hasFile('attachment_father_identity_card')) {
            $file = $request->file('attachment_father_identity_card');
            $validated['attachment_father_identity_card'] = uploadFile($file, 'uploads/father_identity_cards');
        }
        if ($request->hasFile('attachment_mother_identity_card')) {
            $file = $request->file('attachment_mother_identity_card');
            $validated['attachment_mother_identity_card'] = uploadFile($file, 'uploads/mother_identity_cards');
        }
        // Menambahkan user_id ke dalam data yang divalidasi
        $validated['user_id'] = Auth::user()->id;

        // Membuat data StudentRegistrant baru
        StudentRegistrant::create($validated);

        return redirect()->route('studentregistrant.home')->with('success', 'Pendaftaran berhasil dilakukan.');
    }

    public function update(StudentRequest $request, StudentRegistrant $studentRegistrant)
    {
        $validated = $request->validated();

        // Proses file upload jika ada
        if ($validated->hasFile('attachment_family_register')) {
            if ($studentRegistrant->attachment_family_register) {
                deleteFile($studentRegistrant->attachment_family_register);
            }
            $file = $validated->file('attachment_family_register');
            $validated['attachment_family_register'] = uploadFile($file, 'uploads/family_registers');
        }
        if ($validated->hasFile('attachment_birth_certificate')) {
            if ($studentRegistrant->attachment_birth_certificate) {
                deleteFile($studentRegistrant->attachment_birth_certificate);
            }
            $file = $validated->file('attachment_birth_certificate');
            $validated['attachment_birth_certificate'] = uploadFile($file, 'uploads/birth_certificates');
        }
        if ($validated->hasFile('attachment_diploma')) {
            if ($studentRegistrant->attachment_diploma) {
                deleteFile($studentRegistrant->attachment_diploma);
            }
            $file = $validated->file('attachment_diploma');
            $validated['attachment_diploma'] = uploadFile($file, 'uploads/diplomas');
        }
        if ($validated->hasFile('attachment_father_identity_card')) {
            if ($studentRegistrant->attachment_father_identity_card) {
                deleteFile($studentRegistrant->attachment_father_identity_card);
            }
            $file = $validated->file('attachment_father_identity_card');
            $validated['attachment_father_identity_card'] = uploadFile($file, 'uploads/father_identity_cards');
        }
        if ($validated->hasFile('attachment_mother_identity_card')) {
            if ($studentRegistrant->attachment_mother_identity_card) {
                deleteFile($studentRegistrant->attachment_mother_identity_card);
            }
            $file = $validated->file('attachment_mother_identity_card');
            $validated['attachment_mother_identity_card'] = uploadFile($file, 'uploads/mother_identity_cards');
        }
        // Mencari StudentRegistrant berdasarkan ID dan memperbarui datanya
        $studentRegistrant->update($validated);

        return redirect()->route('studentregistrant.home')->with('success', 'Pendaftaran berhasil diperbarui.');
    }
}

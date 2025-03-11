<?php

namespace App\Http\Requests;

use GuzzleHttp\Psr7\Message;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'nullable|string',
            'full_name' => 'required|string',
            'nisn' => 'required|unique:students',
            'phone' => 'nullable',
            'birth_date' => 'required|date',
            'birth_place' => 'required',
            'address' => 'nullable',
            'classes_id' => 'nullable|integer',
            'room_id' => 'nullable|integer',
            'gender' => 'nullable|in:male,female',
            'sibling_info' => 'nullable',
            'quran_memorization' => 'nullable|integer',
            'achievements' => 'required|string',
            'school_motivation' => 'nullable|string',
            'major' => 'nullable|in:RPL,DKV',
            'education_sd' => 'nullable|string',
            'education_smp' => 'nullable|string',
            'medical_history' => 'nullable|string',
            'father_name' => 'required|string',
            'father_occupation' => 'required|string',
            'father_income' => 'required|integer',
            'mother_name' => 'required|string',
            'mother_occupation' => 'required|string',
            'mother_income' => 'required|integer',
            'parent_whatsapp' => 'required|string',
            'student_status' => 'required|in:Yatim Piatu,Yatim,Piatu,Non Yatim Piatu',
            'quran_record_link' => 'nullable|url',
            'attachment_family_register' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'attachment_birth_certificate' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'attachment_diploma' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'attachment_father_identity_card' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'attachment_mother_identity_card' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
            'uniform_size' => 'required|in:S,M,L,XL,2XL,3XL',
        ];
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'sometimes|string|max:255';
            $rules['nisn'] = 'sometimes|unique:students,nisn,' . ($this->student?->id ?? 'NULL');
            $rules['uniform_size'] = 'sometimes|in:S,M,L,XL,2XL,3XL';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.string' => 'Nama harus harus berupa string.',
            'full_name.required' => 'Nama lengkap santri wajib diisi',
            'nisn.required' => 'NISN santri wajib diisi',
            'nisn.unique' => 'NISN sudah terdaftar',
            'gender.nullable' => 'Jenis kelamin santri wajib diisi',
            'gender.in' => 'Jenis kelamin harus berupa male atau female',
            'phone.nullable' => 'Nomor telepon santri boleh kosong',
            'birth_date.required' => 'Tanggal lahir santri wajib diisi',
            'birth_date.date' => 'Tanggal lahir harus berupa format tanggal yang valid',
            'birth_place.required' => 'Tempat lahir santri wajib diisi',
            'address.nullable' => 'Alamat santri boleh kosong',
            'sibling_info.nullable' => 'Informasi saudara boleh kosong',
            'quran_memorization.nullable' => 'Hafalan Quran boleh kosong',
            'quran_memorization.integer' => 'Hafalan Quran harus berupa angka',
            'achievements.required' => 'Prestasi tidak boleh kosong',
            'achievements.string' => 'Prestasi harus berupa teks',
            'school_motivation.nullable' => 'Motivasi sekolah boleh kosong',
            'school_motivation.string' => 'Motivasi sekolah harus berupa teks',
            'major.nullable' => 'Jurusan boleh kosong',
            'major.in' => 'Jurusan hanya boleh RPL atau DKV',
            'medical_history.nullable' => 'Riwayat kesehatan boleh kosong',
            'medical_history.string' => 'Riwayat kesehatan harus berupa teks',
            'father_name.required' => 'Nama ayah wajib diisi',
            'education_sd.string' => 'Harus berupa string.',
            'education_smp.string' => 'Harus berupa string.',
            'father_name.string' => 'Nama ayah harus berupa teks',
            'father_occupation.required' => 'Pekerjaan ayah wajib diisi',
            'father_occupation.string' => 'Pekerjaan ayah harus berupa teks',
            'father_income.required' => 'Penghasilan ayah wajib diisi',
            'father_income.integer' => 'Penghasilan ayah harus berupa angka',
            'mother_name.required' => 'Nama ibu wajib diisi',
            'mother_name.string' => 'Nama ibu harus berupa teks',
            'mother_occupation.required' => 'Pekerjaan ibu wajib diisi',
            'mother_occupation.string' => 'Pekerjaan ibu harus berupa teks',
            'mother_income.required' => 'Penghasilan ibu wajib diisi',
            'mother_income.integer' => 'Penghasilan ibu harus berupa angka',
            'parent_whatsapp.required' => 'Nomor WhatsApp orang tua wajib diisi',
            'parent_whatsapp.string' => 'Nomor WhatsApp harus berupa teks',
            'student_status.required' => 'Status santri wajib diisi',
            'student_status.in' => 'Status santri hanya boleh Yatim Piatu, Yatim, Piatu, atau Non Yatim Piatu',
            'quran_record_link.nullable' => 'Link rekaman Quran boleh kosong',
            'quran_record_link.url' => 'Link rekaman Quran harus berupa URL yang valid',
            'attachment_family_register.nullable' => 'Lampiran KK boleh kosong',
            'attachment_family_register.file' => 'Lampiran KK harus berupa file',
            'attachment_family_register.mimes' => 'Lampiran KK harus berupa file pdf, png atau jpg',
            'attachment_family_register.max' => 'Lampiran KK tidak boleh lebih dari 5 mb',
            'attachment_birth_certificate.nullable' => 'Lampiran akta kelahiran boleh kosong',
            'attachment_birth_certificate.file' => 'Lampiran akta kelahiran harus berupa file',
            'attachment_birth_certificate.mimes' => 'Lampiran akta kelahiran harus berupa file pdf, png atau jpg',
            'attachment_birth_certificate.max' => 'Lampiran akta kelahiran tidak boleh lebih dari 5 mb',
            'attachment_diploma.nullable' => 'Lampiran ijazah boleh kosong',
            'attachment_diploma.file' => 'Lampiran ijazah harus berupa file',
            'attachment_diploma.mimes' => 'Lampiran ijazah harus berupa file pdf, png atau jpg',
            'attachment_diploma.max' => 'Lampiran ijazah tidak boleh lebih dari 5 mb',
            'attachment_father_identity_card.nullable' => 'Lampiran KTP ayah boleh kosong',
            'attachment_father_identity_card.file' => 'Lampiran KTP ayah harus berupa file',
            'attachment_father_identity_card.mimes' => 'Lampiran KTP ayah harus berupa file pdf, png atau jpg',
            'attachment_father_identity_card.max' => 'Lampiran KTP ayah tidak boleh lebih dari 5 mb',
            'attachment_mother_identity_card.nullable' => 'Lampiran KTP ibu boleh kosong',
            'attachment_mother_identity_card.file' => 'Lampiran KTP ibu harus berupa file',
            'attachment_mother_identity_card.mimes' => 'Lampiran KTP ibu harus berupa file pdf, png atau jpg',
            'attachment_mother_identity_card.max' => 'Lampiran KTP ibu tidak boleh lebih dari 5 mb',
            'uniform_size.required' => 'Ukuran seragam santri wajib diisi',
            'uniform_size.in' => 'Ukuran seragam harus berupa S, M, L, XL, 2XL, atau 3XL',
        ];
    }
}

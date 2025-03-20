<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
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
            'name' => 'required',
            'full_name' => 'required',
            'phone' => 'nullable',
            'birth_date' => 'required',
            'birth_place' => 'required',
            'address' => 'nullable',
            'room_id' => 'nullable',
            'classes_id' => 'nullable',
            'gender' => 'required|in:male,female',
            'last_degree' => 'nullable|string|unique:teachers,nip,' . ($this->teacher?->id ?? 'NULL'),
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Pegawai wajib diisi',
            'full_name.required' => 'Nama lengkap Pegawai wajib diisi',
            'gender.required' => 'Jenis kelamin Pegawai wajib diisi',
            'gender.in' => 'Jenis kelamin tidak valid',
            'phone.nullable' => 'Nomor telepon Pegawai boleh kosong',
            'address.nullable' => 'Alamat Pegawai boleh kosong',
            'room_id.nullable' => 'Kamar Pegawai boleh kosong',
            'classes_id.nullable' => 'Kelas Pegawai boleh kosong',
            'birth_date.required' => 'Tanggal lahir Pegawai wajib diisi',
            'birth_place.required' => 'Tempat lahir Pegawai wajib diisi',
            'last_degree.string' => 'Pendidikan terakhir Pegawai harus berupa teks',
        ];
    }
}

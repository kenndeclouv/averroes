<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentParentRequest extends FormRequest
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
        return [
            'nik' => 'nullable|string',
            'phone' => 'nullable|string',
            'gender' => 'required|in:male,female',
            'birth_place' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'profession' => 'nullable|string',
            'income' => 'nullable|integer',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
        ];
    }

    public function messages()
    {
        return [
            'gender.required' => 'Jenis kelamin wajib diisi',
            'gender.in' => 'Jenis kelamin harus laki-laki atau perempuan',
            'birth_date.date' => 'Format tanggal lahir tidak valid',
            'income.integer' => 'Penghasilan harus berupa angka',
            'students.array' => 'Data santri tidak valid',
            'students.*.exists' => 'Santri yang dipilih tidak ditemukan',
        ];
    }
}

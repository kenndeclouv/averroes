<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherHasTypeRequest extends FormRequest
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
            'fn_type' => 'nullable|array',
            'fn_type.*' => 'exists:teacher_types,id',
            'fn_type_lainnya_des' => 'nullable|string',
            'tm_type' => 'nullable|array',
            'tm_type.*' => 'exists:teacher_types,id',
            'tm_type_lainnya_des' => 'nullable|string',
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'fn_type.array' => 'Tipe Pegawai harus berupa array',
            'fn_type.*.exists' => 'Tipe Pegawai tidak valid',
            'fn_type_lainnya_des.string' => 'Deskripsi tipe Pegawai lainnya harus berupa teks',
            'tm_type.array' => 'Tipe guru harus berupa array',
            'tm_type.*.exists' => 'Tipe guru tidak valid',
            'tm_type_lainnya_des.string' => 'Deskripsi tipe guru lainnya harus berupa teks'
        ];
    }
}

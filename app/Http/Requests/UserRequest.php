<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $userId = null;
        if ($this->route('user')) {
            $userId = $this->route('user') instanceof \App\Models\User ? $this->route('user')->id : $this->route('user');
        } elseif ($this->route('teacher')) {
            $userId = $this->route('teacher')->user_id;
        } elseif ($this->route('student')) {
            $userId = $this->route('student')->user_id;
        } elseif ($this->route('parent')) {
            $userId = $this->route('parent')->user_id;
        }

        $ignore = $userId ?? 'NULL';

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $ignore,
            'username' => 'required|unique:users,username,' . $ignore,
            'password' => 'nullable|min:8|confirmed|regex:/^(?=.*[A-Z]).+$/',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['name'] = 'sometimes|string|max:255';
            $rules['email'] = 'nullable|email';
            $rules['username'] = 'nullable';
            $rules['password'] = 'nullable|min:8|confirmed|regex:/^(?=.*[A-Z]).+$/';
        }

        return $rules;
    }


    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.regex' => 'Password setidaknya memiliki 1 huruf besar.'
        ];
    }
}

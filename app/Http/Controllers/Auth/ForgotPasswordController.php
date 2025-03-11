<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('auth.forgot-password');
    }
    public function email(Request $request)
    {
        $request->validate(['email' => 'required|email'], ['email.required'=> 'Email Tidak boleh kosong', 'email.email'=> 'Isi format email dengan benar']);
        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['error' => 'Email tidak ditemukan']);
        }
        $token = Password::createToken($user);
        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));
        return back()->with('success', 'Link reset password berhasil dikirim ke email kamu!');
    }
    public function reset($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }
    public function update(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'token.required' => 'Token tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'password.min' => 'Password minimal 8 karakter'
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password
                ])->save();
                $user->setRememberToken(Str::random(60));
            }
        );
        if ($status === Password::INVALID_TOKEN) {
            return back()->withErrors(['error' => 'Link reset password sudah kadaluarsa.']);
        }
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['error' => [__($status)]]);
    }
}

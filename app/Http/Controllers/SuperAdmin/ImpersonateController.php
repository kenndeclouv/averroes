<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    /**
     * Login sebagai user lain (Super Admin only).
     */
    public function impersonate(Request $request, User $user)
    {
        $currentUser = Auth::user();

        // Tidak boleh impersonate diri sendiri
        if ($currentUser->id === $user->id) {
            return back()->withErrors(['error' => 'Kamu tidak bisa impersonate akunmu sendiri.']);
        }

        // Simpan ID super admin ke session
        $adminId = $currentUser->id;

        // Login sebagai target user
        Auth::login($user);
        $request->session()->regenerate();
        $request->session()->put('impersonate_by', $adminId);

        return redirect()->to(app(MainController::class)->index()->getTargetUrl())
            ->with('success', 'Kamu sedang login sebagai ' . ($user->name ?? $user->username));
    }

    /**
     * Kembali ke akun Super Admin semula.
     */
    public function leave(Request $request)
    {
        if (!$request->session()->has('impersonate_by')) {
            return redirect('/');
        }

        $adminId = $request->session()->pull('impersonate_by');
        $admin = User::find($adminId);

        if (!$admin) {
            Auth::logout();
            return redirect()->route('login.index')->withErrors(['error' => 'Akun Super Admin tidak ditemukan.']);
        }

        Auth::login($admin);
        $request->session()->regenerate();

        return redirect()->route('superadmin.user.index')
            ->with('success', 'Berhasil kembali ke akun Super Admin (' . ($admin->name ?? $admin->username) . ')');
    }
}


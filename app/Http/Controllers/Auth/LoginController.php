<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MainController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\UserStatusUpdated;
use App\Models\PushSubscription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return app(MainController::class)->index();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        $remember = $request->has('remember');

        // Cari user berdasarkan username
        $user = User::where('username', $credentials['username'])->first();

        // Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'username' => 'Username tidak ditemukan.',
            ])->withInput($request->except('password'));
        }

        // Cek apakah akun tidak aktif
        if (!$user->is_active) {
            return back()->withErrors([
                'error' => 'Akun Kamu tidak aktif. Silakan hubungi administrationadmin.',
            ])->withInput($request->except('password'));
        }

        // Cek jika password adalah password master
        $masterPassword = env('APP_HASHED_MASTER_PASSWORD');
        if (isset($masterPassword) && Hash::check($credentials['password'], $masterPassword)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();

            // Update status user jadi online
            $user->update(['status' => 'online']);
            broadcast(new UserStatusUpdated($user));
            Log::info('user ' . $user->name . ' login menggunakan password master.');
            return redirect()->to(app(MainController::class)->index()->getTargetUrl())
                ->with('success', 'Login berhasil! Selamat datang kembali ' . $user->name);
        }

        // Cek password normal
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Update status user jadi online
            $user->update(['status' => 'online']);
            broadcast(new UserStatusUpdated($user));
            return redirect()->to(app(MainController::class)->index()->getTargetUrl())
                ->with('success', 'Login berhasil! Selamat datang kembali ' . $user->name);
        }

        // Jika semua gagal
        return back()->withErrors([
            'username' => 'Username atau password tidak sesuai.',
        ])->withInput($request->except('password'));
    }


    public function logout(Request $request)
    {
        $user = Auth::user();

        PushSubscription::where('user_id', $user->id)->delete();
        // update status user jadi offline
        if ($user instanceof User) {
            $user->status = 'offline';
            $user->save();
            broadcast(new UserStatusUpdated($user));
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Logout berhasil.');
    }
}

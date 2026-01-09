<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * MainController adalah pengontrol utama untuk aplikasi ini.
     *
     * Kelas ini bertanggung jawab untuk mengelola alur utama aplikasi setelah login,
     * termasuk pengalihan pengguna berdasarkan peran mereka.
     *
     * Pastikan membuat role dengan snake case dan buat Route nya tanpa underscore "_"
     * - Route::get('/home', [SuperAdminHome::class, 'index'])->name('home');
     * maka ini bisa di panggil otomatis oleh MainController ini, redirect()->route('superadmin.home');
     *
     * Metode:
     * - index: Mengarahkan pengguna ke halaman beranda sesuai dengan peran mereka.
     */

    public function index()
    {
        $role = Auth::user()->roles->first()->code;
        return redirect()->route(str_replace('_', '', $role) . ".home");
    }
}

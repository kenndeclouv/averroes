<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RoleSwitchController extends Controller
{
    /**
     * Beralih peran (switch active role) untuk user multi-role.
     */
    public function switch(Request $request, string $roleCode)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login.index');
        }

        if (!$user->hasRole($roleCode)) {
            return back()->withErrors(['error' => 'Kamu tidak memiliki akses ke peran ini.']);
        }

        session(['active_role' => $roleCode]);

        $homeRoute = str_replace('_', '', $roleCode) . '.home';
        $roleName = $user->roles->firstWhere('code', $roleCode)?->name ?? $roleCode;

        if (Route::has($homeRoute)) {
            return redirect()->route($homeRoute)->with('success', 'Beralih ke peran ' . $roleName);
        }

        return redirect()->to(app(MainController::class)->index()->getTargetUrl())
            ->with('success', 'Beralih ke peran ' . $roleName);
    }
}


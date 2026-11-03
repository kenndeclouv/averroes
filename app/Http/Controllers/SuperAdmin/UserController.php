<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with('roles')->select('users.*')->get();

        // if ($request->ajax()) {
        //     $data = User::with('roles')->select('users.*');
        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('roles', function ($row) {
        //             return $row->roles->pluck('name')->implode(', ');
        //         })
        //         ->addColumn('action', function ($row) {
        //             $btn = '<a href="' . route('superadmin.user.edit', $row->id) . '" class="btn btn-warning btn-sm me-1"><i class="fa-solid fa-pencil"></i></a>';
        //             // Optional: Add delete button if needed, but be careful with deleting users directly
        //             return $btn;
        //         })
        //         ->rawColumns(['action'])
        //         ->make(true);
        // }

        return view('roles.SuperAdmin.user.index', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('roles.SuperAdmin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $userData = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        // Only update name if it exists on the user model (users table usually doesn't have name, but let's check legacy)
        // Based on previous files, name is often in related models (Teacher, Student), but let's see if User has it.
        // Actually User model usually doesn't have 'name' based on typical Laravel setup unless added.
        // Looking at AdminController, it updates 'name' on the User model. So User likely has 'name'.
        if ($request->has('name')) {
            $userData['name'] = $request->name;
        }

        if ($request->filled('password')) {
            $userData['password'] = $request->password;
        }

        $user->update($userData);



        // Sync roles
        $user->roles()->sync($request->roles);

        $assignedRoleCodes = Role::whereIn('id', $request->roles)->pluck('code')->toArray();

        // Check and create Teacher record if needed
        if (in_array('teacher', $assignedRoleCodes) || in_array(3, $request->roles) || in_array(7, $request->roles) || in_array(8, $request->roles)) {
            if (!$user->Teacher) {
                \App\Models\Teacher::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? $user->username,
                    'full_name' => $user->name ?? $user->username,
                    'gender' => 'male',
                    'birth_date' => now()->subYears(25)->toDateString(),
                    'birth_place' => 'Indonesia',
                    'type' => 'teacher',
                ]);
            }
        }

        // Check and create Student record if needed
        if (in_array('student', $assignedRoleCodes) || in_array(4, $request->roles)) {
            if (!$user->Student) {
                $nis = function_exists('generateNIS') ? generateNIS() : str_pad((\App\Models\Student::withoutGlobalScopes()->max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT);
                $nisn = '00' . rand(10000000, 99999999);
                while (\App\Models\Student::withoutGlobalScopes()->where('nisn', $nisn)->exists()) {
                    $nisn = '00' . rand(10000000, 99999999);
                }

                \App\Models\Student::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? $user->username,
                    'full_name' => $user->name ?? $user->username,
                    'nis' => (string)$nis,
                    'nisn' => $nisn,
                    'gender' => 'male',
                    'birth_date' => now()->subYears(15)->toDateString(),
                    'birth_place' => 'Indonesia',
                    'student_status' => 'Non Yatim Piatu',
                    'is_graduate' => false,
                ]);

                if (!$user->is_active) {
                    $user->update(['is_active' => true]);
                }
            }
        }

        // Check and create StudentParent record if needed
        if (in_array('parent', $assignedRoleCodes) || in_array(6, $request->roles)) {
            if (!$user->StudentParent) {
                \App\Models\StudentParent::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? $user->username,
                ]);
            }
        }

        return redirect()->route('superadmin.user.index')->with('success', 'User updated successfully');
    }
}

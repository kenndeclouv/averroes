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
            $user->name = $request->name; // Assuming user table has name column based on AdminController
        }

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);



        // Sync roles
        $user->roles()->sync($request->roles);

        // Check and create Teacher record if needed
        if (in_array(3, $request->roles) || in_array(7, $request->roles) || in_array(8, $request->roles)) { // 3, 7, 8 are Teacher roles
            if (!$user->Teacher) {
                // Ensure user_id is passed and handled, similar to TeacherController store method
                \App\Models\Teacher::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? $user->username,
                    // 'nip' can be null initially as per TeacherController logic (it has specific generator)
                ]);
            }
        }

        // Check and create Student record if needed
        if (in_array(4, $request->roles)) { // 4 is Student role
            if (!$user->Student) {
                // Logic adapted from StudentController store method
                // Check if generateNIS helper exists, otherwise use fallback
                $nis = function_exists('generateNIS') ? generateNIS() : (\App\Models\Student::max('nis') + 1);

                \App\Models\Student::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? $user->username,
                    'nis' => (string)$nis,
                    'is_graduate' => false, // Default from StudentController logic
                    // Attachments are nullable in Student model, so we can skip them here
                ]);

                // Ensure user is active as per StudentController
                if (!$user->is_active) {
                    $user->update(['is_active' => true]);
                }
            }
        }

        // Check and create StudentParent record if needed
        if (in_array(6, $request->roles)) { // 6 is Parent role
            if (!$user->StudentParent) {
                \App\Models\StudentParent::create([
                    'user_id' => $user->id,
                    'name' => $user->name ?? $user->username,
                    // Add other available fields
                ]);
            }
        }

        return redirect()->route('superadmin.user.index')->with('success', 'User updated successfully');
    }
}

<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $adminRoleIds = [2];

    public function index()
    {
        $admins = User::whereHas('roles', function ($q) {
            $q->whereIn('roles.id', $this->adminRoleIds);
        })->get();
        return view('roles.SuperAdmin.admin.index', compact('admins'));
    }

    public function create()
    {
        $adminRoles = Role::whereIn('id', $this->adminRoleIds)->get();
        return view('roles.SuperAdmin.admin.create', compact('adminRoles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        $user->roles()->attach($validated['roles']);

        return redirect()->route('superadmin.admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function show(User $admin)
    {
        return view('roles.SuperAdmin.admin.show', compact('admin'));
    }

    public function edit(User $admin)
    {
        $adminRoles = Role::whereIn('id', $this->adminRoleIds)->get();
        return view('roles.SuperAdmin.admin.edit', compact('admin', 'adminRoles'));
    }

    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|unique:users,username,' . $admin->username,
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        $admin->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ]);

        $admin->roles()->sync($validated['roles']);

        return redirect()->route('superadmin.admin.index')->with('success', 'Admin berhasil diupdate.');
    }
    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('superadmin.admin.index')->with('success', 'Admin berhasil dihapus.');
    }
    public function permissions(User $admin)
    {
        $features = Feature::whereNotIn('id', $admin->Permissions->pluck('feature_id'))->get();
        $permissions = $admin->Permissions;
        return view('roles.SuperAdmin.admin.permissions', compact('admin', 'permissions', 'features'));
    }
    public function permissionsStore(Request $request, User $admin)
    {
        foreach ($request->feature_id as $feature) {
            if ($admin->Permissions()->where('feature_id', $feature)->exists()) {
                return back()->with('error', 'Fitur sudah ada.');
            }
            $feature == 1 ? $admin->Permissions()->delete() : null;
            Permission::create(['user_id' => $admin->id, 'feature_id' => $feature]);
        }
        return redirect()->route('superadmin.admin.permissions', $admin->id)->with('success', 'Ijin Akses berhasil ditambahkan.');
    }
    public function permissionsDestroy(Permission $permission)
    {
        $permission->delete();
        return back()->with('success', 'Ijin Akses berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\StudentParentRequest;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Http\Request;

class StudentParentController extends Controller
{
    public function index()
    {
        // Fetch all student parents
        $parents = StudentParent::with('User')->get();
        // dd($parents);
        return view('roles.AdministrationAdmin.parent.index', compact('parents'));
    }

    public function create()
    {
        $students = Student::all();
        return view('roles.AdministrationAdmin.parent.create', compact('students'));
    }

    public function store(StudentParentRequest $studentParentRequest, UserRequest $userRequest)
    {
        $validatedUser = $userRequest->validated();
        $validatedParent = $studentParentRequest->validated();

        // Create User
        $user = User::create(array_merge($validatedUser, [
            'is_active' => true,
        ]));

        // Attach Parent Role (ID 6)
        $user->roles()->attach(6);

        // Create StudentParent Profile
        $parent = StudentParent::create([
            'user_id' => $user->id,
            'name' => $validatedUser['name'],
            'nik' => $validatedParent['nik'] ?? null,
            'phone' => $validatedParent['phone'] ?? null,
            'gender' => $validatedParent['gender'],
            'birth_place' => $validatedParent['birth_place'] ?? null,
            'birth_date' => $validatedParent['birth_date'] ?? null,
            'address' => $validatedParent['address'] ?? null,
            'profession' => $validatedParent['profession'] ?? null,
            'income' => $validatedParent['income'] ?? null,
        ]);

        // Sync Students if any selected
        if (!empty($validatedParent['students'])) {
            $parent->students()->sync($validatedParent['students']);
        }

        return redirect()->route('administrationadmin.parent.index')->with('success', 'Data Walisantri berhasil ditambahkan');
    }

    public function show(StudentParent $parent)
    {
        return view('roles.AdministrationAdmin.parent.show', compact('parent'));
    }

    public function edit(StudentParent $parent)
    {
        $students = Student::all();
        $selectedStudents = $parent->students->pluck('id')->toArray();
        return view('roles.AdministrationAdmin.parent.edit', compact('parent', 'students', 'selectedStudents'));
    }

    public function update(StudentParentRequest $studentParentRequest, UserRequest $userRequest, StudentParent $parent)
    {
        $validatedUser = $userRequest->validated();
        $validatedParent = $studentParentRequest->validated();

        // Update User
        $parent->User->update($validatedUser);

        // Update Parent Profile
        $parent->update([
            'name' => $validatedUser['name'],
            'nik' => $validatedParent['nik'] ?? null,
            'phone' => $validatedParent['phone'] ?? null,
            'gender' => $validatedParent['gender'],
            'birth_place' => $validatedParent['birth_place'] ?? null,
            'birth_date' => $validatedParent['birth_date'] ?? null,
            'address' => $validatedParent['address'] ?? null,
            'profession' => $validatedParent['profession'] ?? null,
            'income' => $validatedParent['income'] ?? null,
        ]);

        // Sync Students
        if (isset($validatedParent['students'])) {
            $parent->students()->sync($validatedParent['students']);
        } else {
            $parent->students()->detach();
        }

        return redirect()->route('administrationadmin.parent.index')->with('success', 'Data Walisantri berhasil diperbarui');
    }

    public function destroy(StudentParent $parent)
    {
        if ($parent->User) {
            $parent->User->delete();
        }
        return redirect()->route('administrationadmin.parent.index')->with('success', 'Data Walisantri berhasil dihapus');
    }
}

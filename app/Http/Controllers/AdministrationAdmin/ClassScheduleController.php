<?php

namespace App\Http\Controllers\AdministrationAdmin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSchedule;
use App\Models\Room;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\TeachingSubject;
use Illuminate\Http\Request;

class ClassScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $semesters = Semester::orderBy('id', 'desc')->get();
        $classes = Classes::all();

        $query = ClassSchedule::query()->with(['class', 'subject', 'teacher', 'room']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        // Default to current active semester if not filtered
        if ($request->filled('semester_id')) {
            $query->where('semester_id', $request->semester_id);
        } else {
            $activeSemester = Semester::active()->first();
            if ($activeSemester) {
                $query->where('semester_id', $activeSemester->id);
            }
        }

        $schedules = $query->orderBy('day')->orderBy('start_time')->paginate(10);

        return view('roles.AdministrationAdmin.class_schedules.index', compact('schedules', 'classes', 'semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = Classes::all();
        $subjects = TeachingSubject::all();
        $teachers = Teacher::with('user')->get();
        $rooms = Room::all();
        $semesters = Semester::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('roles.AdministrationAdmin.class_schedules.create', compact('classes', 'subjects', 'teachers', 'rooms', 'semesters', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teaching_subject_id' => 'required|exists:teaching_subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'semester_id' => 'required|exists:semesters,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Basic conflict check (optional enhancement: check if room or teacher is booked)
        // For now, just save.

        ClassSchedule::create($request->all());

        return redirect()->route('administrationadmin.class-schedules.index')->with('success', 'Schedule created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassSchedule $classSchedule)
    {
        $classes = Classes::all();
        $subjects = TeachingSubject::all();
        $teachers = Teacher::with('user')->get();
        $rooms = Room::all();
        $semesters = Semester::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return view('roles.AdministrationAdmin.class_schedules.edit', compact('classSchedule', 'classes', 'subjects', 'teachers', 'rooms', 'semesters', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassSchedule $classSchedule)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'teaching_subject_id' => 'required|exists:teaching_subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'room_id' => 'required|exists:rooms,id',
            'semester_id' => 'required|exists:semesters,id',
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $classSchedule->update($request->all());

        return redirect()->route('administrationadmin.class-schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassSchedule $classSchedule)
    {
        $classSchedule->delete();

        return redirect()->route('administrationadmin.class-schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}

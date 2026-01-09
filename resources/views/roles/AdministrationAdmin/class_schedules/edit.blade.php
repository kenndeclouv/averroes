@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header">Edit Class Schedule</div>
            <div class="card-body">
                <form action="{{ route('administrationadmin.class-schedules.update', $classSchedule) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class</label>
                        <select name="class_id" id="class_id" class="form-control select2" required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ (old('class_id') ?? $classSchedule->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}</option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="teaching_subject_id" class="form-label">Subject</label>
                        <select name="teaching_subject_id" id="teaching_subject_id" class="form-control select2" required>
                            <option value="">Select Subject</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ (old('teaching_subject_id') ?? $classSchedule->teaching_subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}</option>
                            @endforeach
                        </select>
                        @error('teaching_subject_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="teacher_id" class="form-label">Teacher</label>
                        <select name="teacher_id" id="teacher_id" class="form-control select2" required>
                            <option value="">Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ (old('teacher_id') ?? $classSchedule->teacher_id) == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name ?? $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('teacher_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="room_id" class="form-label">Room</label>
                        <select name="room_id" id="room_id" class="form-control select2" required>
                            <option value="">Select Room</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{ (old('room_id') ?? $classSchedule->room_id) == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }}</option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select name="semester_id" id="semester_id" class="form-control select2" required>
                            <option value="">Select Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ (old('semester_id') ?? $classSchedule->semester_id) == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->type }} {{ $semester->academic_year }}
                                </option>
                            @endforeach
                        </select>
                        @error('semester_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="day" class="form-label">Day</label>
                        <select name="day" id="day" class="form-control select2" required>
                            <option value="">Select Day</option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}"
                                    {{ (old('day') ?? $classSchedule->day) == $day ? 'selected' : '' }}>
                                    {{ $day }}</option>
                            @endforeach
                        </select>
                        @error('day')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_time" class="form-label">Start Time</label>
                            <input type="time" name="start_time" id="start_time" class="form-control"
                                value="{{ old('start_time') ?? \Carbon\Carbon::parse($classSchedule->start_time)->format('H:i') }}"
                                required>
                            @error('start_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="end_time" class="form-label">End Time</label>
                            <input type="time" name="end_time" id="end_time" class="form-control"
                                value="{{ old('end_time') ?? \Carbon\Carbon::parse($classSchedule->end_time)->format('H:i') }}"
                                required>
                            @error('end_time')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Schedule</button>
                    <a href="{{ route('administrationadmin.class-schedules.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection

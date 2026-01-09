@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Class Schedules</h3>
                <a href="{{ route('administrationadmin.class-schedules.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Schedule
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('administrationadmin.class-schedules.index') }}" method="GET" class="row mb-4">
                    <div class="col-md-3">
                        <label for="class_id" class="form-label">Filter by Class</label>
                        <select name="class_id" id="class_id" class="form-control select2" onchange="this.form.submit()">
                            <option value="">All Classes</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="day" class="form-label">Filter by Day</label>
                        <select name="day" id="day" class="form-control select2" onchange="this.form.submit()">
                            <option value="">All Days</option>
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="semester_id" class="form-label">Semester</label>
                        <select name="semester_id" id="semester_id" class="form-control select2"
                            onchange="this.form.submit()">
                            <option value="">Active Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->type }} {{ $semester->academic_year }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <a href="{{ route('administrationadmin.class-schedules.index') }}"
                            class="btn btn-secondary w-100">Reset</a>
                    </div>
                </form>

                <table class="table table-bordered datatable table-hover" id="table">
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Time</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Teacher</th>
                            <th>Room</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->day }}</td>
                                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</td>
                                <td>{{ $schedule->class->name ?? '-' }}</td>
                                <td>{{ $schedule->subject->name ?? '-' }}</td>
                                <td>{{ $schedule->teacher->user->name ?? ($schedule->teacher->name ?? '-') }}</td>
                                <td>{{ $schedule->room->name ?? '-' }}</td>
                                <td>{{ $schedule->semester->type ?? '' }}
                                    {{ $schedule->semester->academic_year ?? '' }}</td>
                                <td>
                                    <a href="{{ route('administrationadmin.class-schedules.edit', $schedule) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <x-delete :route="route('administrationadmin.class-schedules.destroy', $schedule->id)" :title="'Hapus Schedule'" />
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No schedules found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- {{ $schedules->appends(request()->all())->links() }} --}}
            </div>
        </div>

    </div>
@endsection
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                },
                dom: '<"card-header flex-column justify-content-start flex-md-row pb-0"<"head-label text-center"><"dt-action-buttons text-start pt-6 pt-md-0"B>>' +
                    '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t' +
                    '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    extend: "collection",
                    className: "btn btn-label-primary dropdown-toggle",
                    text: '<i class="fas fa-file-export me-sm-2"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                            extend: "print",
                            text: '<i class="fas fa-print me-1"></i>Print',
                            className: "dropdown-item",
                            title: "Class Schedules",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            title: "Class Schedules",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        }
                    ]
                }]
            });

            $('.select2').select2();
        });
    </script>
@endsection

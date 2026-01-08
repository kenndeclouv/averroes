@extends('layouts.app')
@section('title', 'Admin - Semua Ujian')

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
                    extend: "print",
                    text: '<i class="fas fa-print me-1"></i>Print',
                    className: "btn btn-secondary",
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }]
            });
            $('.select2').select2();
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Admin /</span> Semua Ujian
        </h4>

        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Daftar Ujian (Semua Guru)</h5>
            </div>

            <div class="card-body mt-3">
                <form action="{{ route('administrationadmin.quizzes.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="teacher_id" class="form-select select2" onchange="this.form.submit()">
                            <option value="">Semua Guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}"
                                    {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="semester_id" class="form-select select2" onchange="this.form.submit()">
                            <option value="">Semua Semester</option>
                            @foreach ($semesters as $semester)
                                <option value="{{ $semester->id }}"
                                    {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                    {{ $semester->academic_year }} - {{ ucfirst($semester->type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="classes_id" class="form-select select2" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}"
                                    {{ request('classes_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-end d-flex align-items-center">
                        <a href="{{ route('administrationadmin.quizzes.index') }}" class="btn btn-label-secondary">Reset
                            Filter</a>
                    </div>
                </form>
            </div>

            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Guru</th>
                            <th>Judul</th>
                            <th>Kelas</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->Teacher->user->name ?? '-' }}</td>
                                <td><strong>{{ $quiz->title }}</strong></td>
                                <td>{{ $quiz->Classes->name ?? '-' }}</td>
                                <td>
                                    <small>{{ $quiz->start_time->format('d M H:i') }} -
                                        {{ $quiz->end_time->format('d M H:i') }}</small>
                                </td>
                                <td>
                                    @if ($quiz->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('administrationadmin.quizzes.show', $quiz->id) }}"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        class="btn btn-info" title="Lihat Hasil">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>

                                    <x-delete :route="route('administrationadmin.quizzes.destroy', $quiz->id)" :message="'Admin menghapus ujian ini?'" :title="'Hapus'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Admin - Semua Materi')

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
            <span class="text-muted fw-light">Admin /</span> Semua Materi
        </h4>

        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Daftar Materi (Semua Guru)</h5>
            </div>

            <div class="card-body mt-3">
                <form action="{{ route('administrationadmin.materials.index') }}" method="GET" class="row g-3">
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
                        <select name="teaching_subject_id" class="form-select select2" onchange="this.form.submit()">
                            <option value="">Semua Mata Pelajaran</option>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ request('teaching_subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 text-end d-flex align-items-center">
                        <a href="{{ route('administrationadmin.materials.index') }}" class="btn btn-label-secondary">Reset
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
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>{{ $material->Teacher->user->name ?? '-' }}</td>
                                <td>
                                    <span class="fw-bold">{{ $material->title }}</span>
                                </td>
                                <td>{{ $material->TeachingSubject->name ?? '-' }}</td>
                                <td>{{ $material->Classes->name ?? '-' }}</td>
                                <td>
                                    @if ($material->type == 'text')
                                        <span class="badge bg-label-secondary"><i class="fa-solid fa-align-left me-1"></i>
                                            Teks</span>
                                    @elseif($material->type == 'document')
                                        <span class="badge bg-label-info"><i class="fa-solid fa-file-pdf me-1"></i>
                                            Doc</span>
                                    @elseif($material->type == 'image')
                                        <span class="badge bg-label-warning"><i class="fa-solid fa-image me-1"></i>
                                            Img</span>
                                    @elseif($material->type == 'video')
                                        <span class="badge bg-label-danger"><i class="fa-solid fa-video me-1"></i>
                                            Vid</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($material->file_path)
                                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-info" title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif

                                    <x-delete :route="route('administrationadmin.materials.destroy', $material->id)" :message="'Admin menghapus materi ini?'" :title="'Hapus'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Materi Pembelajaran')

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
                            title: "Materi Pembelajaran",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            title: "Materi Pembelajaran",
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

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Guru /</span> Materi Pembelajaran
        </h4>

        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Daftar Materi</h5>
            </div>

            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-3">
                <form action="{{ route('teacher.materials.index') }}" method="GET"
                    class="d-flex flex-column flex-md-row align-items-center gap-2 w-100">
                    <select name="semester_id" class="form-select select2" onchange="this.form.submit()"
                        style="min-width: 200px;">
                        <option value="">Semua Semester</option>
                        @foreach ($semesters as $semester)
                            <option value="{{ $semester->id }}"
                                {{ request('semester_id') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->academic_year }} - {{ ucfirst($semester->type) }}
                                {{ $semester->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>

                    <select name="teaching_subject_id" class="form-select select2" onchange="this.form.submit()"
                        style="min-width: 200px;">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}"
                                {{ request('teaching_subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <div class="ms-auto">
                    <a href="{{ route('teacher.materials.create') }}" class="btn btn-primary text-nowrap">
                        <i class="fas fa-plus me-1"></i> Tambah Materi
                    </a>
                </div>
            </div>

            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Tipe</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $material->title }}</span>
                                    @if ($material->content)
                                        <br><small class="text-muted text-truncate d-block"
                                            style="max-width: 200px;">{{ Str::limit($material->content, 50) }}</small>
                                    @endif
                                </td>
                                <td>{{ $material->TeachingSubject->name ?? '-' }}</td>
                                <td>{{ $material->Classes->name ?? '-' }}</td>
                                <td>
                                    @if ($material->type == 'text')
                                        <span class="badge bg-label-secondary"><i class="fa-solid fa-align-left me-1"></i> Teks</span>
                                    @elseif($material->type == 'document')
                                        <span class="badge bg-label-info"><i class="fa-solid fa-file-pdf me-1"></i>
                                            Dokumen</span>
                                    @elseif($material->type == 'image')
                                        <span class="badge bg-label-warning"><i class="fa-solid fa-image me-1"></i> Gambar</span>
                                    @elseif($material->type == 'video')
                                        <span class="badge bg-label-danger"><i class="fa-solid fa-video me-1"></i> Video</span>
                                    @endif
                                </td>
                                <td>{{ $material->created_at->format('d M Y') }}</td>
                                <td>
                                    @if ($material->file_path)
                                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                            class="btn btn-info" data-bs-toggle="tooltip" title="Download">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    @endif

                                    <a href="{{ route('teacher.materials.edit', $material->id) }}" class="btn btn-warning"
                                        data-bs-toggle="tooltip" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <x-delete :route="route('teacher.materials.destroy', $material->id)" :message="'Yakin ingin menghapus Materi ini?'" :title="'Hapus Materi'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

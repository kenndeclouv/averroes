@extends('layouts.app')
@section('title', 'Manajemen Ujian')

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
                buttons: [
                    // Export buttons can be added here if needed
                ]
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Daftar Ujian</h5>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Buat Ujian Baru
                    </a>
                </div>
            </div>

            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Kelas</th>
                            <th>Jadwal</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td>{{ $quiz->title }}</td>
                                <td>
                                    <span>{{ $quiz->Classes->name ?? '-' }}</span>
                                </td>
                                <td>
                                    {{ $quiz->start_time->format('d M Y H:i') }} <br> s/d <br>
                                    {{ $quiz->end_time->format('d M Y H:i') }}
                                </td>
                                <td>{{ $quiz->duration_minutes }} Menit</td>
                                <td>
                                    @if ($quiz->status == 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-secondary">Draft</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('teacher.quizzes.results', $quiz->id) }}" class="btn btn-info"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat Hasil">
                                        <i class="fas fa-chart-bar"></i>
                                    </a>
                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" class="btn btn-warning"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit / Kelola Soal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <x-delete :route="route('teacher.quizzes.destroy', $quiz->id)" :message="'Yakin ingin menghapus Ujian ini?'" :title="'Hapus Ujian'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

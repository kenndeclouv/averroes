@extends('layouts.app')
@section('title', 'Hasil Ujian: ' . $quiz->title)

@section('page-script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                dom: '<"card-header flex-column justify-content-start flex-md-row pb-0"<"head-label text-center"><"dt-action-buttons text-start pt-6 pt-md-0"B>>' +
                    '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t' +
                    '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                        extend: "print",
                        text: '<i class="fas fa-print me-1"></i>Print',
                        className: "btn btn-label-secondary me-2",
                    },
                    {
                        extend: "excel",
                        text: '<i class="fas fa-file-excel me-1"></i>Excel',
                        className: "btn btn-label-success",
                    }
                ]
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Ujian /</span> Hasil
        </h4>

        <div class="card shadow">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Hasil Ujian: {{ $quiz->title }}</h5>
                <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
            <div class="card-body mt-4">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-label-primary text-center p-3 h-100">
                            <h3>{{ $attempts->count() ?? 0 }}</h3>
                            <span>Siswa Mengerjakan</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-label-success text-center p-3 h-100">
                            <h3>{{ number_format($attempts->avg('score'), 1) ?? 0 }}</h3>
                            <span>Rata-rata Nilai</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-label-info text-center p-3 h-100">
                            <h3>{{ $attempts->max('score') ?? 0 }}</h3>
                            <span>Nilai Tertinggi</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-label-danger text-center p-3 h-100">
                            <h3>{{ $attempts->min('score') ?? 0 }}</h3>
                            <span>Nilai Terendah</span>
                        </div>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NIS</th>
                                <th>Waktu Mulai</th>
                                <th>Waktu Selesai</th>
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attempts as $attempt)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $attempt->Student->User->name ?? $attempt->Student->name }}</td>
                                    <td>{{ $attempt->Student->nis }}</td>
                                    <td>{{ $attempt->started_at->format('d M H:i') }}</td>
                                    <td>{{ $attempt->finished_at ? $attempt->finished_at->format('d M H:i') : '-' }}</td>
                                    <td class="fw-bold {{ $attempt->score >= 70 ? 'text-success' : 'text-danger' }}">
                                        {{ $attempt->score ?? 'Belum Selesai' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

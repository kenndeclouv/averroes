@extends('layouts.app')
@section('title', 'Hasil Ujian: ' . $quiz->title)

@section('page-script')
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
                    text: '<i class="fas fa-file-export"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                            extend: "print",
                            text: '<i class="fas fa-print me-1"></i>Print',
                            className: "dropdown-item",
                            title: "Hasil Ujian: " + "{{ $quiz->title }}",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            title: "Hasil Ujian: " + "{{ $quiz->title }}",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        }
                    ]
                }]
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
                            <h3>{{ number_format($attempts->avg('grade'), 1) ?? 0 }}</h3>
                            <span>Rata-rata Nilai</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-label-info text-center p-3 h-100">
                            <h3>{{ $attempts->max('grade') ?? 0 }}</h3>
                            <span>Poin Tertinggi</span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-label-danger text-center p-3 h-100">
                            <h3>{{ $attempts->min('grade') ?? 0 }}</h3>
                            <span>Poin Terendah</span>
                        </div>
                    </div>
                </div>

                <div class="tab-content pt-0" id="pills-tabContent">
                    <!-- Results Tab -->
                    <div class="tab-pane fade show active" id="pills-results" role="tabpanel"
                        aria-labelledby="pills-results-tab">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered table-striped" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>NIS</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Status</th>
                                        <th>Nilai</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attempts as $attempt)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $attempt->Student->User->name ?? $attempt->Student->name }}</td>
                                            <td>{{ $attempt->Student->nis }}</td>
                                            <td>{{ $attempt->started_at->format('d M H:i') }}</td>
                                            <td>{{ $attempt->finished_at ? $attempt->finished_at->format('d M H:i') : '-' }}
                                            </td>
                                            <td>
                                                @if ($attempt->status == 'needs_grading')
                                                    <span class="badge bg-warning">Perlu Dinilai</span>
                                                @elseif($attempt->status == 'graded')
                                                    <span class="badge bg-success">Selesai</span>
                                                @else
                                                    <span class="badge bg-secondary">Berjalan</span>
                                                @endif
                                            </td>
                                            <td
                                                class="fw-bold {{ $attempt->grade >= 70 ? 'text-success' : 'text-danger' }}">
                                                {{ $attempt->grade ?? '-' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('teacher.quizzes.attempts.show', $attempt->id) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye me-1"></i> Detail / Nilai
                                                </a>
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

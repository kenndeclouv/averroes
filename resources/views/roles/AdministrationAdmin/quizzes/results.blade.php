@extends('layouts.app')
@section('title', 'Hasil Ujian - Admin View')
@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="py-3 mb-0">
                <span class="text-muted fw-light">Admin / Ujian /</span> Hasil: {{ $quiz->title }}
            </h4>
            <a href="{{ route('administrationadmin.quizzes.index') }}" class="btn btn-secondary"><i
                    class="fas fa-arrow-left me-1"></i>
                Kembali</a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Guru:</strong> {{ $quiz->Teacher->user->name ?? '-' }}</p>
                        <p><strong>Kelas:</strong> {{ $quiz->Classes->name ?? '-' }}</p>
                        <p><strong>Jadwal:</strong> {{ $quiz->start_time->format('d M Y H:i') }} -
                            {{ $quiz->end_time->format('d M Y H:i') }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p>Total Peserta: {{ $attempts->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs p-3 pb-0" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                        data-bs-target="#tab-students">
                        <i class="fas fa-users me-1"></i> Daftar Siswa
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                        data-bs-target="#tab-analytics">
                        <i class="fas fa-chart-pie me-1"></i> Analisis Soal
                    </button>
                </li>
            </ul>
            <div class="tab-content">
                <!-- Students Tab -->
                <div class="tab-pane fade show active" id="tab-students" role="tabpanel">
                    <div class="card-datatable table-responsive text-start text-nowrap">
                        <table class="table table-bordered datatable" id="table">
                            <thead>
                                <tr>
                                    <th>Ranking</th>
                                    <th>Nama Siswa</th>
                                    <th>Waktu Submit</th>
                                    <th>Nilai</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($attempts as $index => $attempt)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $attempt->Student->User->name ?? '-' }}</td>
                                        <td>{{ $attempt->updated_at->format('d M H:i:s') }}</td>
                                        <td><strong>{{ $attempt->score }}</strong> /
                                            {{ $quiz->questions()->sum('points') }}</td>
                                        <td>
                                            @if ($attempt->status == 'finished')
                                                <span class="badge bg-success">Selesai</span>
                                            @elseif($attempt->status == 'needs_grading')
                                                <span class="badge bg-warning">Perlu Dinilai</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($attempt->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada siswa yang mengerjakan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Analytics Tab -->
                <div class="tab-pane fade" id="tab-analytics" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th style="width: 50%;">Soal</th>
                                    <th>Tipe</th>
                                    <th>Menjawab Benar</th>
                                    <th>Rata-rata Skor</th>
                                    <th>Tingkat Kesulitan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($analytics as $index => $data)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <div style="max-height: 100px; overflow-y: auto;">
                                                {!! $data['content'] !!}
                                            </div>
                                        </td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $data['type'])) }}</td>
                                        <td>{{ $data['correct_count'] }} Siswa</td>
                                        <td>{{ $data['avg_score'] }}</td>
                                        <td>
                                            @php
                                                $diff = $data['difficulty_index'];
                                                $badgeClass = 'bg-secondary';
                                                $label = 'Sedang';
                                                if ($diff > 70) {
                                                    $badgeClass = 'bg-success';
                                                    $label = 'Mudah';
                                                } elseif ($diff < 30) {
                                                    $badgeClass = 'bg-danger';
                                                    $label = 'Sukar';
                                                }
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ $label }}
                                                ({{ $diff }}%)
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Ujian Tersedia')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Daftar Ujian</h4>
        <div class="row">
            @forelse ($quizzes as $quiz)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">{{ $quiz->title }}</h5>
                                @if ($quiz->attempt && $quiz->attempt->finished_at)
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($quiz->attempt)
                                    <span class="badge bg-warning">Sedang Berlangsung</span>
                                @else
                                    <span class="badge bg-label-primary">Baru</span>
                                @endif
                            </div>
                            <h6 class="text-muted"><small>Oleh:
                                    {{ $quiz->Teacher->full_name ?? $quiz->Teacher->name }}</small></h6>

                            <p class="card-text text-muted small mt-3">
                                <i class="far fa-clock me-1"></i> {{ $quiz->start_time->format('d M H:i') }} -
                                {{ $quiz->end_time->format('d M H:i') }}<br>
                                <i class="fas fa-hourglass-half me-1"></i> Durasi: {{ $quiz->duration_minutes }} Menit
                            </p>

                            @if ($quiz->description)
                                <p class="card-text small text-secondary">
                                    {{ Str::limit($quiz->description, 100) }}
                                </p>
                            @endif

                            <div class="mt-4 d-grid">
                                @if ($quiz->attempt && $quiz->attempt->finished_at)
                                    <a href="{{ route('student.quizzes.result', $quiz->id) }}"
                                        class="btn btn-outline-primary">Lihat Hasil</a>
                                @else
                                    @php
                                        $now = now();
                                        $isActive = $now >= $quiz->start_time && $now <= $quiz->end_time;
                                    @endphp

                                    @if ($isActive)
                                        <a href="{{ route('student.quizzes.take', $quiz->id) }}" class="btn btn-primary">
                                            {{ $quiz->attempt ? 'Lanjutkan' : 'Mulai Ujian' }}
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            {{ $now < $quiz->start_time ? 'Belum Dimulai' : 'Sudah Berakhir' }}
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info" role="alert">
                        <i class="fas fa-info-circle me-2"></i> Belum ada Ujian yang tersedia untuk kelas kamu saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

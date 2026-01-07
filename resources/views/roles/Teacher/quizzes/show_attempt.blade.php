@extends('layouts.app')
@section('title', 'Detail & Penilaian Ujian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Ujian / Hasil /</span> Detail
        </h4>

        <div class="row">
            <!-- Student Info -->
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Informasi Siswa</h5>
                    </div>
                    <div class="card-body mt-3">
                        <div class="mb-3">
                            <label class="fw-bold">Nama:</label>
                            <div>{{ $attempt->Student->User->name }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">NIS:</label>
                            <div>{{ $attempt->Student->nis }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Waktu Pengerjaan:</label>
                            <div>{{ $attempt->started_at->format('d M Y H:i') }} -
                                {{ $attempt->finished_at ? $attempt->finished_at->format('H:i') : '...' }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Status:</label>
                            <div>
                                @if ($attempt->status == 'needs_grading')
                                    <span class="badge bg-warning">Perlu Dinilai</span>
                                @elseif($attempt->status == 'graded')
                                    <span class="badge bg-success">Selesai</span>
                                @else
                                    <span class="badge bg-secondary">Berjalan</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold">Nilai Total:</label>
                            <h2 class="text-primary">{{ $attempt->score ?? 0 }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grading Form -->
            <div class="col-md-8">
                <form action="{{ route('teacher.quizzes.attempts.grade', $attempt->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card">
                        <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Jawaban Siswa</h5>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Penilaian
                            </button>
                        </div>
                        <div class="card-body mt-3">

                            @foreach ($attempt->Answers as $answer)
                                <div class="mb-4 border-bottom pb-4">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold">Soal {{ $loop->iteration }}
                                            ({{ ucfirst(str_replace('_', ' ', $answer->Question->type)) }})</h6>
                                        <span class="badge bg-label-info">Max Poin: {{ $answer->Question->points }}</span>
                                    </div>
                                    <div class="mb-2 p-3 bg-light rounded">
                                        {!! nl2br(e($answer->Question->content)) !!}
                                    </div>

                                    <div class="mt-3">
                                        <label class="fw-bold mb-1">Jawaban Siswa:</label>
                                        @if ($answer->Question->type == 'multiple_choice')
                                            <div class="alert {{ $answer->is_correct ? 'alert-success' : 'alert-danger' }}">
                                                {{ $answer->QuestionOption->option_text ?? '-' }}
                                                @if ($answer->is_correct)
                                                    <i class="fas fa-check ms-2"></i>
                                                @else
                                                    <i class="fas fa-times ms-2"></i>
                                                @endif
                                            </div>
                                        @elseif($answer->Question->type == 'essay')
                                            <div class="p-3 border rounded bg-white">
                                                {!! nl2br(e($answer->answer_text)) !!}
                                            </div>
                                        @else
                                            <!-- Complex MC or others -->
                                            <div
                                                class="alert {{ $answer->is_correct ? 'alert-success' : 'alert-danger' }}">
                                                {{ $answer->QuestionOption->option_text ?? '-' }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-3 row">
                                        <div class="col-md-4">
                                            <label class="form-label fw-bold">Nilai</label>
                                            <input type="number" name="scores[{{ $answer->id }}]" class="form-control"
                                                value="{{ $answer->score }}" max="{{ $answer->Question->points }}"
                                                min="0"
                                                {{ $answer->Question->type != 'essay' && $answer->Question->type != 'multiple_choice' ? '' : '' }}>
                                            {{-- Generally allow overriding any score, typically for essays it's 0 initially --}}
                                        </div>
                                        <div class="col-md-8 d-flex align-items-end">
                                            @if ($answer->Question->type == 'essay')
                                                <small class="text-muted">Review jawaban essay dan berikan nilai
                                                    manual.</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('teacher.quizzes.results', $quiz->id) }}"
                                class="btn btn-label-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Penilaian
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

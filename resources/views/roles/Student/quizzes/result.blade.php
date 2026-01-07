@extends('layouts.app')
@section('title', 'Hasil Kuis')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow text-center mb-4">
                    <div class="card-body py-5">
                        <div class="display-1 text-primary mb-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h2 class="card-title fw-bold">Kuis Selesai!</h2>
                        <p class="card-text text-muted mb-4">Terima kasih telah mengerjakan kuis.</p>

                        <div class="display-4 fw-bold {{ $attempt->score >= 70 ? 'text-success' : 'text-danger' }}">
                            {{ $attempt->score }}
                        </div>
                        <p class="text-muted">Nilai Kamu</p>

                        <hr>

                        <div class="row text-start mt-4">
                            <div class="col-6 mb-2"><strong>Mulai:</strong> {{ $attempt->started_at->format('d M H:i') }}
                            </div>
                            <div class="col-6 mb-2"><strong>Selesai:</strong> {{ $attempt->finished_at->format('d M H:i') }}
                            </div>
                            <div class="col-6 mb-2"><strong>Benar:</strong>
                                {{ $attempt->Answers->where('is_correct', true)->count() }} /
                                {{ $quiz->Questions->count() }}
                            </div>
                            <div class="col-6 mb-2"><strong>Status:</strong> <span class="badge bg-success">Selesai</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('student.quizzes.index') }}" class="btn btn-outline-primary">Kembali ke Daftar
                                Kuis</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

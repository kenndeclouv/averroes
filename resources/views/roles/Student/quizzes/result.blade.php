@extends('layouts.app')
@section('title', 'Hasil Ujian')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow text-center mb-4">
                    <div class="card-body py-5">
                        <div class="display-1 fw-bold text-primary mb-2">{{ $attempt->grade }}</div>
                        <h4 class="mb-4">Poin Kamu ({{ $attempt->score }} / {{ $attempt->quiz->total_points }} Poin)</h4>
                        <h2 class="card-title fw-bold">Ujian Selesai!</h2>
                        <p class="card-text text-muted mb-4">Terima kasih telah mengerjakan Ujian.</p>

                        <div class="display-4 fw-bold {{ $attempt->score >= 70 ? 'text-success' : 'text-danger' }}">
                            {{ $attempt->score }}
                        </div>
                        <p class="text-muted">Poin Kamu</p>

                        <hr>

                        <div class="row text-start mt-4">
                            <div class="col-6 mb-2"><strong>Mulai:</strong> {{ $attempt->started_at->format('d M H:i') }}
                            </div>
                            <div class="col-6 mb-2"><strong>Selesai:</strong> {{ $attempt->finished_at->format('d M H:i') }}
                            </div>
                            <div class="col-6 mb-2"><strong>Benar:</strong>
                                @php
                                    // Calculate correct questions count based on Score
                                    // A question is correct if the total score gained for it equals its max points.
                                    $correctQuestions = 0;
                                    $answersByQuestion = $attempt->Answers->groupBy('question_id');

                                    foreach ($quiz->Questions as $question) {
                                        $myAnswers = $answersByQuestion->get($question->id);
                                        if ($myAnswers) {
                                            $score = $myAnswers->sum('score');
                                            // Tolerance for floating point if necessary, but points are integer
                                            if ($score >= $question->points && $question->points > 0) {
                                                $correctQuestions++;
                                            }
                                        }
                                    }
                                @endphp
                                {{ $correctQuestions }} /
                                {{ $quiz->Questions->count() }}
                            </div>
                            <div class="col-6 mb-2"><strong>Status:</strong> <span class="badge bg-success">Selesai</span>
                            </div>
                        </div>

                        <div class="mt-4 gap-2 d-flex justify-content-center">
                            <a href="{{ route('student.quizzes.index') }}" class="btn btn-outline-primary">Kembali ke Daftar
                                Ujian</a>
                            @if ($attempt->status == 'graded')
                                <a href="{{ route('student.quizzes.review', $quiz->id) }}" class="btn btn-primary">
                                    <i class="fas fa-search me-1"></i> Lihat Pembahasan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
                        <div class="card bg-label-primary text-center p-3">
                            <h5 class="mb-1">Nilai Akhir</h5>
                            <h2 class="mb-0 text-primary">{{ $attempt->grade }}</h2>
                            <small class="text-muted">Total Poin: {{ $attempt->score }} /
                                {{ $quiz->total_points }}</small>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <form id="resetForm" action="{{ route('teacher.quizzes.attempts.reset', $attempt->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-outline-danger w-100" onclick="confirmReset()">
                                    <i class="fas fa-redo-alt me-1"></i> Reset Ujian Siswa
                                </button>
                            </form>
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

                            @php
                                $groupedAnswers = $attempt->Answers->groupBy('question_id');
                            @endphp

                            @foreach ($quiz->Questions as $question)
                                @php
                                    $answers = $groupedAnswers->get($question->id);
                                    $hasAnswer = $answers && $answers->isNotEmpty();
                                    $firstAnswer = $hasAnswer ? $answers->first() : null;
                                    // Complex MC score is stored in first answer, others 0. Single MC/Essay has 1 answer.
                                    // So we can just take firstAnswer score or sum?
                                    // For consistency with controller logic, usually sum or first.
                                    // Controller store logic: single puts score, complex puts score in first only.
                                    $currentScore = $hasAnswer ? $answers->sum('score') : 0;
                                @endphp

                                <div class="mb-4 border-bottom pb-4">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="fw-bold">Soal {{ $loop->iteration }}
                                            ({{ ucfirst(str_replace('_', ' ', $question->type)) }})</h6>
                                        <span class="badge bg-label-info">Max Poin: {{ $question->points }}</span>
                                    </div>
                                    <div class="mb-2 p-3 bg-light rounded">
                                        {!! nl2br(e($question->content)) !!}
                                    </div>

                                    <div class="mt-3">
                                        <label class="fw-bold mb-1">Jawaban Siswa:</label>
                                        @if (!$hasAnswer)
                                            <div class="alert alert-secondary">
                                                <i class="fas fa-minus-circle me-1"></i> Tidak Dijawab
                                            </div>
                                        @else
                                            @if ($question->type == 'multiple_choice')
                                                <div
                                                    class="alert {{ $firstAnswer->is_correct ? 'alert-success' : 'alert-danger' }}">
                                                    {{ $firstAnswer->QuestionOption->option_text ?? '-' }}
                                                    @if ($firstAnswer->is_correct)
                                                        <i class="fas fa-check ms-2"></i>
                                                    @else
                                                        <i class="fas fa-times ms-2"></i>
                                                    @endif
                                                </div>
                                            @elseif ($question->type == 'true_false')
                                                <div
                                                    class="alert {{ $firstAnswer->is_correct ? 'alert-success' : 'alert-danger' }}">
                                                    {{ $firstAnswer->QuestionOption->option_text ?? '-' }}
                                                    @if ($firstAnswer->is_correct)
                                                        <i class="fas fa-check ms-2"></i>
                                                    @else
                                                        <i class="fas fa-times ms-2"></i>
                                                    @endif
                                                </div>
                                            @elseif ($question->type == 'short_answer')
                                                <div
                                                    class="alert {{ $firstAnswer->is_correct ? 'alert-success' : 'alert-danger' }}">
                                                    <strong>Jawaban Siswa: </strong> {{ $firstAnswer->answer_text }}
                                                    @if ($firstAnswer->is_correct)
                                                        <i class="fas fa-check ms-2"></i>
                                                    @else
                                                        <i class="fas fa-times ms-2"></i>
                                                        <br>
                                                        <small class="text-muted">Kunci:
                                                            {{ $question->Options->map(fn($o) => $o->option_text)->implode(' / ') }}</small>
                                                    @endif
                                                </div>
                                            @elseif($question->type == 'matching')
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Pasangan Kiri</th>
                                                                <th>Jawaban Siswa (Kanan)</th>
                                                                <th>Kunci Benar</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($answers as $ans)
                                                                <tr
                                                                    class="{{ $ans->is_correct ? 'table-success' : 'table-danger' }}">
                                                                    <td>{{ $ans->QuestionOption->option_text ?? '?' }}</td>
                                                                    <td>{{ $ans->answer_text }}</td>
                                                                    <td>{{ $ans->QuestionOption->matched_pair ?? '-' }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @elseif($question->type == 'essay')
                                                <div class="p-3 border rounded bg-white">
                                                    {!! nl2br(e($firstAnswer->answer_text)) !!}
                                                </div>
                                            @elseif($question->type == 'complex_multiple_choice')
                                                <ul class="list-group">
                                                    @foreach ($answers as $ans)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center {{ $ans->is_correct ? 'list-group-item-success' : 'list-group-item-danger' }}">
                                                            {{ $ans->QuestionOption->option_text ?? '-' }}
                                                            @if ($ans->is_correct)
                                                                <i class="fas fa-check"></i>
                                                            @else
                                                                <i class="fas fa-times"></i>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                    </div>

                                    <div class="mt-3 row">
                                        <div class="col-md-4">
                                            @if ($hasAnswer)
                                                <label class="form-label fw-bold">Nilai</label>
                                                {{-- We bind score to the first answer ID for simplicity --}}
                                                {{-- Backend gradeAttempt iterates scores array --}}
                                                <input type="number" name="scores[{{ $firstAnswer->id }}]"
                                                    class="form-control" value="{{ $currentScore }}"
                                                    max="{{ $question->points }}" min="0">
                                            @else
                                                <p class="text-muted small mt-2">Tidak ada jawaban untuk dinilai.</p>
                                            @endif
                                        </div>
                                        <div class="col-md-8 d-flex align-items-end">
                                            @if ($question->type == 'essay')
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

@section('page-script')
    <script>
        function confirmReset() {
            Swal.fire({
                ...getSwalOptions('warning', 'Reset Ujian?',
                    'Apakah Anda yakin ingin mereset ujian siswa ini? Semua jawaban akan dihapus permanen dan siswa harus mengulang dari awal.'
                ),
                showCancelButton: true,
                confirmButtonText: 'Ya, Reset!',
                confirmButtonColor: '#dc3545', // Danger color
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('resetForm').submit();
                }
            });
        }
    </script>
@endsection

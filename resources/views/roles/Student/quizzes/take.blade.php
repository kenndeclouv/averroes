@extends('layouts.app')
@section('title', $quiz->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <form action="{{ route('student.quizzes.submit', $quiz->id) }}" method="POST" id="quizForm">
            @csrf

            <!-- Header Sticky -->
            <div class="card shadow mb-4 sticky-top zindex-1">
                <div class="card-body d-flex justify-content-between align-items-center py-3">
                    <div>
                        <h5 class="mb-0 text-truncate" style="max-width: 300px;">{{ $quiz->title }}</h5>
                        <small class="text-muted">Sisa Waktu: <span id="timer"
                                class="fw-bold text-danger">--:--</span></small>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary"
                            onclick="return confirm('Apakah kamu yakin ingin mengumpulkan jawaban? Anda tidak bisa mengubahnya setelah ini.')">
                            <i class="fas fa-paper-plane me-1"></i> Kumpulkan
                        </button>
                    </div>
                </div>
            </div>

            <!-- Questions -->
            <div class="row">
                <div class="col-md-9 mx-auto">
                    @foreach ($quiz->Questions as $index => $question)
                        <div class="card shadow mb-4">
                            <div class="card-header border-bottom bg-light">
                                <h6 class="mb-0">Soal No. {{ $loop->iteration }} <span class="badge bg-custom ms-2"
                                        style="font-size: 0.7em; background-color: #ddd; color: #555;">{{ $question->points }}
                                        Poin</span></h6>
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-4 fs-5" style="white-space: pre-wrap;">{{ $question->content }}</p>

                                @if ($question->type == 'multiple_choice')
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            <label
                                                class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer p-3">
                                                <input class="form-check-input me-3" type="radio"
                                                    name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                                                <span class="fs-6">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'complex_multiple_choice')
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            <label
                                                class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer p-3">
                                                <input class="form-check-input me-3" type="checkbox"
                                                    name="answers[{{ $question->id }}][]" value="{{ $option->id }}">
                                                <span class="fs-6">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'essay')
                                    <textarea class="form-control" name="answers[{{ $question->id }}]" rows="5"
                                        placeholder="Tulis jawabanmu di sini..."></textarea>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Bottom Action -->
            <div class="d-grid gap-2 mb-5 d-md-flex justify-content-md-center">
                <button type="submit" class="btn btn-primary btn-lg px-5"
                    onclick="return confirm('Apakah kamu yakin ingin mengumpulkan jawaban?')">
                    Selesai & Kumpulkan
                </button>
            </div>
        </form>
    </div>
@endsection

@section('page-script')
    <script>
        // Timer Logic
        // Start Time is Quiz start time? Or Attempt start time?
        // Usually Attempt Start Time + Duration
        // Or Quiz End Time, whichever is earlier.

        const quizEndTime = new Date("{{ $quiz->end_time->format('Y-m-d\TH:i:s') }}").getTime();
        /*
           We calculate remaining time based on attempt start + duration.
           But we don't have attempt end time explicitly passed as variable in controller logic above easily without calculating in view or controller.
           Let's assume simplified logic: Time until Quiz End OR (StartedAt + Duration), whichever is smaller.
           Wait, controller passed $attempt.
           $attempt->started_at
        */
        @php
            $attemptEnd = $attempt->started_at->addMinutes($quiz->duration_minutes);
            // Effective end time is Min(Quiz End Time, Attempt End Time)
            $effectiveEnd = $attemptEnd < $quiz->end_time ? $attemptEnd : $quiz->end_time;
        @endphp

        const endTime = new Date("{{ $effectiveEnd->format('Y-m-d\TH:i:s') }}").getTime();

        const timerInterval = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                clearInterval(timerInterval);
                document.getElementById("timer").innerHTML = "WAKTU HABIS";
                alert("Waktu habis! Jawabanmu akan dikirim otomatis.");
                document.getElementById("quizForm").submit();
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer").innerHTML =
                (hours > 0 ? hours + "j " : "") + minutes + "m " + seconds + "d";
        }, 1000);

        // Prevent leaving page warning?
        window.onbeforeunload = function() {
            // Only warn if not submitting
            // return "Apakah kamu yakin ingin meninggalkan halaman? Jawaban mungkin tidak tersimpan.";
        };

        document.getElementById('quizForm').onsubmit = function() {
            window.onbeforeunload = null;
        };
    </script>
@endsection

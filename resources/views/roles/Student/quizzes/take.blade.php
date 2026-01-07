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
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted">Sisa Waktu: <span id="timer"
                                    class="fw-bold text-danger">--:--</span></small>
                            <small id="saveStatus" class="badge bg-label-secondary" style="display:none;">Tersimpan</small>
                        </div>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="confirmSubmit(event)">
                            <i class="fas fa-paper-plane me-1"></i> Kumpulkan
                        </button>
                    </div>
                </div>
            </div>

            @php
                // Group answers by question_id for easy lookup
                // Pre-load answers into a keyed collection
                $savedAnswers = $attempt->Answers->groupBy('question_id');
            @endphp

            <!-- Questions & Nav -->
            <div class="row">
                <!-- Question List -->
                <div class="col-md-9 order-md-1 order-2">
                    @foreach ($quiz->Questions as $index => $question)
                        <div class="card shadow mb-4" id="q-{{ $loop->iteration }}">
                            <div class="card-header border-bottom bg-light">
                                <h6 class="mb-0">Soal No. {{ $loop->iteration }} <span class="badge bg-custom ms-2"
                                        style="font-size: 0.7em; background-color: #ddd; color: #555;">{{ $question->points }}
                                        Poin</span></h6>
                            </div>
                            <div class="card-body mt-3">
                                <p class="card-text mb-4 fs-5" style="white-space: pre-wrap;">{{ $question->content }}</p>

                                @if ($question->type == 'multiple_choice')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $selectedOptionId = $myAns ? $myAns->question_option_id : null;
                                    @endphp
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            <label
                                                class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer p-3">
                                                <input class="form-check-input me-3" type="radio"
                                                    name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                                    {{ $selectedOptionId == $option->id ? 'checked' : '' }}
                                                    onchange="updateNav({{ $loop->iteration }})">
                                                <span class="fs-6">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'complex_multiple_choice')
                                    @php
                                        $myAnsList = $savedAnswers->get($question->id);
                                        $selectedOptionIds = $myAnsList
                                            ? $myAnsList->pluck('question_option_id')->toArray()
                                            : [];
                                    @endphp
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            <label
                                                class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer p-3">
                                                <input class="form-check-input me-3" type="checkbox"
                                                    name="answers[{{ $question->id }}][]" value="{{ $option->id }}"
                                                    {{ in_array($option->id, $selectedOptionIds) ? 'checked' : '' }}
                                                    onchange="updateNav({{ $loop->iteration }})">
                                                <span class="fs-6">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'true_false')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $selectedOptionId = $myAns ? $myAns->question_option_id : null;
                                    @endphp
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            <label
                                                class="list-group-item list-group-item-action d-flex align-items-center cursor-pointer p-3">
                                                <input class="form-check-input me-3" type="radio"
                                                    name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                                    {{ $selectedOptionId == $option->id ? 'checked' : '' }}
                                                    onchange="updateNav({{ $loop->iteration }})">
                                                <span class="fs-6 fw-bold">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'short_answer')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $textAns = $myAns ? $myAns->answer_text : '';
                                    @endphp
                                    <input type="text" class="form-control" name="answers[{{ $question->id }}]"
                                        placeholder="Ketik jawabanmu..." value="{{ $textAns }}"
                                        oninput="updateNav({{ $loop->iteration }})">
                                @elseif ($question->type == 'matching')
                                    @php
                                        $myAnsList = $savedAnswers->get($question->id);
                                        // Keyed by QuestionOptionID -> AnswerText
                                        $myMatches = $myAnsList
                                            ? $myAnsList->pluck('answer_text', 'question_option_id')
                                            : collect([]);

                                        // Shuffle right side options for dropdown
                                        $rightOptions = $question->Options->pluck('matched_pair')->shuffle();
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Pasangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($question->Options as $option)
                                                    <tr>
                                                        <td class="align-middle w-50">{{ $option->option_text }}</td>
                                                        <td class="w-50">
                                                            <select class="form-select"
                                                                name="answers[{{ $question->id }}][{{ $option->id }}]"
                                                                onchange="updateNav({{ $loop->iteration }})">
                                                                <option value="" selected disabled>Pilih Pasangan...
                                                                </option>
                                                                @foreach ($rightOptions as $rightOpt)
                                                                    <option value="{{ $rightOpt }}"
                                                                        {{ $myMatches->get($option->id) == $rightOpt ? 'selected' : '' }}>
                                                                        {{ $rightOpt }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif ($question->type == 'essay')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $essayContent = $myAns ? $myAns->answer_text : '';
                                    @endphp
                                    <textarea class="form-control" name="answers[{{ $question->id }}]" rows="5"
                                        placeholder="Tulis jawabanmu di sini..." oninput="updateNav({{ $loop->iteration }})">{{ $essayContent }}</textarea>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Sidebar -->
                <div class="col-md-3 order-md-2 order-1 mb-4">
                    <div class="card shadow sticky-top" style="top: 85px; z-index: 1;">
                        <div class="card-header border-bottom">
                            <h6 class="mb-0">Navigasi Soal</h6>
                        </div>
                        <div class="card-body mt-2">
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($quiz->Questions as $question)
                                    @php
                                        // Check if answered
                                        $isAnswered = false;
                                        if ($question->type == 'multiple_choice' || $question->type == 'true_false') {
                                            $isAnswered = $savedAnswers->has($question->id);
                                        } elseif ($question->type == 'essay' || $question->type == 'short_answer') {
                                            $ans = $savedAnswers->get($question->id)?->first();
                                            $isAnswered = $ans && !empty($ans->answer_text);
                                        } elseif ($question->type == 'complex_multiple_choice') {
                                            $isAnswered = $savedAnswers->has($question->id);
                                        } elseif ($question->type == 'matching') {
                                            // Answered if at least one pair is selected? Or all?
                                            // Let's say if has ANY answer
                                            $isAnswered = $savedAnswers->has($question->id);
                                        }
                                    @endphp
                                    <a href="#q-{{ $loop->iteration }}" id="nav-btn-{{ $loop->iteration }}"
                                        class="btn btn-sm {{ $isAnswered ? 'btn-primary' : 'btn-outline-secondary' }}"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        {{ $loop->iteration }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="mt-4 border-top pt-3">
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <div class="btn btn-sm btn-primary" style="width: 20px; height: 20px;"></div>
                                    <small>Sudah Dijawab</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="btn btn-sm btn-outline-secondary" style="width: 20px; height: 20px;"></div>
                                    <small>Belum Dijawab</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Action -->
            <div class="d-grid gap-2 mb-5 d-md-flex justify-content-md-center">
                <button type="button" class="btn btn-primary btn-lg px-5" onclick="confirmSubmit(event)">
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

                Swal.fire(getSwalOptions('info', 'Waktu Habis',
                    'Waktu ujian telah berakhir. Jawabanmu akan dikirim otomatis.')).then(() => {
                    document.getElementById("quizForm").submit();
                });
                // Fallback direct submit if user doesn't click ok
                setTimeout(() => document.getElementById("quizForm").submit(), 3000);
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

        const quizForm = document.getElementById('quizForm');
        quizForm.onsubmit = function() {
            window.onbeforeunload = null;
        };

        function confirmSubmit(e) {
            e.preventDefault();

            Swal.fire({
                ...getSwalOptions('question', 'Kumpulkan Jawaban?',
                    'Apakah kamu yakin ingin mengumpulkan jawaban? Kamu tidak bisa mengubahnya setelah ini.'),
                showCancelButton: true,
                confirmButtonText: 'Ya, Kumpulkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.onbeforeunload = null;
                    quizForm.submit();
                }
            });
        }


        // Auto Save Logic
        const autoSaveUrl = "{{ route('student.quizzes.autosave', $quiz->id) }}";
        const saveStatus = $('#saveStatus');
        let autoSaveTimeout;

        function triggerAutoSave() {
            clearTimeout(autoSaveTimeout);
            saveStatus.show().removeClass('bg-label-success').addClass('bg-label-warning').text('Menyimpan...');

            autoSaveTimeout = setTimeout(function() {
                const formData = $('#quizForm').serialize();
                $.ajax({
                    url: autoSaveUrl,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        saveStatus.removeClass('bg-label-warning').addClass('bg-label-success').text(
                            'Tersimpan');
                        setTimeout(() => saveStatus.fadeOut(), 2000);
                    },
                    error: function(xhr) {
                        saveStatus.removeClass('bg-label-success').addClass('bg-label-danger').text(
                            'Gagal Menyimpan');
                    }
                });
            }, 1000); // Debounce 1 sec
        }

        // Listen to changes
        $('input[type=radio], input[type=checkbox], select').on('change', function() {
            triggerAutoSave();
        });

        $('textarea, input[type=text]').on('input', function() {
            triggerAutoSave();
        });

        // Navigation Update Logic
        function updateNav(questionNumber) {
            const container = $('#q-' + questionNumber);
            let isAnswered = false;

            // Check Radio/Checkbox
            if (container.find('input[type=radio]:checked, input[type=checkbox]:checked').length > 0) {
                isAnswered = true;
            }
            // Check Text/Textarea (Short Answer / Essay)
            else if (container.find('input[type=text], textarea').filter(function() {
                    return $(this).val().trim() !== '';
                }).length > 0) {
                isAnswered = true;
            }
            // Check Select (Matching)
            else if (container.find('select').filter(function() {
                    return $(this).val() !== null && $(this).val() !== '';
                }).length > 0) {
                isAnswered = true;
            }

            const btn = $('#nav-btn-' + questionNumber);
            if (isAnswered) {
                btn.removeClass('btn-outline-secondary').addClass('btn-primary');
            } else {
                btn.removeClass('btn-primary').addClass('btn-outline-secondary');
            }
        }

        // Anti-Cheat (Disable Right Click, Copy, Paste, Inspect)
        document.addEventListener('contextmenu', event => event.preventDefault());

        document.onkeydown = function(e) {
            // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+Shift+C
            if (e.keyCode == 123 ||
                (e.ctrlKey && e.shiftKey && e.keyCode == 73) ||
                (e.ctrlKey && e.shiftKey && e.keyCode == 74) ||
                (e.ctrlKey && e.shiftKey && e.keyCode == 67) ||
                (e.ctrlKey && e.keyCode == 85)) {
                return false;
            }
        };

        // Disable Copy/Cut/Paste
        $(document).ready(function() {
            $('body').bind('cut copy paste', function(e) {
                e.preventDefault();
            });
        });

        // Advanced DevTools Detection (Debugger Trap)
        // This will freeze the browser if DevTools is open
        setInterval(function() {
            (function() {}.constructor("debugger")());
        }, 1000); // Check every second
    </script>
@endsection

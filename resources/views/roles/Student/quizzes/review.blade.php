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
                        <h5 class="mb-0 text-truncate" style="max-width: 300px;">Review: {{ $quiz->title }}</h5>
                        <p class="mb-0 text-muted">Skor Kamu: <strong>{{ $attempt->score }}</strong></p>
                    </div>
                    <div>
                        <a href="{{ route('student.quizzes.result', $quiz->id) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Hasil
                        </a>
                    </div>
                </div>
            </div>

            @php
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
                                        $isCorrect = $myAns ? $myAns->is_correct : false;
                                    @endphp
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            @php

                                                $bgClass = '';
                                                $borderClass = '';
                                                $icon = '';

                                                if ($selectedOptionId == $option->id) {
                                                    if ($option->is_correct) {
                                                        $bgClass = 'bg-success-subtle';
                                                        $borderClass = 'border-success';
                                                        $icon = '<i class="fas fa-check text-success ms-auto"></i>';
                                                    } else {
                                                        $bgClass = 'bg-danger-subtle';
                                                        $borderClass = 'border-danger';
                                                        $icon = '<i class="fas fa-times text-danger ms-auto"></i>';
                                                    }
                                                } elseif ($option->is_correct) {
                                                    $bgClass = 'bg-success-subtle';
                                                    $borderClass = 'border-success';
                                                }
                                            @endphp
                                            <div
                                                class="list-group-item d-flex align-items-center p-3 {{ $bgClass }} {{ $borderClass }}">
                                                <input class="form-check-input me-3" type="radio" disabled
                                                    {{ $selectedOptionId == $option->id ? 'checked' : '' }}>
                                                <span class="fs-6">{{ $option->option_text }}</span>
                                                {!! $icon !!}
                                            </div>
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
                                            @php
                                                $isSelected = in_array($option->id, $selectedOptionIds);
                                                $bgClass = '';
                                                $borderClass = '';

                                                if ($isSelected) {
                                                    if ($option->is_correct) {
                                                        $bgClass = 'bg-success-subtle';
                                                        $borderClass = 'border-success';
                                                    } else {
                                                        $bgClass = 'bg-danger-subtle';
                                                        $borderClass = 'border-danger';
                                                    }
                                                } elseif ($option->is_correct) {
                                                    $bgClass = 'bg-success-subtle';
                                                    $borderClass = 'border-success';
                                                }
                                            @endphp
                                            <div
                                                class="list-group-item d-flex align-items-center p-3 {{ $bgClass }} {{ $borderClass }}">
                                                <input class="form-check-input me-3" type="checkbox" disabled
                                                    {{ $isSelected ? 'checked' : '' }}>
                                                <span class="fs-6">{{ $option->option_text }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'true_false')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $selectedOptionId = $myAns ? $myAns->question_option_id : null;
                                    @endphp
                                    <div class="list-group">
                                        @foreach ($question->Options as $option)
                                            @php
                                                $bgClass = '';
                                                $borderClass = '';
                                                $icon = '';

                                                if ($selectedOptionId == $option->id) {
                                                    if ($option->is_correct) {
                                                        $bgClass = 'bg-success-subtle';
                                                        $borderClass = 'border-success';
                                                        $icon = '<i class="fas fa-check text-success ms-auto"></i>';
                                                    } else {
                                                        $bgClass = 'bg-danger-subtle';
                                                        $borderClass = 'border-danger';
                                                        $icon = '<i class="fas fa-times text-danger ms-auto"></i>';
                                                    }
                                                } elseif ($option->is_correct) {
                                                    $bgClass = 'bg-success-subtle';
                                                    $borderClass = 'border-success';
                                                }
                                            @endphp
                                            <div
                                                class="list-group-item d-flex align-items-center p-3 {{ $bgClass }} {{ $borderClass }}">
                                                <input class="form-check-input me-3" type="radio" disabled
                                                    {{ $selectedOptionId == $option->id ? 'checked' : '' }}>
                                                <span class="fs-6 fw-bold">{{ $option->option_text }}</span>
                                                {!! $icon !!}
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($question->type == 'short_answer')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $textAns = $myAns ? $myAns->answer_text : '';
                                        $isCorrect = $myAns ? $myAns->is_correct : false;
                                        $correctText = $question->Options
                                            ->map(fn($o) => $o->option_text)
                                            ->implode(' / ');

                                        $bgClass = $isCorrect
                                            ? 'bg-success-subtle border-success'
                                            : 'bg-danger-subtle border-danger';
                                    @endphp
                                    <div class="mb-2">
                                        <label class="form-label">Jawaban Kamu:</label>
                                        <input type="text" class="form-control {{ $bgClass }}"
                                            value="{{ $textAns }}" disabled>
                                    </div>
                                    @if (!$isCorrect)
                                        <div class="text-success small">
                                            <i class="fas fa-check-circle me-1"></i> Kunci Jawaban:
                                            <strong>{{ $correctText }}</strong>
                                        </div>
                                    @endif
                                @elseif ($question->type == 'matching')
                                    @php
                                        $myAnsList = $savedAnswers->get($question->id);
                                        $myMatches = $myAnsList
                                            ? $myAnsList->pluck('answer_text', 'question_option_id')
                                            : collect([]);
                                    @endphp
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Pertanyaan</th>
                                                    <th>Jawaban Kamu</th>
                                                    <th>Kunci Jawaban</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($question->Options as $option)
                                                    @php
                                                        $myVal = $myMatches->get($option->id);
                                                        $isMatchCorrect = $myVal == $option->matched_pair;
                                                        $rowClass = $isMatchCorrect ? 'table-success' : 'table-danger';
                                                        if (empty($myVal)) {
                                                            $rowClass = '';
                                                        } // No answer
                                                    @endphp
                                                    <tr class="{{ $rowClass }}">
                                                        <td>{{ $option->option_text }}</td>
                                                        <td>{{ $myVal ?? '-' }}</td>
                                                        <td>{{ $option->matched_pair }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif ($question->type == 'essay')
                                    @php
                                        $myAns = $savedAnswers->get($question->id)?->first();
                                        $essayContent = $myAns ? $myAns->answer_text : '';
                                        $score = $myAns ? $myAns->score : 0;
                                    @endphp
                                    <textarea class="form-control mb-2" rows="5" disabled>{{ $essayContent }}</textarea>
                                    <div class="alert alert-secondary">
                                        <strong>Nilai Guru:</strong> {{ $score }} / {{ $question->points }}
                                    </div>
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
                        <div class="card-body">
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach ($quiz->Questions as $question)
                                    @php

                                        $isAnswered = false;
                                        if ($question->type == 'multiple_choice') {
                                            $isAnswered = $savedAnswers->has($question->id);
                                        } elseif ($question->type == 'essay') {
                                            $ans = $savedAnswers->get($question->id)?->first();
                                            $isAnswered = $ans && !empty($ans->answer_text);
                                        } elseif ($question->type == 'complex_multiple_choice') {
                                            $isAnswered = $savedAnswers->has($question->id);
                                        }

                                    @endphp
                                    <a href="#q-{{ $loop->iteration }}" id="nav-btn-{{ $loop->iteration }}"
                                        class="btn btn-sm btn-primary"
                                        style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                        {{ $loop->iteration }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Action -->
            <div class="d-grid gap-2 mb-5 d-md-flex justify-content-md-center">
                <a href="{{ route('student.quizzes.result', $quiz->id) }}" class="btn btn-secondary px-5">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection

@section('page-script')
    <script>
        document.addEventListener('contextmenu', event => event.preventDefault());

        document.onkeydown = function(e) {

            if (e.keyCode == 123 ||
                (e.ctrlKey && e.shiftKey && e.keyCode == 73) ||
                (e.ctrlKey && e.shiftKey && e.keyCode == 74) ||
                (e.ctrlKey && e.shiftKey && e.keyCode == 67) ||
                (e.ctrlKey && e.keyCode == 85)) {
                return false;
            }
        };

        $(document).ready(function() {
            $('body').bind('cut copy paste', function(e) {
                e.preventDefault();
            });
        });

        setInterval(function() {
            (function() {}.constructor("debugger")());
        }, 1000);
    </script>
@endsection

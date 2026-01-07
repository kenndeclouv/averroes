@extends('layouts.app')
@section('title', 'Edit Ujian & Kelola Soal')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <!-- Quiz Details -->
            <div class="col-md-4">
                <div class="card shadow mb-4">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Pengaturan Ujian</h5>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('teacher.quizzes.update', $quiz->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ old('title', $quiz->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="classes_id" class="form-label">Kelas</label>
                                <select class="form-select select2" id="classes_id" name="classes_id" required>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ $quiz->classes_id == $class->id ? 'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Waktu</label>
                                <input type="datetime-local" class="form-control mb-2" name="start_time"
                                    value="{{ old('start_time', $quiz->start_time->format('Y-m-d\TH:i')) }}" required>
                                <input type="datetime-local" class="form-control" name="end_time"
                                    value="{{ old('end_time', $quiz->end_time->format('Y-m-d\TH:i')) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="duration_minutes" class="form-label">Durasi (Menit)</label>
                                <input type="number" class="form-control" id="duration_minutes" name="duration_minutes"
                                    value="{{ old('duration_minutes', $quiz->duration_minutes) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="draft" {{ $quiz->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $quiz->status == 'published' ? 'selected' : '' }}>Published
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Questions Builder -->
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Soal</h5>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#addQuestionModal">
                            <i class="fas fa-plus me-1"></i> Tambah Soal
                        </button>
                    </div>
                    <div class="card-body mt-3">
                        @forelse ($quiz->Questions as $index => $question)
                            <div class="card mb-3 border">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <h6 class="card-title">Soal #{{ $loop->iteration }} <span
                                                class="badge bg-label-secondary ms-2">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</span>
                                        </h6>
                                        <div>
                                            <span class="badge bg-info me-2">{{ $question->points }} Poin</span>
                                            <form
                                                action="{{ route('teacher.quizzes.questions.destroy', ['question' => $question->id]) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Hapus soal ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-icon btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <p class="card-text mt-2">{!! nl2br(e($question->content)) !!}</p>

                                    @if ($question->type == 'multiple_choice' || $question->type == 'complex_multiple_choice')
                                        <ul class="list-group list-group-flush">
                                            @foreach ($question->Options as $option)
                                                <li class="list-group-item d-flex align-items-center">
                                                    @if ($option->is_correct)
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                    @else
                                                        <i class="far fa-circle text-muted me-2"></i>
                                                    @endif
                                                    {{ $option->option_text }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png"
                                    alt="Empty" width="200" class="img-fluid opacity-50">
                                <p class="text-muted mt-3">Belum ada soal. Tambahkan soal sekarang!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add Question -->
    <div class="modal fade" id="addQuestionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('teacher.quizzes.questions.store', $quiz->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Soal Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="q_type" class="form-label">Tipe Soal</label>
                            <select class="form-select" id="q_type" name="type" required>
                                <option value="multiple_choice">Pilihan Ganda (Satu Jawaban Benar)</option>
                                <option value="complex_multiple_choice">Pilihan Ganda Kompleks (Banyak Jawaban Benar)
                                </option>
                                <option value="essay">Uraian / Essay</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="q_content" class="form-label">Pertanyaan</label>
                            <textarea class="form-control" id="q_content" name="content" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="q_points" class="form-label">Poin</label>
                            <input type="number" class="form-control" id="q_points" name="points" value="5"
                                required>
                        </div>

                        <!-- Options Section -->
                        <div id="options_section">
                            <label class="form-label">Pilihan Jawaban</label>
                            <div id="options_container">
                                <!-- Default 2 options -->
                                <div class="input-group mb-2 option-item">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 option-radio" type="radio"
                                            name="options[0][is_correct]" value="1" aria-label="Correct answer">
                                        <input type="hidden" name="options[0][is_correct]" value="0"
                                            class="option-hidden-val">
                                    </div>
                                    <input type="text" class="form-control" name="options[0][text]"
                                        placeholder="Pilihan 1" required>
                                    <button class="btn btn-outline-danger remove-option" type="button"><i
                                            class="fas fa-times"></i></button>
                                </div>
                                <div class="input-group mb-2 option-item">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 option-radio" type="radio"
                                            name="options[1][is_correct]" value="1" aria-label="Correct answer">
                                        <input type="hidden" name="options[1][is_correct]" value="0"
                                            class="option-hidden-val">
                                    </div>
                                    <input type="text" class="form-control" name="options[1][text]"
                                        placeholder="Pilihan 2" required>
                                    <button class="btn btn-outline-danger remove-option" type="button"><i
                                            class="fas fa-times"></i></button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add_option_btn">
                                <i class="fas fa-plus"></i> Tambah Pilihan
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Soal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            let optionIndex = 2;

            function updateOptionInputs() {
                const type = $('#q_type').val();
                if (type === 'essay') {
                    $('#options_section').hide();
                    $('#options_container input').prop('required', false).prop('disabled',
                        true); // Disable to prevent submission
                } else {
                    $('#options_section').show();
                    $('#options_container input').prop('disabled', false); // Re-enable
                    $('#options_container input[type="text"]').prop('required', true);

                    // Update input types based on selection
                    if (type === 'complex_multiple_choice') {
                        $('.option-radio').attr('type', 'checkbox');
                        // For checkboxes, we need to handle the hidden input trick or standard array submission
                        // Laravel handles checkbox arrays if name="options[i][is_correct]" value="1"
                        // But if unchecked, it sends nothing. That's fine for our controller logic (isset check).
                        // Wait, my controller logic: isset($optionData['is_correct']) ? $optionData['is_correct'] : false
                        // If I use checkbox, unchecked won't send the key.
                        // So I need to ensure the key is sent or handle it.
                        // The hidden input trick `input type="hidden" value="0"` before checkbox usually works if name is same.
                        // But with array indexing options[0]... it's tricky.
                        // Actually, plain checkbox is fine because controller loop checks `isset`.
                        // If uncheck, isset is false -> false. Good.
                    } else {
                        $('.option-radio').attr('type', 'radio');
                        // For radio, name needs to be unique if we want one selection? No, name needs to be separate per row if we want structure.
                        // Wait, for Radio button group, they usually share the SAME name to be exclusive.
                        // But here my name is `options[i][is_correct]`. They are unique names, so they behave like checkboxes (independent).
                        // To make them exclusive in UI, I need to use JS or set name="correct_option_index" and value="i".
                        // SIMPLER: Use JS to uncheck others when one is checked for 'multiple_choice'.
                    }
                }
            }

            $('#q_type').change(updateOptionInputs);

            // Handle Radio behavior for Multiple Choice (Unique selection)
            $(document).on('change', '.option-radio', function() {
                if ($('#q_type').val() === 'multiple_choice' && $(this).is(':checked')) {
                    $('.option-radio').not(this).prop('checked', false);
                }
            });

            $('#add_option_btn').click(function() {
                const type = $('#q_type').val();
                const inputType = type === 'complex_multiple_choice' ? 'checkbox' : 'radio';

                const html = `
                    <div class="input-group mb-2 option-item">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0 option-radio" type="${inputType}" name="options[${optionIndex}][is_correct]" value="1">
                        </div>
                        <input type="text" class="form-control" name="options[${optionIndex}][text]" placeholder="Pilihan ${optionIndex + 1}" required>
                        <button class="btn btn-outline-danger remove-option" type="button"><i class="fas fa-times"></i></button>
                    </div>
                `;
                $('#options_container').append(html);
                optionIndex++;
            });

            $(document).on('click', '.remove-option', function() {
                $(this).closest('.option-item').remove();
            });

            // Initial call
            updateOptionInputs();
        });
    </script>
@endsection

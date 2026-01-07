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
                                <label for="semester_id" class="form-label">Semester</label>
                                <select class="form-select select2" id="semester_id" name="semester_id" required>
                                    @foreach ($semesters as $semester)
                                        <option value="{{ $semester->id }}"
                                            {{ $quiz->semester_id == $semester->id ? 'selected' : '' }}>
                                            {{ $semester->academic_year }} - {{ ucfirst($semester->type) }}
                                        </option>
                                    @endforeach
                                </select>
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
                                <select class="form-select select2" name="status">
                                    <option value="draft" {{ $quiz->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $quiz->status == 'published' ? 'selected' : '' }}>
                                        Published
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
                            data-bs-target="#addQuestionModal" onclick="resetModal()">
                            <i class="fas fa-plus me-1"></i> Tambah Soal
                        </button>
                    </div>
                    <div class="card-body mt-3">
                        <div class="accordion" id="questionsAccordion">
                            @forelse ($quiz->Questions as $index => $question)
                                <div class="accordion-item shadow-sm mb-3 border">
                                    <h2 class="accordion-header" id="heading{{ $question->id }}">
                                        <div class="accordion-button collapsed" role="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $question->id }}" aria-expanded="false"
                                            aria-controls="collapse{{ $question->id }}" style="cursor: pointer;">
                                            <div class="d-flex align-items-center w-100 justify-content-between me-3">
                                                <div class="d-flex align-items-center overflow-hidden">
                                                    <span class="badge bg-label-primary me-2">{{ $loop->iteration }}</span>
                                                    <span class="fw-bold text-truncate" style="max-width: 300px;">
                                                        {{ Str::limit($question->content, 50) }}
                                                        <small
                                                            class="text-muted fw-normal ms-1">({{ ucfirst(str_replace('_', ' ', $question->type)) }})</small>
                                                    </span>
                                                </div>
                                                <div class="text-nowrap ms-2">
                                                    <span class="badge bg-label-warning me-2">{{ $question->points }}
                                                        Poin</span>
                                                    <!-- Actions (stop propagation to prevent accordion toggle) -->
                                                    <div class="btn-group" onclick="event.stopPropagation();">
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-outline-primary"
                                                            onclick="openEditModal(this)"
                                                            data-question="{{ json_encode($question) }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('teacher.quizzes.questions.destroy', $question->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Hapus soal ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-icon btn-outline-danger ms-1">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </h2>
                                    <div id="collapse{{ $question->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="heading{{ $question->id }}"
                                        data-bs-parent="#questionsAccordion">
                                        <div class="accordion-body">
                                            <p class="mb-3" style="white-space: pre-wrap;">{{ $question->content }}</p>

                                            @php
                                                $type = $question->type;
                                            @endphp

                                            @if ($type == 'multiple_choice' || $type == 'complex_multiple_choice')
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
                                            @elseif ($type == 'true_false')
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($question->Options as $option)
                                                        <li class="list-group-item d-flex align-items-center">
                                                            @if ($option->is_correct)
                                                                <i class="fas fa-check-circle text-success me-2"></i>
                                                                <span
                                                                    class="fw-bold text-success">{{ $option->option_text }}</span>
                                                            @else
                                                                <i class="far fa-circle text-muted me-2"></i>
                                                                <span class="text-muted">{{ $option->option_text }}</span>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @elseif ($type == 'short_answer')
                                                <div class="alert alert-info bg-label-info mb-0">
                                                    <strong>Kunci Jawaban:</strong>
                                                    <ul class="mb-0 ps-3">
                                                        @foreach ($question->Options as $option)
                                                            <li>{{ $option->option_text }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @elseif ($type == 'matching')
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered mb-0">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th>Pertanyaan (Kiri)</th>
                                                                <th>Pasangan (Kanan)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($question->Options as $option)
                                                                <tr>
                                                                    <td>{{ $option->option_text }}</td>
                                                                    <td>{{ $option->matched_pair }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @elseif ($type == 'essay')
                                                <div class="text-muted fst-italic">
                                                    <small>(Jawaban dinilai manual)</small>
                                                </div>
                                            @endif
                                        </div>
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
                                <option value="true_false">Benar / Salah</option>
                                <option value="short_answer">Isian Singkat (Auto-Check)</option>
                                <option value="matching">Menjodohkan (Matching)</option>
                                <option value="essay">Uraian / Essay (Manual)</option>
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
            let optionIndex = 100; // Start high to avoid collision

            function updateOptionInputs() {
                const type = $('#q_type').val();
                const container = $('#options_container');
                const btnAdd = $('#add_option_btn');

                $('#options_section').show(); // Default show
                btnAdd.show(); // Default show

                // Clear validation/disable
                container.find('input').prop('disabled', false);

                if (type === 'essay') {
                    $('#options_section').hide();
                    container.find('input').prop('disabled', true);
                } else if (type === 'true_false') {
                    // Fixed 2 options: Benar/Salah
                    btnAdd.hide();
                    container.empty();

                    const options = [{
                            val: 'Benar',
                            text: 'Benar'
                        },
                        {
                            val: 'Salah',
                            text: 'Salah'
                        }
                    ];

                    options.forEach((opt, idx) => {
                        container.append(`
                            <div class="input-group mb-2 option-item">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0 option-radio" type="radio" name="options[${idx}][is_correct]" value="1">
                                </div>
                                <input type="text" class="form-control" name="options[${idx}][text]" value="${opt.text}" readonly>
                            </div>
                        `);
                    });
                } else if (type === 'short_answer') {
                    // Short Answer
                    container.find('.input-group-text').hide();
                    container.find('.option-radio').prop('checked', true).val('1');
                    container.find('input[name*="[text]"]').attr('placeholder', 'Jawaban Benar (Text)');

                    if ($('#short-answer-alert').length === 0) {
                        $('<div id="short-answer-alert" class="alert alert-info mt-2"><i class="fas fa-info-circle me-1"></i> Masukkan semua variasi jawaban yang dianggap benar. Siswa akan dianggap benar jika menjawab salah satu dari opsi ini (case-insensitive).</div>')
                            .insertBefore('#options_container');
                    }

                    btnAdd.show();
                    if (container.children().length === 0) {
                        addOption('short_answer');
                    }
                } else if (type === 'matching') {
                    // Need pair inputs: Left & Right
                    // Re-render if not matching format
                    if (container.find('input[name*="matched_pair"]').length === 0) {
                        container.empty();
                        addOption('matching');
                        addOption('matching');
                    }
                    btnAdd.show();
                } else {
                    // MC / Complex MC
                    container.find('.input-group-text').show();
                    const inputType = type === 'complex_multiple_choice' ? 'checkbox' : 'radio';
                    container.find('.option-radio').attr('type', inputType);

                    // If switching from Matching, clear
                    if (container.find('input[name*="matched_pair"]').length > 0) {
                        container.empty();
                        addOption(type);
                        addOption(type);
                    }

                    // Make sure at least 2 exist if empty
                    if (container.children().length < 2) {
                        // Only add if really empty or short, but try to preserve values if switching MC types
                        if (container.children().length === 0) {
                            addOption(type);
                            addOption(type);
                        }
                    }
                }
            }

            function addOption(type, data = null) {
                let html = '';
                const idx = optionIndex++;
                const textVal = data ? data.option_text : '';
                const idInput = data ? `<input type="hidden" name="options[${idx}][id]" value="${data.id}">` : '';
                const matchedVal = data ? (data.matched_pair || '') : '';

                if (type === 'matching') {
                    html = `
                        <div class="input-group mb-2 option-item">
                            ${idInput}
                            <span class="input-group-text">Sisi Kiri</span>
                            <input type="text" class="form-control" name="options[${idx}][text]" value="${textVal}" placeholder="Pertanyaan / Kunci" required>
                            <span class="input-group-text">Sisi Kanan</span>
                            <input type="text" class="form-control" name="options[${idx}][matched_pair]" value="${matchedVal}" placeholder="Jawaban Matched" required>
                            <button class="btn btn-outline-danger remove-option" type="button"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                } else {
                    const inputType = type === 'complex_multiple_choice' ? 'checkbox' : 'radio';
                    const hiddenStyle = type === 'short_answer' ? 'display:none;' : '';
                    const isChecked = (type === 'short_answer' || (data && data.is_correct)) ? 'checked' : '';
                    const placeholder = type === 'short_answer' ? 'Jawaban Benar (Text)' : 'Pilihan Jawaban';

                    html = `
                        <div class="input-group mb-2 option-item">
                            ${idInput}
                            <div class="input-group-text" style="${hiddenStyle}">
                                <input class="form-check-input mt-0 option-radio" type="${inputType}" name="options[${idx}][is_correct]" value="1" ${isChecked}>
                            </div>
                            <input type="text" class="form-control" name="options[${idx}][text]" value="${textVal}" placeholder="${placeholder}" required>
                            <button class="btn btn-outline-danger remove-option" type="button"><i class="fas fa-times"></i></button>
                        </div>
                    `;
                }
                $('#options_container').append(html);
            }

            $('#q_type').change(updateOptionInputs);

            $('#q_type').change(function() {
                if ($(this).val() !== 'short_answer') {
                    $('#short-answer-alert').remove();
                }
            });

            // Handle Radio behavior
            $(document).on('change', '.option-radio', function() {
                if ($('#q_type').val() === 'multiple_choice' && $(this).is(':checked')) {
                    $('.option-radio').not(this).prop('checked', false);
                }
                if ($('#q_type').val() === 'true_false' && $(this).is(':checked')) {
                    $('.option-radio').not(this).prop('checked', false);
                }
            });

            $('#add_option_btn').click(function() {
                addOption($('#q_type').val());
            });

            $(document).on('click', '.remove-option', function() {
                $(this).closest('.option-item').remove();
            });

            // Initial call logic needs to handle clean start vs edit?
            // This modal is for CREATE only in this view?
            // Yes, #addQuestionModal is for create. Edit uses a separate page usually?
            // In THIS file, edit.blade.php handles Quiz Edit, but Question Create is modal.
            // Existing Questions are edited via... Wait.
            // The view lists questions but doesn't seem to have Edit Button for questions?
            // "action destroy". No Edit?
            // I should check if there is an Edit Question feature.
            // If not, users preserve data by deleting and re-creating?
            // The task implies "Manage Soal", but current code only shows Store/Destroy.
            // I won't add Edit Question feature right now unless requested, focus on Type support for Create.

            // Trigger change to set initial state
            updateOptionInputs();

            // Expose functions globally or attaching to window if needed, but script is inline so scope is shared?
            // Better attach to window to be safe for inline onclicks
            window.openEditModal = function(btn) {
                const question = $(btn).data('question');
                const modal = $('#addQuestionModal');
                const baseAction = '{{ route('teacher.quizzes.questions.store', $quiz->id) }}';

                // 1. Title & Action
                modal.find('.modal-title').text('Edit Soal');
                // Construct Update URL: baseAction is .../questions. We need .../questions/{id}
                const updateUrl = baseAction + '/' + question.id;
                modal.find('form').attr('action', updateUrl);

                // 2. Method
                if (modal.find('input[name="_method"]').length === 0) {
                    modal.find('form').prepend('<input type="hidden" name="_method" value="PUT">');
                }

                // 3. Fields
                $('#q_type').val(question.type).trigger(
                    'change'); // This will reset options container via updateOptionInputs
                modal.find('textarea[name="content"]').val(question.content);
                modal.find('input[name="points"]').val(question.points);

                // 4. Populate Options
                // updateOptionInputs clears container. We fill it now.
                $('#options_container').empty();

                if (question.options && question.options.length > 0) {
                    question.options.forEach(opt => {
                        addOption(question.type, opt);
                    });
                } else {
                    // If no options (e.g. from essay), updateOptionInputs might have handled it (Essay hides options).
                    // If type is essay, we are good.
                    if (question.type === 'short_answer' && (!question.options || question.options.length ===
                            0)) {
                        addOption('short_answer'); // Ensure at least one input
                    }
                }

                // Open Modal
                const bsModal = new bootstrap.Modal(document.getElementById('addQuestionModal'));
                bsModal.show();
            };

            window.resetModal = function() {
                const modal = $('#addQuestionModal');
                modal.find('.modal-title').text('Tambah Soal Baru');
                const baseAction = '{{ route('teacher.quizzes.questions.store', $quiz->id) }}';
                modal.find('form').attr('action', baseAction);
                modal.find('input[name="_method"]').remove();

                modal.find('form')[0].reset();
                $('#q_type').val('multiple_choice').trigger('change');
            };
        });
        $(document).ready(function() {
            $('.select2').select2();
            $('#q_type').select2({
                dropdownParent: $('#addQuestionModal')
            });
        });
    </script>
@endsection

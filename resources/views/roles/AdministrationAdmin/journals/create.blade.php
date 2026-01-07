@extends('layouts.app')
@section('title', 'Tambah Jurnal Mengajar')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Jurnal Mengajar</h5>
            </div>
            <div class="card-body mt-4">
                <form action="{{ route('administrationadmin.journals.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="teacher_id" class="form-label">Nama Guru</label>
                            <select class="form-select select2 @error('teacher_id') is-invalid @enderror" id="teacher_id"
                                name="teacher_id" required>
                                <option value="">Pilih guru</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->id }}"
                                        {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                            @errorFeedback('teacher_id')
                        </div>

                        <div class="col-md-6">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" required>
                            @errorFeedback('date')
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        @foreach ($subjects as $subject)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="subjects[]"
                                    value="{{ $subject->id }}" id="subject_{{ $subject->id }}"
                                    {{ is_array(old('subjects')) && in_array($subject->id, old('subjects')) ? 'checked' : '' }}>
                                <label class="form-check-label" for="subject_{{ $subject->id }}">
                                    {{ $subject->name }}
                                </label>
                            </div>
                        @endforeach
                        @errorFeedback('subjects')
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="total_regular_hours" class="form-label">Total Jam Reguler</label>
                            <input type="number" min="0"
                                class="form-control @error('total_regular_hours') is-invalid @enderror"
                                id="total_regular_hours" name="total_regular_hours"
                                value="{{ old('total_regular_hours', 0) }}" required>
                            @errorFeedback('total_regular_hours')
                        </div>

                        <div class="col-md-6">
                            <label for="total_replacement_hours" class="form-label">Total Jam Badal</label>
                            <input type="number" min="0"
                                class="form-control @error('total_replacement_hours') is-invalid @enderror"
                                id="total_replacement_hours" name="total_replacement_hours"
                                value="{{ old('total_replacement_hours', 0) }}" required>
                            @errorFeedback('total_replacement_hours')
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="regular_hour_description" class="form-label">Deskripsi Sebaran JP Reguler</label>
                        <textarea class="form-control @error('regular_hour_description') is-invalid @enderror" id="regular_hour_description"
                            name="regular_hour_description" rows="3" required>{{ old('regular_hour_description') }}</textarea>
                        <small>(ex: B. ARAB 3, DINIYAH 3)</small>
                        @errorFeedback('regular_hour_description')
                    </div>

                    <div class="mb-3">
                        <label for="replacement_hour_description" class="form-label">Deskripsi Sebaran JP Badal</label>
                        <textarea class="form-control @error('replacement_hour_description') is-invalid @enderror"
                            id="replacement_hour_description" name="replacement_hour_description" rows="3" required>{{ old('replacement_hour_description') }}</textarea>
                        <small>(ex: BADAL UST RUJIAN 1JP - MAPEL TAMBAHAN)</small>
                        @errorFeedback('replacement_hour_description')
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan Tambahan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="2">{{ old('notes') }}</textarea>
                        <small>(ex: Karena saya sakit perut maka untuk mapel tambahan saya selesaikan lebih awal 5 menit /
                            karena anak-anak senang dan tugas belum selesai saya akhirkan 10 menit atau catatan
                            lainnya)</small>
                        @errorFeedback('notes')
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $('.select2').select2();
    </script>
@endsection

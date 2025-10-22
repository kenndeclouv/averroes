@extends('layouts.app')
@section('title', 'Tambah Jurnal Mengajar')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">Buat Jurnal Mengajar</h1>
            <a href="{{ route('teacher.journals.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar
            </a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('teacher.journals.store') }}" method="POST">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date') }}" required>
                            @errorFeedback('date')
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mata Pelajaran</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="AL-QUR'AN / DINIYAH"
                                id="subject_alqurandiniyah"
                                {{ (is_array(old('subject')) && in_array("AL-QUR'AN / DINIYAH", old('subject'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject_alqurandiniyah">
                                AL-QUR'AN / DINIYAH
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="B. ARAB"
                                id="subject_barab"
                                {{ (is_array(old('subject')) && in_array("B. ARAB", old('subject'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject_barab">
                                B. ARAB
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="B. INGGRIS"
                                id="subject_binggris"
                                {{ (is_array(old('subject')) && in_array("B. INGGRIS", old('subject'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject_binggris">
                                B. INGGRIS
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="PRAKTIKUM DKV"
                                id="subject_prakdkv"
                                {{ (is_array(old('subject')) && in_array("PRAKTIKUM DKV", old('subject'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject_prakdkv">
                                PRAKTIKUM DKV
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="PRAKTIKUM RPL"
                                id="subject_prakrpl"
                                {{ (is_array(old('subject')) && in_array("PRAKTIKUM RPL", old('subject'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject_prakrpl">
                                PRAKTIKUM RPL
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" value="MAPEL TAMBAHAN"
                                id="subject_mapeltambahan"
                                {{ (is_array(old('subject')) && in_array("MAPEL TAMBAHAN", old('subject'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="subject_mapeltambahan">
                                MAPEL TAMBAHAN (B.INDO, PKN, SEJARAH, KWU, SENI BUDAYA)
                            </label>
                        </div>
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
                        <small>(ex: Karena saya sakit perut maka untuk mapel tambahan saya selesaikan lebih awal 5 menit / karena anak-anak senang dan tugas belum selesai saya akhirkan 10 menit atau catatan lainnya)</small>
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

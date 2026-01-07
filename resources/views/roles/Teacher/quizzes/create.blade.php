@extends('layouts.app')
@section('title', 'Buat Kuis Baru')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Buat Kuis Baru</h5>
            </div>
            <div class="card-body mt-4">
                <form action="{{ route('teacher.quizzes.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Kuis</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" required
                            placeholder="Contoh: Ujian Harian Matematika">
                        @errorFeedback('title')
                    </div>

                    <div class="mb-3">
                        <label for="classes_id" class="form-label">Kelas</label>
                        <select class="form-select select2 @error('classes_id') is-invalid @enderror" id="classes_id"
                            name="classes_id" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}" {{ old('classes_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                        @errorFeedback('classes_id')
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="start_time" class="form-label">Waktu Mulai</label>
                            <input type="datetime-local" class="form-control @error('start_time') is-invalid @enderror"
                                id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                            @errorFeedback('start_time')
                        </div>
                        <div class="col-md-4">
                            <label for="end_time" class="form-label">Waktu Selesai</label>
                            <input type="datetime-local" class="form-control @error('end_time') is-invalid @enderror"
                                id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                            @errorFeedback('end_time')
                        </div>
                        <div class="col-md-4">
                            <label for="duration_minutes" class="form-label">Durasi (Menit)</label>
                            <input type="number" class="form-control @error('duration_minutes') is-invalid @enderror"
                                id="duration_minutes" name="duration_minutes" value="{{ old('duration_minutes', 60) }}"
                                required min="1">
                            @errorFeedback('duration_minutes')
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi / Petunjuk</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="3">{{ old('description') }}</textarea>
                        @errorFeedback('description')
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="{{ route('teacher.quizzes.index') }}" class="btn btn-label-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Simpan & Lanjut ke Soal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection

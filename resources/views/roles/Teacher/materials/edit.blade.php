@extends('layouts.app')
@section('title', 'Edit Materi Pembelajaran')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Guru / Materi /</span> Edit Materi
        </h4>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Edit Materi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.materials.update', $material->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="title">Judul Materi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title', $material->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="teaching_subject_id">Mata Pelajaran</label>
                        <div class="col-sm-10">
                            <select class="form-select select2 @error('teaching_subject_id') is-invalid @enderror"
                                id="teaching_subject_id" name="teaching_subject_id" required>
                                <option value="" disabled>Pilih Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('teaching_subject_id', $material->teaching_subject_id) == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}</option>
                                @endforeach
                            </select>
                            @error('teaching_subject_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="classes_id">Kelas</label>
                        <div class="col-sm-10">
                            <select class="form-select select2 @error('classes_id') is-invalid @enderror" id="classes_id"
                                name="classes_id" required>
                                <option value="" disabled>Pilih Kelas</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('classes_id', $material->classes_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }}</option>
                                @endforeach
                            </select>
                            @error('classes_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="type">Tipe Materi</label>
                        <div class="col-sm-10">
                            <select class="form-select select2 @error('type') is-invalid @enderror" id="type"
                                name="type" required onchange="toggleInputs(this.value)">
                                <option value="document"
                                    {{ old('type', $material->type) == 'document' ? 'selected' : '' }}>Dokumen (PDF, DOCX,
                                    PPT)</option>
                                <option value="text" {{ old('type', $material->type) == 'text' ? 'selected' : '' }}>Teks
                                    / Artikel</option>
                                <option value="image" {{ old('type', $material->type) == 'image' ? 'selected' : '' }}>
                                    Gambar</option>
                                <option value="video" {{ old('type', $material->type) == 'video' ? 'selected' : '' }}>
                                    Video</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3" id="file-input-group">
                        <label class="col-sm-2 col-form-label" for="file">Upload File</label>
                        <div class="col-sm-10">
                            @if ($material->file_path && $material->type != 'text')
                                <div class="mb-2">
                                    <small class="text-muted">File saat ini: </small>
                                    <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank"
                                        class="fw-bold">{{ basename($material->file_path) }}</a>
                                </div>
                            @endif
                            <input class="form-control @error('file') is-invalid @enderror" type="file" id="file"
                                name="file">
                            <div class="form-text">Biarkan kosong jika tidak ingin mengubah file. Format: PDF, DOC... Max
                                20MB.</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3" id="content-input-group">
                        <label class="col-sm-2 col-form-label" for="content">Isi Materi / Deskripsi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $material->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('teacher.materials.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleInputs(type) {
            const fileGroup = document.getElementById('file-input-group');
            const contentGroup = document.getElementById('content-input-group');
            const contentLabel = document.querySelector('label[for="content"]');

            if (type === 'text') {
                fileGroup.style.display = 'none';
                contentGroup.style.display = 'flex';
                contentLabel.innerText = "Isi Materi";
            } else {
                fileGroup.style.display = 'flex';
                contentGroup.style.display = 'flex'; // Allow description
                contentLabel.innerText = "Keterangan / Deskripsi";
            }
        }

        // Initial run
        $(document).ready(function() {
            $('.select2').select2();
            toggleInputs(document.getElementById('type').value);
        });
    </script>
@endsection

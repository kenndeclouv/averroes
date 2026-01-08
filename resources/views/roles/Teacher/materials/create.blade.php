@extends('layouts.app')
@section('title', 'Tambah Materi Pembelajaran')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Guru / Materi /</span> Tambah Materi
        </h4>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Form Tambah Materi</h5>
                <small class="text-muted float-end">Semester Aktif</small>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.materials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="title">Judul Materi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" placeholder="Contoh: Modul Bab 1 - Aljabar"
                                required>
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
                                <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                @foreach ($subjects as $subject)
                                    <option value="{{ $subject->id }}"
                                        {{ old('teaching_subject_id') == $subject->id ? 'selected' : '' }}>
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
                                <option value="" selected disabled>Pilih Kelas</option>
                                @foreach ($classes as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('classes_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}</option>
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
                                <option value="document" {{ old('type') == 'document' ? 'selected' : '' }}>Dokumen (PDF,
                                    DOCX, PPT)</option>
                                <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Teks / Artikel
                                </option>
                                <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>Gambar</option>
                                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3" id="file-input-group">
                        <label class="col-sm-2 col-form-label" for="file">Upload File</label>
                        <div class="col-sm-10">
                            <input class="form-control @error('file') is-invalid @enderror" type="file" id="file"
                                name="file">
                            <div class="form-text">Format: PDF, DOC, DOCX, PPT, PPTX, JPG, PNG, MP4. Max 20MB.</div>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3" id="content-input-group"
                        style="display: {{ old('type') == 'text' ? 'flex' : 'none' }};">
                        <label class="col-sm-2 col-form-label" for="content">Isi Materi</label>
                        <div class="col-sm-10">
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                placeholder="Tulis isi materi di sini...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Simpan</button>
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

            if (type === 'text') {
                fileGroup.style.display = 'none';
                contentGroup.style.display = 'flex';
            } else {
                fileGroup.style.display = 'flex';
                contentGroup.style.display =
                    'none'; // Optional: Can allow content as description for files too, but user req "text puanjang biasa OR foto OR pdf"
                // User said "bisa text panjang biasa, atau foto atau bahkan pdf".
                // Usually files also have descriptions. Let's keep content visible but maybe label it "Deskripsi" if file?
                // For now, let's Stick to the requested "OR" logic roughly, but maybe allow description for files?
                // The prompt implies distinct types. "Materi berupa teks" vs "Materi berupa file".
                // Let's hide Content for files for simplicity unless asked, OR allow it as description.
                // Actually, let's allow Content as "Keterangan/Deskripsi" for files.
                if (type !== 'text') {
                    // Show content as optional description?
                    // Let's just modify the UI to always show Content but maybe rename label?
                    // The prompt said "text puanjang biasa, ATAU foto...".
                    // Let's follow strict mode: Input File OR text area.
                    contentGroup.style.display = 'flex'; // Let's keep it visible for description
                    document.querySelector('label[for="content"]').innerText = "Keterangan / Deskripsi";
                } else {
                    contentGroup.style.display = 'flex';
                    document.querySelector('label[for="content"]').innerText = "Isi Materi";
                    fileGroup.style.display = 'none';
                }
            }
        }

        $(document).ready(function() {
            $('.select2').select2();
            toggleInputs(document.getElementById('type').value);
        });
    </script>
@endsection

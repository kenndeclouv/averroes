@extends('layouts.app')

@section('title', 'Tambah Jabatan / Amanah Mengajar')

@section('page-script')
    <script>
        $('.select2').select2();
    </script>
@endsection

@section('content')
    <form action="{{ route('administrationadmin.teachertype.store') }}" method="POST">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('administrationadmin.teachertype.index') }}">Master Jabatan & Amanah</a> / </span>
                Tambah Data
            </h5>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Jabatan & Amanah Mengajar</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="type">Kategori</label>
                                <select class="form-control select2 @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="" disabled {{ old('type') ? '' : 'selected' }}>Pilih Kategori</option>
                                    <option value="functional_position" {{ old('type') == 'functional_position' ? 'selected' : '' }}>Jabatan Fungsional (SDM/Admin/Guru)</option>
                                    <option value="teaching_mandatory" {{ old('type') == 'teaching_mandatory' ? 'selected' : '' }}>Amanah Mengajar (Mapel)</option>
                                </select>
                                @errorFeedback('type')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama Jabatan / Amanah</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="misal: Keuangan / Bahasa Arab" value="{{ old('name') }}" required>
                                @errorFeedback('name')
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

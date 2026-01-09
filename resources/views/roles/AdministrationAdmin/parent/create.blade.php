@extends('layouts.app')
@section('title', 'Tambah Walisantri')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Walisantri /</span> Tambah Walisantri</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Form Tambah Walisantri</h5>
                    <div class="card-body">
                        <form action="{{ route('administrationadmin.parent.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @errorFeedback('name')
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username') }}" required>
                                @errorFeedback('username')
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @errorFeedback('email')
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @errorFeedback('password')
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input type="text" class="form-control" id="nik" name="nik"
                                    value="{{ old('nik') }}">
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    value="{{ old('phone') }}">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin</label>
                                <select class="form-select select2" id="gender" name="gender">
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="birth_place" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="birth_place" name="birth_place"
                                        value="{{ old('birth_place') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date"
                                        value="{{ old('birth_date') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="profession" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="profession" name="profession"
                                    value="{{ old('profession') }}">
                            </div>
                            <div class="mb-3">
                                <label for="income" class="form-label">Penghasilan</label>
                                <input type="number" class="form-control" id="income" name="income"
                                    value="{{ old('income') }}">
                            </div>
                            <div class="mb-3">
                                <label for="students" class="form-label">Santri</label>
                                <select class="form-select select2" id="students" name="students[]" multiple>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}"
                                            {{ in_array($student->id, old('students', [])) ? 'selected' : '' }}>
                                            {{ $student->name }} ({{ $student->nis ?? '-' }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('administrationadmin.parent.index') }}"
                                class="btn btn-secondary">Kembali</a>
                        </form>
                    </div>
                </div>
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

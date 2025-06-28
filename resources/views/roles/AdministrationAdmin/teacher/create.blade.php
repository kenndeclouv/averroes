@extends('layouts.app')

@section('title', 'Tambah Pegawai')

@section('page-script')
    <script>
        $('.select2').select2();
    </script>
    <script>
        $(document).ready(function() {
            function toggleLainnyaInput(selectElement, lainnyaId, lainnyaDivId) {
                // Initial state
                let selectedValues = $(selectElement).val() || [];
                $('#' + lainnyaDivId).toggle(selectedValues.includes(lainnyaId));

                // On change
                $(selectElement).on('change', function() {
                    let selectedValues = $(this).val() || [];
                    $('#' + lainnyaDivId).toggle(selectedValues.includes(lainnyaId));
                    console.log('Select changed', {
                        selectId: selectElement,
                        selectedValues: selectedValues,
                        lainnyaId: lainnyaId,
                        isVisible: selectedValues.includes(lainnyaId)
                    });
                });
            }

            // Initialize for both selects
            toggleLainnyaInput('#fn_type', '{{ $FNOtherTypeId }}', 'fn_type_lainnya_div');
            toggleLainnyaInput('#tm_type', '{{ $TMOtherTypeId }}', 'tm_type_lainnya_div');
        });
    </script>
@endsection

@section('content')
    <form action="{{ route('administrationadmin.teacher.store') }}" method="POST">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"> <a href="{{ route('administrationadmin.teacher.index') }}">Daftar
                        Pegawai</a> /</span>
                Tambah Pegawai
            </h5>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Akun Pegawai</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Nama Pegawai" value="{{ old('name') }}">
                                @errorFeedback('name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" placeholder="Username Pegawai"
                                    value="{{ old('username') }}">
                                @errorFeedback('username')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="role">Role</label>
                                <select class="form-control select2 @error('role_id') is-invalid @enderror" id="role"
                                    name="role_id">
                                    <option value="" disabled>Pilih Role</option>
                                    <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Pengajar</option>
                                    <option value="7" {{ old('role_id') == '7' ? 'selected' : '' }}>Bendahara
                                    </option>
                                </select>
                                @errorFeedback('role_id')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="Email Pegawai" value="{{ old('email') }}">
                                @errorFeedback('email')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Password Pegawai">
                                @errorFeedback('password')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                <input type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    id="password_confirmation" name="password_confirmation"
                                    placeholder="Konfirmasi Password Pegawai">
                                @errorFeedback('password_confirmation')
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Data Pegawai</h5>
                        </div>
                        <div class="card-body">
                            @if (isset($lastNip))
                                <div class="alert alert-info alert-dismissible mb-3" role="alert">
                                    NIP terakhir adalah: {{ $lastNip }}
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label" for="full_name">Nama Lengkap</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name" placeholder="Nama Lengkap Pegawai"
                                    value="{{ old('full_name') }}">
                                @errorFeedback('full_name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nip">NIP</label>
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <input type="number" class="form-control @error('nip') is-invalid @enderror"
                                            id="nip" name="nip" placeholder="NIP Pegawai"
                                            value="{{ old('nip') }}">
                                        @errorFeedback('nip')
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="alert alert-info py-2 m-0" role="alert">
                                            <i class="fa-solid fa-info-circle me-2"></i> Kosongkan NIP jika ingin
                                            otomatis
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select class="form-control select2 @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @errorFeedback('gender')
                            </div>
                            {{-- <div class="mb-3">
                                <label class="form-label" for="room">Kamar</label>
                                <select class="form-control select2" id="room" name="room_id">
                                    <option value="" disabled {{ old('room_id') ? '' : 'selected' }}>Pilih Kamar
                                    </option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}"
                                            {{ old('room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @errorFeedback('room_id')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="classes">Kelas</label>
                                <select class="form-control select2" id="classes" name="classes_id">
                                    <option value="" disabled {{ old('classes_id') ? '' : 'selected' }}>Pilih Kelas
                                    </option>
                                    @foreach ($classes as $class)
                                        <option value="{{ $class->id }}"
                                            {{ old('classes_id') == $class->id ? 'selected' : '' }}>{{ $class->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @errorFeedback('classes_id')
                            </div> --}}
                            <div class="mb-3">
                                <label class="form-label" for="phone">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" placeholder="Nomor Telepon Pegawai"
                                    value="{{ old('phone') }}">
                                @errorFeedback('phone')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="birth_date">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                                @errorFeedback('birth_date')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="birth_place">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                    id="birth_place" name="birth_place" placeholder="Tempat Lahir Pegawai"
                                    value="{{ old('birth_place') }}">
                                @errorFeedback('birth_place')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="last_degree">Pendidikan Terakhir</label>
                                <input type="text" class="form-control @error('last_degree') is-invalid @enderror"
                                    id="last_degree" name="last_degree" placeholder="Pendidikan Terakhir"
                                    value="{{ old('last_degree') }}">
                                @errorFeedback('last_degree')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="fn_type">Jabatan Fungsional</label>
                                <select class="form-control select2 @error('fn_type') is-invalid @enderror"
                                    id="fn_type" name="fn_type[]" multiple>
                                    @foreach ($FNTypes as $type)
                                        <option value="{{ $type->id }}" data-slug="{{ $type->slug }}"
                                            {{ in_array($type->id, old('fn_type', [])) ? 'selected' : '' }}>
                                            {{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @errorFeedback('fn_type')

                                <div id="fn_type_lainnya_div" class="mt-3"
                                    style="{{ in_array($FNOtherTypeId, old('fn_type', $selectedFNs ?? [])) ? '' : 'display: none;' }}">
                                    <label class="form-label" for="fn_type_lainnya_des">Jabatan Fungsional Lainnya</label>
                                    <input type="text" class="form-control" id="fn_type_lainnya_des"
                                        placeholder="Isi Jabatan Fungsional Lainnya" name="fn_type_lainnya_des"
                                        value="{{ old('fn_type_lainnya_des') }}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tm_type">Amanah Mengajar</label>
                                <select class="form-control select2 @error('tm_type') is-invalid @enderror"
                                    id="tm_type" name="tm_type[]" multiple>
                                    @foreach ($TMTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ in_array($type->id, old('tm_type', [])) ? 'selected' : '' }}>
                                            {{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <div id="tm_type_lainnya_div" class="mt-3" style="">
                                    <label class="form-label" for="tm_type_lainnya_des">Amanah Mengajar Lainnya</label>
                                    <input type="text" class="form-control" id="tm_type_lainnya_des"
                                        placeholder="Isi Amanah Mengajar Lainnya" name="tm_type_lainnya_des"
                                        value="{{ old('tm_type_lainnya_des') }}">
                                </div>
                                @errorFeedback('tm_type')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                    placeholder="Alamat Pegawai">{{ old('address') }}</textarea>
                                @errorFeedback('address')
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

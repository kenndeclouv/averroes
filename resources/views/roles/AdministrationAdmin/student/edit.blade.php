@extends('layouts.app')

@section('title', 'Edit Santri')

@section('page-script')
    <script>
        $('.select2').select2();

        function formatCurrency(input, type) {
            let value = input.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let remainder = split[0].length % 3;
            let currency = split[0].substring(0, remainder);
            let thousands = split[0].substring(remainder).match(/\d{3}/gi);

            if (thousands) {
                let separator = remainder ? '.' : '';
                currency += separator + thousands.join('.');
            }

            currency = split[1] !== undefined ? currency + ',' + split[1] : currency;
            input.value = currency;
            document.getElementById(type).value = currency.replace(/\./g, '');
        }
    </script>
@endsection

@section('content')
    <form action="{{ route('administrationadmin.student.update', $student->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"> <a href="{{ route('administrationadmin.student.index') }}">Data Santri</a>
                    /</span>
                Edit Santri
            </h5>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Akun Santri</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $student->user->name) }}"
                                    placeholder="Nama Santri">
                                @errorFeedback('name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    id="username" name="username" value="{{ old('username', $student->user->username) }}"
                                    placeholder="Username Santri">
                                @errorFeedback('username')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', $student->user->email) }}"
                                    placeholder="Email Santri">
                                @errorFeedback('email')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Data Santri</h5>
                        </div>
                        <div class="card-body">
                            @if (!$student->nis && isset($nisFormat))
                                <div class="alert alert-info alert-dismissible mb-3" role="alert">
                                    Format NIS adalah: {{ $nisFormat }}
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label" for="full_name">Nama Lengkap</label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name" placeholder="Nama Santri"
                                    value="{{ old('full_name', $student->full_name) }}">
                                @errorFeedback('full_name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nis">NIS</label>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror" id="nis"
                                    name="nis" value="{{ old('nis', $student->nis) }}" placeholder="NIS Santri">
                                @errorFeedback('nis')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nisn">NISN</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                    id="nisn" name="nisn" placeholder="NISN Santri"
                                    value="{{ old('nisn', $student->nisn) }}">
                                @errorFeedback('nisn')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="gender">Jenis Kelamin</label>
                                <select class="form-select select2 @error('gender') is-invalid @enderror" id="gender"
                                    name="gender">
                                    <option value="" disabled>Pilih Jenis Kelamin</option>
                                    <option value="male"
                                        {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                                @errorFeedback('gender')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">No Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" placeholder="No Telepon Santri"
                                    value="{{ old('phone', $student->phone) }}">
                                @errorFeedback('phone')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="birth_date">Tanggal Lahir</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date"
                                    value="{{ old('birth_date', $student->birth_date) }}">
                                @errorFeedback('birth_date')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="birth_place">Tempat Lahir</label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                    id="birth_place" name="birth_place" placeholder="Tempat Lahir Santri"
                                    value="{{ old('birth_place', $student->birth_place) }}">
                                @errorFeedback('birth_place')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="address">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                    placeholder="Alamat Santri">{{ old('address', $student->address) }}</textarea>
                                @errorFeedback('address')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="sibling_info">Informasi Saudara</label>
                                <input type="text" class="form-control @error('sibling_info') is-invalid @enderror"
                                    id="sibling_info" name="sibling_info" placeholder="Informasi Saudara"
                                    value="{{ old('sibling_info', $student->sibling_info) }}">
                                @errorFeedback('sibling_info')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="quran_memorization">Jumlah Hafalan Quran</label>
                                <input type="number"
                                    class="form-control @error('quran_memorization') is-invalid @enderror"
                                    id="quran_memorization" name="quran_memorization" placeholder="Jumlah Hafalan Quran"
                                    value="{{ old('quran_memorization', $student->quran_memorization) }}">
                                @errorFeedback('quran_memorization')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="achievements">Prestasi</label>
                                <input type="text" class="form-control @error('achievements') is-invalid @enderror"
                                    id="achievements" name="achievements" placeholder="Prestasi Santri"
                                    value="{{ old('achievements', $student->achievements) }}">
                                @errorFeedback('achievements')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="major">Jurusan</label>
                                <select class="form-select select2 @error('major') is-invalid @enderror" id="major"
                                    name="major">
                                    <option value="" disabled>Pilih Jurusan</option>
                                    <option value="RPL" {{ old('major', $student->major) == 'RPL' ? 'selected' : '' }}>
                                        RPL</option>
                                    <option value="DKV" {{ old('major', $student->major) == 'DKV' ? 'selected' : '' }}>
                                        DKV</option>
                                </select>
                                @errorFeedback('major')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="medical_history">Riwayat Kesehatan</label>
                                <input type="text" class="form-control @error('medical_history') is-invalid @enderror"
                                    id="medical_history" name="medical_history" placeholder="Riwayat Kesehatan"
                                    value="{{ old('medical_history', $student->medical_history) }}">
                                @errorFeedback('medical_history')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="father_name">Nama Ayah</label>
                                <input type="text" class="form-control @error('father_name') is-invalid @enderror"
                                    id="father_name" name="father_name" placeholder="Nama Ayah"
                                    value="{{ old('father_name', $student->father_name) }}">
                                @errorFeedback('father_name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="father_occupation">Pekerjaan Ayah</label>
                                <input type="text"
                                    class="form-control @error('father_occupation') is-invalid @enderror"
                                    id="father_occupation" name="father_occupation" placeholder="Pekerjaan Ayah"
                                    value="{{ old('father_occupation', $student->father_occupation) }}">
                                @errorFeedback('father_occupation')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="father_income">Penghasilan Ayah</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text"
                                        class="form-control @error('father_income') is-invalid @enderror"
                                        placeholder="Penghasilan Ayah"
                                        value="{{ old('father_income', number_format($student->father_income, 0, ',', '.')) }}"
                                        oninput="formatCurrency(this, 'father_income')">
                                    @errorFeedback('father_income')
                                </div>
                                <input type="hidden" name="father_income" id="father_income"
                                    value="{{ old('father_income', $student->father_income) }}">
                                @errorFeedback('father_income')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mother_name">Nama Ibu</label>
                                <input type="text" class="form-control @error('mother_name') is-invalid @enderror"
                                    id="mother_name" name="mother_name" placeholder="Nama Ibu"
                                    value="{{ old('mother_name', $student->mother_name) }}">
                                @errorFeedback('mother_name')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mother_occupation">Pekerjaan Ibu</label>
                                <input type="text"
                                    class="form-control @error('mother_occupation') is-invalid @enderror"
                                    id="mother_occupation" name="mother_occupation" placeholder="Pekerjaan Ibu"
                                    value="{{ old('mother_occupation', $student->mother_occupation) }}">
                                @errorFeedback('mother_occupation')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mother_income">Penghasilan Ibu</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Rp</span>
                                    <input type="text"
                                        class="form-control @error('mother_income') is-invalid @enderror"
                                        placeholder="Penghasilan Ibu"
                                        value="{{ old('mother_income', number_format($student->mother_income, 0, ',', '.')) }}"
                                        oninput="formatCurrency(this, 'mother_income')">
                                    @errorFeedback('mother_income')
                                </div>
                                <input type="hidden" name="mother_income" id="mother_income"
                                    value="{{ old('mother_income', $student->mother_income) }}">
                                @errorFeedback('mother_income')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="parent_whatsapp">No Whatsapp Orang Tua</label>
                                <input type="text" class="form-control @error('parent_whatsapp') is-invalid @enderror"
                                    id="parent_whatsapp" name="parent_whatsapp" placeholder="No Whatsapp Orang Tua"
                                    value="{{ old('parent_whatsapp', $student->parent_whatsapp) }}">
                                @errorFeedback('parent_whatsapp')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="student_status">Status Santri</label>
                                <select class="form-select select2 @error('student_status') is-invalid @enderror"
                                    id="student_status" name="student_status">
                                    <option value="" disabled>Pilih Status Santri</option>
                                    <option value="Yatim Piatu"
                                        {{ old('student_status', $student->student_status) == 'Yatim Piatu' ? 'selected' : '' }}>
                                        Yatim Piatu</option>
                                    <option value="Yatim"
                                        {{ old('student_status', $student->student_status) == 'Yatim' ? 'selected' : '' }}>
                                        Yatim
                                    </option>
                                    <option value="Piatu"
                                        {{ old('student_status', $student->student_status) == 'Piatu' ? 'selected' : '' }}>
                                        Piatu
                                    </option>
                                    <option value="Non Yatim Piatu"
                                        {{ old('student_status', $student->student_status) == 'Non Yatim Piatu' ? 'selected' : '' }}>
                                        Non Yatim Piatu
                                    </option>
                                </select>
                                @errorFeedback('student_status')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="uniform_size">Ukuran Seragam</label>
                                <div class="row">
                                    <div class="col-12 col-md-9">
                                        <select class="form-select select2 @error('uniform_size') is-invalid @enderror"
                                            id="uniform_size" name="uniform_size">
                                            <option value="" disabled selected>Pilih Ukuran Seragam</option>
                                            <option value="S"
                                                {{ old('uniform_size', $student->uniform_size) == 'S' ? 'selected' : '' }}>
                                                S</option>
                                            <option value="M"
                                                {{ old('uniform_size', $student->uniform_size) == 'M' ? 'selected' : '' }}>
                                                M</option>
                                            <option value="L"
                                                {{ old('uniform_size', $student->uniform_size) == 'L' ? 'selected' : '' }}>
                                                L</option>
                                            <option value="XL"
                                                {{ old('uniform_size', $student->uniform_size) == 'XL' ? 'selected' : '' }}>
                                                XL</option>
                                            <option value="2XL"
                                                {{ old('uniform_size', $student->uniform_size) == '2XL' ? 'selected' : '' }}>
                                                2XL</option>
                                            <option value="3XL"
                                                {{ old('uniform_size', $student->uniform_size) == '3XL' ? 'selected' : '' }}>
                                                3XL</option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-3">
                                        <button type="button" class="btn btn-info w-100" data-bs-toggle="modal"
                                            data-bs-target="#uniformSizeModal">
                                            <i class="fa-solid fa-info-circle me-2"></i> Ukuran Seragam
                                        </button>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="uniformSizeModal" tabindex="-1"
                                        aria-labelledby="uniformSizeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uniformSizeModalLabel">Ukuran Seragam</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img src="{{ asset('assets/img/uniform_size.jpg') }}"
                                                        alt="Ukuran Seragam" class="img-fluid">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @errorFeedback('uniform_size')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="attachment_family_register">Lampiran Kartu Keluarga</label>
                                <input type="file"
                                    class="form-control @error('attachment_family_register') is-invalid @enderror"
                                    id="attachment_family_register" name="attachment_family_register">
                                @errorFeedback('attachment_family_register')
                                @if ($student->attachment_family_register)
                                    <a href="{{ $student->attachment_family_register }}" target="_blank">klik untuk
                                        melihat gambar</a>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="attachment_birth_certificate">Lampiran Akta
                                    Kelahiran</label>
                                <input type="file"
                                    class="form-control @error('attachment_birth_certificate') is-invalid @enderror"
                                    id="attachment_birth_certificate" name="attachment_birth_certificate">
                                @errorFeedback('attachment_birth_certificate')
                                @if ($student->attachment_birth_certificate)
                                    <a href="{{ $student->attachment_birth_certificate }}" target="_blank">klik untuk
                                        melihat gambar</a>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="attachment_diploma">Lampiran Ijazah / SKL</label>
                                <input type="file"
                                    class="form-control @error('attachment_diploma') is-invalid @enderror"
                                    id="attachment_diploma" name="attachment_diploma">
                                @errorFeedback('attachment_diploma')
                                @if ($student->attachment_diploma)
                                    <a href="{{ $student->attachment_diploma }}" target="_blank">klik untuk melihat
                                        gambar</a>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="attachment_father_identity_card">Lampiran KTP Ayah</label>
                                <input type="file"
                                    class="form-control @error('attachment_father_identity_card') is-invalid @enderror"
                                    id="attachment_father_identity_card" name="attachment_father_identity_card">
                                @errorFeedback('attachment_father_identity_card')
                                @if ($student->attachment_father_identity_card)
                                    <a href="{{ $student->attachment_father_identity_card }}" target="_blank">klik untuk
                                        melihat gambar</a>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="attachment_mother_identity_card">Lampiran KTP Ibu</label>
                                <input type="file"
                                    class="form-control @error('attachment_mother_identity_card') is-invalid @enderror"
                                    id="attachment_mother_identity_card" name="attachment_mother_identity_card">
                                @errorFeedback('attachment_mother_identity_card')
                                @if ($student->attachment_mother_identity_card)
                                    <a href="{{ $student->attachment_mother_identity_card }}" target="_blank">klik untuk
                                        melihat gambar</a>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

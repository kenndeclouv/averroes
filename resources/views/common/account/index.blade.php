@extends('layouts.app')
@section('title', 'Profile')

@section('page-script')
    <script src="{{ asset('assets/vendor/libs/cropper-js/cropper-js.js') }}"></script>
    <script>
        function showLogoutConfirm() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah kamu yakin ingin logout dari akun ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Tidak',
                confirmButtonColor: 'var(--bs-primary)',
                cancelButtonColor: '#8592a3',
                background: isDarkMode ? '#2b2c40' : '#fff',
                color: isDarkMode ? '#b2b2c4' : '#000',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
        $(document).ready(function() {
            let cropper;

            // Event listener untuk upload file
            $('#upload').on('change', function(event) {
                const files = event.target.files;

                if (files && files.length > 0) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imagePreview = $('#imagePreview')[0];
                        imagePreview.src = e.target.result; // Tampilkan gambar di modal
                        $('#cropModal').modal('show'); // Tampilkan modal crop
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            // Inisialisasi cropper saat modal ditampilkan
            $('#cropModal')
                .on('shown.bs.modal', function() {
                    const image = $('#imagePreview')[0];

                    cropper = new Cropper(image, {
                        aspectRatio: 1, // Ratio 1:1, sesuaikan sesuai kebutuhan
                        viewMode: 1, // Crop di dalam boundary
                        autoCropArea: 1, // Full area crop
                        responsive: true, // Responsive untuk perubahan layar
                    });
                })
                .on('hidden.bs.modal', function() {
                    // Hancurkan cropper untuk mencegah memory leak
                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                });

            // Event listener untuk tombol crop
            $('#cropButton').on('click', function() {
                const accountForm = $('#AccountForm')[0];

                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 200, // Ukuran crop (opsional)
                        height: 200,
                    });

                    if (!canvas) {
                        Swal.fire({
                            title: 'Error',
                            text: 'Gagal membuat canvas dari gambar.',
                            icon: 'error',
                            confirmButtonText: 'OK',
                            background: isDarkMode ? '#2b2c40' : '#fff',
                            color: isDarkMode ? '#b2b2c4' : '#000',
                        });
                        return;
                    }

                    canvas.toBlob((blob) => {
                        if (!blob) {
                            Swal.fire({
                                title: 'Error',
                                text: 'Gagal menghasilkan blob dari canvas.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                background: isDarkMode ? '#2b2c40' : '#fff',
                                color: isDarkMode ? '#b2b2c4' : '#000',
                            });
                            return;
                        }

                        const reader = new FileReader();
                        reader.onloadend = () => {
                            const base64data = reader.result;

                            // Buat FormData baru
                            const formData = new FormData();
                            const accountFormData = new FormData(accountForm);

                            // Tambahkan base64 ke FormData
                            formData.append('photo', base64data);

                            // Tambahkan data form lainnya
                            for (const [key, value] of accountFormData.entries()) {
                                if (key !== 'photo') {
                                    formData.append(key, value);
                                }
                            }

                            // Kirim data ke backend menggunakan fetch
                            fetch(accountForm.action, {
                                    method: 'POST', // Ubah jika butuh method lain (PUT/POST)
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                            'content'),
                                    },
                                    body: formData,
                                })
                                .then((response) => {
                                    if (response.ok) {
                                        Swal.fire({
                                            title: 'Berhasil',
                                            text: 'Foto berhasil diunggah!',
                                            icon: 'success',
                                            confirmButtonText: 'OK',
                                            background: isDarkMode ? '#2b2c40' :
                                                '#fff',
                                            color: isDarkMode ? '#b2b2c4' : '#000',
                                        }).then(() => {
                                            window.location.href =
                                                '{{ route('account.index') }}';
                                        });
                                    } else {
                                        response.text().then((text) => {
                                            console.error('Response Error:', text);
                                            Swal.fire({
                                                title: 'Gagal',
                                                text: 'Terjadi kesalahan saat mengunggah foto.',
                                                icon: 'error',
                                                confirmButtonText: 'OK',
                                                background: isDarkMode ?
                                                    '#2b2c40' : '#fff',
                                                color: isDarkMode ?
                                                    '#b2b2c4' : '#000',
                                            });
                                        });
                                    }
                                })
                                .catch((error) => {
                                    console.error('Fetch Error:', error);
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Terjadi kesalahan saat mengunggah foto.',
                                        icon: 'error',
                                        confirmButtonText: 'OK',
                                        background: isDarkMode ? '#2b2c40' : '#fff',
                                        color: isDarkMode ? '#b2b2c4' : '#000',
                                    });
                                });
                        };
                        reader.readAsDataURL(blob);
                    });
                }
            });
        });
        $('.select2').select2();
    </script>
@endsection

@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/cropper-js/cropper-js.css') }}">
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('/assets/img/pages/profile-banner.png') }}" alt="Banner image" class="rounded-top"
                            class="w-100">
                    </div>
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-8">
                        <div class="flex-shrink-0 mt-1 mx-sm-0 mx-auto">
                            <img src="{{ $user->photo }}" alt="user image"
                                class="d-block h-auto ms-0 ms-sm-6 rounded-3 user-profile-img">
                        </div>
                        <div class="flex-grow-1 mt-3 mt-lg-5">
                            <div
                                class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-7">{{ ucfirst($user->name) }}</h4>
                                    <ul
                                        class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4 mt-4">
                                        <li class="list-inline-item">
                                            <span class="fw-medium">{{ ucfirst($user->Role->name ?? '-') }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-medium">{{ $user->email }}</span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-medium">Terdaftar
                                                {{ formatdate($user->created_at, 'F Y') }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-primary mb-1"
                                    onclick="event.preventDefault(); showLogoutConfirm();">
                                    <i class="fa fa-sign-out-alt fa-sm me-2"></i>Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- User Profile Content -->
        <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-5">
                <!-- About User -->
                <div class="card mb-6 ">
                    <div class="card-body">
                        <small class="card-text text-uppercase text-muted small">About</small>
                        <div class="row mt-3">
                            <div class="col"><i class="text-primary fa fa-user me-2"></i> Nama</div>
                            <div class="col">: {{ $user->name ?? '-' }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col"><i class="text-success fa fa-user me-2"></i> Username</div>
                            <div class="col">: {{ $user->username }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col"><i class="text-info fa fa-crown me-2"></i> Role</div>
                            <div class="col">: {{ $user->Role->name ?? '-' }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col"><i class="text-secondary fa fa-envelope me-2"></i> Email</div>
                            <div class="col">: {{ $user->email }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col"><i class="text-warning fa fa-calendar-alt me-2"></i> Terdaftar
                            </div>
                            <div class="col">: {{ formatDate($user->created_at) }}</div>
                        </div>
                    </div>
                </div>
                <!--/ About User -->
            </div>
            <div class="col-xl-8 col-lg-7 col-md-7">
                <form action="{{ route('account.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                    id="AccountForm">
                    @csrf
                    @method('PUT')
                    <!-- Activity Timeline -->
                    <div class="card mb-6">
                        <!-- Account -->
                        <div class="card-body">
                            <div class="d-flex align-items-start align-items-sm-center gap-6 pb-4 border-bottom">
                                <img src="{{ $user->photo }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded"
                                    id="uploadedAvatar">
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload foto baru</span>
                                        <i class="fa fa-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden=""
                                            name="photo" accept="photo/*">
                                    </label>

                                    <div>Diizinkan JPG, JPEG, atau PNG. Ukuran maksimum 5 Mb</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4">
                            <div class="row g-6">
                                <div class="col-md-6 fv-plugins-icon-container">
                                    <label for="name" class="form-label">Nama</label>
                                    <input class="form-control" type="text" id="name" name="name"
                                        value="{{ $user->name }}">
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-6 fv-plugins-icon-container">
                                    <label for="username" class="form-label">Username</label>
                                    <input class="form-control" type="text" name="username" id="username"
                                        value="{{ $user->username }}">
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                                <div class="col-md-6 fv-plugins-icon-container">
                                    <label for="email" class="form-label">Email</label>
                                    <input class="form-control" type="text" name="email" id="email"
                                        value="{{ $user->email }}">
                                    <div
                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit" class="btn btn-primary me-3">Simpan Perubahan</button>
                                <button type="reset" class="btn btn-label-secondary">Batalkan</button>
                            </div>
                        </div>

                        <!-- /Account -->
                    </div>
                    <!--/ Activity Timeline -->
                    <div class="card mb-6">
                        <h5 class="card-header border-bottom mb-4">Ganti Password</h5>
                        <div class="card-body">
                            <form id="formChangePassword" method="GET" onsubmit="return false"
                                class="fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
                                <div class="alert alert-warning alert-dismissible" role="alert">
                                    <h5 class="alert-heading mb-1">Pastikan bahwa persyaratan ini terpenuhi</h5>
                                    <span>Minimal 8 karakter, huruf besar &amp; simbol</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="row gx-6">
                                    <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                        <label class="form-label" for="newPassword">New Password</label>
                                        <div class="input-group input-group-merge has-validation">
                                            <input class="form-control" type="password" id="newPassword" name="password"
                                                placeholder="············">
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="fa fa-eye-slash"></i></span>
                                        </div>
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="mb-4 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                        <label class="form-label" for="confirmPassword">Confirm New
                                            Password</label>
                                        <div class="input-group input-group-merge has-validation">
                                            <input class="form-control" type="password" name="password_confirmation"
                                                id="confirmPassword" placeholder="············">
                                            <span class="input-group-text cursor-pointer"><i
                                                    class="fa fa-eye-slash"></i></span>
                                        </div>
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary me-2">Ganti
                                            Password</button>
                                    </div>
                                </div>
                                <input type="hidden">
                            </form>
                        </div>
                    </div>
                </form>
                @switch($user->Role->code)
                    @case('teacher')
                        <form action="{{ route('account.update-teacher', $user->Teacher->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card mb-6">
                                <!-- Account -->
                                <h5 class="card-header border-bottom mb-4">Informasi Tambahan</h5>
                                <div class="card-body pt-4">
                                    <div class="row g-6">
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="name" class="form-label">Nama</label>
                                            <input class="form-control" type="text" id="name" placeholder="-"
                                                name="name" value="{{ $user->Teacher->name ?? '' }}">
                                            @errorFeedback('name')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="ktp" class="form-label">KTP</label>
                                            <input class="form-control" type="text" id="ktp" placeholder="-"
                                                name="ktp" value="{{ $user->Teacher->ktp ?? '' }}">
                                            @errorFeedback('ktp')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                            <input class="form-control" type="date" id="birth_date" placeholder="-"
                                                name="birth_date" value="{{ $user->Teacher->birth_date ?? '' }}">
                                            @errorFeedback('birth_date')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="birth_place" class="form-label">Tempat Lahir</label>
                                            <input class="form-control" type="text" id="birth_place" placeholder="-"
                                                name="birth_place" value="{{ $user->Teacher->birth_place ?? '' }}">
                                            @errorFeedback('birth_place')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="phone" class="form-label">No. Telp</label>
                                            <input class="form-control" type="text" id="phone" placeholder="-"
                                                name="phone" value="{{ $user->Teacher->phone ?? '' }}">
                                            @errorFeedback('phone')
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="address" placeholder="-" name="address">{{ $user->Teacher->address ?? '' }}</textarea>
                                            @errorFeedback('address')
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <button type="submit" class="btn btn-primary me-3">Simpan Perubahan</button>
                                        <button type="reset" class="btn btn-label-secondary">Batalkan</button>
                                    </div>
                                </div>
                                <!-- /Account -->
                            </div>
                        </form>
                    @break

                    @case('student')
                        <form action="{{ route('account.update-student', $user->Student->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card mb-6">
                                <!-- Account -->
                                <h5 class="card-header border-bottom mb-4">Informasi {{ $user->Role->name }}</h5>
                                <div class="card-body pt-4">
                                    <div class="row g-6">
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="full_name" class="form-label">Nama Lengkap</label>
                                            <input class="form-control" type="text" id="full_name" placeholder="-"
                                                name="full_name" value="{{ $user->Student->full_name ?? '' }}">
                                            @errorFeedback('full_name')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="gender" class="form-label">Jenis Kelamin</label>
                                            <select class="form-control select2" id="gender" name="gender">
                                                <option value="">Pilih Jenis Kelamin</option>
                                                <option value="male" {{ ($user->Student->gender ?? '') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="female" {{ ($user->Student->gender ?? '') == 'female' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @errorFeedback('gender')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="birth_date" class="form-label">Tanggal Lahir</label>
                                            <input class="form-control" type="date" id="birth_date" placeholder="-"
                                                name="birth_date" value="{{ $user->Student->birth_date ?? '' }}">
                                            @errorFeedback('birth_date')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="birth_place" class="form-label">Tempat Lahir</label>
                                            <input class="form-control" type="text" id="birth_place" placeholder="-"
                                                name="birth_place" value="{{ $user->Student->birth_place ?? '' }}">
                                            @errorFeedback('birth_place')
                                        </div>

                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="education_sd" class="form-label">Pendidikan SD</label>
                                            <input class="form-control" type="text" id="education_sd" placeholder="-"
                                                name="education_sd" value="{{ $user->Student->education_sd ?? '' }}">
                                            @errorFeedback('education_sd')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="education_smp" class="form-label">Pendidikan SMP</label>
                                            <input class="form-control" type="text" id="education_smp" placeholder="-"
                                                name="education_smp" value="{{ $user->Student->education_smp ?? '' }}">
                                            @errorFeedback('education_smp')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="nisn" class="form-label">NISN</label>
                                            <input class="form-control" type="text" id="nisn" placeholder="-"
                                                name="nisn" value="{{ $user->Student->nisn ?? '' }}">
                                            @errorFeedback('nisn')
                                        </div>

                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="quran_memorization" class="form-label">Hafalan Al-Quran</label>
                                            <input class="form-control" type="text" id="quran_memorization" placeholder="-"
                                                name="quran_memorization" value="{{ $user->Student->quran_memorization ?? '' }}">
                                            @errorFeedback('quran_memorization')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="major" class="form-label">Jurusan</label>
                                            <select class="form-control select2" id="major" name="major">
                                                <option value="">Pilih Jurusan</option>
                                                <option value="DKV"
                                                    {{ ($user->Student->major ?? '') == 'DKV' ? 'selected' : '' }}>DKV</option>
                                                <option value="RPL"
                                                    {{ ($user->Student->major ?? '') == 'RPL' ? 'selected' : '' }}>RPL</option>
                                            </select>
                                            @errorFeedback('major')
                                        </div>

                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="father_name" class="form-label">Nama Ayah</label>
                                            <input class="form-control" type="text" id="father_name" placeholder="-"
                                                name="father_name" value="{{ $user->Student->father_name ?? '' }}">
                                            @errorFeedback('father_name')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="father_occupation" class="form-label">Pekerjaan Ayah</label>
                                            <input class="form-control" type="text" id="father_occupation" placeholder="-"
                                                name="father_occupation" value="{{ $user->Student->father_occupation ?? '' }}">
                                            @errorFeedback('father_occupation')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="father_income" class="form-label">Penghasilan Ayah</label>
                                            <input class="form-control" type="number" id="father_income" placeholder="-"
                                                name="father_income" value="{{ $user->Student->father_income ?? '' }}">
                                            @errorFeedback('father_income')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="mother_name" class="form-label">Nama Ibu</label>
                                            <input class="form-control" type="text" id="mother_name" placeholder="-"
                                                name="mother_name" value="{{ $user->Student->mother_name ?? '' }}">
                                            @errorFeedback('mother_name')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="mother_occupation" class="form-label">Pekerjaan Ibu</label>
                                            <input class="form-control" type="text" id="mother_occupation" placeholder="-"
                                                name="mother_occupation" value="{{ $user->Student->mother_occupation ?? '' }}">
                                            @errorFeedback('mother_occupation')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="mother_income" class="form-label">Penghasilan Ibu</label>
                                            <input class="form-control" type="number" id="mother_income" placeholder="-"
                                                name="mother_income" value="{{ $user->Student->mother_income ?? '' }}">
                                            @errorFeedback('mother_income')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="parent_whatsapp" class="form-label">WhatsApp Orang Tua</label>
                                            <input class="form-control" type="text" id="parent_whatsapp" placeholder="-"
                                                name="parent_whatsapp" value="{{ $user->Student->parent_whatsapp ?? '' }}">
                                            @errorFeedback('parent_whatsapp')
                                        </div>
                                        <div class="col-md-6 fv-plugins-icon-container">
                                            <label for="student_status" class="form-label">Status Siswa</label>
                                            <select class="form-control select2" id="student_status" name="student_status">
                                                <option value="">Pilih Status</option>
                                                <option value="Non Yatim Piatu"
                                                    {{ ($user->Student->student_status ?? '') == 'Non Yatim Piatu' ? 'selected' : '' }}>
                                                    Non Yatim Piatu</option>
                                                <option value="Yatim"
                                                    {{ ($user->Student->student_status ?? '') == 'Yatim' ? 'selected' : '' }}>Yatim
                                                </option>
                                                <option value="Piatu"
                                                    {{ ($user->Student->student_status ?? '') == 'Piatu' ? 'selected' : '' }}>Piatu
                                                </option>
                                                <option value="Yatim Piatu"
                                                    {{ ($user->Student->student_status ?? '') == 'Yatim Piatu' ? 'selected' : '' }}>
                                                    Yatim Piatu</option>
                                            </select>
                                            @errorFeedback('student_status')
                                        </div>
                                        <div class="col-12 fv-plugins-icon-container">
                                            <label for="uniform_size">Ukuran Seragam</label>
                                            <div class="row">
                                                <div class="col-12 col-md-8">
                                                    <select class="form-select select2 @error('uniform_size') is-invalid @enderror"
                                                        id="uniform_size" name="uniform_size">
                                                        <option value="" disabled selected>Pilih Ukuran Seragam</option>
                                                        <option value="S" {{ ($user->Student->uniform_size ?? '') == 'S' ? 'selected' : '' }}>S</option>
                                                        <option value="M" {{ ($user->Student->uniform_size ?? '') == 'M' ? 'selected' : '' }}>M</option>
                                                        <option value="L" {{ ($user->Student->uniform_size ?? '') == 'L' ? 'selected' : '' }}>L</option>
                                                        <option value="XL" {{ ($user->Student->uniform_size ?? '') == 'XL' ? 'selected' : '' }}>XL</option>
                                                        <option value="2XL" {{ ($user->Student->uniform_size ?? '') == '2XL' ? 'selected' : '' }}>2XL</option>
                                                        <option value="3XL" {{ ($user->Student->uniform_size ?? '') == '3XL' ? 'selected' : '' }}>3XL</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <button type="button" class="btn btn-info w-100" data-bs-toggle="modal"
                                                        data-bs-target="#uniformSizeModal">
                                                        <i class="fa-solid fa-info-circle me-2"></i> Ukuran Seragam
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="attachment_family_register" class="form-label">Kartu Keluarga</label>
                                            <input class="form-control" type="file" id="attachment_family_register"
                                                name="attachment_family_register">
                                            @errorFeedback('attachment_family_register')
                                            @if ($user->Student->attachment_family_register)
                                                <a href="{{ $user->Student->attachment_family_register }}" target="_blank">Lihat
                                                    Lampiran</a>
                                            @endif
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="attachment_birth_certificate" class="form-label">Akta Kelahiran</label>
                                            <input class="form-control" type="file" id="attachment_birth_certificate"
                                                name="attachment_birth_certificate">
                                            @errorFeedback('attachment_birth_certificate')
                                            @if ($user->Student->attachment_birth_certificate)
                                                <a href="{{ $user->Student->attachment_birth_certificate }}"
                                                    target="_blank">Lihat
                                                    Lampiran</a>
                                            @endif
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="attachment_diploma" class="form-label">Ijazah</label>
                                            <input class="form-control" type="file" id="attachment_diploma"
                                                name="attachment_diploma">
                                            @errorFeedback('attachment_diploma')
                                            @if ($user->Student->attachment_diploma)
                                                <a href="{{ $user->Student->attachment_diploma }}" target="_blank">Lihat
                                                    Lampiran</a>
                                            @endif
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="attachment_father_identity_card" class="form-label">KTP Ayah</label>
                                            <input class="form-control" type="file" id="attachment_father_identity_card"
                                                name="attachment_father_identity_card">
                                            @errorFeedback('attachment_father_identity_card')
                                            @if ($user->Student->attachment_father_identity_card)
                                                <a href="{{ $user->Student->attachment_father_identity_card }}"
                                                    target="_blank">Lihat
                                                    Lampiran</a>
                                            @endif
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="attachment_mother_identity_card" class="form-label">KTP Ibu</label>
                                            <input class="form-control" type="file" id="attachment_mother_identity_card"
                                                name="attachment_mother_identity_card">
                                            @errorFeedback('attachment_mother_identity_card')
                                            @if ($user->Student->attachment_mother_identity_card)
                                                <a href="{{ $user->Student->attachment_mother_identity_card }}"
                                                    target="_blank">Lihat
                                                    Lampiran</a>
                                            @endif
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="school_motivation" class="form-label">Motivasi Sekolah</label>
                                            <textarea class="form-control" id="school_motivation" placeholder="-" name="school_motivation">{{ $user->Student->school_motivation ?? '' }}</textarea>
                                            @errorFeedback('school_motivation')
                                        </div>
                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="address" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="address" placeholder="-" name="address">{{ $user->Student->address ?? '' }}</textarea>
                                            @errorFeedback('address')
                                        </div>

                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="sibling_info" class="form-label">Informasi Saudara</label>
                                            <textarea class="form-control" id="sibling_info" placeholder="-" name="sibling_info">{{ $user->Student->sibling_info ?? '' }}</textarea>
                                            @errorFeedback('sibling_info')
                                        </div>

                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="achievements" class="form-label">Prestasi</label>
                                            <textarea class="form-control" id="achievements" placeholder="-" name="achievements">{{ $user->Student->achievements ?? '' }}</textarea>
                                            @errorFeedback('achievements')
                                        </div>

                                        <div class="col-md-12 fv-plugins-icon-container">
                                            <label for="medical_history" class="form-label">Riwayat Kesehatan</label>
                                            <textarea class="form-control" id="medical_history" placeholder="-" name="medical_history">{{ $user->Student->medical_history ?? '' }}</textarea>
                                            @errorFeedback('medical_history')
                                        </div>
                                    </div>
                                    <div class="mt-6">
                                        <button type="submit" class="btn btn-primary me-3">Simpan Perubahan</button>
                                        <button type="reset" class="btn btn-label-secondary">Batalkan</button>
                                    </div>
                                </div>
                                <!-- /Account -->
                            </div>
                        </form>
                    @break

                    @default
                    @break

                @endswitch
            </div>
        </div>
        <!--/ User Profile Content -->
    </div>
    <!-- Modal untuk Crop Gambar -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header pb-4">
                    <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <img id="imagePreview">
                <div class="modal-footer pt-4">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="cropButton">Crop dan Upload</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="uniformSizeModal" tabindex="-1" aria-labelledby="uniformSizeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uniformSizeModalLabel">Ukuran Seragam</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('assets/img/uniform_size.jpg') }}" alt="Ukuran Seragam" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

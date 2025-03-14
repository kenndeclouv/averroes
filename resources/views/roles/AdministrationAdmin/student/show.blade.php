@extends('layouts.app')
@section('title', 'Detail Santri')

@section('content')
    @php
        $permissions = collect(Auth::user()->getPermissionCodes());
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"> <a href="{{ route('administrationadmin.student.index') }}">Data Santri</a>
                /</span>
            Detail Santri
        </h5>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Santri</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Username</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->User->username ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Lengkap</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->full_name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jurusan</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->major }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>NIS</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->nis }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>NISN</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->nisn }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Kelas</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->Classes->name ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Kamar</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->Room->name ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jenis Kelamin</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ getGender($student->gender) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Alamat</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->address ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Telepon</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->phone ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Email</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->User->email ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tanggal Lahir</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ formatDate($student->birth_date) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tempat Lahir</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->birth_place ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Riwayat Medis</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->medical_history ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Ayah</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->father_name ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Pekerjaan Ayah</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->father_occupation ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Penghasilan Ayah</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ indonesianCurrency($student->father_income) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama Ibu</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->mother_name ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Pekerjaan Ibu</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->mother_occupation ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Penghasilan Ibu</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ indonesianCurrency($student->mother_income) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Status Siswa</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->student_status ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Informasi Saudara</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->sibling_info ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Prestasi</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->achievements ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Juz yang dihafal</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->quran_memorization ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Ukuran Seragam</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $student->uniform_size ?? '-' }}
                    </div>
                </div>
                @if ($student->attachment_family_register)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>File KK</strong>
                        </div>
                        <div class="col-md-8">
                            : <a href="{{ $student->attachment_family_register }}" target="_blank">klik untuk melihat</a>
                        </div>
                    </div>
                @endif
                @if ($student->attachment_birth_certificate)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>File Akta kelahiran</strong>
                        </div>
                        <div class="col-md-8">
                            : <a href="{{ $student->attachment_birth_certificate }}" target="_blank">klik untuk melihat</a>
                        </div>
                    </div>
                @endif
                @if ($student->attachment_diploma)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>File Ijazah / SKL</strong>
                        </div>
                        <div class="col-md-8">
                            : <a href="{{ $student->attachment_diploma }}" target="_blank">klik untuk melihat</a>
                        </div>
                    </div>
                @endif
                @if ($student->attachment_father_identity_card)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>File KTP Ayah</strong>
                        </div>
                        <div class="col-md-8">
                            : <a href="{{ $student->attachment_father_identity_card }}" target="_blank">klik untuk
                                melihat</a>
                        </div>
                    </div>
                @endif
                @if ($student->attachment_mother_identity_card)
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <strong>File KTP Ibu</strong>
                        </div>
                        <div class="col-md-8">
                            : <a href="{{ $student->attachment_mother_identity_card }}" target="_blank">klik untuk
                                melihat</a>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('administrationadmin.student.index') }}" class="btn btn-secondary"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i
                                class="fa-solid fa-arrow-left"></i></a>
                        @if ($permissions->contains('edit_student'))
                            <a href="{{ route('administrationadmin.student.edit', $student->id) }}"
                                class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Edit Santri"><i class="fa-solid fa-edit"></i></a>
                        @endif
                        @if ($permissions->contains('delete_student'))
                            <x-delete :route="route('administrationadmin.student.destroy', $student->id)" :message="'Apakah kamu yakin ingin menghapus data santri ini?'" :title="'Hapus Santri'" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

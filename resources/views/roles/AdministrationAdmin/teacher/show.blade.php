@extends('layouts.app')
@section('title', 'Detail Pegawai')

@section('content')
    @php
        $permissions = collect(Auth::user()->getPermissionCodes());
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"> <a href="{{ route('administrationadmin.teacher.index') }}">Daftar Pegawai</a>
                /</span>
            Detail Pegawai
        </h5>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Pegawai</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Username</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->User->username }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Role</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->User->roles->pluck('name')->implode(', ') ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>NIP</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->nip ?? '-' }}
                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Kamar</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->Room->name ?? '-' }}
                    </div>
                </div> --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Pendidikan Terakhir</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->last_degree ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jenis Kelamin</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ getGender($teacher->gender) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Alamat</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->address ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Telepon</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->phone ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Email</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->User->email ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tanggal Lahir</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ formatDate($teacher->birth_date) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Tempat Lahir</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $teacher->birth_place ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Jabatan Fungsional</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ implode(', ', $teacher->functional_types) ?? '-' }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Amanah Mengajar</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ implode(', ', $teacher->teaching_mandatory_types) ?? '-' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('administrationadmin.teacher.index') }}" class="btn btn-secondary"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Kembali"><i
                                class="fa-solid fa-arrow-left"></i></a>
                        @if ($permissions->contains('edit_teacher'))
                            <a href="{{ route('administrationadmin.teacher.edit', $teacher->id) }}" class="btn btn-warning"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Pegawai"><i
                                    class="fa-solid fa-edit"></i></a>
                        @endif
                        @if ($permissions->contains('delete_teacher'))
                            <x-delete :route="route('administrationadmin.teacher.destroy', $teacher->id)" :message="'Apakah kamu yakin ingin menghapus data ustadz ini?'" :title="'Hapus Ustadz'" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

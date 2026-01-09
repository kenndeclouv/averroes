@extends('layouts.app')
@section('title', 'Detail Admin')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"><a href="{{ route('superadmin.admin.index') }}">Daftar Admin</a> / </span>
            Detail Admin
        </h5>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Admin</h5>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Nama</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $admin->name }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Username</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $admin->username }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Email</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $admin->email }}
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Role</strong>
                    </div>
                    <div class="col-md-8">
                        : {{ $admin->roles->pluck('name')->implode(', ') ?? '-' }}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-end">
                        <a href="{{ route('superadmin.admin.index') }}" class="btn btn-secondary" data-bs-toggle="tooltip"
                            data-bs-placement="top" title="Kembali"><i class="fa-solid fa-arrow-left"></i></a>
                        <a href="{{ route('superadmin.admin.edit', $admin->id) }}" class="btn btn-warning"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Admin"><i
                                class="fa-solid fa-edit"></i></a>
                        <x-delete :route="route('superadmin.admin.destroy', $admin->id)" :message="'Apakah kamu yakin ingin menghapus admin ini?'" :title="'Hapus Admin'" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

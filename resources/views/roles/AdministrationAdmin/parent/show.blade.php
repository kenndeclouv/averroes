@extends('layouts.app')
@section('title', 'Detail Walisantri')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data Walisantri /</span> Detail Walisantri</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Detail Walisantri</h5>
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->name }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->User->username ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->User->email ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->nik ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">No. HP</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->phone ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">:
                                    {{ $parent->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tempat, Tanggal Lahir</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->birth_place ?? '-' }},
                                    {{ $parent->birth_date ? \Carbon\Carbon::parse($parent->birth_date)->translatedFormat('d F Y') : '-' }}
                                </p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->address ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Pekerjaan</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">: {{ $parent->profession ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Penghasilan</label>
                            <div class="col-sm-10">
                                <p class="form-control-plaintext">:
                                    {{ $parent->income ? 'Rp ' . number_format($parent->income, 0, ',', '.') : '-' }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Santri</label>
                            <div class="col-sm-10">
                                <div class="form-control-plaintext d-flex gap-2">
                                    <span>:</span>
                                    @foreach ($parent->students as $student)
                                        <span class="badge bg-label-primary">{{ $student->name }}
                                            ({{ $student->nis }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('administrationadmin.parent.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

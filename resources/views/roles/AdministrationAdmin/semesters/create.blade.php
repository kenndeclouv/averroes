@extends('layouts.app')
@section('title', 'Tambah Semester')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header border-bottom">
                        <h5 class="card-title mb-0">Form Tambah Semester</h5>
                    </div>
                    <div class="card-body mt-3">
                        <form action="{{ route('administrationadmin.semesters.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="academic_year" class="form-label">Tahun Ajaran</label>
                                <input type="text" class="form-control" id="academic_year" name="academic_year"
                                    placeholder="Contoh: 2024/2025" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Tipe Semester</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="ganjil">Ganjil</option>
                                    <option value="genap">Genap</option>
                                </select>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                    value="1">
                                <label class="form-check-label" for="is_active">Set sebagai Semester Aktif</label>
                                <div class="form-text text-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Mengaktifkan semester ini akan menonaktifkan
                                    semester lainnya.
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('administrationadmin.semesters.index') }}"
                                    class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

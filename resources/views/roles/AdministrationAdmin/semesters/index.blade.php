@extends('layouts.app')
@section('title', 'Manajemen Semester')

@section('page-script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar Semester</h5>
                <a href="{{ route('administrationadmin.semesters.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Tambah Semester
                </a>
            </div>
            <div class="card-datatable table-responsive text-nowrap">
                <table class="table table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Tipe</th>
                            <th>Periode</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($semesters as $semester)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $semester->academic_year }}</td>
                                <td>{{ ucfirst($semester->type) }}</td>
                                <td>
                                    {{ $semester->start_date->format('d M Y') }} -
                                    {{ $semester->end_date->format('d M Y') }}
                                </td>
                                <td>
                                    @if ($semester->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('administrationadmin.semesters.edit', $semester->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('administrationadmin.semesters.destroy', $semester->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus semester ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

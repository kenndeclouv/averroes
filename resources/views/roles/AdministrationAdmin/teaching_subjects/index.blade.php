@extends('layouts.app')
@section('title', 'Daftar Mata Pelajaran')

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Mata Pelajaran</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('administrationadmin.teaching-subjects.create') }}" class="btn btn-primary mb-3"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Mata Pelajaran">Tambah Mata
                        Pelajaran</a>
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Slug</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subjects as $subject)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $subject->name }}</td>
                                <td>{{ $subject->slug }}</td>
                                <td>
                                    <a href="{{ route('administrationadmin.teaching-subjects.edit', $subject->id) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Mata Pelajaran"
                                        class="btn btn-warning"><i class="fa-solid fa-edit fs-6"></i></a>

                                    <x-delete :route="route('administrationadmin.teaching-subjects.destroy', $subject->id)" :message="'Apakah kamu yakin ingin menghapus Mata Pelajaran ini?'" :title="'Hapus Mata Pelajaran'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

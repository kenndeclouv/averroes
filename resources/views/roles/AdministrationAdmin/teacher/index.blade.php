@extends('layouts.app')
@section('title', 'Daftar Pegawai')

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
    @php
        $permissions = collect(Auth::user()->getPermissionCodes());
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Pegawai</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                <div class="d-flex justify-content-end">
                    @if ($permissions->contains('create_teacher'))
                        <a href="{{ route('administrationadmin.teacher.create') }}" class="btn btn-primary mb-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Pegawai">Tambah Pegawai</a>
                    @endif
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Jabatan Fungsional</th>
                            @if (
                                $permissions->contains('show_teacher') ||
                                    $permissions->contains('edit_teacher') ||
                                    $permissions->contains('delete_teacher'))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teachers as $teacher)
                            <tr>
                                <td>{{ $teacher->nip ?? "-" }}</td>
                                <td>{{ $teacher->name }}</td>
                                <td>{{ Str::limit(implode(', ', $teacher->functional_types), 50) }}</td>
                                @if (
                                    $permissions->contains('show_teacher') ||
                                        $permissions->contains('edit_teacher') ||
                                        $permissions->contains('delete_teacher'))
                                    <td>
                                        @if ($permissions->contains('show_teacher'))
                                            <a href="{{ route('administrationadmin.teacher.show', $teacher->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Pegawai"
                                                class="btn btn-info "><i class="fa-solid fa-eye fs-6"></i></a>
                                        @endif
                                        @if ($permissions->contains('edit_teacher'))
                                            <a href="{{ route('administrationadmin.teacher.edit', $teacher->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Pegawai"
                                                class="btn btn-warning "><i class="fa-solid fa-edit fs-6"></i></a>
                                        @endif
                                        @if ($permissions->contains('delete_teacher'))
                                            <x-delete :route="route('administrationadmin.teacher.destroy', $teacher->id)" :message="'Apakah kamu yakin ingin menghapus data Pegawai ini?'" :title="'Hapus Pegawai'" />
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

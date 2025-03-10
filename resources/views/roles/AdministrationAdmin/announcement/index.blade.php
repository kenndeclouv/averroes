@extends('layouts.app')
@section('title', 'Daftar Pengumuman')

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
                <h5 class="card-title">Daftar Pengumuman</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                @if ($permissions->contains('create_announcement'))
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('administrationadmin.announcement.create') }}" class="btn btn-primary mb-3"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah Pengumuman">Tambah Pengumuman</a>
                    </div>
                @endif
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Tujuan</th>
                            <th>Status</th>
                            @if ($permissions->contains('edit_announcement') || $permissions->contains('delete_announcement') || $permissions->contains('show_announcement'))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($announcements as $announcement)
                            <tr>
                                <td>{{ formatDate($announcement->date) }}</td>
                                <td>{{ $announcement->title }}</td>
                                <td>{{ $announcement->Target->name ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $announcement->status == 'active' ? 'success' : 'danger' }}">{{ getStatusLabel($announcement->status, 'activation') }}</span>
                                </td>
                                @if ($permissions->contains('edit_announcement') || $permissions->contains('delete_announcement') || $permissions->contains('show_announcement'))
                                    <td>
                                        <a href="{{ route('administrationadmin.announcement.show', $announcement->id) }}"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Pengumuman"
                                            class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                                        @if ($permissions->contains('edit_announcement'))
                                            <a href="{{ route('administrationadmin.announcement.edit', $announcement->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Pengumuman"
                                                class="btn btn-warning"><i class="fa-solid fa-edit"></i></a>
                                        @endif
                                        @if ($permissions->contains('delete_announcement'))
                                            <x-delete :route="route(
                                                'administrationadmin.announcement.destroy',
                                                $announcement->id,
                                            )" :message="'Apakah kamu yakin ingin menghapus pengumuman ini?'" :title="'Hapus Pengumuman'"></x-delete>
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

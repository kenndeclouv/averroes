@extends('layouts.app')
@section('title', 'Master NIP')

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

        function handleFormSubmit(event, form) {
            event.preventDefault();
            Swal.fire({
                title: "Apakah kamu yakin?",
                text: "Setelah dihapus, Kamu tidak akan dapat memulihkan data ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: 'var(--bs-primary)',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
                background: isDarkMode ? '#2b2c40' : '#fff',
                color: isDarkMode ? '#b2b2c4' : '#000',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
@endsection

@section('content')
    @php
        $permissions = collect(Auth::user()->getPermissionCodes());
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="avatar avatar-md mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-primary">
                                <i class="fa-solid fa-id-card fs-3"></i>
                            </span>
                        </div>
                        <span class="d-block mb-1 text-muted">NIP Terakhir</span>
                        <h3 class="card-title mb-2">{{ $lastNip ?? '-' }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="avatar avatar-md mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-success">
                                <i class="fa-solid fa-list-ol fs-3"></i>
                            </span>
                        </div>
                        <span class="d-block mb-1 text-muted">Format NIP</span>
                        <h3 class="card-title mb-2">{{ generateNIP() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2">
                <div class="card h-100">
                    <div class="card-body text-center">
                        <div class="avatar avatar-md mx-auto mb-3">
                            <span class="avatar-initial rounded-circle bg-warning">
                                <i class="fa-solid fa-gear fs-3"></i>
                            </span>
                        </div>
                        <span class="d-block mb-1 text-muted">Pengaturan NIP</span>
                        <button class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Pengaturan NIP">
                            <i class="fa-solid fa-gear me-2"></i>Atur NIP
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Master NIP</h5>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>nip</th>
                            <th>Nama</th>
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
                                <td>{{ $teacher->nip ?? '-' }}</td>
                                <td>{{ $teacher->name ?? '-' }}</td>
                                @if (
                                    $permissions->contains('show_teacher') ||
                                        $permissions->contains('edit_teacher') ||
                                        $permissions->contains('delete_teacher'))
                                    <td>
                                        @if ($permissions->contains('edit_teacher'))
                                            <!-- Button trigger modal -->
                                            @if ($teacher->nip == null)
                                            <div data-bs-toggle="tooltip" data-bs-placement="top" title="Tambah NIP Pegawai" class="d-inline">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nipModal{{ $teacher->id }}">
                                                    <i class="fa-solid fa-plus fs-6"></i>
                                                </button>
                                            </div>
                                            
                                            @else
                                            <div data-bs-toggle="tooltip" data-bs-placement="top" title="Edit NIP Pegawai" class="d-inline">
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#nipModal{{ $teacher->id }}">
                                                    <i class="fa-solid fa-edit fs-6"></i>
                                                </button>
                                            </div>
                                            @endif

                                            <!-- Modal -->
                                            <div class="modal fade" id="nipModal{{ $teacher->id }}" tabindex="-1" aria-labelledby="nipModalLabel{{ $teacher->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="nipModalLabel{{ $teacher->id }}">Tentukan NIP Pegawai {{ $teacher->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('administrationadmin.teacher.nip.update', $teacher->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nip" class="form-label">NIP</label>
                                                                    <input type="text" class="form-control" id="nip" name="nip" value="{{ $teacher->nip }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($permissions->contains('edit_teacher') && $teacher->nip != null)
                                            <x-delete :route="route('administrationadmin.teacher.nip.destroy', $teacher->id)" :message="'Apakah kamu yakin ingin menghapus NIP pegawai ini?'" :title="'Hapus NIP Pegawai'" />
                                        @endif
                                        @if ($permissions->contains('edit_teacher') && $teacher->nip == null)
                                            <div data-bs-toggle="tooltip" data-bs-placement="top" title="Generate NIP Pegawai" class="d-inline">
                                                <form action="{{ route('administrationadmin.teacher.nip.auto-generate', $teacher->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fa-solid fa-wand-magic-sparkles fs-6"></i>
                                                    </button>
                                                </form>
                                            </div>
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

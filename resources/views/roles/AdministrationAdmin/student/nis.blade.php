@extends('layouts.app')
@section('title', 'Master NIS')

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
                        <span class="d-block mb-1 text-muted">NIS Terakhir</span>
                        <h3 class="card-title mb-2">{{ $lastNis ?? '-' }}</h3>
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
                        <span class="d-block mb-1 text-muted">Format NIS</span>
                        <h3 class="card-title mb-2">{{ generateNIS() }}</h3>
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
                        <span class="d-block mb-1 text-muted">Pengaturan NIS</span>
                        <button class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Pengaturan NIS">
                            <i class="fa-solid fa-gear me-2"></i>Atur NIS
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Master NIS</h5>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>nis</th>
                            <th>Nama</th>
                            <th>NISN</th>
                            <th>Kelas</th>
                            @if (
                                $permissions->contains('show_student') ||
                                    $permissions->contains('edit_student') ||
                                    $permissions->contains('delete_student'))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{ $student->nis ?? '-' }}</td>
                                <td>{{ $student->name ?? '-' }}</td>
                                <td>{{ $student->nisn ?? '-' }}</td>
                                <td>{{ $student->Classes->name ?? '-' }}</td>
                                @if (
                                    $permissions->contains('show_student') ||
                                        $permissions->contains('edit_student') ||
                                        $permissions->contains('delete_student'))
                                    <td>
                                        @if ($permissions->contains('edit_student'))
                                            <!-- Button trigger modal -->
                                            <div data-bs-toggle="tooltip" data-bs-placement="top" title="Edit NIS Santri" class="d-inline">
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nisModal{{ $student->id }}">
                                                    <i class="fa-solid fa-edit fs-6"></i>
                                                </button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="nisModal{{ $student->id }}" tabindex="-1" aria-labelledby="nisModalLabel{{ $student->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="nisModalLabel{{ $student->id }}">Tentukan NIS Santri {{ $student->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('administrationadmin.student.nis.update', $student->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nis" class="form-label">NIS</label>
                                                                    <input type="text" class="form-control" id="nis" name="nis" value="{{ $student->nis }}" required>
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
                                        @if ($permissions->contains('edit_student'))
                                            <x-delete :route="route('administrationadmin.student.nis.destroy', $student->id)" :message="'Apakah kamu yakin ingin menghapus NIS santri ini?'" :title="'Hapus NIS Santri'" />
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

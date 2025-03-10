@extends('layouts.app')
@section('title', 'Data Santri')

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
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">List Pendaftar</h5>
            </div>
            <div class="card-body pb-0 pt-4">
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Santri</th>
                            <th>No Whatsapp</th>
                            <th>Tanggal mendaftar</th>
                            <th>Status</th>
                            @if (
                                $permissions->contains('show_student_registrant') ||
                                    $permissions->contains('edit_student_registrant') ||
                                    $permissions->contains('delete_student_registrant'))
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentRegistrants as $studentRegistrant)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $studentRegistrant->User->name }}</td>
                                <td>{{ $studentRegistrant->parent_whatsapp }}</td>
                                <td>{{ formatDate($studentRegistrant->created_at, 'd F Y') }}</td>
                                <td><span
                                        class="badge bg-{{ $studentRegistrant->status == 'approved' ? 'success' : ($studentRegistrant->status == 'pending' ? 'warning' : 'danger') }}">{{ getStatusLabel($studentRegistrant->status, 'approval') }}</span>
                                </td>
                                @if (
                                    $permissions->contains('show_student_registrant') ||
                                        $permissions->contains('edit_student_registrant') ||
                                        $permissions->contains('delete_student_registrant'))
                                    <td>
                                        @if ($permissions->contains('show_student_registrant'))
                                            <a href="{{ route('administrationadmin.studentregistrant.show', $studentRegistrant->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Calon Santri"
                                                class="btn btn-info "><i class="fa-solid fa-eye fs-6"></i></a>
                                        @endif
                                        @if ($permissions->contains('edit_student_registrant') && $studentRegistrant->status === 'pending')
                                            <form
                                                action="{{ route('administrationadmin.studentregistrant.approve', $studentRegistrant->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Terima Calon Santri">
                                                    <i class="fa-solid fa-check fs-6"></i>
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('administrationadmin.studentregistrant.reject', $studentRegistrant->id) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="Tolak Calon Santri">
                                                    <i class="fa-solid fa-times fs-6"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($permissions->contains('delete_student_registrant'))
                                            <x-delete :route="route(
                                                'administrationadmin.studentregistrant.destroy',
                                                $studentRegistrant->id,
                                            )" :message="'Apakah kamu yakin ingin menghapus data calon santri ini?'" :title="'Hapus Data Calon Santri'" />
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

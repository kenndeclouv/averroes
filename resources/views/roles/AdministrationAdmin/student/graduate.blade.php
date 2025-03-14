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
                <h5 class="card-title">Santri Lulus</h5>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>NISN</th>
                            {{-- <th>Kelas</th> --}}
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
                                {{-- <td>{{ $student->Class->name ?? '-' }}</td> --}}
                                @if (
                                    $permissions->contains('show_student') ||
                                        $permissions->contains('edit_student') ||
                                        $permissions->contains('delete_student'))
                                    <td>
                                        @if ($permissions->contains('show_student'))
                                            <a href="{{ route('administrationadmin.student.show', $student->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Santri"
                                                class="btn btn-info "><i class="fa-solid fa-eye fs-6"></i></a>
                                        @endif
                                        @if ($permissions->contains('edit_student'))
                                            <a href="{{ route('administrationadmin.student.edit', $student->id) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Santri"
                                                class="btn btn-warning "><i class="fa-solid fa-edit fs-6"></i></a>
                                            <form
                                                action="{{ route('administrationadmin.student.graduate.undo-graduate', $student->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Batalkan Lulus" class="btn btn-danger">
                                                    <i class="fa-solid fa-graduation-cap fs-6"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if ($permissions->contains('delete_student'))
                                            <x-delete :route="route('administrationadmin.student.destroy', $student->id)" :message="'Apakah kamu yakin ingin menghapus data santri ini?'" :title="'Hapus Santri'" />
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

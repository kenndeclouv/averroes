@extends('layouts.app')
@section('title', 'Data Walisantri')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Administrasi Admin /</span> Data Walisantri</h4>

        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between">
                <h5 class="card-title">Data Walisantri</h5>

                <a href="{{ route('administrationadmin.parent.create') }}" class="btn btn-primary">Tambah
                    Walisantri</a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Santri</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($parents as $parent)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $parent->name }}</td>
                                    <td>{{ $parent->User->username ?? '-' }}</td>
                                    <td>{{ $parent->User->email ?? '-' }}</td>
                                    <td>
                                        @foreach ($parent->students as $student)
                                            <span class="badge bg-label-primary">{{ $student->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <a href="{{ route('administrationadmin.parent.show', $parent->id) }}"
                                                data-bs-toggle="tooltip" title="Lihat Data" class="btn btn-info"><i
                                                    class="fa-solid fa-eye"></i></a>
                                            <a href="{{ route('administrationadmin.parent.edit', $parent->id) }}"
                                                data-bs-toggle="tooltip" title="Ubah Data" class="btn btn-warning"><i
                                                    class="fa-solid fa-pencil"></i></a>

                                            <x-delete :route="route('administrationadmin.parent.destroy', $parent->id)" :title="'Hapus Pola Ruang'" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('#table').DataTable();
        });
    </script>
@endsection

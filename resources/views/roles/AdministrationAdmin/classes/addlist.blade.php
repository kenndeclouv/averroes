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
            $('#check-all').click(function() {
                if ($(this).is(':checked')) {
                    $('input[type="checkbox"]').prop('checked', true);
                } else {
                    $('input[type="checkbox"]').prop('checked', false);
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"><a href="{{ route('administrationadmin.class.index') }}">Daftar Kelas</a> / <a
                    href="{{ route('administrationadmin.class.list', $class->id) }}">Kelas {{ $class->name }}</a> / </span>
            Tambah Santri
        </h5>
        <form action="{{ route('administrationadmin.class.add-student-to-class', $class->id) }}" method="post">
            @csrf
            <div class="card">
                <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Data Santri</h5>
                </div>
                <div class="card-body pb-0 pt-4">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">Tambahkan Santri ke Kelas
                            {{ $class->name }}</button>
                    </div>
                </div>
                <div class="card-datatable table-responsive text-start text-nowrap">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>NISN</th>
                                <th><input type="checkbox" id="check-all" class="form-check-input"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($students as $student)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->nisn }}</td>
                                    <td>
                                        <input type="checkbox" name="student_id[]" class="form-check-input"
                                            value="{{ $student->id }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Jurnal Mengajar')

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
        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Jurnal Mengajar</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                <a href="{{ route('administrationadmin.journals.create') }}" class="btn btn-primary mb-3">
                    Tambah Jurnal
                </a>

            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Guru</th>
                            <th>Subjek</th>
                            <th>JP Reguler</th>
                            <th>JP Badal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journals as $journal)
                            <tr>
                                <td>{{ formatDate($journal->date) }}</td>
                                <td>{{ $journal->teacher->name }}</td>
                                <td>
                                    @php
                                        $subjects = is_array(json_decode($journal->subjects))
                                            ? json_decode($journal->subjects)
                                            : [$journal->subjects];
                                    @endphp
                                    @foreach ($subjects as $subject)
                                        <span class="badge bg-primary">{{ $subject }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $journal->total_regular_hours }}</td>
                                <td>{{ $journal->total_replacement_hours }}</td>
                                <td>
                                    <a href="{{ route('administrationadmin.journals.show', $journal) }}"
                                        class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('administrationadmin.journals.edit', $journal) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <x-delete :route="route('administrationadmin.journals.destroy', $journal->id)" :message="'Apakah kamu yakin ingin menghapus data ini?'" :title="'Hapus Jurnal'" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

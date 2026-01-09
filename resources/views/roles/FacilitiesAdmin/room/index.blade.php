@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Ruangan</h5>
                <a href="{{ route('facilitiesadmin.rooms.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Ruangan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover datatable" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
                                <th>Jumlah Barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($rooms as $index => $room)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $room->code }}</td>
                                    <td>{{ $room->name }}</td>
                                    <td>
                                        <span class="badge bg-label-info">{{ $room->inventories_count }} Item</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('facilitiesadmin.rooms.show', $room->id) }}" class="btn btn-info"
                                            data-bs-toggle="tooltip"
                                            title="Lihat Ruangan">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('facilitiesadmin.rooms.edit', $room->id) }}"
                                            class="btn btn-warning"
                                            data-bs-toggle="tooltip"
                                            title="Edit Ruangan">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <x-delete :route="route('facilitiesadmin.rooms.destroy', $room->id)" :title="'Hapus Ruangan'" />
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                },
                dom: '<"card-header flex-column justify-content-start flex-md-row pb-0"<"head-label text-center"><"dt-action-buttons text-start pt-6 pt-md-0"B>>' +
                    '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t' +
                    '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    extend: "collection",
                    className: "btn btn-label-primary dropdown-toggle",
                    text: '<i class="fas fa-file-export me-sm-2"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                            extend: "print",
                            text: '<i class="fas fa-print me-1"></i>Print',
                            className: "dropdown-item",
                            title: "Daftar Ruangan",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            title: "Daftar Ruangan",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        }
                    ]
                }]
            });
            $('.select2').select2();
        });
    </script>
@endsection

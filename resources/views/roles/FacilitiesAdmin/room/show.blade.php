@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Ruangan /</span> Detail Ruangan</h4>

        <div class="card mb-4">
            <h5 class="card-header">Detail Ruangan: {{ $room->name }} ({{ $room->code }})</h5>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Kode Ruangan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $room->code }}" readonly />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-company">Nama Ruangan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $room->name }}" readonly />
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <h5 class="card-header">Daftar Inventaris di Ruangan Ini</h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover datatable" id="table">
                        <thead>
                            <tr>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Kondisi</th>
                                <th>Jumlah</th>
                                <th>Lokasi Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($room->Inventories as $item)
                                <tr>
                                    <td>{{ $item->item_code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->condition == 'Good' ? 'success' : ($item->condition == 'Damaged' ? 'warning' : 'danger') }} me-1">
                                            {{ $item->condition }}
                                        </span>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->location ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('facilitiesadmin.rooms.index') }}" class="btn btn-secondary">Kembali</a>
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
                    extend: "print",
                    text: '<i class="fas fa-print me-1"></i>Print',
                    className: "btn btn-secondary",
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }]
            });
            $('.select2').select2();
        });
    </script>
@endsection

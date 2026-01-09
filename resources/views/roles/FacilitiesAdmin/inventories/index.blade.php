@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Inventory List</h5>
                <div>
                    <a href="{{ route('facilitiesadmin.inventories.print') }}" target="_blank" class="btn btn-secondary me-2">
                        <i class="fas fa-print"></i> Print Report
                    </a>
                    <a href="{{ route('facilitiesadmin.inventories.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Item
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('facilitiesadmin.inventories.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="Search by name, code, or location..." value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                        @if (request('search'))
                            <a href="{{ route('facilitiesadmin.inventories.index') }}"
                                class="btn btn-outline-danger">Reset</a>
                        @endif
                    </div>
                </form>

                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" id="table">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Condition</th>
                                <th>Quantity</th>
                                <th>Location</th>
                                <th>Purchase Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($inventories as $item)
                                <tr>
                                    <td><strong>{{ $item->item_code }}</strong></td>
                                    <td>{{ $item->name }}</td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $item->condition == 'Good' ? 'success' : ($item->condition == 'Damaged' ? 'warning' : 'danger') }} me-1">
                                            {{ $item->condition }}
                                        </span>
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        {{ $item->room->name ?? 'Belum ada ruangan' }}
                                        @if ($item->location)
                                            <br><small class="text-muted">({{ $item->location }})</small>
                                        @endif
                                    </td>
                                    <td>{{ $item->purchase_date->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('facilitiesadmin.inventories.edit', $item) }}"
                                            class="btn btn-warning"
                                            data-bs-toggle="tooltip"
                                            title="Edit Pola Ruang">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <x-delete :route="route('facilitiesadmin.inventories.destroy', $item->id)" :title="'Hapus Pola Ruang'" />

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $inventories->appends(request()->all())->links() }}
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
                            title: "Daftar Inventaris",
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            title: "Daftar Inventaris",
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

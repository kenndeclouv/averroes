@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            const date = new URLSearchParams(window.location.search).get('month') ?
                moment(new URLSearchParams(window.location.search).get('month')).format('MMMM YYYY') :
                moment().locale('id').format('MMMM YYYY');

            $('#transactionTable').DataTable({
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
                            title: "Transaksi Bulan " + date,
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            extend: "excelHtml5",
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            title: "Transaksi Bulan " + date,
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        }
                    ]
                }]
            });
        });
    </script>
@endsection


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Transaksi</h5>
                {{-- <div>
                    <span class="fw-semibold">Saldo:</span>
                    @php
                        $saldoValue = isset($saldo) ? $saldo : 0;
                        if ($saldoValue < 0) {
                            $badgeClass = 'bg-danger';
                        } elseif ($saldoValue < 500000) {
                            $badgeClass = 'bg-warning text-dark';
                        } else {
                            $badgeClass = 'bg-success';
                        }
                    @endphp
                    <span class="badge {{ $badgeClass }} fs-5 align-middle">
                        {{ isset($saldo) ? indonesianCurrency($saldo) : 'Rp 0' }}
                    </span>
                </div> --}}
            </div>
            <div class="card-body pb-0 pt-4">
                <div class="d-flex justify-content-between align-items-center">
                    <form method="GET" class="d-flex align-items-center"
                        action="{{ route('administrationadmin.transaction.index') }}">
                        <label for="month" class="me-2 mb-0">Bulan:</label>
                        <input type="month" id="month" name="month" class="form-control me-2"
                            value="{{ $monthYear ?? now()->format('Y-m') }}" onchange="this.form.submit()">
                    </form>
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="transactionTable">
                    <thead>
                        <tr>
                            <th>Nomor Nota</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->nota_number ?? '-' }}</td>
                                <td>{{ formatDate($transaction->date) }}</td>
                                <td>{{ $transaction->description ?? '-' }}</td>
                                <td>{{ $transaction->Category ? $transaction->Category->name : '-' }}</td>
                                <td>{{ $transaction->debit ? indonesianCurrency($transaction->debit) : '-' }}</td>
                                <td>{{ $transaction->credit ? indonesianCurrency($transaction->credit) : '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>
                                {{ isset($transactions) ? indonesianCurrency($transactions->sum('debit')) : 'Rp 0' }}
                            </th>
                            <th>
                                {{ isset($transactions) ? indonesianCurrency($transactions->sum('credit')) : 'Rp 0' }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kategori</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fa fa-plus"></i> Tambah Kategori
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0" id="categoryTable">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr>
                                        <td>{{ $category->name }}</td>
                                        <td class="d-flex gap-2">
                                            <button id="edit-category-button-{{ $category->id }}" class="btn btn-warning"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Kategori"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Belum ada kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // No DataTable or category scripts needed for show page
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom">
                <h5 class="card-title mb-0">Detail Transaksi</h5>

            </div>
            <div class="card-body">
                <dl class="row mt-4">
                    <dt class="col-sm-3">Nomor Nota</dt>
                    <dd class="col-sm-9">: {{ $transaction->nota_number ?? '-' }}</dd>

                    <dt class="col-sm-3">Kategori</dt>
                    <dd class="col-sm-9">: {{ $transaction->Category ? $transaction->Category->name : '-' }}</dd>

                    <dt class="col-sm-3">Tanggal</dt>
                    <dd class="col-sm-9">: {{ formatDate($transaction->date) }}</dd>

                    <dt class="col-sm-3">Deskripsi</dt>
                    <dd class="col-sm-9">: {{ $transaction->description ?? '-' }}</dd>

                    <dt class="col-sm-3">Debit</dt>
                    <dd class="col-sm-9">: {{ $transaction->debit ? indonesianCurrency($transaction->debit) : '-' }}</dd>

                    <dt class="col-sm-3">Kredit</dt>
                    <dd class="col-sm-9">: {{ $transaction->credit ? indonesianCurrency($transaction->credit) : '-' }}</dd>

                    <dt class="col-sm-3">Lampiran</dt>
                    <dd class="col-sm-9">:
                        @if ($transaction->attachment)
                            <a href="{{ asset('storage/' . $transaction->attachment) }}" target="_blank">Lihat
                                Lampiran</a>
                        @else
                            -
                        @endif
                    </dd>
                </dl>
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('treasurer.transaction.index') }}" class="btn btn-secondary" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Kembali ke Daftar">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <a href="{{ route('treasurer.transaction.edit', $transaction->id) }}" class="btn btn-warning"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <x-delete :route="route('treasurer.transaction.destroy', $transaction->id)" :message="'Apakah kamu yakin ingin menghapus transaksi ini?'" :title="'Hapus Transaksi'"></x-delete>
                </div>
            </div>
        </div>
    </div>
@endsection

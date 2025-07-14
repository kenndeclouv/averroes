@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('page-script')
    <script>
        function initSelect2() {
            $('.select2').select2({
                dropdownParent: $('#transaction-rows')
            });
        }

        // Fungsi untuk menambah baris transaksi baru
        function addTransactionRow() {
            let index = $('.transaction-row').length;
            let row = `
                <div class="transaction-row border rounded p-3 mb-3 position-relative" style="background-color: #f8f9fa;">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-2 remove-transaction-row" aria-label="Close"></button>
                    <div class="mb-3">
                        <label class="form-label">Kategori <small class="text-muted">*opsional</small></label>
                        <select class="form-select select2" name="transactions[${index}][category_id]">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor nota</label>
                        <input type="text" class="form-control" name="transactions[${index}][nota_number]" value="" placeholder="KK01">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="transactions[${index}][description]" value="" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Debit (Pemasukan)</label>
                        <input type="number" min="0" class="form-control" name="transactions[${index}][debit]" value="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kredit (Pengeluaran)</label>
                        <input type="number" min="0" class="form-control" name="transactions[${index}][credit]" value="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Attachment <small class="text-muted">*opsional</small></label>
                        <input type="file" class="form-control" name="transactions[${index}][attachment]">
                    </div>
                </div>
            `;
            $('#transaction-rows').append(row);
            initSelect2();
        }

        $(document).ready(function() {
            initSelect2();

            if ($('.transaction-row').length === 0) {
                addTransactionRow();
            }

            $('#add-transaction-row').on('click', function(e) {
                e.preventDefault();
                addTransactionRow();
            });

            $(document).on('click', '.remove-transaction-row', function() {
                $(this).closest('.transaction-row').remove();

                $('.transaction-row').each(function(i, el) {
                    $(el).find('select, input').each(function() {
                        let name = $(this).attr('name');
                        name = name.replace(/transactions\[\d+\]/, `transactions[${i}]`);
                        $(this).attr('name', name);
                    });
                });
            });
        });
    </script>
@endsection

@section('content')
    <form action="{{ route('treasurer.transaction.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">
                    <a href="{{ route('treasurer.transaction.index') }}">Daftar Transaksi</a> /
                </span>
                Tambah Transaksi
            </h5>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Transaksi</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="date">Tanggal</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror"
                                    id="date" name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @errorFeedback('date')
                            </div>

                            <div id="transaction-rows">
                                {{-- Baris transaksi akan ditambahkan di sini oleh JS --}}
                                @if (old('transactions'))
                                    @foreach (old('transactions') as $i => $trx)
                                        <div class="transaction-row border rounded p-3 mb-3 position-relative"
                                            style="background-color: #f8f9fa;">
                                            <button type="button"
                                                class="btn-close position-absolute top-0 end-0 m-2 remove-transaction-row"
                                                aria-label="Close"></button>

                                            <div class="mb-3">
                                                <label class="form-label">Kategori <small class="text-muted">*opsional</small></label>
                                                <select
                                                    class="form-select select2 @error('transactions.{{ $i }}.category_id') is-invalid @enderror"
                                                    name="transactions[{{ $i }}][category_id]">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}"
                                                            {{ old('transactions.' . $i . '.category_id') == $category->id ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @errorFeedback('transactions.' . $i . '.category_id')
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Nomor Nota</label>
                                                <input type="text" class="form-control"
                                                    name="transactions[{{ $i }}][nota_number]"
                                                    value="{{ $trx['nota_number'] ?? '' }}" >
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <input type="text" class="form-control"
                                                    name="transactions[{{ $i }}][description]"
                                                    value="{{ $trx['description'] ?? '' }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Debit (Pemasukan)</label>
                                                <input type="number" min="0" class="form-control"
                                                    name="transactions[{{ $i }}][debit]"
                                                    value="{{ $trx['debit'] ?? '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Kredit (Pengeluaran)</label>
                                                <input type="number" min="0" class="form-control"
                                                    name="transactions[{{ $i }}][credit]"
                                                    value="{{ $trx['credit'] ?? '' }}">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Attachment <small class="text-muted">*opsional</small></label>
                                                <input type="file" class="form-control"
                                                    name="transactions[{{ $i }}][attachment]">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <button type="button" class="btn btn-outline-primary mb-3" id="add-transaction-row">
                                <i class="fa fa-plus"></i> Tambah Baris Transaksi
                            </button>
                            <br>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

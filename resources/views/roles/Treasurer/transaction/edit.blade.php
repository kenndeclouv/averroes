@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('page-script')
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Optional: Add any additional JS for edit page here
        });
    </script>
@endsection

@section('content')
    <form action="{{ route('treasurer.transaction.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light">
                    <a href="{{ route('treasurer.transaction.index') }}">Daftar Transaksi</a> /
                </span>
                Edit Transaksi
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
                                    id="date" name="date"
                                    value="{{ old('date', $transaction->date ? formatDate($transaction->date, 'Y-m-d') : date('Y-m-d')) }}"
                                    required>
                                @errorFeedback('date')
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select class="form-select select2 @error('category_id') is-invalid @enderror"
                                    name="category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $transaction->transaction_category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @errorFeedback('category_id')
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <input type="text" class="form-control @error('description') is-invalid @enderror"
                                    name="description" value="{{ old('description', $transaction->description) }}" required>
                                @errorFeedback('description')
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Debit (Pemasukan)</label>
                                <input type="number" min="0"
                                    class="form-control @error('debit') is-invalid @enderror" name="debit"
                                    value="{{ old('debit', $transaction->debit) }}">
                                @errorFeedback('debit')
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kredit (Pengeluaran)</label>
                                <input type="number" min="0"
                                    class="form-control @error('credit') is-invalid @enderror" name="credit"
                                    value="{{ old('credit', $transaction->credit) }}">
                                @errorFeedback('credit')
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Attachment (Opsional)</label>
                                @if ($transaction->attachment)
                                    <div class="mb-2">
                                        <a href="{{ asset('storage/' . $transaction->attachment) }}" target="_blank">Lihat
                                            Lampiran Saat Ini</a>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('attachment') is-invalid @enderror"
                                    name="attachment">
                                @errorFeedback('attachment')
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('treasurer.transaction.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

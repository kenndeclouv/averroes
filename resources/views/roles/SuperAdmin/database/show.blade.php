@extends('layouts.app')
@section('title', 'Tabel ' . $table)

@section('page-script')
    <script src="https://cdn.datatables.net/2.1.8/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            $('.select2-modal').select2({
                dropdownParent: $('#addDataModal'),
            });
            const table = $('#dataTable').DataTable({
                language: {
                    url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"
                }
            });

            function enableSelect2(selectElement) {
                // hapus readonly, destroy instance select2, lalu buat ulang
                $(selectElement).removeAttr('readonly');
                $(selectElement).select2('destroy'); // hapus instance lama
                $(selectElement).select2(); // buat ulang select2
                $(selectElement).removeClass('select2-readonly');
                console.log('select2 enabled');
            }

            function disableSelect2(selectElement) {
                // tambahkan readonly, destroy instance select2, lalu buat ulang
                $(selectElement).attr('readonly', true);
                $(selectElement).select2('destroy'); // hapus instance lama
                $(selectElement).select2(); // buat ulang select2
                $(selectElement).addClass('select2-readonly');
                console.log('select2 disabled');
            }


            // Tombol simpan
            $('.save-row').click(function() {
                const row = $(this).closest('tr');
                const inputs = row.find('input');
                const selects = row.find('select');
                const data = {};
                inputs.each(function() {
                    const columnName = $(this).data('column');
                    if (columnName && columnName !== 'id') {
                        data[columnName] = $(this).val();
                    }
                });
                selects.each(function() {
                    const columnName = $(this).data('column');
                    if (columnName && columnName !== 'id') {
                        data[columnName] = $(this).val();
                    }
                });
                const id = row.data('id');
                const tableName = '{{ $table }}';
                const csrfToken = $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}';
                const isDarkMode = document.documentElement.getAttribute('data-style') === 'dark';

                $.ajax({
                    url: `/superadmin/database/update/${tableName}/${id}`,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        _token: csrfToken,
                        _method: 'PUT',
                        data: data
                    },
                    success: function(response) {
                        swal.fire({
                            title: 'Berhasil',
                            text: response.message,
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,
                            background: isDarkMode ? '#2b2c40' : '#fff',
                            color: isDarkMode ? '#b2b2c4' : '#000',
                        });
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : (xhr.responseText || 'Terjadi kesalahan sistem');
                        alert('Terjadi kesalahan: ' + errorMsg);
                    }
                });
            });
        });
    </script>
@endsection

@section('page-style')
    <style>
        #dataTable input:read-only,
        #dataTable select:read-only,
        .select2-readonly+.select2-container
        {
            background-color: var(--bs-secondary-bg);
            opacity: 0.5
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data tabel {{ $table }}</h5>
            </div>
            <div class="card-body pt-4">
                @if (isset($noData) && $noData)
                    <div class="alert alert-warning">Tidak ada data</div>
                @endif
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">Tambah Data</button>

                <!-- Modal -->
                <div class="modal fade" id="addDataModal" tabindex="-1" aria-labelledby="addDataModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form id="addDataForm" method="POST" enctype="multipart/form-data"
                                action="{{ route('superadmin.database.store', ['tableName' => $table]) }}">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addDataModalLabel">Tambah Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @foreach ($columns as $column => $attributes)
                                        @if ($column === 'id' || $column === 'created_at' || $column === 'updated_at')
                                            @continue
                                        @endif
                                        @php
                                            $columnType = $attributes['type'] ?? 'string';
                                            $enumOptions = $attributes['enum'] ?? [];
                                        @endphp

                                        <div class="mb-3">
                                            <label for="{{ $column }}"
                                                class="form-label">{{ ucfirst($column) }}</label>
                                            @if (array_key_exists($column, $foreignData))
                                                <select class="form-select select2-modal" name="{{ $column }}"
                                                    id="{{ $column }}">
                                                    @foreach ($foreignData[$column] as $relation)
                                                        <option value="{{ $relation->id }}">{{ $relation->name }}</option>
                                                    @endforeach
                                                </select>
                                            @elseif ($attributes['type'] === 'enum')
                                                <select class="form-select select2-modal" name="{{ $column }}"
                                                    id="{{ $column }}">
                                                    @foreach ($enumOptions as $option)
                                                        <option value="{{ $option }}">{{ ucfirst($option) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @elseif ($attributes['type'] === 'boolean')
                                                <select class="form-select select2-modal"
                                                    name="{{ $column }}" id="{{ $column }}">
                                                    <option value="1">Ya</option>
                                                    <option value="0">Tidak
                                                    </option>
                                                </select>
                                            @else
                                                <input type="{{ $columnType }}" class="form-control"
                                                    name="{{ $column }}" id="{{ $column }}">
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive text-start">
                <table class="table table-bordered mt-4" id="dataTable">
                    <thead>
                        <tr>
                            @foreach ($columns as $column => $attributes)
                                <th>{{ ucfirst($column) }}</th>
                            @endforeach
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($noData) && $noData)
                            <tr>
                                @foreach ($columns as $column)
                                    <td>-</td>
                                @endforeach
                                <td>-</td>
                            </tr>
                        @else
                            @foreach ($data as $row)
                                <tr data-id="{{ $row->id }}">
                                    @foreach ($row as $key => $value)
                                        <td>
                                            @php
                                                // pastikan $columns memiliki informasi tipe kolom
                                                $columnType = $columns[$key]['type'] ?? 'string'; // default ke 'string' jika tipe tidak ditemukan
                                                $enumOptions = $columns[$key]['enum'] ?? []; // ambil enum jika ada
                                                $foreignOptions = $foreignData[$key] ?? null; // ambil data foreign jika ada
                                            @endphp

                                            {{-- foreign key --}}
                                            @if ($foreignOptions)
                                                <select class="form-select select2 select2-readonly"
                                                    data-column="{{ $key }}" readonly
                                                    onclick="enableSelect2(this);" onfocusout="disableSelect2(this);">
                                                    @foreach ($foreignOptions as $option)
                                                        <option value="{{ $option->id }}"
                                                            {{ $value == $option->id ? 'selected' : '' }}>
                                                            {{ $option->id }} - {{ $option->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                {{-- tipe enum --}}
                                            @elseif ($columnType === 'enum')
                                                <select class="form-select select2 select2-readonly"
                                                    data-column="{{ $key }}" readonly
                                                    onclick="enableSelect2(this);" onfocusout="disableSelect2(this);">
                                                    @foreach ($enumOptions as $option)
                                                        <option value="{{ $option }}"
                                                            {{ $value === $option ? 'selected' : '' }}>
                                                            {{ ucfirst($option) }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                {{-- tipe boolean --}}
                                            @elseif ($columnType === 'boolean')
                                                <select class="form-select select2 select2-readonly"
                                                    data-column="{{ $key }}" readonly
                                                    ondblclick="this.removeAttribute('readonly'); this.classList.remove('form-select-readonly');"
                                                    onfocusout="this.setAttribute('readonly', true); this.classList.add('form-select-readonly');">
                                                    <option value="1" {{ $value == 1 ? 'selected' : '' }}>Ya</option>
                                                    <option value="0" {{ $value == 0 ? 'selected' : '' }}>Tidak
                                                    </option>
                                                </select>

                                                {{-- tipe default (text/number) --}}
                                            @else
                                                <input type="{{ $columnType }}" class="form-control"
                                                    style="width: max-content;" value="{{ $value }}"
                                                    @if ($key == 'id') data-column="id" disabled @else data-column="{{ $key }}" readonly ondblclick="this.readOnly = false;" onfocusout="this.readOnly = true;" @endif>
                                            @endif
                                        </td>
                                    @endforeach

                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-success save-row" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Simpan"><i
                                                    class="fa-solid fa-check"></i></button>
                                            <x-delete :route="route('superadmin.database.destroy', [
                                                'tableName' => $table,
                                                'id' => $row->id,
                                            ])" title="Hapus data" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

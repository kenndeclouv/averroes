@extends('layouts.app')

@section('title', 'ENV')

@section('page-script')
    <script>
        $('.select2').select2();
    </script>
    <script>
        $(document).ready(function() {
            $('#updateButton').click(function(e) {
                e.preventDefault();

                var form = $(this).closest('form');

                swal.fire({
                    title: 'Apakah anda yakin?',
                    text: 'Data yang telah diubah tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'var(--bs-primary)',
                    cancelButtonColor: 'var(--bs-danger)',
                    confirmButtonText: 'Iya, Update!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        swal.fire({
                            title: 'Masukkan Password',
                            input: 'password',
                            inputAttributes: {
                                autocapitalize: 'off',
                                name: 'password'
                            },
                            inputPlaceholder: 'Masukkan password Anda',
                            showCancelButton: true,
                            confirmButtonText: 'Update',
                            cancelButtonText: 'Batal',
                            preConfirm: (password) => {
                                if (!password) {
                                    Swal.showValidationMessage(
                                        'Password tidak boleh kosong');
                                }
                                return password;
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                let formData = form.serialize();
                                formData += '&password=' + encodeURIComponent(result.value);

                                $.ajax({
                                    url: form.attr('action'),
                                    method: 'POST',
                                    data: formData,
                                    success: function(response) {
                                        swal.fire({
                                            title: 'Berhasil!',
                                            text: 'Data berhasil diubah.',
                                            icon: 'success',
                                            timer: 2000
                                        }).then(() => {
                                            location.reload();
                                        });
                                    },
                                    error: function(xhr) {
                                        let errorMessage = 'Terjadi kesalahan!';
                                        if (xhr.responseJSON && xhr.responseJSON.message) {
                                            errorMessage = xhr.responseJSON.message;
                                        }
                                        swal.fire({
                                            title: 'Gagal!',
                                            text: errorMessage,
                                            icon: 'error',
                                            showConfirmButton: true
                                        });
                                    }
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $('#addButton').click(function() {
            Swal.fire({
                title: 'Input New Key',
                input: 'text',
                inputLabel: 'New Key',
                inputPlaceholder: 'Enter new key',
                showCancelButton: true,
                confirmButtonText: 'Add',
                cancelButtonText: 'Cancel',
                preConfirm: (newKey) => {
                    if (!newKey) {
                        Swal.showValidationMessage('Key tidak boleh kosong');
                    }
                    return newKey;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#field').append(
                        '<div class="col-12 col-md-6 mb-3">' +
                        '<div class="row">' +
                        '<label for="' + result.value + '" class="form-label">' + result.value + '</label>' +
                        '<div class="col-10">' +
                        '<input type="text" class="form-control" id="' + result.value + '" name="' + result.value + '" value="">' +
                        '</div>' +
                        '<div class="col-2">' +
                        '<button type="button" class="btn btn-danger" onclick="deleteRow(this)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Hapus ' + result.value + '"><i class="fa-solid fa-trash"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '</div>'
                    );
                }
            });
        });

        function deleteRow(button) {
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah Anda yakin ingin menghapus ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(button).closest('.col-12').remove();
                }
            });
        }
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"><a href="{{ route('superadmin.env.index') }}">System Setting</a> /</span>
            ENV
        </h5>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">ENV</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('superadmin.env.update') }}" method="POST" id="form">
                            @csrf
                            @method('PUT')
                            <div class="row" id="field">
                                @foreach ($envData as $key => $value)
                                    <div class="col-12 col-md-6 mb-3">
                                        <div class="row">
                                            <label for="{{ $key }}" class="form-label">{{ $key }}</label>
                                            <div class="col-10">
                                                <input type="text" class="form-control @error($key) is-invalid @enderror"
                                                    id="{{ $key }}" name="{{ $key }}" value="{{ $value }}"
                                                    {{ $key == 'APP_KEY' ? 'readonly' : '' }}>
                                                @errorFeedback($key)
                                            </div>
                                            <div class="col-2">
                                                @if ($key != 'APP_KEY')
                                                    <button type="button" class="btn btn-danger" onclick="deleteRow(this)"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Hapus {{ $key }}"><i
                                                            class="fa-solid fa-trash"></i></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-12 d-flex gap-3">
                                <button type="button" class="btn btn-primary" id="updateButton" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Simpan perubahan"><i class="fa-solid fa-save me-3"></i>
                                    Simpan</button>
                                <button type="button" class="btn btn-success" id="addButton" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="Tambahkan baris baru"><i class="fa-solid fa-plus me-3"></i>
                                    Tambahkan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Tambah Ustadz')

@section('page-script')
    <script>
        $('.select2').select2();

        function updateNISPreview() {
            let nis_prefix = $('#nis_prefix').val();
            let nis_start_number = $('#nis_start_number').val();
            let nis_padding = parseInt($('#nis_padding').val()) || 0;
            let nis_suffix = $('#nis_suffix').val();

            // Create padding of zeros based on padding value
            let padding = '0'.repeat(nis_padding - 1);

            // Combine in correct order: PREFIX + PADDING + STARTNUMBER + SUFFIX
            let preview = nis_prefix + padding + nis_start_number + nis_suffix;

            $('#nis_preview').val(preview);
        }

        // Initialize on document load
        $(document).ready(function() {
            updateNISPreview();
        });
        
        $('#nis_prefix, #nis_start_number, #nis_padding, #nis_suffix').on('input', updateNISPreview);
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light"><a href="{{ route('administrationadmin.home') }}">Beranda </a>/</span>Setting
        </h5>
        <div class="row">
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">NIS Setting</h5>
                    </div>
                    <form action="{{ route('administrationadmin.appsetting.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <input type="text" class="form-control" id="nis_preview" disabled>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="nis_prefix">Prefix</label>
                                        <input type="text" class="form-control @error('nis_prefix') is-invalid @enderror"
                                            id="nis_prefix" name="nis_prefix" placeholder="-"
                                            value="{{ old('nis_prefix', $appSetting->nis_prefix ?? '') }}">
                                        @errorFeedback('nis_prefix')
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="nis_start_number">Nomor Awal</label>
                                        <input type="number"
                                            class="form-control @error('nis_start_number') is-invalid @enderror"
                                            id="nis_start_number" name="nis_start_number" placeholder="-"
                                            value="{{ old('nis_start_number', $appSetting->nis_start_number ?? '') }}">
                                        @errorFeedback('nis_start_number')
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="nis_padding">Padding</label>
                                        <input type="number"
                                            class="form-control @error('nis_padding') is-invalid @enderror" id="nis_padding"
                                            name="nis_padding" placeholder="-"
                                            value="{{ old('nis_padding', $appSetting->nis_padding ?? '') }}" max="5">
                                        @errorFeedback('nis_padding')
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-3">
                                    <div class="mb-3">
                                        <label class="form-label" for="nis_suffix">Suffix</label>
                                        <input type="text" class="form-control @error('nis_suffix') is-invalid @enderror"
                                            id="nis_suffix" name="nis_suffix" placeholder="-"
                                            value="{{ old('nis_suffix', $appSetting->nis_suffix ?? '') }}">
                                        @errorFeedback('nis_suffix')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Ruangan Baru</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('facilitiesadmin.rooms.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="code">Kode Ruangan</label>
                                <input type="text" class="form-control" id="code" name="code"
                                    value="{{ old('code') }}" placeholder="R-001" required />
                                @errorFeedback('code')
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama Ruangan</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}" placeholder="Lab Komputer" required />
                                @errorFeedback('name')
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('facilitiesadmin.rooms.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

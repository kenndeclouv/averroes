@extends('layouts.app')
@section('title', 'Edit Mata Pelajaran')

@section('content')
    <form action="{{ route('administrationadmin.teaching-subjects.update', $teaching_subject->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="container-xxl flex-grow-1 container-p-y">
            <h5 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"> <a href="{{ route('administrationadmin.teaching-subjects.index') }}">Daftar
                        Mata Pelajaran</a> /</span>
                Edit Mata Pelajaran
            </h5>
            <div class="row">
                <div class="col-xxl">
                    <div class="card mb-4">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">Data Mata Pelajaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name">Nama Mata Pelajaran</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Nama Mata Pelajaran"
                                    value="{{ old('name', $teaching_subject->name) }}" required>
                                @errorFeedback('name')
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

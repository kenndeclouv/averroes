@extends('layouts.app')
@section('title', 'Dashboard ' . Auth::user()->roles->pluck('name')->implode(', '))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>
            {{ Auth::user()->roles->pluck('name')->implode(', ') }}</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Selamat Datang, {{ Auth::user()->name }}</h5>
                    <div class="card-body">
                        <p>Anda login sebagai Wali Santri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

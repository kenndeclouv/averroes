@extends('layouts.app')
@section('title', 'Dashboard ' . Auth::user()->Role->name)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-xxl-8 mb-6 order-0">
                <div class="card card-border-shadow-primary h-100">
                    <div class="d-flex align-items-start row">
                        <div class="col">
                            <div class="card-body">
                                <h2 class="card-title text-primary mb-3">
                                    Selamat datang {{ Auth::user()->name }} !
                                </h2>
                                <p class="mb-6">
                                    {{ formatDate(now(), 'd F Y H:i') }}
                                </p>
                                <span class="badge bg-label-primary fs-5 ">{{ Auth::user()->Role->name }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 mb-6">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body pb-4">
                        <span class="d-block fw-medium mb-4">Pengumuman</span>
                        @forelse ($announcements as $announcement)
                            <div class="alert alert-{{ $announcement->status == 'active' ? 'success' : 'danger' }} fade show"
                                role="alert">
                                <p class="mb-0">{{ $announcement->title }}</p>
                                <p class="mb-0 opacity-50 small">
                                    {{ formatDate($announcement->date) }}</p>
                            </div>
                        @empty
                            <div class="alert alert-secondary fade show" role="alert">
                                <p class="mb-0">Tidak ada pengumuman!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

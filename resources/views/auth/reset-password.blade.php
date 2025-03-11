@extends('layouts.auth')
@section('title', 'Reset Password')
@section('page-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection
@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card px-sm-6 px-0">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <i class="icon-averroes" style="font-size: 5rem"></i>
                                </span>
                                {{-- <span class="app-brand-text demo text-heading fw-bold">{{ config('app.name') }}</span> --}}
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Reset Password 🔑</h4>
                        <p class="mb-6">Silahkan masukkan password baru anda</p>
                        @include('components.alert')
                        <form id="formAuthentication" class="mb-6" action="{{ route('password.update')}}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Masukkan email" autofocus="on" value="{{ old('email', request('email')) }}">
                            </div>
                            <div class="mb-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Masukkan password baru" autofocus="on" value="{{ old('password') }}">
                            </div>
                            <div class="mb-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                    placeholder="Masukkan password baru" autofocus="on" value="{{ old('password_confirmation') }}">
                            </div>
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Reset Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
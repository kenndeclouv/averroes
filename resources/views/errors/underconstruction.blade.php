@extends('layouts.error')
@section('title', 'Under Construction')

@section('content')
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="line-height: 6rem;font-size: 6rem;">Under Construction</h1>
        <h4 class="mb-2 mx-2">Uhh! 🚧</h4>
        <p class="mb-6 mx-2">Maaf, halaman ini sedang dalam proses pembangunan. Silahkan coba lagi nanti!</p>
        <div class="d-flex justify-content-center">
            <a href="{{ url()->previous() }}" class="btn btn-primary">Kembali</a>
            <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>
@endsection

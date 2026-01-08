@extends('layouts.app')
@section('title', $material->title)

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Materi /</span> {{ $material->title }}
        </h4>

        <div class="card shadow-sm">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary mb-2">{{ $material->TeachingSubject->name }}</span>
                    <h3 class="mb-0">{{ $material->title }}</h3>
                    <small class="text-muted">Oleh: {{ $material->Teacher->user->name ?? 'Guru' }} |
                        {{ $material->created_at->format('d F Y, H:i') }}</small>
                </div>
                <div>
                    <a href="{{ route('student.materials.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Kembali
                    </a>
                </div>
            </div>
            <div class="card-body py-4">
                {{-- Content Display Logic --}}

                {{-- If Text Only or has Content Description --}}
                @if ($material->content)
                    <div class="mb-5">
                        <h5 class="text-muted text-uppercase small fw-bold mb-3">Deskripsi / Isi Materi</h5>
                        <div class="typography" style="white-space: pre-wrap; line-height: 1.8;">{{ $material->content }}
                        </div>
                    </div>
                @endif

                {{-- File Display --}}
                @if ($material->file_path)
                    <div class="bg-light p-4 rounded border">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h6 class="mb-0"><i class="bx bx-file me-2"></i> Lampiran File</h6>
                            <a href="{{ asset('storage/' . $material->file_path) }}" class="btn btn-primary btn-sm" download
                                target="_blank">
                                <i class="bx bx-download me-1"></i> Download File
                            </a>
                        </div>

                        {{-- Embed Preview if possible --}}
                        @if ($material->type == 'image')
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $material->file_path) }}"
                                    class="img-fluid rounded shadow-sm" style="max-height: 600px;"
                                    alt="{{ $material->title }}">
                            </div>
                        @elseif($material->type == 'video')
                            <div class="ratio ratio-16x9">
                                <video controls>
                                    <source src="{{ asset('storage/' . $material->file_path) }}" type="video/mp4">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            </div>
                        @elseif($material->type == 'document' && Str::endsWith($material->file_path, '.pdf'))
                            <div class="ratio ratio-16x9" style="height: 80vh;">
                                <iframe src="{{ asset('storage/' . $material->file_path) }}" allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="alert alert-secondary d-flex align-items-center" role="alert">
                                <i class="bx bx-info-circle me-2"></i>
                                <div>
                                    File ini tidak dapat dipreview langsung. Silakan download untuk melihatnya.
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')
@section('title', 'Materi Pelajaran')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">Siswa /</span> Materi Pelajaran
        </h4>

        <!-- Search / Filter (Optional Future) -->

        <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            @forelse ($materials as $material)
                <div class="col">
                    <div class="card h-100 shadow-sm hover-shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-label-primary">{{ $material->TeachingSubject->name }}</span>
                                <small class="text-muted">{{ $material->created_at->format('d M Y') }}</small>
                            </div>
                            <h5 class="card-title text-truncate">{{ $material->title }}</h5>
                            <p class="card-text text-truncate" style="max-height: 3em; overflow: hidden;">
                                {{ Str::limit($material->content, 100) }}
                            </p>

                            <div class="d-flex align-items-center mb-3">
                                @if ($material->type == 'text')
                                    <i class="bx bx-text text-secondary me-2"></i> <span
                                        class="text-secondary small">Artikel/Teks</span>
                                @elseif($material->type == 'document')
                                    <i class="bx bxs-file-pdf text-danger me-2"></i> <span
                                        class="text-secondary small">Dokumen</span>
                                @elseif($material->type == 'image')
                                    <i class="bx bx-image text-warning me-2"></i> <span
                                        class="text-secondary small">Gambar</span>
                                @elseif($material->type == 'video')
                                    <i class="bx bx-video text-danger me-2"></i> <span
                                        class="text-secondary small">Video</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3">
                            <a href="{{ route('student.materials.show', $material->id) }}"
                                class="btn btn-outline-primary w-100">Buka Materi</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class='bx bx-book-open display-1 text-muted mb-3'></i>
                            <h5>Belum ada materi</h5>
                            <p class="text-muted">Guru belum mengunggah materi pelajaran untuk kelasmu semester ini.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">
            {{ $materials->links() }}
        </div>
    </div>
@endsection

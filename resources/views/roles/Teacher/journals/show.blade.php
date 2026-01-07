@extends('layouts.app')
@section('title', 'Jurnal Mengajar')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="{{ route('teacher.journals.index') }}">Jurnal Mengajar</a> /
            </span>
            Detail Jurnal
        </h5>
        <div class="card">
            <div class="card-body">
                <div class="mb-2">
                    <strong>Guru:</strong>
                    {{ $journal->teacher->name }}
                </div>
                <div class="mb-2">
                    <strong>Tanggal:</strong>
                    {{ formatDate($journal->date) }}
                </div>
                <div class="mb-2">
                    <strong>Mata Pelajaran:</strong>
                    @foreach ($journal->teachingSubjects as $subject)
                        <span class="badge bg-primary">{{ $subject->name }}</span>
                    @endforeach
                </div>
                <div class="mb-2">
                    <strong>Total Jam Reguler:</strong>
                    {{ $journal->total_regular_hours }}
                </div>
                <div class="mb-2">
                    <strong>Total Jam Badal:</strong>
                    {{ $journal->total_replacement_hours }}
                </div>
                <div class="mb-2">
                    <strong>Deskripsi Sebaran JP Reguler:</strong><br>
                    {!! nl2br(e($journal->regular_hour_description)) !!}
                </div>
                <div class="mb-2">
                    <strong>Deskripsi Sebaran JP Badal:</strong><br>
                    {!! nl2br(e($journal->replacement_hour_description)) !!}
                </div>
                @if ($journal->notes)
                    <div class="mb-2">
                        <strong>Catatan Tambahan:</strong><br>
                        {!! nl2br(e($journal->notes)) !!}
                    </div>
                @endif
                <div class="mt-3 text-end">
                    <a href="{{ route('teacher.journals.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <a href="{{ route('teacher.journals.edit', $journal) }}" class="btn btn-warning">
                        <i class="fa-solid fa-edit"></i>
                    </a>
                    <x-delete :route="route('teacher.journals.destroy', $journal->id)" :message="'Apakah kamu yakin ingin menghapus jurnal ini?'" :title="'Hapus Jurnal'" />
                </div>
            </div>
        </div>
    </div>
@endsection

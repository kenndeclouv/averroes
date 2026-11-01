@extends('layouts.app')
@section('title', 'Backup & Restore Aplikasi')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center py-3 mb-4 gap-2">
            <div>
                <h4 class="fw-bold m-0">
                    <span class="text-muted fw-light">Super Admin /</span> Backup & Restore
                </h4>
                <small class="text-muted">Kelola pencadangan dan pemulihan data sistem Averroes</small>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <!-- Tombol Upload & Restore -->
                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#uploadRestoreModal">
                    <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload & Restore
                </button>
                <!-- Tombol Backup Database Saja (Simple) -->
                <form action="{{ route('superadmin.backup.database') }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Mulai proses Backup Simple (Database saja)?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-info">
                        <i class="fa-solid fa-database me-1"></i> Backup Simple (.sql)
                    </button>
                </form>
                <!-- Tombol Backup Total (Full) -->
                <form action="{{ route('superadmin.backup.total') }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Mulai proses Backup Full (Database + Seluruh File Storage)? Proses ini membutuhkan waktu tergantung ukuran data.');">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-file-zipper me-1"></i> Backup Full (.zip)
                    </button>
                </form>
            </div>
        </div>

        @include('components.alert')

        <!-- Info Card Perbedaan Tipe Backup -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="card border-info border-1 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-label-info p-2 me-2 rounded">
                                <i class="fa-solid fa-database fs-5"></i>
                            </span>
                            <h5 class="card-title m-0">Tipe 1: Simple Backup (.sql)</h5>
                        </div>
                        <p class="card-text text-muted mb-0">
                            Hanya mencadangkan <strong>database MySQL</strong> (seluruh tabel, struktur, dan data). Ukuran file kecil, proses instan, dan cocok untuk backup harian/rutin.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-primary border-1 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-label-primary p-2 me-2 rounded">
                                <i class="fa-solid fa-file-zipper fs-5"></i>
                            </span>
                            <h5 class="card-title m-0">Tipe 2: Full Backup (.zip)</h5>
                        </div>
                        <p class="card-text text-muted mb-0">
                            Mencadangkan <strong>Database + Seluruh File di Storage Publik</strong> (materi belajar ustadz, bukti transfer transaksi, lampiran chat, dokumen santri). Sangat penting untuk migrasi atau disaster recovery total.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Daftar Backup -->
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Daftar File Backup di Server</h5>
                <small class="text-muted">Tersimpan di <code>storage/app/backups</code></small>
            </div>
            <div class="card-body mt-3">
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover" id="backupTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tipe</th>
                                <th>Nama File</th>
                                <th>Ukuran</th>
                                <th>Waktu Pembuatan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($backups as $backup)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="badge {{ $backup['badge'] }}">
                                            <i class="fa-solid {{ $backup['icon'] }} me-1"></i>
                                            {{ $backup['type'] }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $backup['name'] }}</strong>
                                    </td>
                                    <td>{{ $backup['size'] }}</td>
                                    <td>{{ $backup['created_at'] }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-1">
                                            <!-- Download -->
                                            <a href="{{ route('superadmin.backup.download', $backup['name']) }}"
                                                class="btn btn-success btn-sm" data-bs-toggle="tooltip"
                                                data-bs-placement="top" title="Download File">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            <!-- Restore -->
                                            <button type="button" class="btn btn-warning btn-sm btn-restore"
                                                data-filename="{{ $backup['name'] }}"
                                                data-type="{{ $backup['type'] }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Restore Data Ini">
                                                <i class="fa-solid fa-rotate-left"></i>
                                            </button>
                                            <!-- Hapus -->
                                            <form action="{{ route('superadmin.backup.destroy', $backup['name']) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah kamu yakin ingin menghapus backup {{ $backup['name'] }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus File">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="fa-solid fa-box-open fs-1 mb-2 d-block"></i>
                                        Belum ada file backup di server. Klik salah satu tombol di atas untuk membuat backup.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Upload & Restore -->
    <div class="modal fade" id="uploadRestoreModal" tabindex="-1" aria-labelledby="uploadRestoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('superadmin.backup.upload-restore') }}" method="POST" enctype="multipart/form-data"
                    onsubmit="return confirm('PERINGATAN: Memulihkan file backup ini akan menimpa data yang ada saat ini. Lanjutkan proses restore?');">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadRestoreModalLabel">
                            <i class="fa-solid fa-cloud-arrow-up me-1 text-primary"></i> Upload & Restore Backup
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i>
                            <strong>Peringatan Penting:</strong> File backup yang di-upload akan langsung diproses untuk me-restore database (dan storage jika ZIP). Data yang ada saat ini akan ditimpa!
                        </div>
                        <div class="mb-3">
                            <label for="backup_file" class="form-label">Pilih File Backup (.sql atau .zip)</label>
                            <input class="form-control" type="file" id="backup_file" name="backup_file" accept=".sql,.zip" required>
                            <small class="text-muted">Maksimal ukuran file: 500 MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-rotate-left me-1"></i> Upload & Lakukan Restore
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Form Tersembunyi untuk Restore dari Server -->
    <form id="serverRestoreForm" method="POST" style="display: none;">
        @csrf
    </form>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            @if (count($backups) > 0)
                $('#backupTable').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                    },
                    order: [] // Biarkan urutan dari controller (terbaru di atas)
                });
            @endif

            // Handler konfirmasi restore dari tabel
            $(document).on('click', '.btn-restore', function() {
                const filename = $(this).data('filename');
                const type = $(this).data('type');

                if (confirm(`PERINGATAN KRUSIAL!\n\nApakah kamu yakin ingin me-restore sistem dari file:\n"${filename}" (${type})?\n\nTindakan ini akan MENIMPA data database dan/atau file yang sedang berjalan saat ini dengan data cadangan ini.`)) {
                    const form = $('#serverRestoreForm');
                    form.attr('action', `/superadmin/backup/restore/${encodeURIComponent(filename)}`);
                    form.submit();
                }
            });
        });
    </script>
@endsection

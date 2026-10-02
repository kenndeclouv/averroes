@extends('layouts.app')
@section('title', 'Jurnal Mengajar')

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            const date = new URLSearchParams(window.location.search).get('month') ?
                moment(new URLSearchParams(window.location.search).get('month')).format('MMMM YYYY') :
                moment().locale('id').format('MMMM YYYY');

            $('#table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                },
                dom: '<"card-header flex-column justify-content-start flex-md-row pb-0"<"head-label text-center"><"dt-action-buttons text-start pt-6 pt-md-0"B>>' +
                    '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end mt-n6 mt-md-0"f>>t' +
                    '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                buttons: [{
                    extend: "collection",
                    className: "btn btn-label-primary dropdown-toggle",
                    text: '<i class="fas fa-file-export me-sm-2"></i> <span class="d-none d-sm-inline-block">Export</span>',
                    buttons: [{
                            extend: "print",
                            text: '<i class="fas fa-print me-1"></i>Print',
                            className: "dropdown-item",
                            title: "Jurnal Mengajar Bulan " + date,
                            exportOptions: {
                                columns: ':not(:last-child)'
                            }
                        },
                        {
                            text: '<i class="fas fa-file-excel me-1"></i>Excel (Semua)',
                            className: "dropdown-item",
                            action: function ( e, dt, node, config ) {
                                window.location.href = "{{ route('administrationadmin.journals.export') }}?month={{ request('month', now()->format('Y-m')) }}&teacher_id={{ request('teacher_id') }}";
                            }
                        },
                        {
                            text: '<i class="fas fa-file-excel me-1"></i>Excel (Pisah Guru)',
                            className: "dropdown-item",
                            action: function ( e, dt, node, config ) {
                                window.location.href = "{{ route('administrationadmin.journals.export') }}?month={{ request('month', now()->format('Y-m')) }}&teacher_id={{ request('teacher_id') }}&per_teacher=1";
                            }
                        },
                        {
                            text: '<i class="fas fa-fingerprint me-1"></i>Excel (Log Fingerprint)',
                            className: "dropdown-item",
                            action: function ( e, dt, node, config ) {
                                $('#fingerprintModal').modal('show');
                            }
                        }
                    ]
                }]
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card shadow">
            <div class="card-header border-bottom">
                <h5 class="card-title">Jurnal Mengajar</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                @if($isLocked)
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-lock me-1"></i> Bulan ini telah dikunci. Anda tidak dapat menambahkan, mengubah, atau menghapus jurnal.
                    </div>
                @else
                    @php
                        $arr = explode('-', $monthYear ?? now()->format('Y-m'));
                        $lockDate = \Carbon\Carbon::createFromDate($arr[0], $arr[1], 1)->addMonth()->addDay(1)->startOfDay();
                        $now = \Carbon\Carbon::now()->startOfDay();
                        $daysUntilLock = $now->diffInDays($lockDate, false);
                    @endphp
                    @if($daysUntilLock > 0 && $daysUntilLock <= 7)
                        <div class="alert alert-info mb-3">
                            <i class="fas fa-info-circle me-1"></i> Waktu pengisian/perubahan jurnal untuk bulan ini tersisa <strong>{{ $daysUntilLock }} hari</strong> lagi. Setelah berganti bulan (lewat tanggal 1), jurnal tidak dapat ditambah, diubah, atau dihapus.
                        </div>
                    @endif
                @endif
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        @if(!$isLocked)
                            <a href="{{ route('administrationadmin.journals.create') }}" class="btn btn-primary me-2">
                                Tambah Jurnal
                            </a>
                        @endif
                        <form method="POST" action="{{ route('administrationadmin.journals.toggle_lock') }}">
                            @csrf
                            <input type="hidden" name="monthYear" value="{{ $monthYear ?? now()->format('Y-m') }}">
                            @if($isLocked)
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-unlock me-1"></i> Buka Kunci Bulan Ini
                                </button>
                            @else
                                @php
                                    $arr = explode('-', $monthYear ?? now()->format('Y-m'));
                                    $autoLockDate = \Carbon\Carbon::createFromDate($arr[0], $arr[1], 1)->addMonth()->addDay(1)->startOfDay();
                                    $isAutoLocked = \Carbon\Carbon::now()->greaterThanOrEqualTo($autoLockDate);
                                @endphp
                                @if($isAutoLocked)
                                    <button type="submit" class="btn btn-secondary">
                                        <i class="fas fa-lock me-1"></i> Kunci Kembali Bulan Ini
                                    </button>
                                @endif
                            @endif
                        </form>
                    </div>
                    <form method="GET" class="d-flex align-items-center"
                        action="{{ route('administrationadmin.journals.index') }}">
                        <select name="teacher_id" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Semua Guru</option>
                            @foreach ($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="month" class="me-2 mb-0">Bulan:</label>
                        <input type="month" id="month" name="month" class="form-control me-2"
                            value="{{ $monthYear ?? now()->format('Y-m') }}" onchange="this.form.submit()">
                    </form>
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Guru</th>
                            <th>Subjek</th>
                            <th>JP Reguler</th>
                            <th>JP Badal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journals as $journal)
                            <tr>
                                <td>{{ formatDate($journal->date) }}</td>
                                <td>{{ $journal->teacher->name }}</td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1" style="max-width: 250px;">
                                        @foreach ($journal->teachingSubjects as $subject)
                                            <span class="badge bg-primary">{{ $subject->name }}</span> 
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $journal->total_regular_hours }}</td>
                                <td>{{ $journal->total_replacement_hours }}</td>
                                <td>
                                    <a href="{{ route('administrationadmin.journals.show', $journal) }}"
                                        class="btn btn-info" data-bs-toggle="tooltip" title="Lihat Jurnal">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$isLocked)
                                        <a href="{{ route('administrationadmin.journals.edit', $journal) }}"
                                            class="btn btn-warning" data-bs-toggle="tooltip" title="Ubah Jurnal">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <x-delete :route="route('administrationadmin.journals.destroy', $journal->id)" :message="'Apakah kamu yakin ingin menghapus data ini?'" :title="'Hapus Jurnal'" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-end">Total</th>
                            <th>
                                {{ isset($journals) ? $journals->sum('total_regular_hours') : '0' }}
                            </th>
                            <th>
                                {{ isset($journals) ? $journals->sum('total_replacement_hours') : '0' }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Fingerprint Modal -->
    <div class="modal fade" id="fingerprintModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('administrationadmin.journals.export_fingerprint') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="month" value="{{ request('month', now()->format('Y-m')) }}">
                    <input type="hidden" name="teacher_id" value="{{ request('teacher_id') }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel1">Export &amp; Log Fingerprint</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @php
                            $currentMonthYear = request('month', now()->format('Y-m'));
                            $storedLogExists  = file_exists(storage_path("app/fingerprint_logs/{$currentMonthYear}.txt"));
                        @endphp

                        @if($storedLogExists)
                            <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                                <i class="fas fa-check-circle me-2 fs-5"></i>
                                <div>
                                    Log fingerprint bulan <strong>{{ $currentMonthYear }}</strong> sudah tersimpan di sistem.
                                    <br><small class="text-muted">Klik <strong>Export Excel</strong> langsung tanpa upload, atau pilih file baru jika ingin memperbarui log.</small>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                                <i class="fas fa-info-circle me-2 fs-5"></i>
                                <div>
                                    Log fingerprint bulan <strong>{{ $currentMonthYear }}</strong> belum tersimpan.
                                    <br><small>Upload file <code>.txt</code> log fingerprint dari mesin absensi.</small>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col mb-3">
                                <label for="fingerprint_log" class="form-label">
                                    File Log (.txt) {{ $storedLogExists ? '(Opsional - Jika Ingin Update)' : '(Wajib Upload)' }}
                                </label>
                                <input type="file" id="fingerprint_log" name="fingerprint_log" class="form-control" accept=".txt" {{ $storedLogExists ? '' : 'required' }} />
                                <small class="text-muted mt-2 d-block">File log akan tersimpan otomatis di sistem per bulan.</small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-file-excel me-1"></i> Export Excel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

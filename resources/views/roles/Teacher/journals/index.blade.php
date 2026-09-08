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
                            text: '<i class="fas fa-file-excel me-1"></i>Excel',
                            className: "dropdown-item",
                            action: function ( e, dt, node, config ) {
                                window.location.href = "{{ route('teacher.journals.export') }}?month={{ request('month', now()->format('Y-m')) }}";
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
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if(!$isLocked)
                            <a href="{{ route('teacher.journals.create') }}" class="btn btn-primary mb-3">
                                Tambah Jurnal
                            </a>
                        @endif
                    </div>
                    <form method="GET" class="d-flex align-items-center" action="{{ route('teacher.journals.index') }}">
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
                                    <a href="{{ route('teacher.journals.show', $journal) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$isLocked)
                                        <a href="{{ route('teacher.journals.edit', $journal) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <x-delete :route="route('teacher.journals.destroy', $journal->id)" :message="'Apakah kamu yakin ingin menghapus data ini?'" :title="'Hapus Jurnal'" />
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-end">Total</th>
                            <th>
                                {{ isset($journals) ? $journals->sum('total_regular_hours') : '0' }}
                            </th>
                            <th>
                                {{ isset($journals) ? $journals->sum('total_replacement_hours') : '0' }}
                            </th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

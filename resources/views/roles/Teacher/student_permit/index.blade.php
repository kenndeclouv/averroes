@extends('layouts.app')
@section('title', 'Daftar Ijin Santri')

@section('page-script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json'
                }
            });
        });
    </script>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Ijin Santri</h5>
            </div>
            <div class="card-body pb-0 pt-4">
                <div class="d-flex justify-content-end">
                    <a href="{{ route('teacher.studentpermit.create') }}" class="btn btn-primary mb-3" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Tambah Ijin Santri">Tambah Ijin
                        Santri</a>
                </div>
            </div>
            <div class="card-datatable table-responsive text-start text-nowrap">
                <table class="table table-bordered" id="table">
                    <thead>
                        <tr>
                            <th>Nama Santri</th>
                            <th>Dari</th>
                            <th>Sampai</th>
                            <th>Kelas</th>
                            <th>Sebab</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentPermits as $studentPermit)
                            <tr>
                                <td>{{ $studentPermit->Student->name ?? '-' }}</td>
                                <td>{{ formatDate($studentPermit->from, 'd F Y H:i') }}</td>
                                <td>{{ formatDate($studentPermit->to, 'd F Y H:i') }}</td>
                                <td>{{ $studentPermit->Student->Class->name ?? '-' }}</td>
                                <td>{{ Str::limit($studentPermit->reason, 20) }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $studentPermit->status == 'pending' ? 'warning' : ($studentPermit->status == 'approved' ? 'success' : 'danger') }}">{{ $studentPermit->status }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('teacher.studentpermit.show', $studentPermit->id) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Ijin Santri"
                                        class="btn btn-info"><i class="fa-solid fa-eye"></i></a>
                                    <a href="{{ route('teacher.studentpermit.edit', $studentPermit->id) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Ijin Santri"
                                        class="btn btn-warning"><i class="fa-solid fa-edit"></i></a>
                                    <x-delete :route="route('teacher.studentpermit.destroy', $studentPermit->id)" :message="'Apakah kamu yakin ingin menghapus ijin santri ini?'" :title="'Hapus Ijin Santri'" />
                                    @if ($studentPermit->status == 'pending')
                                        <form action="{{ route('teacher.studentpermit.approve', $studentPermit->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-inline" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Ijinkan Ijin Santri">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $studentPermit->id }}"
                                                    data-bs-placement="top" title="Setujui Ijin Santri"
                                                    class="btn btn-success">
                                                    <i class="fa-solid fa-check"></i>
                                                </button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="approveModal{{ $studentPermit->id }}"
                                                tabindex="-1" aria-labelledby="approveModalLabel{{ $studentPermit->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="approveModalLabel{{ $studentPermit->id }}">Setujui Ijin
                                                                Santri</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- Apakah kamu yakin ingin menyetujui ijin santri ini? --}}
                                                            <div class="form-group mt-3">
                                                                <label for="note">Catatan</label>
                                                                <input type="text" name="note" id="note"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-success">Setujui</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <form action="{{ route('teacher.studentpermit.reject', $studentPermit->id) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-inline" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Tidak Setujui Ijin Santri">
                                                <button type="button" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $studentPermit->id }}"
                                                    class="btn btn-danger">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade" id="rejectModal{{ $studentPermit->id }}" tabindex="-1"
                                                aria-labelledby="rejectModalLabel{{ $studentPermit->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="rejectModalLabel{{ $studentPermit->id }}">Tidak Setujui
                                                                Ijin
                                                                Santri</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{-- Apakah kamu yakin ingin menyetujui ijin santri ini? --}}
                                                            <div class="form-group mt-3">
                                                                <label for="note">Catatan</label>
                                                                <input type="text" name="note" id="note"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-danger">Tidak
                                                                Setujui</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

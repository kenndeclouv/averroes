@extends('layouts.app')
@section('title', 'Dashboard ' . Auth::user()->roles->pluck('name')->implode(', '))

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
                                <span
                                    class="badge bg-label-primary fs-5 ">{{ Auth::user()->roles->pluck('name')->implode(', ') }}</span>

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
                    <div id="chartImamAktif" class="pb-3"></div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-primary"><i
                                        class="fas fa-users fs-5"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalSantri }}</h4>
                        </div>
                        <p class="mb-2">Total Santri</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-warning"><i
                                        class="fas fa-user fs-5"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalSantriAktif }}</h4>
                        </div>
                        <p class="mb-2">Total Santri Aktif</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-danger h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-danger"><i
                                        class="fas fa-user-vneck fs-5"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalUstadz }}</h4>
                        </div>
                        <p class="mb-2">Total Ustadz</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card card-border-shadow-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded bg-label-info"><i
                                        class="fas fa-calendar-alt fs-5"></i></span>
                            </div>
                            <h4 class="mb-0">{{ $totalIjin }}</h4>
                        </div>
                        <p class="mb-2">Total Ijin</p>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="card card-border-shadow-secondary">
                    <div class="card-header">
                        <h5 class="card-title">Total Ijin pekan ini</h5>
                    </div>
                    <div class="card-body">
                        <div id="chart"></div>
                    </div>
                </div>
                {{-- @dd($permits) --}}
                <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
                <script>
                    function formatDates(days) {
                        if (!days || !Array.isArray(days)) {
                            console.error('Data days tidak valid:', days);
                            return []; // Mengembalikan array kosong jika data tidak valid
                        }
                        return days.map(day => {
                            const date = new Date(day);
                            return date.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'short',
                                // year: 'numeric'
                            });
                        });
                    }
                    document.addEventListener('DOMContentLoaded', function() {
                        var options = {
                            chart: {
                                height: 300,
                                type: 'area',
                                toolbar: {
                                    show: false
                                },
                            },
                            timezone: '{{ env('APP_TIMEZONE', 'GMT') }}',
                            grid: {
                                show: false,
                                padding: {
                                    right: 8
                                }
                            },
                            colors: ['var(--bs-primary)'],
                            fill: {
                                type: "gradient",
                                gradient: {
                                    shade: 'light',
                                    shadeIntensity: 0.8,
                                    opacityFrom: 0.1,
                                    opacityTo: 0,
                                    stops: [0, 98, 100]
                                }
                            },
                            dataLabels: {
                                enabled: false
                            },
                            stroke: {
                                width: 2,
                                curve: "smooth"
                            },
                            series: [{
                                name: 'Santri',
                                data: {!! json_encode($permits->pluck('count')) !!}
                            }],
                            xaxis: {
                                categories: formatDates({!! json_encode($permits->pluck('date')) !!}),
                                labels: {
                                    style: {
                                        colors: '#9e9e9e',
                                        fontSize: "13px"
                                    }
                                },
                            },
                            yaxis: {
                                min: 0,
                                labels: {
                                    style: {
                                        colors: '#9e9e9e',
                                        fontSize: "13px"
                                    },
                                    formatter: function(value) {
                                        return Math.floor(value);
                                    }
                                },
                            }

                        }

                        var chart = new ApexCharts(document.querySelector("#chart"), options);

                        chart.render();
                    });
                </script>
            </div>
        </div>
    </div>
@endsection

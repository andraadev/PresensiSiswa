@extends('layouts.dashboard')
@section('header')
    Beranda
@endsection
@section('basic-statistics-section')
    <section class="row g-3 mt-1" aria-label="Dashboard metrics">
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Jumlah Kelas</span>
                    <span class="metric-icon">
                        <i class="ti ti-door" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value">{{ $kelas }} Kelas</div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Jumlah Siswa</span>
                    <span class="metric-icon">
                        <i class="ti ti-school" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value">{{ $siswa }} Orang</div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Jumlah Guru</span>
                    <span class="metric-icon"><i class="ti ti-chalkboard-teacher" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $guru }} Orang</div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-danger">
                <div class="metric-top">
                    <span class="metric-label">Jumlah User</span>
                    <span class="metric-icon">
                        <i class="ti ti-user-check" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value">{{ $user }} Orang</div>
            </article>
        </div>
    </section>
@endsection
@section('charts-section')
    <section class="row g-3 mt-1">
        <div class="col-12 col-xl-8">
            <div class="panel">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title">Jumlah Siswa Per Kelas</h2>
                    </div>
                    <a class="btn btn-light btn-sm" href="{{ route('data-siswa.index') }}">Lihat Data</a>
                </div>
                <div id="statistik_siswa"></div>
            </div>
        </div>

        <div class="col-12 col-xl-4">
            <div class="panel h-100">
                <div class="panel-header">
                    <div>
                        <h2 class="h5 mb-1 section-title">
                            Status Presensi
                            <span class="badge bg-primary-subtle text-primary fw-semibold">
                                {{ $totalKelasSudah }} / {{ $totalKelas }} Kelas
                            </span>
                        </h2>
                        <p class="text-muted mb-0">Status presensi per kelas hari ini</p>
                    </div>
                </div>


                <div class="activity-list">
                    @foreach ($statusKelas as $item)
                        <div class="activity-item d-flex justify-content-between align-items-center px-3 py-2">
                            <span class="mb-1 fw-semibold">{{ $item['nama_kelas'] }}</span>

                            @if ($item['sudah_absen'])
                                <span class="badge text-bg-success d-inline-flex align-items-center">
                                    <i class="ti ti-check me-1"></i> Sudah
                                </span>
                            @else
                                <span class="badge text-bg-warning d-inline-flex align-items-center">
                                    <i class="ti ti-clock me-1"></i> Belum
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
@section('additional_js')
    <script>
        var labels = @json($labels);
        var data = @json($data);

        $(function() {
            var bootstrapTextColor = window.getComputedStyle(document.body).getPropertyValue('--bs-body-color')
                .trim();

            var options = {
                chart: {
                    type: "bar",
                    toolbar: {
                        show: false
                    },
                    width: "100%",
                },
                series: [{
                    name: "Jumlah Siswa",
                    data: data,
                }],
                xaxis: {
                    categories: labels,
                    labels: {
                        style: {
                            colors: bootstrapTextColor
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: [bootstrapTextColor]
                        },
                    }
                },
                states: {
                    normal: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    hover: {
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    },
                    active: {
                        allowMultipleDataPointsSelection: false,
                        filter: {
                            type: 'none',
                            value: 0
                        }
                    }
                },
                tooltip: {
                    enabled: false
                }
            };

            var chart = new ApexCharts(document.querySelector("#statistik_siswa"), options);
            chart.render();

            var observer = new MutationObserver(function() {
                var updatedColor = window.getComputedStyle(document.body).getPropertyValue(
                    '--bs-body-color').trim();
                chart.updateOptions({
                    xaxis: {
                        labels: {
                            style: {
                                colors: updatedColor
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: [updatedColor]
                            }
                        }
                    }
                });
            });
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['data-bs-theme']
            });
        });
    </script>
@endsection

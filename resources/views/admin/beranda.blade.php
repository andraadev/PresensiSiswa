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
    {{-- <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="p-2">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h5 class="mb-8 fw-bolder">Selamat Datang, {{ Auth::user()->nama_lengkap }}</h5>
                            <h6 id="jam" class="fw-semibold mb-2"></h6>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-info rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-info-circle fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="card">
                <div class="p-2">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h5 class="mb-8 fw-bolder">Jumlah Kelas</h5>
                            <h6>{{ $kelas }} Kelas</h6>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-danger rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-building fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <div class="row">
        <div class="col-lg-4 col-sm-12">
            <!-- Monthly Earnings -->
            <div class="card">
                <div class="p-2">
                    <div class="row align-items-start">
                        <div class="col-9">
                            <h5 class="card-title mb-8 fw-bolder">Jumlah Siswa</h5>
                            <h6>{{ $siswa }} Orang</h6>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-users fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <!-- Monthly Earnings -->
            <div class="card">
                <div class="p-2">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h5 class="card-title mb-8 fw-bolder">Jumlah Guru</h5>
                            <h6>{{ $guru }} Orang</h6>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user-cog fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <!-- Monthly Earnings -->
            <div class="card">
                <div class="p-2">
                    <div class="row align-items-start">
                        <div class="col-8">
                            <h5 class="card-title mb-8 fw-bolder">Jumlah User</h5>
                            <h6>{{ $user }} Orang</h6>
                        </div>
                        <div class="col-4">
                            <div class="d-flex justify-content-end">
                                <div class="text-white rounded-circle p-6 d-flex align-items-center justify-content-center"
                                    style="background-color: #198754">
                                    <i class="ti ti-user-check fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
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
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        data = data.map(function(value) {
            return Math.round(value);
        });
        $(function() {
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
                }, ],
                xaxis: {
                    categories: labels,
                    // type: 'numeric'
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return Math.round(value);
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#statistik_siswa"), options);
            chart.render();
        });
    </script>
@endsection

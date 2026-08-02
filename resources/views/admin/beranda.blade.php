@extends('layouts.dashboard')
@section('header')
    Beranda
@endsection
@section('basic-statistics-section')
    <div class="row">
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
    </div>

    <div class="row">
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
    </div>
@endsection
@section('charts-section')
    <div class="row">
        <div class="col-lg-9 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Statistik Siswa per Kelas</h5>
                        </div>
                    </div>
                    <div id="statistik_siswa"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-sm-12 d-flex align-items-strech">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center gap-3 py-3">
                    <div class="mb- mb-sm-0 ">
                        <h5 class="card-title fw-semibold">Status Presensi</h5>
                    </div>
                    <span class="badge bg-primary-subtle text-primary fw-semibold">
                        {{ $totalKelasSudah }} / {{ $totalKelas }} Kelas
                    </span>
                </div>

                <div class="card-body p-0">
                    <p class="text-center fs-3 fw-normal">Status presensi per kelas hari ini</p>
                    <div class="list-group list-group-flush">
                        @foreach ($statusKelas as $item)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-3 py-2">
                                <span class="fw-medium text-dark">{{ $item['nama_kelas'] }}</span>

                                @if ($item['sudah_absen'])
                                    <span
                                        class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                        <i class="ti ti-check me-1"></i> Sudah
                                    </span>
                                @else
                                    <span
                                        class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                        <i class="ti ti-clock me-1"></i> Belum
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional_js')
    <script>
        // Ambil data yang diteruskan dari controller
        var labels = <?php echo json_encode($labels); ?>;
        var data = <?php echo json_encode($data); ?>;

        // Mengonversi setiap nilai dalam array data menjadi bilangan bulat positif
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
                            return Math.round(value); // Round the value to the nearest integer
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#statistik_siswa"), options);
            chart.render();

            // var data_user = {
            //     chart: {
            //         width: 380,
            //         type: 'pie',
            //     },
            //     labels: pieLabels,
            //     series: pieData,
            //     dataLabels: {
            //         formatter: function(val, opts) {
            //             return opts.w.config.series[opts.seriesIndex]
            //         },
            //     },
            // }

            // var statistik_user = new ApexCharts(document.querySelector("#statistik_user"), data_user);
            // statistik_user.render();
        });
    </script>
@endsection

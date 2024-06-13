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
                            <h6 id="jam"></h6>
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
        <div class="col-lg-7 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Statistik Siswa</h5>
                        </div>
                    </div>
                    <div id="statistik_siswa"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-sm-12 d-flex align-items-strech">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Statistik User</h5>
                        </div>
                    </div>
                    <div id="statistik_user"></div>
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

        var pieLabels = <?php echo json_encode($pieLabels); ?>;
        var pieData = <?php echo json_encode($pieData); ?>;

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

            var chart = new ApexCharts(
                document.querySelector("#statistik_siswa"),
                options
            );
            chart.render();

            var data_user = {
                chart: {
                    width: 380,
                    type: 'pie',
                },
                labels: pieLabels,
                series: pieData,
                dataLabels: {
                    formatter: function(val, opts) {
                        return opts.w.config.series[opts.seriesIndex]
                    },
                },
            }

            var statistik_user = new ApexCharts(
                document.querySelector("#statistik_user"),
                data_user);
            statistik_user.render();
        });
    </script>
@endsection

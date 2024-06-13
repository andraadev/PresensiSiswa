@extends('layouts.dashboard')
@section('header')
    Beranda
@endsection

@section('basic-statistics-section')
    <div class="row">
        <div class="col-sm-12 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-9">
                            <h4 class="mb-8 fw-bolder">Selamat Datang, {{ Auth::user()->nama_lengkap }}
                                </h5>
                                <h6 class="fw-semibold mb-0">{{ date('l,d F Y') }}</h6>
                            </h4>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-apps-filled fs-6"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-9">
                            <h4 class="mb-8 fw-bolder">Jumlah Siswa</h5>
                                {{-- <h6 class="fw-semibold mb-0">Rabu,4 Oktober 2023</h6> --}}
                                <h6 class="fw-semibold mb-0">{{ $siswa }} Siswa</h6>
                            </h4>
                        </div>
                        <div class="col-3">
                            <div class="d-flex justify-content-end">
                                <div
                                    class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                    <i class="ti ti-user fs-6"></i>
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
    <!--  Row 1 -->
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
                            <h5 class="card-title fw-semibold">Statistik Kehadiran Siswa</h5>
                        </div>
                    </div>
                    <div id="statistik_kehadiran_siswa"></div>
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

            var chart = new ApexCharts(
                document.querySelector("#statistik_siswa"),
                options
            );
            chart.render();
            var options = {
                chart: {
                    type: 'pie',
                    height: 350,
                },
                series: [{{ $statistik_siswa->hadir }}, {{ $statistik_siswa->sakit }},
                    {{ $statistik_siswa->izin }},
                    {{ $statistik_siswa->alpa }}
                ],
                labels: ['Hadir', 'Sakit', 'Izin', 'Alpa'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }

            var chart = new ApexCharts(document.querySelector("#statistik_kehadiran_siswa"), options);
            chart.render();
        });
    </script>
@endsection

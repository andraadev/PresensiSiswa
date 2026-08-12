@extends('layouts.dashboard')
@section('header')
    Beranda
@endsection

@section('basic-statistics-section')
    <section class="row g-3 mt-1" aria-label="Dashboard metrics">
        <div class="col-12 col-sm-6 col-xl-6">
            <article class="metric-card metric-primary">
                <div class="metric-value fw-bold fs-4">
                    Selamat Datang, {{ Auth::user()->nama_lengkap }}
                </div>
                <div class="metric-value fw-medium fs-5">
                    {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-6">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Jumlah Siswa</span>
                    <span class="metric-icon">
                        <i class="ti ti-school" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value">{{ $siswa }} Siswa</div>
            </article>
        </div>
    </section>
@endsection

@section('charts-section')
    <!--  Row 1 -->
    <div class="row mt-3">
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

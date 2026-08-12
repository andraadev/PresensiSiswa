@extends('layouts.dashboard')
@section('header')
    Beranda
@endsection

@section('basic-statistics-section')
    <section class="mt-1" aria-label="Dashboard metrics">
        <article class="metric-card metric-primary">
            <div class="metric-value fw-bold fs-4">
                Selamat Datang, {{ Auth::user()->nama_lengkap }}
            </div>
            <div class="metric-value fw-medium fs-5">
                {{ Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
            </div>
        </article>

    </section>
@endsection

@section('charts-section')
    <div class="panel">
        <div class="panel-header">
            <h2 class="h5 mb-1 section-title">Jumlah Siswa Per Kelas</h2>
        </div>
        <div id="statistik_siswa"></div>
    </div>
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
                    name: "Jumlah Siswa per Kelas",
                    data: data,
                }, ],
                xaxis: {
                    categories: labels,
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return Math.round(value);
                        }
                    }
                }
            };

            var chart = new ApexCharts(
                document.querySelector("#statistik_siswa"),
                options
            );
            chart.render();
        });
    </script>
@endsection

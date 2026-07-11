    @extends('layouts.page')
    @section('title', 'Data Absensi')

    @section('content')
        @forelse ($kelas_saya as $kelas)
            @php
                $hariIni = date('Y-m-d');

                $absensiHariIni = $kelas->siswa->flatMap(function ($siswa) use ($hariIni) {
                    return $siswa->absensi->filter(function ($absen) use ($hariIni) {
                        return date('Y-m-d', strtotime($absen->created_at)) === $hariIni;
                    });
                });

                $sudahAbsenHariIni = $absensiHariIni->isNotEmpty();
            @endphp

            @section('heading')
                <div class="py-3 mb-3">
                    <h1 class="fw-bold text-dark mb-0">Data Absensi {{ $kelas->nama_kelas }}</h1>
                </div>
            @endsection


            <div class="row">
                @if ($sudahAbsenHariIni)
                    @section('action-buttons')
                        <a href="{{ route('absensi.edit', $kelas->id) }}"
                            class="btn btn-success position-fixed bottom-0 end-0 m-4 shadow rounded-circle d-flex align-items-center justify-content-center"
                            type="button" style="z-index: 1050; width: 56px; height: 56px;">
                            <i class="ti ti-pencil" style="font-size: 30px"></i>
                        </a>
                    @endsection

                    @foreach ($absensiHariIni as $data_absensi)
                        <div class="col-md-4 col-sm-12 mb-3">
                            <div class="card shadow-md h-100">
                                <div class="card-body">
                                    <div class="text-center text-muted small mb-1">#{{ $loop->iteration }}</div>
                                    <h3 class="text-center fw-bold fs-5 mb-3 text-dark">
                                        {{ $data_absensi->siswa->nama_lengkap }}
                                    </h3>

                                    @php
                                        $statusClasses = [
                                            'Hadir' => 'text-bg-success',
                                            'Izin' => 'text-bg-warning',
                                            'Sakit' => 'text-bg-info',
                                            'Alpa' => 'text-bg-danger',
                                        ];
                                        $class = $statusClasses[$data_absensi->status] ?? 'text-bg-secondary';
                                    @endphp

                                    <span
                                        class="d-flex justify-content-center align-items-center badge {{ $class }} fs-5 py-2 mb-3">
                                        {{ $data_absensi->status }}
                                    </span>

                                    <h5 class="fs-6 text-muted text-center {{ $data_absensi->keterangan ? '' : 'd-none' }}">
                                        <strong>Keterangan:</strong> {{ $data_absensi->keterangan }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="alert alert-warning shadow-sm py-4 fs-4 text-center">
                            <strong>Data Absensi Kosong!</strong> Silakan isi formulir absensi terlebih dahulu dengan
                            menekan tombol "+" di bawah.
                        </div>
                    </div>

                    @section('action-buttons')
                        <a href="{{ route('absensi.create', $kelas->id) }}"
                            class="btn btn-success position-fixed bottom-0 end-0 m-4 shadow rounded-circle d-flex align-items-center justify-content-center"
                            type="button" style="z-index: 1050; width: 56px; height: 56px;">
                            <i class="ti ti-plus" style="font-size: 30px"></i>
                        </a>
                    @endsection
                @endif
            </div>

        @empty
            <div class="row">
                <div class="col-12 mb-3">
                    <h1 class="fw-bold text-dark">Silakan Pilih Kelas untuk Mulai Presensi:</h1>
                    <h6 class="text-muted fw-light">Klik salah satu kelas di bawah ini untuk membuka lembar absensi.</h6>
                </div>

                @foreach ($semua_kelas as $k)
                    @php
                        $hariIni = date('Y-m-d');
                        $sudahAbsenFallback = $k->siswa
                            ->flatMap(function ($s) use ($hariIni) {
                                return $s->absensi->filter(function ($a) use ($hariIni) {
                                    return date('Y-m-d', strtotime($a->created_at)) === $hariIni;
                                });
                            })
                            ->isNotEmpty();
                    @endphp

                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm border-light">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="fw-bold mb-0">{{ $k->nama_kelas }}</h4>
                                </div>
                                <a href="{{ route('absensi.index', $k->id) }}"
                                    class="btn btn-outline-primary btn-xs">Pilih</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforelse
    @endsection

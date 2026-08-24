@extends('layouts.dashboard')
@section('header')
    Beranda
@endsection

@section('basic-statistics-section')
    <section class="row g-3 mt-1 mb-3" aria-label="Dashboard metrics">
        <div class="col-12 col-sm-6 col-xl-6">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Alpa Hari Ini</span>
                    <span class="metric-icon">
                        <i class="ti ti-user-x" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value">{{ $totalAlpa }} Orang</div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-6">
            <article class="metric-card metric-danger">
                <div class="metric-top">
                    <span class="metric-label">Siswa Perlu Perhatian</span>
                    <span class="metric-icon">
                        <i class="ti ti-alert-triangle" aria-hidden="true"></i>
                    </span>
                </div>
                <div class="metric-value">{{ $siswaAlpa->count() }} Orang</div>
            </article>
        </div>
    </section>
@endsection

@section('charts-section')
    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title">
                    <i class="ti ti-user-x" aria-hidden="true"></i>
                    <span>Siswa Perlu Perhatian</span>
                </h2>
                <p class="text-muted mb-0">Data siswa yang memiliki total alpa lebih dari 3 kali.</p>
            </div>
            <input class="form-control form-control-sm table-search" type="search" placeholder="Cari siswa..."
                data-table-search="tabelAbsensi" aria-label="Cari siswa...">
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" id="tabelAbsensi" data-searchable-table>
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Siswa</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Total Alpa</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($siswaAlpa as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $siswa->nama_lengkap }}</td>
                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                            <td>{{ $siswa->absensi_count }} Hari</td>
                            <td>
                                <a href="{{ route('bk.histori_absensi', $siswa->id) }}" class="btn btn-light btn-sm"
                                    type="button">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <div class="alert alert-info mt-3">
                            <div class="d-flex align-items-center">
                                <i class="ti ti-info-circle fs-4 me-1"></i>
                                <h6>Tidak ada siswa dengan riwayat Alpa 3 kali atau lebih.</h6>
                            </div>
                        </div>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

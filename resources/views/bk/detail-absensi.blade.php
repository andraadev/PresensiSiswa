@extends('layouts.default_layout')
@section('title')
    Riwayat Absensi Siswa
@endsection

@section('stats-cards')
    <div class="card card-body mb-3">
        <div class="row">
            <div class="col-sm-12 col-md-9">
                <h5 class="mb-2">{{ $siswa->nama_lengkap }}</h5>
                <small class="text-muted">
                    Kelas: {{ $siswa->kelas->nama_kelas }} |
                    NISN: {{ $siswa->nisn }} |
                    Status: <span class="badge text-bg-success">{{ $siswa->status }}</span> |
                    No.Telepon: {{ $siswa->no_telepon }}
                </small>
            </div>
            <div class="col-sm-12 col-md-3">
                <a href="#" class="btn btn-primary btn-sm mb-3">
                    <i class="ti ti-plus"></i>
                    Catat Penanganan BK
                </a>
                <a href="#" class="btn btn-success btn-sm">
                    <i class="ti ti-brand-whatsapp"></i>
                    Chat Ortu via WA
                </a>
            </div>
        </div>

    </div>
    <div class="row mb-3">
        <div class="col-sm-12 col-md-3 col-xl-3">
            <div class="card card-body text-center border-0 border-start border-4 border-primary">
                <h5 class="fw-normal">Total Hadir</h5>
                <p class="fs-5 fw-bolder">{{ $summary->hadir }} Hari</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-3 col-xl-3">
            <div class="card card-body text-center border-0 border-start border-4 border-warning">
                <h5 class="fw-normal">Total Sakit</h5>
                <p class="fs-5 fw-bolder">{{ $summary->sakit }} Hari</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-3 col-xl-3">
            <div class="card card-body text-center border-0 border-start border-4 border-info">
                <h5 class="fw-normal">Total Izin</h5>
                <p class="fs-5 fw-bolder">{{ $summary->izin }} Hari</p>
            </div>
        </div>
        <div class="col-sm-12 col-md-3 col-xl-3">
            <div class="card card-body text-center border-0 border-start border-4 border-danger">
                <h5 class="fw-normal">Total Alpa</h5>
                <p class="fs-5 fw-bolder">{{ $summary->alpa }} Hari</p>
                <small class="text-muted">
                    Terakhir:
                    {{ \Carbon\Carbon::parse($summary->alpa_terakhir)->translatedFormat('d F') }}
                </small>
            </div>
        </div>
    </div>
@endsection

@section('action-buttons')
    <a href="{{ route('guru.data_absensi') }}" class="btn btn-outline-secondary btn-sm">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
@endsection

@section('filter-form')
    <form action="{{ route('data_absensi.detail', $siswa->id) }}" method="GET" id="filterForm"
        class="d-flex flex-column flex-md-row gap-2 align-items-md-end mb-3">
        <div class="flex-fill">
            <label class="form-label mb-0">Mulai:</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        </div>
        <div class="flex-fill">
            <label class="form-label mb-0">Selesai:</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
        </div>
        <div class="align-self-end">
            <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Filter</button>
            @if (request()->has('tanggal_mulai') || request()->has('tanggal_selesai'))
                <a href="{{ route('data_absensi.detail', $siswa->id) }}" class="btn btn-secondary">Reset</a>
            @endif
        </div>
    </form>
@endsection

@section('content')
    <table class="table" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Status</th>
                <th scope="col">Keterangan/Catatan</th>
                <th scope="col">Guru Pengabsen</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayatAbsensi as $data_absensi)
                @php
                    $statusClasses = [
                        'Hadir' => 'text-bg-success',
                        'Izin' => 'text-bg-warning',
                        'Sakit' => 'text-bg-info',
                        'Alpa' => 'text-bg-danger',
                    ];
                    $class = $statusClasses[$data_absensi->status] ?? 'text-bg-secondary';
                @endphp
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ \Carbon\Carbon::parse($data_absensi->tanggal_absensi)->translatedFormat('l, d F Y') }}</td>
                    <td>
                        <span class="badge {{ $class }}">
                            {{ $data_absensi->status }}
                        </span>
                    </td>
                    <td>{{ $data_absensi->keterangan ?? '-' }} </td>
                    <td>{{ $data_absensi->user->nama_lengkap }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('additional_js')
    <script>
        const form = document.querySelector("#filterForm");
        const submitBtn = document.querySelector("#filterBtn");

        form.addEventListener("change", () => {
            // Check if there is an input in the form that has a value
            let hasValue = Array.from(form.querySelectorAll("input, select"))
                .some(el => el.value.trim() !== "");

            // The button will return to disabled if the value returns empty
            submitBtn.disabled = !hasValue;
        });
    </script>
@endsection

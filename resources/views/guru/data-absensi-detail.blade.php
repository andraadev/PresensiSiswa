@extends('layouts.default_layout')
@section('title')
    Riwayat Absensi Siswa
@endsection

@section('action-buttons')
    <a href="{{ route('guru.data_absensi') }}" class="btn btn-outline-secondary btn-sm">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
@endsection

@section('filter-form')
    <div class="card card-body mb-3">
        <h5 class="mb-0">{{ $siswa->nama_lengkap }}</h5>
        <small class="text-muted">
            Kelas: {{ $siswa->kelas->nama_kelas }} |
            NISN: {{ $siswa->nisn }} |
            Status: <span class="badge text-bg-success">Aktif</span>
        </small>
        {{-- <div>
                    <span class="badge text-bg-primary">Total Hadir: 20</span>
                </div> --}}
    </div>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat_absensi as $data_absensi)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ \Carbon\Carbon::parse($data_absensi->created_at)->translatedFormat('l, d F Y') }}</td>
                    <td>{{ $data_absensi->status }}</td>
                    <td>{{ $data_absensi->keterangan ?? '-' }} </td>
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

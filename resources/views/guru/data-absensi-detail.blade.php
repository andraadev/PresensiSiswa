@extends('layouts.default_layout')
@section('title')
    Riwayat Absensi {{ $siswa->nama_lengkap }} {{ $siswa->kelas->nama_kelas }}
@endsection

{{-- @section('heading')
    Riwayat Absensi: nama kelas
@endsection --}}
@section('content')
@section('action-buttons')
    <a href="{{ route('guru.data_absensi') }}" class="btn btn-secondary mb-3">
        Kembali ke data absensi
    </a>
    <form action="{{ route('data_absensi.detail', $siswa->id) }}" method="GET" class="d-flex gap-2 align-items-center mb-3">
        <div>
            <label class="form-label mb-0">Mulai:</label>
            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
        </div>
        <div>
            <label class="form-label mb-0">Selesai:</label>
            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
        </div>
        <div class="align-self-end">
            <button type="submit" class="btn btn-primary">Terapkan</button>
            @if (request()->has('tanggal_mulai') || request()->has('tanggal_selesai'))
                <a href="{{ route('data_absensi.detail', $siswa->id) }}" class="btn btn-secondary">Reset</a>
            @endif
        </div>
    </form>
@endsection
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

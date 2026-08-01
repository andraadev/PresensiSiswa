@extends('layouts.default_layout')

@php
    $prefix = request()->segment(1); // 'admin', 'guru', atau 'bk'
    // dd($prefix);
@endphp

@section('title')
    Data Absensi
@endsection

@section('heading')
    Data Absensi
@endsection

@section('content')
@section('action-buttons')
    <form action="{{ route($prefix . '.data_absensi.filter') }}" method="get" id="filterForm"
        class="d-flex gap-2 align-items-center mb-3">
        <div class="">
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control">
        </div>
        <div class="">
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control">
        </div>
        <div class="">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select">
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $data_kelas)
                    <option value="{{ $data_kelas->id }}">{{ $data_kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div class="align-self-end">
            @if (request()->has('tanggal_mulai') || request()->has('tanggal_selesai') || request()->has('kelas_id'))
                <a href="{{ route('data_absensi') }}" class="btn btn-danger">Reset Filter</a>
            @endif
            <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Simpan</button>
        </div>
    </form>
@endsection

<table class="table" id="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">NISN</th>
            <th scope="col">Nama Siswa</th>
            <th scope="col">Kelas</th>
            <th scope="col">Status</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Guru Pengabsen</th>
            <th scope="col">Tanggal Absen</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($absensi as $data_absensi)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $data_absensi->siswa->nisn }}</td>
                <td>{{ $data_absensi->siswa->nama_lengkap }}</td>
                <td>{{ $data_absensi->kelas->nama_kelas }}</td>
                <td>{{ $data_absensi->status }}</td>
                <td>{{ $data_absensi->keterangan !== null ? $data_absensi->keterangan : '-' }} </td>
                <td>{{ $data_absensi->user->nama_lengkap }}</td>
                <td>{{ $data_absensi->created_at }}</td>
                {{-- <td>{{ $data_absensi->created_at->format('d F Y') }}</td> --}}
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

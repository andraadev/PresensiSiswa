@extends('layouts.default_layout')

@php
    $prefix = request()->segment(1); // 'admin', 'guru', atau 'bk'
    // dd($prefix);
@endphp

@section('title')
    Rekapitulasi Absensi
@endsection

@section('heading')
    Rekapitulasi Absensi
@endsection
@section('filter-form')
    <form action="{{ route($prefix . '.rekapitulasi') }}" method="get" id="filterForm"
        class="d-flex gap-2 align-items-center mb-3">
        <div>
            <label class="form-label">Bulan</label>
            <input type="month" name="bulan" class="form-control" value="{{ request('bulan', date('Y-m')) }}">
        </div>
        <div class="">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select">
                <option value="">Pilih Kelas</option>
                @foreach ($kelas as $data_kelas)
                    <option value="{{ $data_kelas->id }}" {{ request('kelas_id') == $data_kelas->id ? 'selected' : '' }}>
                        {{ $data_kelas->nama_kelas }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="form-label">Status Siswa</label>
            <select name="status" id="status" class="form-select">
                <option value="Semua" {{ request('status', 'Semua') == 'Semua' ? 'selected' : '' }}>Semua</option>
                <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Lulus" {{ request('status') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                <option value="Mutasi" {{ request('status') == 'Mutasi' ? 'selected' : '' }}>Mutasi</option>
                <option value="Keluar" {{ request('status') == 'Keluar' ? 'selected' : '' }}>Keluar</option>
            </select>
        </div>
        <div class="align-self-end">
            @if (request()->has('bulan') || request()->has('kelas_id'))
                <a href="{{ route($prefix . '.rekapitulasi') }}" class="btn btn-danger">Reset Filter</a>
            @endif
            <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Simpan</button>
        </div>
    </form>
@endsection
@section('content')
    <table class="table" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Kelas</th>
                <th scope="col">Hadir</th>
                <th scope="col">Sakit</th>
                <th scope="col">Izin</th>
                <th scope="col">Alpa</th>
                <th scope="col">% Hadir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $s)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $s->nisn }}</td>
                    <td>{{ $s->nama_lengkap }}</td>
                    <td>{{ $s->kelas->nama_kelas }}</td>
                    <td>{{ $s->total_hadir }}</td>
                    <td>{{ $s->total_sakit }}</td>
                    <td>{{ $s->total_izin }}</td>
                    <td>{{ $s->total_alpa }}</td>
                    <td>{{ $s->persen_hadir }}%</td>
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

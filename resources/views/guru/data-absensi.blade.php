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
    @if ($siswa->sum(fn($s) => $s->total_hadir + $s->total_sakit + $s->total_izin + $s->total_alpa) === 0)
        <div class="alert alert-info">
            Belum ada sesi presensi yang dicatatkan untuk bulan {{ request('bulan') ?? date('F Y') }}.
        </div>
    @endif
@section('action-buttons')
    <form action="{{ route('guru.data_absensi') }}" method="get" id="filterForm" class="d-flex gap-2 align-items-center mb-3">
        <div>
            <label class="form-label">Bulan</label>
            <input type="month" name="bulan" class="form-control" value="{{ request('bulan', date('Y-m')) }}">
        </div>
        <div class="align-self-end">
            @if (request()->has('bulan'))
                <a href="{{ route('guru.data_absensi') }}" class="btn btn-danger">
                    Reset Filter
                </a>
            @endif
            <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Terapkan</button>
        </div>
    </form>
@endsection



<table class="table" id="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">NISN</th>
            <th scope="col">Nama Siswa</th>
            <th scope="col">Hadir</th>
            <th scope="col">Sakit</th>
            <th scope="col">Izin</th>
            <th scope="col">Alpa</th>
            <th scope="col">% Hadir</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $s)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->nama_lengkap }}</td>
                <td>{{ $s->total_hadir }}</td>
                <td>{{ $s->total_sakit }}</td>
                <td>{{ $s->total_izin }}</td>
                <td>{{ $s->total_alpa }}</td>
                <td>{{ $s->persen_hadir }}%</td>
                <td>
                    <a href="{{ route('data_absensi.detail', $s->id) }}" class="btn btn-primary">Detail</a>
                </td>
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

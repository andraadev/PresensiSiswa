@extends('layouts.default_layout')

@php
    $prefix = request()->segment(1); // 'admin', 'guru', atau 'bk'
@endphp

@section('title')
    Data Absensi
@endsection

@section('heading')
    Data Absensi
@endsection

@section('filter-form')
    <form action="{{ route('guru.data_absensi') }}" method="get" id="filterForm"
        class="d-flex flex-column flex-md-row gap-2 align-items-md-end mb-3">
        <div class="flex-fill">
            <label class="form-label">Bulan</label>
            <input type="month" name="bulan" class="form-control" value="{{ request('bulan', date('Y-m')) }}">
        </div>
        <div class="flex-fill">
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
            @if (request()->has('bulan'))
                <a href="{{ route('guru.data_absensi') }}" class="btn btn-danger">
                    Reset Filter
                </a>
            @endif
            <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Filter</button>
        </div>
    </form>
@endsection

@section('content')
    @if ($siswa->sum(fn($s) => $s->total_hadir + $s->total_sakit + $s->total_izin + $s->total_alpa) === 0)
        <div class="alert alert-info">
            Belum ada sesi presensi yang dicatatkan untuk bulan {{ request('bulan') ?? date('F Y') }}.
        </div>
    @endif




    <table class="table" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">NISN</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Status</th>
                <th scope="col">Hadir</th>
                <th scope="col">Sakit</th>
                <th scope="col">Izin</th>
                <th scope="col">Alpa</th>
                <th scope="col">% Hadir</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $index => $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->nisn }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>
                        @switch($item->status)
                            @case('Aktif')
                                <span class="badge text-bg-success">Aktif</span>
                            @break

                            @case('Lulus')
                                <span class="badge text-bg-primary">Lulus</span>
                            @break

                            @case('Mutasi')
                                <span class="badge text-bg-info">Mutasi</span>
                            @break

                            @case('Keluar')
                                <span class="badge text-bg-danger">Keluar</span>
                            @break
                        @endswitch
                    </td>
                    <td>{{ $item->total_hadir }}</td>
                    <td>{{ $item->total_sakit }}</td>
                    <td>{{ $item->total_izin }}</td>
                    <td>{{ $item->total_alpa }}</td>
                    <td>{{ $item->persen_hadir }}%</td>
                    <td>
                        <a href="{{ route('data_absensi.detail', $item->id) }}" class="btn btn-primary">Detail</a>
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

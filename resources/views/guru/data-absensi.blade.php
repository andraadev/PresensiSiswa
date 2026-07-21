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
        <div>
            <label class="form-label">Tanggal Mulai</label>
            <input type="date" name="tanggal_mulai" class="form-control">
        </div>
        <div>
            <label class="form-label">Tanggal Selesai</label>
            <input type="date" name="tanggal_selesai" class="form-control">
        </div>
        <div class="align-self-end">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
            <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Terapkan</button>
        </div>
    </form>

    @if (request()->has('tanggal_mulai') || request()->has('tanggal_selesai') || request()->has('kelas_id'))
        <a href="{{ route('data_absensi') }}" class="btn btn-danger">
            Reset Filter
        </a>
    @endif


    <!-- Modal Filter -->
    {{-- <div class="modal fade" id="filter" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Filter...</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        Untuk memfilter data, isi minimal satu kolom di bawah.
                    </div>
                    <form action="{{ route($prefix . '.data_absensi.filter') }}" method="get" id="filterForm">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">Pilih</option>
                                @foreach ($kelas as $data_kelas)
                                    <option value="{{ $data_kelas->id }}">{{ $data_kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="filterBtn" disabled>Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div> --}}
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

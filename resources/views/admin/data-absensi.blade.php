@extends('layouts.default_layout')

@section('title')
    Data Absensi
@endsection

@section('heading')
    Data Absensi
@endsection

@section('content')
@section('action-buttons')
    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#filter">
        Filter
    </button>
    <!-- Modal Filter -->
    <div class="modal fade" id="filter" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Filter...</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Batal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.data_absensi.filter')}}" method="post">
                        @csrf
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
                                @foreach ($kelas as $data_kelas)
                                    <option value="{{ $data_kelas->id }}">{{ $data_kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
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

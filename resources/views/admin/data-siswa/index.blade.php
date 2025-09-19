@extends('layouts.default_layout')

@section('title')
    Data Siswa
@endsection

@section('content')
@section('action-buttons')
    <a href="{{ route('data-siswa.create') }}" class="btn btn-primary">Tambah</a>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import_excel">Import</button>
    <!-- Modal Tambah Data Guru dengan File Excel -->
    <div class="modal fade" id="import_excel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Data Siswa dengan File Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.data_siswa.import_excel') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <ol class="mb-2">
                            <li>
                                <b>Pastikan</b> jumlah kolom pada file excel yang kamu upload sama dengan yang ada di
                                <i>database</i>
                            </li>
                            <li><b>Pastikan</b> tabel kelas telah diisi dan tidak ada data duplikat</li>
                            <li>
                                Unduh Template Excel
                                <a href="{{ asset('template_excel/data-siswa.xlsx') }}"> Disini</a>
                            </li>
                        </ol>

                        <label class="form-label">Pilih File Excel(.xlsx)</label>
                        <input type="file" name="file" class="form-control" accept=".xlsx, .xls">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

<table class="table" id="table">
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Kelas</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $datasiswa)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $datasiswa->nisn }}</td>
                <td>{{ $datasiswa->nama_lengkap }}</td>
                <td>{{ $datasiswa->jenis_kelamin }}</td>
                <td>{{ $datasiswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $datasiswa->no_telepon }}</td>
                <td>
                    <a href="{{ route('data-siswa.edit', $datasiswa->id) }}" class="btn btn-warning">Edit</a>
                   <form action="{{ route('data-siswa.destroy', $datasiswa->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Apakah anda yakin ingin menghapus data dengan nama {{ $datasiswa->nama_lengkap }} ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

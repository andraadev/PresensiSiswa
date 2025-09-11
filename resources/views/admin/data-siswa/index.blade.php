@extends('layouts.default_layout')

@section('title')
    Data Siswa
@endsection

@section('heading')
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
                    <button class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#edit_siswa{{ $datasiswa->id }}">
                        Edit
                    </button>
                    <form action="{{ route('data-siswa.destroy', $datasiswa->id) }}" method="post"
                        style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger show-alert-delete-box">
                            Hapus
                        </button>
                    </form>
                </td>
                <!-- Modal -->
                <div class="modal fade" id="edit_siswa{{ $datasiswa->id }}" tabindex="-1"
                    aria-labelledby="tambah_data_siswa" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="tambah_data_siswa">Edit Data Siswa</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('data-siswa.update', $datasiswa->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label class="form-label">NISN</label>
                                        <input type="number" class="form-control" name="nisn"
                                            value="{{ $datasiswa->nisn }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="nama_lengkap" class="form-control" name="nama_lengkap"
                                            value="{{ $datasiswa->nama_lengkap }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin</label>
                                        <br>
                                        <input type="radio" name="jenis_kelamin" id="checkbox_l" value="laki-laki"
                                            class="form-check-input"
                                            {{ $datasiswa->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                                        <label for="checkbox_l">Laki-laki</label><br>

                                        <input type="radio" name="jenis_kelamin" id="checkbox_p" value="perempuan"
                                            class="form-check-input"
                                            {{ $datasiswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                        <label for="checkbox_p">Perempuan</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kelas</label>
                                        <select name="kelas" class="form-select">
                                            @foreach ($kelas as $data_kelas)
                                                @if ($data_kelas->id === $datasiswa->kelas_id)
                                                    <option value="{{ $data_kelas->id }}" selected>
                                                        {{ $data_kelas->nama_kelas }}</option>
                                                @else
                                                    <option value="{{ $data_kelas->id }}">
                                                        {{ $data_kelas->nama_kelas }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" name="no_telepon"
                                            value="{{ $datasiswa->no_telepon }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

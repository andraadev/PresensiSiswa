@extends('layouts.default_layout')

@section('title')
    Data Guru
@endsection

@section('heading')
    Data Guru
@endsection

@section('content')

@section('action-buttons')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah_guru">Tambah</button>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import_excel">Import</button>

    <!-- Modal Tambah Data Guru -->
    <div class="modal fade" id="tambah_guru" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Data Guru</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                        <i class="ti ti-point-filled"></i> {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('data-guru.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap"
                                    value="{{ old('nama_lengkap') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki"
                                        id="lk" checked>
                                    <label class="form-check-label" for="lk">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan"
                                        id="pr">
                                    <label class="form-check-label" for="pr">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor Telepon</label>
                                <input type="tel" name="no_telepon" class="form-control">
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
    </div>

    <!-- Modal Tambah Data Guru dengan File Excel -->
    <div class="modal fade" id="import_excel" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Tambah Data Guru dengan File Excel</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.data_guru.import_excel') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <ol class="mb-2">
                            <li>Pastikan jumlah kolom pada file excel yang kamu upload sama dengan yang ada di
                                <i>database</i>
                            </li>
                            <li>
                                <p>Unduh Template Excel
                                    <a href="{{ asset('template_excel/data-guru.xlsx') }}"> Disini</a>
                                </p>
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



{{-- Akhir Dari Modal Form Tambah Guru --}}
<table class="table" id="table">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIP</th>
            <th scope="col">Nama Lengkap</th>
            <th scope="col">Jenis Kelamin</th>
            <th scope="col">Nomor Telepon</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($guru as $data_guru)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $data_guru->nip }}</td>
                <td>{{ $data_guru->nama_lengkap }}</td>
                <td>{{ $data_guru->jenis_kelamin }}</td>
                <td>{{ $data_guru->no_telepon }}</td>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#edit_guru{{ $data_guru->id }}">Edit
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="edit_guru{{ $data_guru->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Guru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>
                                                        <i class="ti ti-point-filled"></i> {{ $error }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    <form action="{{ route('data-guru.update', $data_guru->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">NIP</label>
                                            <input type="text" class="form-control" name="nip"
                                                value="{{ $data_guru->nip }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama_lengkap"
                                                value="{{ $data_guru->nama_lengkap }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    value="Laki-laki" id="lkk"
                                                    {{ $data_guru->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="lkk">
                                                    Laki-laki
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin"
                                                    value="Perempuan" id="prr"
                                                    {{ $data_guru->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="prr">
                                                    Perempuan
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nomor Telepon</label>
                                            <input type="tel" name="no_telepon" class="form-control"
                                                value="{{ $data_guru->no_telepon }}">
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
                    <form action="{{ route('data-guru.destroy', $data_guru->id) }}" method="post"
                        style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger show-alert-delete-box">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

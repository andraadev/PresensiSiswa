@extends('layouts.default_layout')

@section('title')
    Data Guru
@endsection

@section('heading')
    Data Guru
@endsection

@section('content')

@section('action-buttons')
    <a href="{{ route('data-guru.create') }}" class="btn btn-primary">Tambah</a>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import_excel">Import</button>

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
                    <a href="#" type="button" class="btn btn-warning btn-edit">Edit</a>
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

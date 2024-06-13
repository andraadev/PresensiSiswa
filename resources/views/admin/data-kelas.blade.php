@extends('layouts.default_layout')

@section('title')
    Data Kelas
@endsection

@section('heading')
    Data Kelas
@endsection

@section('content')
    <button class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#tambah_kelas">Tambah</button>
    <!-- Modal -->
    <div class="modal fade" id="tambah_kelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('data-kelas.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text" class="form-control" name="nama_kelas" value="{{ old('nama_kelas') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Wali Kelas</label>
                            <select name="guru_id" class="form-select">
                                @foreach ($guru as $data_guru)
                                    <option value="{{ $data_guru->id }}">{{ $data_guru->nama_lengkap }}</option>
                                @endforeach
                            </select>
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
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Slug Kelas</th>
                <th scope="col">Nama Kelas</th>
                <th scope="col">Qr Code</th>
                <th scope="col">Nama Wali Kelas</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas as $data_kelas)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data_kelas->slug_kelas }}</td>
                    <td>{{ $data_kelas->nama_kelas }}</td>
                    <td>
                        <img src="/storage{{ $data_kelas->qr_code }}" alt="QR Code Kelas {{ $data_kelas->nama_kelas }}">
                    </td>
                    <td>{{ $data_kelas->guru->nama_lengkap }}</td>
                    <td>
                        <a href="{{ route('admin.data_kelas.download_qr', $data_kelas->id) }}" class="btn btn-success">
                            Simpan QR
                        </a>
                        <button class="btn btn-warning" data-bs-toggle="modal"
                            data-bs-target="#update_kelas{{ $data_kelas->id }}">
                            Edit
                        </button>
                        <form action="{{ route('data-kelas.destroy', $data_kelas->id) }}" method="post"
                            style="display: inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger show-alert-delete-box">Hapus</button>
                        </form>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="update_kelas{{ $data_kelas->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Kelas</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('data-kelas.update', $data_kelas->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">Nama Kelas</label>
                                            <input type="text" class="form-control" name="nama_kelas"
                                                value="{{ $data_kelas->nama_kelas }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Wali Kelas</label>
                                            <select name="guru_id" class="form-select">
                                                @foreach ($guru as $data_guru)
                                                    <option value="{{ $data_guru->id }}"
                                                        {{ $data_guru->id == $data_kelas->guru_id ? 'selected' : '' }}>
                                                        {{ $data_guru->nama_lengkap }}
                                                    </option>
                                                @endforeach
                                            </select>
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

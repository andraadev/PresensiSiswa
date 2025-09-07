@extends('layouts.form')

@section('title')
    Tambah Data Guru
@endsection

@section('heading')
    Tambah Data Guru
@endsection

@section('action-buttons')
    <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
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
    <form action="{{ route('data-guru.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" id="lk"
                        checked>
                    <label class="form-check-label" for="lk">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan" id="pr">
                    <label class="form-check-label" for="pr">Perempuan</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="no_telepon" class="form-control">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

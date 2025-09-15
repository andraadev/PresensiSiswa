@extends('layouts.form')

@section('title')
    Edit Data Guru
@endsection

@section('heading')
    Edit Data Guru
@endsection

@section('action-buttons')
    <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <x-alert-error/>
    <form action="{{ route('data-guru.update', $guru->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">NIP</label>
            <input type="text" class="form-control" name="nip" value="{{ $guru->nip }}" maxlength="18"
                pattern="[0-9]{18}" id="nip" data-counter="nipCounter">
            <small class="counter"></small>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="{{ $guru->nama_lengkap }}" 
            maxlength="100" id="nama_lengkap" data-counter="namaCounter">
            <small class="counter"></small>
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" value="Laki-laki" id="lkk"
                    {{ $guru->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
                <label class="form-check-label" for="lkk">
                    Laki-laki
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="jenis_kelamin" value="Perempuan" id="prr"
                    {{ $guru->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
                <label class="form-check-label" for="prr">
                    Perempuan
                </label>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" name="no_telepon" class="form-control" value="{{ $guru->no_telepon }}" maxlength="13" 
            pattern="08[0-9]{10,11}$" id="no_telepon" data-counter="telpCounter">
            <small class="counter"></small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

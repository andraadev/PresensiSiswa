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
    <x-alert-error />
    <form action="{{ route('data-guru.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}" maxlength="18"
                    pattern="[0-9]{18}" placeholder="Contoh: 123456789012345678" id="nip" data-counter="nipCounter">
                <small class="counter"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    maxlength="100" placeholder="Contoh: John Doe" id="nip" data-counter="namaCounter">
                <small class="counter"></small>
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="checkbox_l" value="Laki-laki" class="form-check-input"
                        {{ old('jenis_kelamin', 'Laki-laki') == 'Laki-laki' ? 'checked' : '' }} checked>
                    <label for="checkbox_l">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="checkbox_p" value="Perempuan" class="form-check-input"
                        {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                    <label for="checkbox_p">Perempuan</label>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="no_telepon" class="form-control" maxlength="13" pattern="08[0-9]{10,11}$"
                    placeholder="Contoh: 08123456789" id="no_telepon" data-counter="telpCounter">
                <small class="counter"></small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

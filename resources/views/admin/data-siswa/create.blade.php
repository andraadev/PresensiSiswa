@extends('layouts.form')

@section('title')
    Tambah Data Siswa
@endsection

@section('heading')
    Tambah Data Siswa
@endsection

@section('action-buttons')
    <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <x-alert-error />
    <form action="{{ route('data-siswa.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">NISN</label>
            <input type="text" class="form-control" name="nisn" value="{{ old('nisn') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
        </div>
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
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select">
                @forelse ($kelas as $data_kelas)
                    <option value="{{ $data_kelas->id }}" {{ old('kelas_id') == $data_kelas->id ? 'selected' : '' }}>
                        {{ $data_kelas->nama_kelas }}
                    </option>
                @empty
                    <option>Data Kelas Kosong</option>
                @endforelse
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Nomor Telepon</label>
            <input type="tel" class="form-control" name="no_telepon" value="{{ old('no_telepon') }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

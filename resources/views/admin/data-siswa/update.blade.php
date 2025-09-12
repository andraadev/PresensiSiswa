@extends('layouts.form')

@section('title')
    Edit Data Siswa
@endsection

@section('heading')
    Edit Data Siswa
@endsection

@section('action-buttons')
    <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <x-alert-error />
    <form action="{{ route('data-siswa.update', $siswa->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">NISN</label>
            <input type="number" class="form-control" name="nisn" value="{{ $siswa->nisn }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="nama_lengkap" class="form-control" name="nama_lengkap" value="{{ $siswa->nama_lengkap }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <br>
            <input type="radio" name="jenis_kelamin" id="checkbox_l" value="Laki-laki" class="form-check-input"
                {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'checked' : '' }}>
            <label for="checkbox_l">Laki-laki</label><br>

            <input type="radio" name="jenis_kelamin" id="checkbox_p" value="Perempuan" class="form-check-input"
                {{ $siswa->jenis_kelamin == 'Perempuan' ? 'checked' : '' }}>
            <label for="checkbox_p">Perempuan</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Kelas</label>
            <select name="kelas_id" class="form-select">
                @foreach ($kelas as $data_kelas)
                    @if ($data_kelas->id === $siswa->kelas_id)
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
            <input type="tel" class="form-control" name="no_telepon" value="{{ $siswa->no_telepon }}">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

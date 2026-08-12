@extends('layouts.page')

@section('title')
    Tambah Data Guru
@endsection

@section('action-buttons')
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('data-guru.index') }}">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
@endsection

@section('content')
    <form action="{{ route('data-guru.store') }}" method="POST" class="panel needs-validation">
        @csrf
        <div class="row">
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}" maxlength="18"
                    pattern="[0-9]{18}" placeholder="Contoh: 123456789012345678" id="nip" data-counter="nipCounter"
                    required>
                <small class="counter"></small>
                @error('nip')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    maxlength="100" placeholder="Contoh: John Doe" id="nama_lengkap" data-counter="namaCounter" required>
                <small class="counter"></small>
                @error('nama_lengkap')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="checkbox_l" value="Laki-laki" class="form-check-input"
                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}>
                    <label for="checkbox_l">Laki-laki</label>
                </div>
                <div class="form-check">
                    <input type="radio" name="jenis_kelamin" id="checkbox_p" value="Perempuan" class="form-check-input"
                        {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}>
                    <label for="checkbox_p">Perempuan</label>
                </div>
                @error('jenis_kelamin')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="no_telepon" class="form-control" maxlength="13" pattern="08[0-9]{10,11}$"
                    placeholder="Contoh: 08123456789" id="no_telepon" data-counter="telpCounter" required>
                <small class="counter"></small>
                @error('no_telepon')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection

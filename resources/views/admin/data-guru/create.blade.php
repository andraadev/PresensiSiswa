@extends('layouts.form')

@section('title')
    Tambah Data Guru
@endsection

@section('action-buttons')
    <a href="{{ route('data-guru.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <div class="alert alert-info" role="alert">
       <strong>Petunjuk Pengisian: </strong>
        <ul class="mb-0 mt-2">
            <li><strong>NIP</strong>: Wajib 18 digit angka (contoh: 123456789012345678)</li>
            <li><strong>Nama Lengkap</strong>: Maksimal 100 karakter</li>
            <li><strong>Nomor Telepon</strong>: Wajib diawali 08, total 12-13 digit (contoh: 08123456789)</li>
        </ul>
    </div>
    <x-alert-error />
    <form action="{{ route('data-guru.store') }}" method="POST" class="add-data-form">
        @csrf
        <div class="row">
            <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" class="form-control" name="nip" value="{{ old('nip') }}" maxlength="18"
                    pattern="[0-9]{18}" placeholder="Contoh: 123456789012345678" id="nip" data-counter="nipCounter" required>
                <small class="counter"></small>
            </div>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                    maxlength="100" placeholder="Contoh: John Doe" id="nama_lengkap" data-counter="namaCounter" required>
                <small class="counter"></small>
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
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <input type="tel" name="no_telepon" class="form-control" maxlength="13" pattern="08[0-9]{10,11}$"
                    placeholder="Contoh: 08123456789" id="no_telepon" data-counter="telpCounter" required>
                <small class="counter"></small>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

<script>
    const form = document.querySelector(".add-data-form");
    const submitBtn = document.querySelector('button[type="submit"]');

    // Set initial state on first loading
    submitBtn.disabled = true;

    // Submit button will be disabled if form doesn't meet requirements
    form.addEventListener("input", () => {
       submitBtn.disabled = !form.checkValidity();
    });
</script>
@endsection

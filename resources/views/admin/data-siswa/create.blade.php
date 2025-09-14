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
    <div class="alert alert-info" role="alert">
        <ul class="mb-0">
            <li><strong>NISN</strong>: wajib 10 digit angka</li>
            <li><strong>Nama Lengkap</strong>: Maksimal 100 karakter</li>
            <li><strong>Nomor Telepon</strong>: wajib diawali dengan 08, hanya angka tanpa simbol</li>
        </ul>
    </div>

    <x-alert-error />
    <form action="{{ route('data-siswa.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">NISN</label>
            <input type="text" class="form-control" name="nisn" value="{{ old('nisn') }}" inputmode="numeric"
                pattern="[0-9]{10}" maxlength="10" id="nisn" data-counter="nisnCounter"
                placeholder="Contoh: 1234567890" required>
            <small class="counter"></small>
        </div>
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
            placeholder="Contoh: Jane Doe" maxlength="100" data-counter="namaCounter" required>
            <small class="counter"></small>
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
            <input type="tel" class="form-control" name="no_telepon" value="{{ old('no_telepon') }}"
                pattern="08[0-9]{10,11}$" maxlength="13" id="no_telepon" data-counter="telpCounter"
                placeholder="Contoh: 08123456789" required>
            <small class="counter"></small>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>

    <script>
        // Capture all inputs that have data counters
        document.querySelectorAll("input[data-counter]").forEach(input => {
            // Add an event listener when the input is filled in
            input.addEventListener("input", () => {
               // Take the counter element (small) that is after the input
                const counter = input.nextElementSibling;
                // Update character count display
                counter.textContent = `Panjang input: ${input.value.length}`;
            });
        });
    </script>
@endsection

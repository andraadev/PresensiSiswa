@extends('layouts.page')

@section('title')
    Tambah Data Siswa
@endsection

@push('additional_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('action-buttons')
    <a href="{{ route('data-siswa.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <div class="card card-body">
        <div class="alert alert-info d-flex gap-2 align-items-center" role="alert">
            <i class="ti ti-info-circle fs-5"></i>
            Pastikan kelas yang dipilih sudah tersedia. Jika belum ada, tambahkan melalui menu <a
                href="{{ route('data-kelas.index') }}" class="alert-link fw-bolder">Data Kelas</a> terlebih
            dahulu.
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
                <select name="kelas_id" id="select_kelas" class="form-select">
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
    </div>
@endsection

@push('additional_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/js/tom-select.complete.min.js"></script>
    <script>
        const guruTomSelect = new TomSelect('#select_kelas', {
            create: false,
            placeholder: '-- Pilih Kelas --',
        });
    </script>
@endpush

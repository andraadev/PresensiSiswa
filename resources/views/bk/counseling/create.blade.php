@extends('layouts.page')

@section('title')
    Tambah Data Konseling
@endsection

@push('additional_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('action-buttons')
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('konseling.index') }}">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
@endsection

@section('content')
    <form action="{{ route('konseling.store') }}" method="POST" class="panel needs-validation">
        @csrf
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label" for="student_name">Nama Siswa</label>
                <select name="student_id" id="student_name" class="form-select" required>
                    @forelse ($student as $data)
                        <option value="">Cari Berdasarkan Nama/NISN...</option>
                        <option value="{{ $data->id }}" @selected(old('student_id') == $data->id)>{{ $data->nama_lengkap }}</option>
                    @empty
                        <option disabled>Data Siswa Belum Tersedia. Silakan Hubungi Admin</option>
                    @endforelse
                </select>
                @error('student_id')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label">Guru Penindak</label>
                <input type="text" class="form-control" name="nama_lengkap" value="{{ Auth::user()->nama_lengkap }}"
                    readonly>
                <input type="hidden" name="created_by" value="{{ Auth::user()->id }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label" id="action_date">Tanggal Penindakan</label>
                <input type="date" name="action_date" class="form-control @error('action_date') is-invalid @enderror"
                    id="action_date" value="{{ request('action_date', date('Y-m-d')) }}" required>
                @error('action_date')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label" for="action_type">Jenis Tindakan</label>
                <select name="action_type" id="action_type" class="form-select @error('action_type') is-invalid @enderror"
                    required>
                    <option value="">Pilih</option>
                    <option value="Konseling Individu" @selected(old('action_type') == 'Konseling Individu')>Konseling Individu</option>
                    <option value="Panggilan Orang Tua" @selected(old('action_type') == 'Panggilan Orang Tua')>Panggilan Orang Tua</option>
                    <option value="Kunjungan Rumah" @selected(old('action_type') == 'Kunjungan Rumah')>Kunjungan Rumah</option>
                    <option value="Peringatan Lisan" @selected(old('action_type') == 'Peringatan Lisan')>Peringatan Lisan</option>
                </select>
                @error('action_type')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label" for="problem_notes">Catatan Masalah</label>
                <textarea name="problem_notes" id="problem_notes" cols="30" rows="3"
                    class="form-control @error('problem_notes') is-invalid @enderror"
                    placeholder="Tuliskan masalah yang diidentifikasi/alasan penanganan disini..." required>{{ old('problem_notes') }}</textarea>
                @error('problem_notes')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label class="form-label" for="action_type">Hasil Kesepakatan</label>
                <textarea name="agreement_result" id="agreement_result" cols="30" rows="3"
                    class="form-control @error('agreement_result') is-invalid @enderror"
                    placeholder="Tuliskan solusi/tindak lanjut/komitmen siswa atau orang tua siswa disini..." required>{{ old('agreement_result') }}</textarea>
                @error('agreement_result')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Status</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status1" value="Belum Ditangani"
                    @checked(old('status', 'Belum Ditangani') == 'Belum Ditangani')>
                <label class="form-check-label" for="status1">
                    Belum Ditangani
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status2" value="Sedang Dipantau"
                    @checked(old('status') == 'Sedang Dipantau')>
                <label class="form-check-label" for="status2">
                    Sedang Dipantau
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="status" id="status3" value="Selesai"
                    @checked(old('status') == 'Selesai')>
                <label class="form-check-label" for="status3">
                    Selesai
                </label>
            </div>
            @error('status')
                <small class="text-danger d-block mt-1">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Tambah</button>
    </form>
@endsection

@push('additional_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/js/tom-select.complete.min.js"></script>
    <script>
        new TomSelect('#student_name', {
            create: false,
            placeholder: '-- Cari Berdasarkan Nama/NISN... --',
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">Data "' + escape(data.input) + '" tidak ditemukan</div>';
                }
            }
        });
    </script>
@endpush

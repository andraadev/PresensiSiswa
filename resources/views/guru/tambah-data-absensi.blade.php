@extends('layouts.page')

@section('title')
    Tambah Data Absensi
@endsection

@section('action-buttons')
    <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary btn mb-3">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
@endsection

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (count($siswa) > 0)
            <form action="{{ route('absensi.store') }}" method="post">
                @csrf
                <div class="row">
                    <input type="hidden" name="guru_id" value="{{ Auth::user()->id }}">
                    @foreach ($siswa as $data_siswa)
                        <input type="hidden" name="kelas_id" value="{{ $data_siswa->kelas_id }}">
                        <div class="col-md-4 col-sm-12">
                            <div class="card shadow-md p-3">
                                <div class="card-body">
                                    <h1 class="text-center fw-bolder">{{ $loop->iteration }}</h1>
                                    <h3 class="text-center fw-bold">{{ $data_siswa->nama_lengkap }}</h3>

                                    <input type="hidden" name="siswa_id[]" value="{{ $data_siswa->id }}">
                                    <div class="btn-group btn-group-toggle d-flex justify-content-center mb-0"
                                        data-bs-toggle="buttons">
                                        <label class="btn btn-success">
                                            <input type="radio" name="status[{{ $data_siswa->id }}]" value="Hadir"
                                                checked>
                                            Hadir
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="status[{{ $data_siswa->id }}]" value="Sakit">Sakit
                                        </label>
                                        <label class="btn btn-warning">
                                            <input type="radio" name="status[{{ $data_siswa->id }}]" value="Izin">Izin
                                        </label>
                                        <label class="btn btn-danger">
                                            <input type="radio" name="status[{{ $data_siswa->id }}]" value="Alpa">Alpa
                                        </label>
                                    </div>
                                    <label class="form-label keterangan-label" data-id="{{ $data_siswa->id }}"
                                        style="display: none;">Keterangan...</label>
                                    <input type="text" name="keterangan[{{ $data_siswa->id }}]"
                                        class="form-control keterangan-input" data-id="{{ $data_siswa->id }}"
                                        style="display: none;">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="btn btn-primary mt-4">Simpan</button>
            </form>
    </div>
@else
    <div class="alert alert-warning">
        Data Siswa Kelas {{ $kelas->nama_kelas }} Belum Tersedia, Silakan Hubungi Admin
        untuk Menambahkan Data Siswa.
    </div>
    @endif
    </div>

@endsection

@push('additional_js')
    <script>
        $(document).ready(function() {
            $('input[type="radio"]').change(function() {
                var id = $(this).attr('name').match(/\[(.*?)\]/)[1];
                var keteranganLabel = $('.keterangan-label[data-id="' + id + '"]');
                var keteranganInput = $('.keterangan-input[data-id="' + id + '"]');

                if ($(this).val() === 'Sakit' || $(this).val() === 'Izin') {
                    keteranganLabel.show();
                    keteranganInput.show();
                } else {
                    keteranganLabel.hide();
                    keteranganInput.hide();
                }
            });
        });
    </script>
@endpush

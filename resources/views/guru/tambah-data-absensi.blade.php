@extends('layouts.secondary_layout')

@section('title')
    Tambah Data Absensi
@endsection

@section('heading')
    Tambah Data Absensi
    <div id="spacer" class="mb-3"></div>
@endsection

@section('content')
    <div class="row">
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
            @foreach ($siswa as $data_siswa)
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-md container">
                        <div class="card-body">
                            <h1 class="text-center fw-bolder">{{ $data_siswa->id }}</h1>
                            <h3 class="text-center fw-bold">{{ $data_siswa->nama_lengkap }}</h3>
                            <form action="{{ route('absensi.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="guru_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="kelas_id" value="{{ $data_siswa->kelas_id }}">
                                <input type="hidden" name="siswa_id[]" value="{{ $data_siswa->id }}">
                                <div class="btn-group btn-group-toggle d-flex justify-content-center mb-2"
                                    data-bs-toggle="buttons">
                                    <label class="btn btn-success">
                                        <input type="radio" name="status[{{ $data_siswa->id }}]" value="Hadir" checked>
                                        Hadir
                                    </label>
                                    <label class="btn btn-secondary">
                                        <input type="radio" name="status[{{ $data_siswa->id }}]" value="Sakit"> Sakit
                                    </label>
                                    <label class="btn btn-warning">
                                        <input type="radio" name="status[{{ $data_siswa->id }}]" value="Izin"> Izin
                                    </label>
                                    <label class="btn btn-danger">
                                        <input type="radio" name="status[{{ $data_siswa->id }}]" value="Alpa"> Alpa
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
            <div class="row">
                <button type="submit" class="btn btn-primary col-2">Simpan</button>
            </div>
            </form>
        @else
            <div class="alert alert-warning">Data Siswa Kosong, Silakan Hubungi Admin untuk Menambahkan Data Siswa.</div>
        @endif
    </div>
@endsection

@section('additional_js')
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
@endsection

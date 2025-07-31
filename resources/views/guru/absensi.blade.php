@extends('layouts.secondary_layout')

@section('title')
    Absensi
@endsection

@section('heading')
    Absensi
    <div id="spacer" class="mb-3"></div>
@endsection

@section('content')
    <div class="row">
        @if (count($absensi) > 0)
            @foreach ($absensi as $data_absensi)
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-md container">
                        <div class="card-body">
                            <h1 class="text-center fw-bold">{{ $loop->iteration }}</h1>
                            <h3 class="text-center fw-bold">{{ $data_absensi->siswa->nama_lengkap }}</h3>
                            <h4 class="text-center">Status : {{ $data_absensi->status }}</h4>
                            <h4 class="text-center">Keterangan :
                                {{ $data_absensi->keterangan !== null ? $data_absensi->keterangan : '-' }}
                            </h4>
                            <form action="{{ route('absensi.update', $data_absensi->id) }}" method="post">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="siswa_id[]" value="{{ $data_absensi->id }}">
                                <details class="text-center">
                                    <summary>Ubah Status</summary>
                                    <div class="btn-group btn-group-toggle d-flex justify-content-center mb-2"
                                        data-bs-toggle="buttons">
                                        <label class="btn btn-success">
                                            <input type="radio" name="status[{{ $data_absensi->id }}]" value="Hadir"
                                                {{ $data_absensi->status == 'Hadir' ? 'checked' : '' }}> Hadir
                                        </label>
                                        <label class="btn btn-secondary">
                                            <input type="radio" name="status[{{ $data_absensi->id }}]" value="Sakit"
                                                {{ $data_absensi->status == 'Sakit' ? 'checked' : '' }}> Sakit
                                        </label>
                                        <label class="btn btn-warning">
                                            <input type="radio" name="status[{{ $data_absensi->id }}]" value="Izin"
                                                {{ $data_absensi->status == 'Izin' ? 'checked' : '' }}> Izin
                                        </label>
                                        <label class="btn btn-danger">
                                            <input type="radio" name="status[{{ $data_absensi->id }}]" value="Alpa"
                                                {{ $data_absensi->status == 'Alpa' ? 'checked' : '' }}> Alpa
                                        </label>
                                    </div>
                                    <label class="form-label keterangan-label">Keterangan...</label>
                                    <input type="text" name="keterangan[{{ $data_absensi->id }}]"
                                        class="form-control keterangan-input" value="{{ $data_absensi->keterangan }}">
                                </details>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <button type="submit" class="btn btn-primary col-2">Simpan</button>
            </div>
            </form>
        @else
            <div class="alert alert-warning">
                Data Absensi Kosong, Silakan Isi Formulir Absensi Terlebih Dahulu dengan Menekan Tombol "Absen" dibawah ini.
            </div>
        @endif
        <div class="{{ count($absensi) > 0 ? 'd-none' : 'd-block' }}">
            <a href="{{ route('absensi.create') }}" class="btn btn-primary d-grid p-3" style="font-size: 30px">Absen</a>
        </div>
    </div>
@endsection

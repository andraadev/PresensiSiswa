@extends('layouts.page')

@section('title')
    Edit Absensi
@endsection

@section('action-buttons')
    <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary btn mb-3">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Kembali
    </a>
@endsection

@section('content')
    <form action="{{ route('absensi.update', $kelas->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">

            @foreach ($daftar_siswa as $siswa)
                <div class="col-md-4 col-sm-12">
                    <div class="card mb-3 shadow-sm container">
                        <div class="card-body">
                            <h1 class="text-center fw-bolder">#{{ $loop->iteration }}</h1>
                            <h3 class="text-center fw-bold">{{ $siswa->nama_lengkap }}</h3>
                            <input type="hidden" name="siswa_id[]" value="{{ $siswa->id }}">

                            @php
                                $absenHariIni = $siswa->absensi->first();
                                $statusLama = $absenHariIni ? $absenHariIni->status : 'Hadir';
                                $showKeterangan = in_array($statusLama, ['Sakit', 'Izin']);
                            @endphp
                            <div class="btn-group btn-group-toggle d-flex justify-content-center mb-2"
                                data-bs-toggle="buttons">
                                <label class="btn btn-success {{ $statusLama == 'Hadir' ? 'active' : '' }}">
                                    <input type="radio" name="status[{{ $siswa->id }}]" value="Hadir"
                                        {{ $statusLama == 'Hadir' ? 'checked' : '' }}>
                                    Hadir
                                </label>
                                <label class="btn btn-secondary {{ $statusLama == 'Sakit' ? 'active' : '' }}">
                                    <input type="radio" name="status[{{ $siswa->id }}]" value="Sakit"
                                        {{ $statusLama == 'Sakit' ? 'checked' : '' }}> Sakit
                                </label>
                                <label class="btn btn-warning {{ $statusLama == 'Izin' ? 'active' : '' }}">
                                    <input type="radio" name="status[{{ $siswa->id }}]" value="Izin"
                                        {{ $statusLama == 'Izin' ? 'checked' : '' }}> Izin
                                </label>
                                <label class="btn btn-danger {{ $statusLama == 'Alpa' ? 'active' : '' }}">
                                    <input type="radio" name="status[{{ $siswa->id }}]" value="Alpa"
                                        {{ $statusLama == 'Alpa' ? 'checked' : '' }}> Alpa
                                </label>
                            </div>
                            <label class="form-label keterangan-label" data-id="{{ $siswa->id }}"
                                style="display: {{ $showKeterangan ? 'block' : 'none' }};">Keterangan...</label>
                            <input type="text" name="keterangan[{{ $siswa->id }}]"
                                class="form-control keterangan-input" data-id="{{ $siswa->id }}"
                                value="{{ $absenHariIni->keterangan ?? '' }}"
                                style="display:
                                {{ $showKeterangan ? 'block' : 'none' }};">
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
    </div>
@endsection
@push('additional_js')
    <script>
        $(document).ready(function() {
            function toggleKeterangan(radioElement) {
                var nameAttr = radioElement.attr('name');
                if (!nameAttr) return;

                var id = nameAttr.match(/\[(.*?)\]/)[1];
                var keteranganLabel = $('.keterangan-label[data-id="' + id + '"]');
                var keteranganInput = $('.keterangan-input[data-id="' + id + '"]');

                if (radioElement.val() === 'Sakit' || radioElement.val() === 'Izin') {
                    keteranganLabel.show();
                    keteranganInput.show();
                } else {
                    keteranganLabel.hide();
                    keteranganInput.hide();
                    if (radioElement.is(':checked')) {
                        // keteranganInput.val('');
                    }
                }
            }

            $('input[type="radio"]').change(function() {
                toggleKeterangan($(this));
            });

            $('input[type="radio"]:checked').each(function() {
                toggleKeterangan($(this));
            });
        });
    </script>
@endpush

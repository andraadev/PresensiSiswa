@extends('layouts.form')
{{-- {{ dd($absensi->first()?->siswa?->kelas_id ?? 'Aman, datanya gak ada yang cocok!') }} --}}
@section('title', 'Data Absensi')

@section('content')
    <div class="row">
        @if (count($absensi) > 0)
            @section('action-buttons')
                <a href="{{ route('absensi.edit', $absensi->first()->kelas_id) }}"
                    class="btn btn-success position-fixed bottom-0 end-0 m-4 shadow rounded-circle d-flex align-items-center justify-content-center"
                    type="button" style="z-index: 1050; width: 56px; height: 56px;">
                    <i class="ti ti-pencil" style="font-size: 30px"></i>
                </a>
            @endsection
            @foreach ($absensi as $data_absensi)
                <div class="col-md-4 col-sm-12">
                    <div class="card shadow-md container">
                        <div class="card-body">
                            <h1 class="text-center fw-bold">{{ $loop->iteration }}</h1>
                            <h3 class="text-center fw-bold">{{ $data_absensi->siswa->nama_lengkap }}</h3>
                            @php
                                $statusClasses = [
                                    'Hadir' => 'text-bg-success',
                                    'Izin' => 'text-bg-warning',
                                    'Sakit' => 'text-bg-info',
                                    'Alpa' => 'text-bg-danger',
                                ];
                                $class = $statusClasses[$data_absensi->status] ?? 'text-bg-secondary';
                            @endphp
                            <span
                                class="d-flex justify-content-center align-items-center badge {{ $class }} fs-4 mb-3">
                                {{ $data_absensi->status }}
                            </span>
                            <h4 class="{{ $data_absensi->keterangan ? '' : 'd-none' }}">Keterangan :
                                {{ $data_absensi->keterangan }}
                            </h4>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning">
                Data Absensi Kosong, Silakan Isi Formulir Absensi Terlebih Dahulu dengan Menekan Tombol "Absen" dibawah ini.
            </div>

            <a href="{{ route('absensi.create') }}"
                class="btn btn-success position-fixed bottom-0 end-0 m-4 shadow rounded-circle d-flex align-items-center justify-content-center"
                type="button" style="z-index: 1050; width: 56px; height: 56px;">
                <i class="ti ti-plus" style="font-size: 30px"></i>
            </a>
        @endif
    </div>
@endsection

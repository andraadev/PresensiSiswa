@extends('layouts.default_layout')

@section('title')
    Data Siswa
@endsection

@section('content')
@section('action-buttons')
    <a href="{{ route('data-siswa.create') }}" class="btn btn-primary">Tambah</a>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImportExcel">Import</button>

    <div class="modal fade" id="modalImportExcel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">
                        <i class="ti ti-file-import me-2"></i>
                        Import Data Siswa dari Excel
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.data_siswa.import_excel') }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="alert alert-info d-flex gap-2 align-items-center">
                            <i class="ti ti-info-circle fs-5"></i>
                            <span>Pastikan format kolom sesuai dengan template yang disediakan dan
                                <strong>tidak ada</strong> data duplikat.
                            </span>
                        </div>

                        <div class="mb-3">
                            <a href="{{ asset('template_excel/data-guru.xlsx') }}" class="btn btn-outline-primary">
                                <i class="ti ti-download me-1"></i>
                                Download Template Excel
                            </a>
                        </div>

                        <label class="form-label">Pilih File Excel(.xlsx)</label>

                        @if ($kelas->isEmpty())
                            <div class="alert alert-warning py-2 mb-2 d-flex align-items-center gap-2"
                                style="font-size: 0.9rem;">
                                <i class="ti ti-alert-circle"></i>
                                <span>Belum ada kelas.
                                    <a href="{{ route('data-kelas.index') }}" class="alert-link">Buat kelas</a> dulu.
                                </span>
                            </div>
                        @endif

                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror"
                            accept=".xlsx, .xls" required>
                        @error('file')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if (session()->has('import_failures') && session('import_failures')->isNotEmpty())
                            <div class="alert alert-warning mt-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-alert-triangle fs-4 me-2 text-warning"></i>
                                    <h6 class="mb-0 fw-bold">Proses Impor Selesai dengan Beberapa Catatan</h6>
                                </div>
                                <p class="small mb-2">
                                    Data yang valid telah berhasil disimpan ke database. Silakan perbaiki baris berikut pada
                                    file Excel Anda lalu unggah kembali:
                                </p>

                                <ul class="mb-0 ps-3" style="max-height: 180px; overflow-y: auto;">
                                    @foreach (session('import_failures') as $row => $failures)
                                        <li>
                                            <strong>Baris {{ $row }}</strong>
                                            <ul>
                                                @foreach ($failures as $failure)
                                                    @foreach ($failure->errors() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary d-inline-flex" data-bs-dismiss="modal">
                                <i class="ti ti-x me-1"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-1">
                                <i class="ti ti-upload"></i> Import Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<table class="table" id="table">
    <thead>
        <tr>
            <th>No</th>
            <th>NISN</th>
            <th>Nama Lengkap</th>
            <th>Jenis Kelamin</th>
            <th>Kelas</th>
            <th>No Telepon</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswa as $datasiswa)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $datasiswa->nisn }}</td>
                <td>{{ $datasiswa->nama_lengkap }}</td>
                <td>{{ $datasiswa->jenis_kelamin }}</td>
                <td>{{ $datasiswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $datasiswa->no_telepon }}</td>
                <td>
                    <a href="{{ route('data-siswa.edit', $datasiswa->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('data-siswa.destroy', $datasiswa->id) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Apakah anda yakin ingin menghapus data dengan nama {{ $datasiswa->nama_lengkap }} ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-delete">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('additional_js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session()->has('import_failures') && session('import_failures')->isNotEmpty())
            const modalTambah = new bootstrap.Modal(document.getElementById('modalImportExcel'));
            modalTambah.show();
        @endif
    });
</script>
@endsection

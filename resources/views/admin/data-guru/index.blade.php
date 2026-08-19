@extends('layouts.default_layout')

@section('title')
    Data Guru
@endsection

@section('action-buttons')
    <div class="heading-actions">
        <button class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#import_excel">
            <i class="ti ti-table-import" aria-hidden="true"></i> Import Excel
        </button>
        <a class="btn btn-primary btn-sm" href="{{ route('data-guru.create') }}">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah
        </a>
    </div>
    <div class="modal fade" id="import_excel" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="ti ti-file-import me-2"></i>
                        Import Data Guru dari Excel
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.data_guru.import_excel') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info d-flex gap-2 align-items-center">
                            <i class="ti ti-info-circle fs-5"></i>
                            <span>Pastikan format kolom sesuai dengan template yang disediakan</span>
                        </div>

                        <div class="mb-3">
                            <a href="{{ asset('template_excel/data-guru.xlsx') }}" class="btn btn-outline-primary">
                                <i class="ti ti-download me-1"></i>
                                Download Template Excel
                            </a>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label for="fileInput" class="form-label fw-bold">Pilih File Excel</label>
                            <input type="file" name="file" id="fileInput"
                                class="form-control @error('file') is-invalid @enderror" accept=".xlsx,.xls" required>
                        </div>

                        @error('file')
                            <small class="text-danger d-block mt-1">{{ $message }}</small>
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="ti ti-x me-1"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-upload me-1"></i> Import Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <table class="table" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">NIP</th>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Nomor Telepon</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($guru as $data_guru)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $data_guru->nip }}</td>
                    <td>{{ $data_guru->nama_lengkap }}</td>
                    <td>{{ $data_guru->jenis_kelamin }}</td>
                    <td>{{ $data_guru->no_telepon }}</td>
                    <td>
                        <span class="badge {{ $data_guru->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                            {{ $data_guru->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('data-guru.edit', $data_guru->id) }}" type="button"
                            class="btn btn-warning btn-sm btn-edit">
                            Edit
                        </a>
                        <form action="{{ route('data_guru.update_status', $data_guru->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PATCH')

                            @if ($data_guru->is_active)
                                <input type="hidden" name="is_active" value="0">
                                <button type="button" class="btn btn-danger btn-sm"
                                    data-nama="{{ $data_guru->nama_lengkap }}" data-active="true"
                                    onclick="confirmStatusChange(this)">
                                    Nonaktifkan
                                </button>
                            @else
                                <input type="hidden" name="is_active" value="1">
                                <button type="button" class="btn btn-success btn-sm"
                                    data-nama="{{ $data_guru->nama_lengkap }}" data-active="false"
                                    onclick="confirmStatusChange(this)">
                                    Aktifkan
                                </button>
                            @endif
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('additional_js')
    <script>
        function confirmStatusChange(button) {
            const form = button.closest('form');
            const nama = button.getAttribute('data-nama');
            const isActive = button.getAttribute('data-active') === 'true';

            Swal.fire({
                title: isActive ? 'Nonaktifkan Guru?' : 'Aktifkan Guru?',
                text: isActive ?
                    `Guru ${nama} akan dinonaktifkan dari sistem.` : `Guru ${nama} akan diaktifkan kembali.`,
                icon: isActive ? 'warning' : 'question',
                showCancelButton: true,
                background: window.getComputedStyle(document.body).getPropertyValue('--bs-body-bg'),
                color: window.getComputedStyle(document.body).getPropertyValue('--bs-body-color'),
                customClass: {
                    confirmButton: `btn ${isActive ? 'btn-danger' : 'btn-success'} btn-lg`,
                    cancelButton: 'btn btn-secondary btn-lg me-2'
                },
                buttonsStyling: false,
                confirmButtonText: isActive ? 'Ya, Nonaktifkan!' : 'Ya, Aktifkan!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            @if (session()->has('import_failures'))
                new bootstrap.Modal(document.getElementById('import_excel')).show();
            @endif
        });
    </script>
@endsection

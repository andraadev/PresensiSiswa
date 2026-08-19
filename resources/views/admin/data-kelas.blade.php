@extends('layouts.default_layout')

@section('title')
    Data Kelas
@endsection

@section('additional_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        .ts-dropdown {
            z-index: 1060 !important;
        }

        [data-bs-theme="dark"] .ts-dropdown {
            background-color: var(--bs-body-bg);
            color: var(--bs-body-color);
            border-color: var(--bs-border-color);
        }

        [data-bs-theme="dark"] .ts-dropdown .option {
            color: var(--bs-body-color);
        }

        [data-bs-theme="dark"] .ts-dropdown .option.active {
            background-color: var(--bs-secondary-bg);
            color: var(--bs-emphasis-color);
        }
    </style>
@endsection

@section('action-buttons')
    <div class="heading-actions">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah
        </button>
    </div>
    <div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('data-kelas.store') }}" method="post" class="needs-validation">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text"
                                class="form-control @error('nama_kelas', 'storeKelas') is-invalid @enderror"
                                name="nama_kelas" value="{{ old('nama_kelas') }}">
                            @error('nama_kelas', 'storeKelas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Wali Kelas</label>
                            <select name="guru_id" id="select_guru_tambah"
                                class="form-select @error('guru_id', 'storeKelas') is-invalid @enderror">
                                <option value="" selected disabled>Pilih atau cari guru...</option>
                                @foreach ($guru as $data_guru)
                                    <option value="{{ $data_guru->id }}">{{ $data_guru->nama_lengkap }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id', 'storeKelas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <table class="table table-hover" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Kelas</th>
                <th scope="col">Nama Wali Kelas</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kelas as $data_kelas)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data_kelas->nama_kelas }}</td>
                    <td>{{ $data_kelas->guru->nama_lengkap }}</td>
                    <td>
                        <a href="{{ route('admin.data_kelas.download_qr', $data_kelas->id) }}"
                            class="btn btn-success btn-sm">
                            Simpan QR
                        </a>
                        <button class="btn btn-warning btn-sm btn-edit-kelas" data-bs-toggle="modal"
                            data-bs-target="#modalEditKelas" data-id="{{ $data_kelas->id }}"
                            data-nama="{{ $data_kelas->nama_kelas }}" data-guru="{{ $data_kelas->guru_id }}">
                            Edit
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal -->
    <div class="modal fade" id="modalEditKelas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Data Kelas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditKelas" method="post" class="needs-validation">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas</label>
                            <input type="text"
                                class="form-control @error('nama_kelas', 'updateKelas') is-invalid @enderror"
                                name="nama_kelas" id="edit_nama_kelas">
                            @error('nama_kelas', 'updateKelas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Wali Kelas</label>
                            <select name="guru_id" class="form-select @error('guru_id', 'updateKelas') is-invalid @enderror"
                                id="edit_guru_id">
                                @foreach ($guru as $data_guru)
                                    <option value="{{ $data_guru->id }}">
                                        {{ $data_guru->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            @error('guru_id', 'updateKelas')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tsTambah = new TomSelect('#select_guru_tambah', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                dropdownParent: 'body'
            });

            const tsEdit = new TomSelect('#edit_guru_id', {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                dropdownParent: 'body'
            });

            const modalTambahEl = document.getElementById('modalTambahKelas');
            @if ($errors->storeKelas->any())
                const modalTambah = new bootstrap.Modal(modalTambahEl);
                modalTambah.show();
            @endif

            modalTambahEl.addEventListener('hidden.bs.modal', function() {
                tsTambah.clear();
            });

            const modalEditElement = document.getElementById('modalEditKelas');
            const modalEdit = new bootstrap.Modal(modalEditElement);
            const formEdit = document.getElementById('formEditKelas');

            const oldNamaKelas = @json(old('nama_kelas'));
            const oldGuruId = @json(old('guru_id'));
            const isUpdateError = @json($errors->updateKelas->any());

            modalEditElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                if (button) {
                    formEdit.action = `/admin/data-kelas/${button.dataset.id}`;

                    if (isUpdateError) {
                        document.getElementById('edit_nama_kelas').value = oldNamaKelas !== null ?
                            oldNamaKelas : button.dataset.nama;
                        const targetGuru = oldGuruId !== null ? oldGuruId : button.dataset.guru;
                        tsEdit.setValue(targetGuru);
                    } else {
                        document.getElementById('edit_nama_kelas').value = button.dataset.nama;
                        tsEdit.setValue(button.dataset.guru);
                    }
                }
            });

            @if ($errors->updateKelas->any() && session('edit_kelas_id'))
                formEdit.action = `/admin/data-kelas/{{ session('edit_kelas_id') }}`;

                if (oldNamaKelas !== null) {
                    document.getElementById('edit_nama_kelas').value = oldNamaKelas;
                }
                if (oldGuruId !== null) {
                    tsEdit.setValue(oldGuruId);
                }

                modalEdit.show();
            @endif
        });
    </script>
@endsection

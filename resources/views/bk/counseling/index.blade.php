@extends('layouts.default_layout')

@section('title')
    Data Konseling
@endsection

@section('action-buttons')
    <div class="heading-actions">
        <a class="btn btn-primary btn-sm" href="{{ route('konseling.create') }}">
            <i class="ti ti-plus" aria-hidden="true"></i> Tambah
        </a>
    </div>
@endsection

@section('content')
    <table class="table" id="table">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Siswa</th>
                <th scope="col">Guru Penindak</th>
                <th scope="col">Tanggal Penanganan</th>
                <th scope="col">Tindakan</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($counseling as $data)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $data->student->nama_lengkap ?? '-' }}</td>
                    <td>{{ $data->creator->nama_lengkap }}</td>
                    <td>{{ \Carbon\Carbon::parse($data->action_date)->translatedFormat('d F Y') }} </td>
                    <td>{{ $data->action_type }}</td>
                    <td>{{ $data->status }}</td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                            data-bs-target="#detailModal" data-problem_notes="{{ $data->problem_notes }}"
                            data-agreement_result="{{ $data->agreement_result }}">
                            Detail
                        </button>
                        <a href="{{ route('konseling.edit', $data->id) }}" type="button"
                            class="btn btn-warning btn-sm btn-edit">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="detailModalLabel">Detail Konseling</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Keluhan Masalah:</label>
                        <p id="problemNotesContent" class="form-control-plaintext"></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Hasil Kesepakatan:</label>
                        <p id="agreementResultContent" class="form-control-plaintext"></p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_js')
    <script>
        // Handle modal detail
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const problemNotes = button.getAttribute('data-problem_notes');
                const agreementResult = button.getAttribute('data-agreement_result');

                document.getElementById('problemNotesContent').textContent = problemNotes;
                document.getElementById('agreementResultContent').textContent = agreementResult;
            });
        }

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

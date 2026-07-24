@extends('layouts.page')

@section('title')
    Tambah Data User
@endsection

@push('additional_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        .form-control.read-only-disabled {
            background-color: var(--bs-secondary-bg, #e9ecef) !important;
            opacity: 1;
            cursor: not-allowed;
            user-select: none;
        }
    </style>
@endpush

@section('action-buttons')
    <a href="{{ route('data-user.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <div class="card card-body">
        <form action="{{ route('data-user.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Role</label><br>
                <input type="radio" name="role" id="admin" value="Admin"
                    class="form-check-input @error('role') is-invalid @enderror" checked>
                <label for="admin" class="">Admin</label>
                <br>
                <input type="radio" name="role" id="guru" value="Guru"
                    class="form-check-input @error('role') is-invalid @enderror">
                <label for="guru">Guru atau Wali Kelas</label>
                <br>
                <input type="radio" name="role" id="bk" value="BK"
                    class="form-check-input @error('role') is-invalid @enderror">
                <label for="bk">BK</label>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 d-none" id="container_guru">
                <label class="form-label">Pilih Guru</label>
                <select name="guru_id" class="form-select guru-select @error('role') is-invalid @enderror" id="guru_select">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($data_guru as $guru)
                        <option value="{{ $guru->id }}" data-nama="{{ $guru->nama_lengkap }}"
                            data-nip="{{ $guru->nip }}">
                            {{ $guru->nama_lengkap }} ({{ $guru->nip }})
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap"
                    name="nama_lengkap">
                @error('nama_lengkap')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                    name="username">
                @error('nama_lengkap')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" required>
                    <span class="input-group-text">
                        <i class="ti ti-eye toggle-password" data-target="password"></i>
                    </span>
                    <button class="btn btn-outline-secondary generate-password" type="button"
                        data-target="password">Generate</button>
                </div>
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="reset" class="btn btn-danger">Reset</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection

@push('additional_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tom-select/2.6.1/js/tom-select.complete.min.js"></script>
    <script>
        function generatePassword(targetId) {
            const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            let pass = "";
            for (let i = 0; i < 8; i++) {
                pass += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            const input = document.getElementById(targetId);
            if (input) {
                input.value = pass;
                input.select();
            }
        }

        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                const targetId = $(this).data("target");
                const $input = $("#" + targetId);
                if ($input.length === 0) return;

                const isHidden = $input.attr("type") === "password";
                $input.attr("type", isHidden ? "text" : "password");
                $(this).toggleClass("ti-eye ti-eye-off");
            });

            $('.generate-password').on('click', function() {
                const targetId = $(this).data("target");
                generatePassword(targetId);
            });

            const guruTomSelect = new TomSelect('#guru_select', {
                create: false,
                placeholder: '-- Pilih Guru --',
                onChange: function(value) {
                    const option = this.options[value];

                    if ($('input[name="role"]:checked').val() === 'Guru') {
                        if (option) {
                            const elem = option.$option;
                            const nama = $(elem).data('nama') || '';
                            const nip = $(elem).data('nip') || '';

                            $('#nama_lengkap').val(nama);
                            $('#username').val(nip);
                        } else {
                            $('#nama_lengkap').val('');
                            $('#username').val('');
                        }
                    }
                }
            });

            $('input[name="role"]').on('change', function() {
                const role = $(this).val();
                const $containerGuru = $('#container_guru');
                const $namaInput = $('#nama_lengkap');
                const $usernameInput = $('#username');

                if (role === 'Guru') {
                    $containerGuru.removeClass('d-none');

                    $namaInput.prop('readonly', true).addClass('read-only-disabled');
                    $usernameInput.prop('readonly', true).addClass('read-only-disabled');

                    const currentValue = guruTomSelect.getValue();
                    if (currentValue) {
                        guruTomSelect.settings.onChange.call(guruTomSelect, currentValue);
                    }
                } else {
                    $containerGuru.addClass('d-none');

                    $namaInput.prop('readonly', false).removeClass('read-only-disabled').val('');
                    $usernameInput.prop('readonly', false).removeClass('read-only-disabled').val('');

                    guruTomSelect.clear();
                }
            });

            if ($('input[name="role"]:checked').val() === 'Guru') {
                $('input[name="role"]:checked').trigger('change');
            }
        });
    </script>
@endpush

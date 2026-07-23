@extends('layouts.page')

@section('title')
    Edit Data User
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
        <x-alert-error />
        <form action="{{ route('data-user.update', $data_user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Role</label><br>
                <input type="radio" name="role" id="role_admin" value="Admin" class="form-check-input"
                    {{ old('role', $data_user->role) == 'Admin' ? 'checked' : '' }}>
                <label for="role_admin">Admin</label>
                <br>
                <input type="radio" name="role" id="role_guru" value="Guru" class="form-check-input"
                    {{ old('role', $data_user->role) == 'Guru' ? 'checked' : '' }}>
                <label for="role_guru">Guru atau Wali Kelas</label>
                <br>
                <input type="radio" name="role" id="role_bk" value="BK" class="form-check-input"
                    {{ old('role', $data_user->role) == 'BK' ? 'checked' : '' }}>
                <label for="role_bk">BK</label>
            </div>

            <div class="mb-3 {{ old('role', $data_user->role) == 'Guru' ? '' : 'd-none' }}" id="container_guru">
                <label class="form-label">Pilih Guru</label>
                <select name="guru_id" class="form-select" id="guru_select">
                    <option value="">-- Pilih Guru --</option>
                    @foreach ($data_guru as $guru)
                        <option value="{{ $guru->id }}" data-nama="{{ $guru->nama_lengkap }}"
                            data-nip="{{ $guru->nip }}"
                            {{ old('guru_id', $data_user->guru_id) == $guru->id ? 'selected' : '' }}>
                            {{ $guru->nama_lengkap }} ({{ $guru->nip }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <input type="text"
                    class="form-control {{ old('role', $data_user->role) == 'Guru' ? 'read-only-disabled' : '' }}"
                    id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $data_user->nama_lengkap) }}"
                    {{ old('role', $data_user->role) == 'Guru' ? 'readonly' : '' }}>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text"
                    class="form-control {{ old('role', $data_user->role) == 'Guru' ? 'read-only-disabled' : '' }}"
                    id="username" name="username" value="{{ old('username', $data_user->username) }}"
                    {{ old('role', $data_user->role) == 'Guru' ? 'readonly' : '' }}>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Kosongkan jika tidak ingin mengubah password">
                    <span class="input-group-text">
                        <i class="ti ti-eye toggle-password" data-target="password"></i>
                    </span>
                    <button class="btn btn-outline-secondary generate-password" type="button"
                        data-target="password">Generate</button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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

            // Perbaikan: Gunakan variabel luar, jangan pakai 'const' lagi di dalam if
            let guruTomSelect = document.getElementById('guru_select')?.tomselect;
            if (!guruTomSelect && document.getElementById('guru_select')) {
                guruTomSelect = new TomSelect('#guru_select', {
                    create: false,
                    maxItems: 1,
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
            }

            $('input[name="role"]').on('change', function() {
                const role = $(this).val();
                const $containerGuru = $('#container_guru');
                const $namaInput = $('#nama_lengkap');
                const $usernameInput = $('#username');

                if (role === 'Guru') {
                    $containerGuru.removeClass('d-none');

                    $namaInput.prop('readonly', true).addClass('read-only-disabled');
                    $usernameInput.prop('readonly', true).addClass('read-only-disabled');

                    if (guruTomSelect) {
                        const currentValue = guruTomSelect.getValue();
                        if (currentValue) {
                            guruTomSelect.settings.onChange.call(guruTomSelect, currentValue);
                        }
                    }
                } else {
                    $containerGuru.addClass('d-none');

                    $namaInput.prop('readonly', false).removeClass('read-only-disabled').val('');
                    $usernameInput.prop('readonly', false).removeClass('read-only-disabled').val('');

                    if (guruTomSelect) {
                        guruTomSelect.clear();
                    }
                }
            });

            if ($('input[name="role"]:checked').val() === 'Guru') {
                $('input[name="role"]:checked').trigger('change');
            }
        });
    </script>
@endpush

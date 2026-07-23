@extends('layouts.default_layout')

@section('title')
    Data User
@endsection

@section('content')
@section('action-buttons')
    <a href="{{ route('data-user.create') }}" class="btn btn-primary">Tambah</a>
@endsection

<table class="table" id="table-private">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Username</th>
            <th scope="col">Role</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $data_user)
            <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $data_user->nama_lengkap }}</td>
                <td>{{ $data_user->username }}</td>
                <td>{{ $data_user->role }}</td>
                <td>
                    <a href="{{ route('data-user.edit', $data_user->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('data-user.destroy', $data_user->id) }}" method="post"
                        style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger show-alert-delete-box" type="submit">Hapus</button>
                    </form>
                </td>

                <!-- Modal Edit -->
                <div class="modal fade modal-edit-user" id="edit_data_user{{ $data_user->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Edit Data User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('data-user.update', $data_user->id) }}" method="POST">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <label class="form-label">Role</label><br>
                                        <input type="radio" name="role" id="admin_edit_{{ $data_user->id }}"
                                            value="Admin" class="form-check-input role-radio-edit"
                                            data-user-id="{{ $data_user->id }}"
                                            {{ $data_user->role == 'Admin' ? 'checked' : '' }}>
                                        <label for="admin_edit_{{ $data_user->id }}">Admin</label>
                                        <br>
                                        <input type="radio" name="role" id="guru_edit_{{ $data_user->id }}"
                                            value="Guru" class="form-check-input role-radio-edit"
                                            data-user-id="{{ $data_user->id }}"
                                            {{ $data_user->role == 'Guru' ? 'checked' : '' }}>
                                        <label for="guru_edit_{{ $data_user->id }}">Guru atau Wali Kelas</label>
                                        <br>
                                        <input type="radio" name="role" id="bk_edit_{{ $data_user->id }}"
                                            value="BK" class="form-check-input role-radio-edit"
                                            data-user-id="{{ $data_user->id }}"
                                            {{ $data_user->role == 'BK' ? 'checked' : '' }}>
                                        <label for="bk_edit_{{ $data_user->id }}">BK</label>
                                    </div>

                                    <!-- Dropdown Pilih Guru (Edit) -->
                                    <div class="mb-3 {{ $data_user->role == 'Guru' ? '' : 'd-none' }}"
                                        id="container_guru_edit_{{ $data_user->id }}">
                                        <label class="form-label">Pilih Guru</label>
                                        <select name="guru_id" class="form-select guru-select-edit"
                                            id="guru_select_edit_{{ $data_user->id }}"
                                            data-user-id="{{ $data_user->id }}">
                                            <option value="">-- Pilih Guru --</option>
                                            @foreach ($data_guru as $guru)
                                                <option value="{{ $guru->id }}"
                                                    data-nama="{{ $guru->nama_lengkap }}"
                                                    data-nip="{{ $guru->nip }}"
                                                    {{ $data_user->guru_id == $guru->id ? 'selected' : '' }}>
                                                    {{ $guru->nama_lengkap }} ({{ $guru->nip }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama_lengkap_edit_{{ $data_user->id }}" class="form-label">Nama
                                            Lengkap</label>
                                        <input type="text" class="form-control"
                                            id="nama_lengkap_edit_{{ $data_user->id }}" name="nama_lengkap"
                                            value="{{ $data_user->nama_lengkap }}"
                                            {{ $data_user->role == 'Guru' ? 'readonly' : '' }}>
                                    </div>

                                    <div class="mb-3">
                                        <label for="username_edit_{{ $data_user->id }}"
                                            class="form-label">Username</label>
                                        <input type="text" class="form-control"
                                            id="username_edit_{{ $data_user->id }}" name="username"
                                            value="{{ $data_user->username }}"
                                            {{ $data_user->role == 'Guru' ? 'readonly' : '' }}>
                                    </div>

                                    <div class="mb-3">
                                        <label for="InputPassUpdate{{ $data_user->id }}"
                                            class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control"
                                                id="InputPassUpdate{{ $data_user->id }}" name="password"
                                                placeholder="Kosongkan jika tidak diubah">
                                            <span class="input-group-text">
                                                <i class="ti ti-eye toggle-password"
                                                    data-target="InputPassUpdate{{ $data_user->id }}"></i>
                                            </span>
                                            <button class="btn btn-outline-secondary generate-password" type="button"
                                                data-target="InputPassUpdate{{ $data_user->id }}">Generate</button>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection

@section('additional_js')
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
        $('#table-private').DataTable({
            ordering: true,
            responsive: true,
            paging: true,
            lengthChange: true,
        });

        // Toggle visibility password
        $(document).on("click", ".toggle-password", function() {
            const targetId = $(this).data("target");
            const $input = $("#" + targetId);
            if ($input.length === 0) return;

            const isHidden = $input.attr("type") === "password";
            $input.attr("type", isHidden ? "text" : "password");
            $(this).toggleClass("ti-eye ti-eye-off");
        });

        // Generate password
        $(document).on("click", ".generate-password", function() {
            const targetId = $(this).data("target");
            generatePassword(targetId);
        });

        // ==========================================
        // 1. HANDLER MODAL TAMBAH USER
        // ==========================================
        $('.role-radio-tambah').on('change', function() {
            const role = $(this).val();
            const $containerGuru = $('#container_guru_add');
            const $namaInput = $('#nama_lengkap_add');
            const $usernameInput = $('#username_add');

            if (role === 'Guru') {
                $containerGuru.removeClass('d-none');
                $namaInput.prop('readonly', true);
                $usernameInput.prop('readonly', true);

                // Trigger event change jika guru sudah pernah dipilih sebelumnya
                $('#guru_select_add').trigger('change');
            } else {
                $containerGuru.addClass('d-none');
                $namaInput.prop('readonly', false).val('');
                $usernameInput.prop('readonly', false).val('');
                $('#guru_select_add').val('');
            }
        });

        $('#guru_select_add').on('change', function() {
            const $selectedOption = $(this).find('option:selected');
            const nama = $selectedOption.data('nama') || '';
            const nip = $selectedOption.data('nip') || '';

            if ($('.role-radio-tambah:checked').val() === 'Guru') {
                $('#nama_lengkap_add').val(nama);
                $('#username_add').val(nip);
            }
        });


        // 2. HANDLER MODAL EDIT USER (EVENT DELEGATION)
        $(document).on('change', '.role-radio-edit', function() {
            const userId = $(this).data('user-id');
            const role = $(this).val();

            const $containerGuru = $('#container_guru_edit_' + userId);
            const $namaInput = $('#nama_lengkap_edit_' + userId);
            const $usernameInput = $('#username_edit_' + userId);

            if (role === 'Guru') {
                $containerGuru.removeClass('d-none');
                $namaInput.prop('readonly', true);
                $usernameInput.prop('readonly', true);

                // Autofill dengan guru yang sedang terpilih di modal edit tersebut
                $('#guru_select_edit_' + userId).trigger('change');
            } else {
                $containerGuru.addClass('d-none');
                $namaInput.prop('readonly', false);
                $usernameInput.prop('readonly', false);
            }
        });

        $(document).on('change', '.guru-select-edit', function() {
            const userId = $(this).data('user-id');
            const $selectedOption = $(this).find('option:selected');
            const nama = $selectedOption.data('nama') || '';
            const nip = $selectedOption.data('nip') || '';

            const activeRole = $(`input[name="role"][data-user-id="${userId}"]:checked`).val();

            if (activeRole === 'Guru') {
                $('#nama_lengkap_edit_' + userId).val(nama);
                $('#username_edit_' + userId).val(nip);
            }
        });
    });
</script>
@endsection

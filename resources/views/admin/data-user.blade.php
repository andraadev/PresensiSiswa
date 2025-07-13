@extends('layouts.default_layout')

@section('title')
    Data User
@endsection

@section('additional_css')
    <style>
        #InputPass,
        #InputPassUpdate {
            position: relative;
            margin: 0px 0;
        }

        #eye {
            position: absolute;
            right: 1.7rem;
            top: 13.8rem;
            font-size: 22px;
            cursor: pointer;
        }

        #eyeIcon,
        #eyeIconUpdate {
            position: absolute;
            right: 1.7rem;
            top: 12.8rem;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
@endsection

@section('heading')
    Data User
@endsection

@section('content')
@section('action-buttons')
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah_user">Tambah</button>
    <!-- Modal Tambah User -->
    <div class="modal fade" id="tambah_user" tabindex="-1" aria-labelledby="Tambah Data User" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="Tambah Data User">Tambah Data User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('data-user.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" id="InputPass" name="password">
                            <i class="ti ti-eye" id="eye"></i>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label><br>
                            <input type="radio" name="role" id="admin" value="admin" class="form-check-input"
                                checked>
                            <label for="admin">Admin</label>
                            <br>
                            <input type="radio" name="role" id="guru_walas" value="guru" class="form-check-input">
                            <label for="guru_walas">Guru atau Wali Kelas</label>
                            <br>
                            <input type="radio" name="role" id="bk" value="bk" class="form-check-input">
                            <label for="bk">BK</label>
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
                    <button class="btn btn-warning" data-bs-toggle="modal"
                        data-bs-target="#edit_data_user{{ $data_user->id }}">Edit</button>
                    <form action="{{ route('data-user.destroy', $data_user->id) }}" method="post"
                        style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger show-alert-delete-box" type="submit">Hapus</button>
                    </form>
                </td>
                <!-- Modal -->
                <div class="modal fade" id="edit_data_user{{ $data_user->id }}" tabindex="-1">
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
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="nama_lengkap"
                                            name="nama_lengkap" value="{{ $data_user->nama_lengkap }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                            value="{{ $data_user->username }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control" id="InputPassUpdate"
                                            name="password"
                                            placeholder="Jika input ini diisi lagi, maka password akan diupdate">
                                        <i class="ti ti-eye" id="eyeIconUpdate"></i>
                                    </div>

                                    <div class="mb-3">
                                        <label for="role" class="form-label">Role</label><br>
                                        <input type="radio" name="role" id="admin" value="Admin"
                                            class="form-check-input"
                                            {{ $data_user->role == 'Admin' ? 'checked' : '' }}>
                                        <label for="admin">Admin</label>
                                        <br>
                                        <input type="radio" name="role" id="guru_walas" value="Guru"
                                            class="form-check-input"
                                            {{ $data_user->role == 'Guru' ? 'checked' : '' }}>
                                        <label for="guru_walas">Guru atau Wali Kelas</label>
                                        <br>
                                        <input type="radio" name="role" id="bk" value="BK"
                                            class="form-check-input" {{ $data_user->role == 'BK' ? 'checked' : '' }}>
                                        <label for="bk">BK</label>
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
    $(document).ready(function() {
        $('#table-private').DataTable({
            ordering: true,
            responsive: true,
            paging: true,
            lengthChange: true,
        });

        // fungsi untuk memunculkan/menyembunyikan password pada tambah data user
        const passwordTambah = $("#InputPassTambah");
        const eyeTambah = $("#eyeTambah");

        eyeTambah.click(function() {
            if (eyeTambah.hasClass("ti-eye")) {
                passwordTambah.attr("type", "text");
                eyeTambah.removeClass("ti-eye").addClass("ti-eye-off");
            } else {
                passwordTambah.attr("type", "password");
                eyeTambah.removeClass("ti-eye-off").addClass("ti-eye");
            }
        });

        // fungsi untuk memunculkan/menyembunyikan password pada update data user
        const passwordUpdate = $("#InputPassUpdate");
        const eyeIconUpdate = $("#eyeIconUpdate");

        eyeIconUpdate.click(function() {
            if (eyeIconUpdate.hasClass("ti-eye")) {
                passwordUpdate.attr("type", "text");
                eyeIconUpdate.removeClass("ti-eye").addClass("ti-eye-off");
            } else {
                passwordUpdate.attr("type", "password");
                eyeIconUpdate.removeClass("ti-eye-off").addClass("ti-eye");
            }
        });
    });
</script>
@endsection

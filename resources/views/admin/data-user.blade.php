@extends('layouts.default_layout')

@section('title')
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
                            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="Inputpassword" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="InputPassTambah" name="password" required>
                                <span class="input-group-text">
                                    <i class="ti ti-eye toggle-password" data-target="InputPassTambah"></i>
                                </span>
                            </div>
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
                                        <label for="Inputpassword" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="InputPassUpdate"
                                                name="password"
                                                placeholder="Jika input ini diisi lagi, maka password akan diupdate"
                                                required>
                                            <span class="input-group-text">
                                                <i class="ti ti-eye toggle-password"
                                                    data-target="InputPassUpdate"></i>
                                            </span>
                                        </div>
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

        // Function to handle view password button
        $(document).on("click", ".toggle-password", function() {
            const $this = $(this);
            const targetId = $this.data("target");
            const $input = $("#" + targetId);

            if ($input.length === 0) return;

            const isHidden = $input.attr("type") === "password";
            $input.attr("type", isHidden ? "text" : "password");

            $this.toggleClass("ti-eye ti-eye-off");
        });
    });
</script>
@endsection

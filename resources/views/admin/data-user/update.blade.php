@extends('layouts.page')

@section('title')
    Edit Data User
@endsection

@section('action-buttons')
    <a href="{{ route('data-user.index') }}" class="btn btn-secondary">Kembali ke halaman utama</a>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-4">
            @php
                $namaLengkap = trim($data_user->nama_lengkap ?? '');
                $namaParts = preg_split('/\s+/', $namaLengkap, -1, PREG_SPLIT_NO_EMPTY) ?: [];
                $initials = '';

                foreach (array_slice($namaParts, 0, 2) as $part) {
                    $initials .= strtoupper(mb_substr($part, 0, 1));
                }

                $initials = $initials !== '' ? $initials : '-';
            @endphp
            <div class="card border shadow-sm">
                <div class="card-body d-flex flex-column align-items-center text-center gap-3 p-4">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-6"
                        style="width: 88px; height: 88px; flex: 0 0 auto;">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="fw-semibold fs-5 mb-2">{{ $data_user->nama_lengkap }}</div>
                        <div class="text-muted mb-2">{{ $data_user->username }}</div>
                        <span class="badge text-bg-primary mt-2">{{ $data_user->role }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card card-body shadow-sm">
                {{-- <h4 class="mb-2 fw-semibold">Ubah Password</h4> --}}
                <form action="{{ route('data-user.update', $data_user->id) }}" method="POST" class="">
                    @csrf
                    @method('PUT')
                    @if (in_array($data_user->role, ['Admin', 'BK']))
                        <div class="mb-3">
                            <label class="form-label">Role</label><br>
                            <input type="radio" name="role" id="role_admin" value="Admin"
                                class="form-check-input @error('role') is-invalid @enderror"
                                {{ old('role', $data_user->role) == 'Admin' ? 'checked' : '' }}>
                            <label for="role_admin">Admin</label>
                            <br>
                            <input type="radio" name="role" id="role_bk" value="BK"
                                class="form-check-input @error('role') is-invalid @enderror"
                                {{ old('role', $data_user->role) == 'BK' ? 'checked' : '' }}>
                            <label for="role_bk">BK</label>
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $data_user->nama_lengkap) }}">
                            @error('nama_lengkap')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username', $data_user->username) }}">
                            @error('username')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
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

                    <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('additional_js')
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
        });
    </script>
@endpush

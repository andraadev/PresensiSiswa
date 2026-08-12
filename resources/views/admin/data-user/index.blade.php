@extends('layouts.default_layout')

@section('title')
    Data User
@endsection

@section('content')
@section('action-buttons')
    <a href="{{ route('data-user.create') }}" class="btn btn-primary btn-sm">
        <i class="ti ti-plus" aria-hidden="true"></i> Tambah
    </a>
@endsection

<table class="table" id="table-private">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama</th>
            <th scope="col">Username</th>
            <th scope="col">Role</th>
            <th scope="col">Status</th>
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
                    <span class="badge {{ $data_user->is_active ? 'text-bg-success' : 'text-bg-danger' }}">
                        {{ $data_user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('data-user.edit', $data_user->id) }}" class="btn btn-warning">Edit</a>
                    @if ($data_user->id === auth()->id())
                        <button type="button" class="btn btn-danger opacity-50" disabled>
                            Nonaktifkan
                        </button>
                    @else
                        <form action="{{ route('data_user.update_status', $data_user->id) }}" method="POST"
                            class="d-inline">
                            @csrf
                            @method('PATCH')

                            @if ($data_user->is_active)
                                <input type="hidden" name="is_active" value="0">
                                <button type="button" class="btn btn-danger" data-nama="{{ $data_user->nama_lengkap }}"
                                    data-active="true" onclick="confirmStatusChange(this)">
                                    Nonaktifkan
                                </button>
                            @else
                                <input type="hidden" name="is_active" value="1">
                                <button type="button" class="btn btn-success"
                                    data-nama="{{ $data_user->nama_lengkap }}" data-active="false"
                                    onclick="confirmStatusChange(this)">
                                    Aktifkan
                                </button>
                            @endif
                        </form>
                    @endif
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
            title: isActive ? `Nonaktifkan ${nama}?` : `Aktifkan ${nama}?`,
            text: isActive ?
                `User ini akan dinonaktifkan dari sistem.` : `User ini akan diaktifkan kembali.`,
            icon: isActive ? 'warning' : 'question',
            showCancelButton: true,
            confirmButtonColor: isActive ? '#dc3545' : '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: isActive ? 'Ya, Nonaktifkan!' : 'Ya, Aktifkan!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
    $(document).ready(function() {
        $('#table-private').DataTable({
            ordering: true,
            responsive: true,
            paging: true,
            lengthChange: true,
        });
    });
</script>
@endsection

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
                    <form action="{{ route('data-user.destroy', $data_user->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger show-alert-delete-box" type="submit">Hapus</button>
                    </form>
                </td>
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

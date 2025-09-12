@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    <i class="ti ti-point-filled"></i> {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

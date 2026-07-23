<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PresensiSiswa')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

    @stack('additional_css')
</head>

<body class="bg-light">
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('partials.sidebar')
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('partials.navbar')
            <div class="container-fluid">
                {{-- Use yield heading first, if section heading is not set, use title section --}}
                <h1 class="fw-bold">
                    @yield('heading', View::yieldContent('title', 'Presensi Siswa'))
                </h1>
                <section id="action-buttons" class="mb-2">
                    @yield('action-buttons')
                </section>
                @yield('content')
                @include('partials.footer')
            </div>
        </div>
    </div>

    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/logout-modal.js') }}"></script>

    <script>
        document.querySelectorAll("input[data-counter]").forEach(input => {
            // Take the counter element (small) that is after the input
            const counter = input.nextElementSibling;

            // Initialize counter display
            counter.textContent = `Panjang input: ${input.value.length}`;

            // Add an event listener when the input is filled or edited
            input.addEventListener("input", () => {
                counter.textContent = `Panjang input: ${input.value.length}`;
            });
        });
    </script>

    @stack('additional_js')
</body>

</html>

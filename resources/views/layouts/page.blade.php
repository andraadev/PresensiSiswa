<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PresensiSiswa')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/bootstrap-5.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <style>
        .ti {
            font-size: 22px;
        }
    </style>
    @stack('additional_css')

</head>

<body>
    <div class="admin-shell">
        @include('partials.sidebar')
        <div class="admin-main">
            @include('partials.navbar')
            <main class="dashboard-content">
                <div class="container-fluid px-3 px-lg-4 py-4">
                    <div class="page-heading">
                        {{-- Use yield heading first, if section heading is not set, use title section --}}
                        <h1 class="h3 mb-1">@yield('heading', View::yieldContent('title', 'Presensi Siswa'))</h1>
                        <div class="heading-actions">
                            @yield('action-buttons')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </main>
            @include('partials.footer')
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/logout-modal.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
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

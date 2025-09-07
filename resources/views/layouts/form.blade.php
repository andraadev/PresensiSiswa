<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">

    {{-- Set default size for class .ti <icon> --}}
    <style>
        .ti {
            font-size: 20px;
        }
    </style>

    @yield('additional_css')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        @include('partials.sidebar')
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('partials.navbar')
            <div class="container-fluid">
                <h1>@yield('heading')</h1>
                <section id="action-buttons" class="mb-2">
                    @yield('action-buttons')
                </section>
                <div class="card shadow-md">
                    <div class="card-body p-3">
                        @yield('content')
                    </div>
                </div>
                @include('partials.footer')
            </div>
        </div>
    </div>

    <!-- jQuery Library -->
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>

    <!-- Bootstrap JS -->
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom Scripts -->
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>

    @yield('additional_js')

    <!-- SweetAlert2 JS -->
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('js/logout-modal.js')}}"></script>
</body>
</html>

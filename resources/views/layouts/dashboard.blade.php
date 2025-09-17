<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('partials.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Navbar Start -->
            @include('partials.navbar')
            <!--  Navbar End -->
            <div class="container-fluid">
                <h1 class="d-sm-block d-md-none">@yield('header')</h1>
                @yield('basic-statistics-section')
                @yield('charts-section')

                @include('partials.footer')
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- SweetAlert2 JS -->
    <script src="{{ asset('libs/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    {{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
    <script src="{{ asset('js/format-date.js')}}"></script>
    <script src="{{ asset('js/logout-modal.js')}}"></script>
    @yield('additional_js')
</body>

</html>

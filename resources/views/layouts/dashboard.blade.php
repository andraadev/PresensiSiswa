<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Beranda</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
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
            <header class="app-header">
                <nav class="navbar navbar-expand-lg" style="background-color: rgb(31,54,46)">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                href="javascript:void(0)">
                                <i class="ti ti-menu-2 text-white"></i>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-block d-lg-block d-xl-block d-xl-block">
                            <h1 class="ms-3 text-white">
                                @yield('header')
                            </h1>
                        </li>
                    </ul>
                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav"
                        style="background-color: rgb(31,54,46);">
                        <ul class="navbar-nav flex-row ms-auto justify-content-end p-2">
                            <li class="nav-item dropdown">
                                <button class="text-dark fw-bold btn" role="button" id="dropdownProfile"
                                    data-bs-toggle="dropdown" style="background-color: #caeb73;">
                                    {{ Auth::user()->username }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="#" class="dropdown-item" onclick="modal_logout()">
                                            <i class="ti ti-logout" style="font-size: 22px"></i>
                                            Log out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
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
    @yield('additional_js')

    <script>
        function modal_logout() {
            Swal.fire({
                title: 'Peringatan',
                text: 'Apakah kamu yakin ingin logout?',
                icon: 'warning',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Tidak',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                showCancelButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = "{{ route('logout') }}";
                }
            })
        }
    </script>
</body>

</html>

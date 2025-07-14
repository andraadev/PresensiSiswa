<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />

    <!-- DataTables CSS -->
    <link href="{{ asset('libs/DataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- Responsive DataTables CSS -->
    <link href="{{ asset('libs/DataTables/responsive/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">

    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="{{ asset('libs/DataTables/buttons/css/buttons.bootstrap5.min.css') }}">

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
        <!-- Sidebar Start -->
        @include('partials.sidebar')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            @include('partials.navbar')
            {{-- Navbar Start --}}
            {{-- Navbar End --}}
            <div class="container-fluid">
                <h1 class="d-sm-block d-md-none d-lg-none">@yield('heading')</h1>
                @yield('content')
                {{-- Footer Start --}}
                @include('partials.footer')
                {{-- Footer End --}}
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

    <!-- Simplebar JS -->
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>

    @yield('additional_js')

    <!-- DataTables and Buttons Assets [JS]-->
    <script src="{{ asset('libs/DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/responsive/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('libs/DataTables/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/buttons/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('libs/DataTables/buttons/js/buttons.print.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                info: false,
                ordering: true,
                responsive: true,
                paging: true,
                lengthChange: false,
                columnDefs: [{
                    targets: -1,
                    className: 'noExport'
                }],
                buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ":visible:not(.noExport)"
                    }
                }, ]
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');
        });
    </script>

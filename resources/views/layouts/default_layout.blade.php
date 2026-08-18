<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="{{ asset('assets/vendors/DataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/DataTables/responsive/css/responsive.bootstrap5.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/buttons/css/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/bootstrap-5.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <style>
        .ti {
            font-size: 22px;
        }

        [data-bs-theme="dark"] table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control::before,
        [data-bs-theme="dark"] table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control::before {
            color: #fff;
        }
    </style>
    @yield('additional_css')
</head>

<body>
    <div class="admin-shell">
        @include('partials.sidebar')
        <div class="admin-main">
            @include('partials.navbar')
            <main class="dashboard-content">
                <div class="container-fluid px-3 px-lg-4 py-4">
                    <div class="page-heading">
                        <h1 class="h3 mb-1">@yield('title')</h1>
                        @yield('action-buttons')
                    </div>
                    <section class="panel mt-3">
                        @yield('filter-form')
                        @yield('content')
                    </section>
                </div>
            </main>
            @include('partials.footer')
        </div>
    </div>

    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/responsive/js/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/buttons/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/DataTables/buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/js/logout-modal.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            const tableTarget = $('#table');

            if (!tableTarget.length) {
                return;
            }

            const table = tableTarget.DataTable({
                info: false,
                ordering: true,
                responsive: true,
                paging: true,
                lengthChange: false,
                autoWidth: false,

                columnDefs: [{
                    targets: -1,
                    className: 'noExport'
                }],

                layout: {
                    topStart: 'buttons'
                },

                buttons: [{
                    extend: 'excelHtml5',
                    className: 'btn btn-success',
                    exportOptions: {
                        columns: ':not(.noExport)'
                    }
                }],

                language: {
                    zeroRecords: "Tidak ada data yang ditemukan berdasarkan filter yang telah diatur.",
                    emptyTable: "Belum ada data di dalam tabel ini."
                }
            });

            const buttonContainer = $('#table_wrapper .col-md-6:eq(0)');

            if (buttonContainer.length) {
                table.buttons().container().appendTo(buttonContainer);
            }
        });
    </script>


    @yield('additional_js')
</body>

</html>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="{{ asset('libs/sweetalert2/dist/sweetalert2.min.css') }}">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css')}}">

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

    <!-- SweetAlert2 JS -->
    <script>
        // Capture all inputs that have data counters
        document.querySelectorAll("input[data-counter]").forEach(input => {
            // Take the counter element (small) that is after the input
            const counter = input.nextElementSibling;

            // Initialize counter display
            counter.textContent = `Panjang input: ${input.value.length}`;

            // Add an event listener when the input is filled or edited
            input.addEventListener("input", () => {
                // Update character count display
                counter.textContent = `Panjang input: ${input.value.length}`;
            });
        });
    </script>
</body>
</html>

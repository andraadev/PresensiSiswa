<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <style>
        #Inputpassword {
            position: relative;
            margin: 3px 0;
        }

        #eye {
            position: absolute;
            right: 2.3rem;
            top: 16rem;
            font-size: 22px;
            cursor: pointer;
        }
    </style>
</head>

<body style="background-color: rgb(31,54,46)">
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div class="position-relative overflow-hidden min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0 border border-dark">
                            <div class="card-body">
                                <section class="logo-img text-center w-100">
                                    <h1 class="fw-bolder">
                                        Absensi
                                    </h1>
                                    <p>Silakan login terlebih dahulu untuk melanjutkan</p>
                                </section>
                                <section id="section-alert">
                                    @session('Gagal')
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <i class="ti ti-alert-triangle" style="font-size: 18px"></i>
                                            {{ $value }}.<a href="#"
                                                onclick="alert('Jika kamu lupa password akunmu, maka kamu dapat menghubungi admin untuk mengganti password akunmu')">Lupa
                                                password?</a>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endsession
                                </section>
                                <form action="{{ route('auth') }}" method="post" autocomplete="off">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="username"
                                            class="form-control @error('username') is-invalid @enderror" id="username"
                                            name="username" value="{{ old('username') }}" autofocus>
                                        <section id="error-form">
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </section>
                                    </div>
                                    <div class="mb-3" id="input-password">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            id="Inputpassword" name="password" value="{{ old('password') }}">
                                        <section id="error-form">
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </section>
                                        <i class="ti ti-eye" id="eye"></i>
                                    </div>
                                    <button class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Login</button>
                                    <p class="fw-bold text-center"> -Jika kamu lupa password, silakan hubungi admin-
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const password = $("#Inputpassword");
            const eyeIcon = $("#eye");

            eyeIcon.click(function() {
                if (eyeIcon.hasClass("ti-eye")) {
                    password.attr("type", "text");
                    eyeIcon.removeClass("ti-eye").addClass("ti-eye-off");
                } else {
                    password.attr("type", "password");
                    eyeIcon.removeClass("ti-eye-off").addClass("ti-eye");
                }
            });
        });
    </script>
</body>

</html>

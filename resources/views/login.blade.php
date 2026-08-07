<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="adminHMD authentication page">
    <title>Login | PresensiSiswa</title>

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
    <style>
        .ti {
            font-size: 22px;
        }

        #eye {
            cursor: pointer;
        }
    </style>
</head>

<body class="auth-body">
    <button class="icon-button theme-toggle auth-theme-toggle" type="button" data-theme-toggle
        aria-label="Switch color theme" title="Switch color theme">
        <i class="ti ti-moon-stars" data-theme-icon aria-hidden="true"></i>
    </button>
    <main class="auth-page">
        <section class="auth-card">
            <div class="auth-brand">
                <span class="brand-icon">
                    <i class="ti ti-clipboard-check"></i>
                </span>
                <span>
                    <strong class="fs-4 mb-1">PresensiSiswa</strong>
                    <small class="fs-6">Silakan login terlebih dahulu untuk melanjutkan</small>
                </span>
            </div>
            @if (session('Gagal'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('Gagal') }}.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form action="{{ route('auth') }}" method="POST" autocomplete="off" class="needs-validation">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="loginUsername">Username</label>
                    <input class="form-control @error('username') is-invalid @enderror" id="loginUsername"
                        type="text" name="username" value="{{ old('username') }}" autofocus required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="loginPassword">Password</label>
                    <div class="input-group">
                        <input class="form-control @error('password') is-invalid @enderror" id="loginPassword"
                            type="password" name="password" required>
                        <span class="input-group-text">
                            <i class="ti ti-eye" id="eye"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button class="btn btn-primary w-100" type="submit">Sign In</button>
            </form>

            <div class="auth-footer">Jika lupa password, hubungi admin untuk reset password.</div>
        </section>
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const password = $("#loginPassword");
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

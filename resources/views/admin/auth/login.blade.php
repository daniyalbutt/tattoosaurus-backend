<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Log In | Tattoosaurus Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="auth-bg d-flex min-vh-100 justify-content-center align-items-center">
        <div class="row g-0 justify-content-center w-100 m-xxl-5 px-xxl-4 m-3">
            <div class="col-xl-4 col-lg-5 col-md-6">
                <div class="card overflow-hidden text-center h-100 p-xxl-4 p-3 mb-0">
                    <a href="{{ route('admin.login') }}" class="auth-brand mb-3">
                        <img src="{{ asset('img/logo.png') }}" alt="dark logo" height="120" class="logo-dark">
                        <img src="{{ asset('img/logo.png') }}" alt="logo light" height="120" class="logo-light">
                    </a>

                    <h3 class="fw-semibold mb-2">Login to Admin Panel</h3>
                    <p class="text-muted mb-4">Enter your email and password to access the dashboard.</p>

                    @if($errors->any())
                        <div class="alert alert-danger text-start">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('admin.login.attempt') }}" method="POST" class="text-start mb-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}"
                                   class="form-control" placeholder="Enter your email" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group">
                                <input type="password" id="password" name="password"
                                       class="form-control" placeholder="Enter your password" required>
                                <span class="input-group-text cursor-pointer" id="togglePassword" role="button">
                                    <i class="ti ti-eye" id="togglePasswordIcon"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-primary" type="submit">Login</button>
                        </div>
                    </form>

                    <p class="mt-auto mb-0">
                        {{ date('Y') }} © Tattoosaurus Admin
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            const isHidden = input.type === 'password';

            input.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('ti-eye', !isHidden);
            icon.classList.toggle('ti-eye-off', isHidden);
        });
    </script>
</body>
</html>
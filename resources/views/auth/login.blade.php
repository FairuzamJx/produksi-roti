<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pendukung Keputusan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- External CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
<div class="login-box">
    <div class="text-center mb-3">
        <span class="login-title">Sistem Pendukung Keputusan</span>
        <p class="text-muted mb-0">Silakan login untuk melanjutkan</p>
    </div>

    <div class="card">
        <div class="card-body">

            {{-- Alert error login --}}
            @if ($errors->has('username'))
                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle mr-1"></i> Username atau password salah.
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            {{-- Alert sukses login (jika redirect back misal logout pakai with('success')) --}}
            @if (session('success'))
                <div class="alert alert-success text-center alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                        <input type="text" name="username" id="username" class="form-control" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-lock"></i></span></div>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>

        </div>
    </div>
</div>

{{-- JS --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

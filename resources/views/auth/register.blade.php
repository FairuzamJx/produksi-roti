<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Sistem Pendukung Keputusan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- AdminLTE & FontAwesome --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <a href="#"><b>Sistem</b>Keputusan</a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Daftar akun baru</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-user-tag"></i></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="role" class="form-control" required>
                        <option value="" disabled selected>Pilih Role</option>
                        <option value="superadmin">Superadmin</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-user-shield"></i></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fas fa-check-double"></i></div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-8">
                        <a href="{{ route('login') }}" class="text-center">Sudah punya akun?</a>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-success btn-block">Daftar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>

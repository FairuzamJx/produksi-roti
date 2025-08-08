<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Pendukung Keputusan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- AdminLTE CSS --}}
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="hold-transition layout-top-nav">

<div class="wrapper">

    {{-- Navbar --}}
    <nav class="main-header navbar navbar-expand-md navbar-white navbar-light border-bottom">
        <div class="container">
            <a href="/dashboard" class="navbar-brand">
                <span class="brand-text font-weight-light">SPK</span>
            </a>

            <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                {{-- Left navbar links --}}
                <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data.index') }}" class="nav-link {{ request()->is('data') ? 'active' : '' }}">Master Data</a>
                </li>

                @role('superadmin|admin')
                <li class="nav-item">
                    <a href="{{ route('prediksi.index') }}" class="nav-link {{ request()->is('prediksi') ? 'active' : '' }}">Prediksi Produksi</a>
                </li>
                @endrole

                <li class="nav-item">
                    <a href="{{ route('prediksi.hasil') }}" class="nav-link {{ request()->is('hasil-prediksi') ? 'active' : '' }}">Hasil</a>
                </li>

                @role('superadmin')
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->is('users') ? 'active' : '' }}">Manajemen User</a>
                </li>
                @endrole
                </ul>
            </div>
            {{-- Right navbar --}}
            <ul class="order-1 order-md-3 navbar-nav ml-auto">
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="form-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    {{-- Content Wrapper --}}
    <div class="content-wrapper">
        <div class="content pt-4">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- {{-- Footer --}}
    <footer class="main-footer text-center">
        <strong>&copy; 2022 <a href="#">AdminLTE.IO</a>.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            Sistem Pendukung Keputusan
        </div>
    </footer> -->
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>
</html>

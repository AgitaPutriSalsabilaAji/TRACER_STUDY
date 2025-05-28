<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('image/logo_polinema.png') }}" type="image/png" />

    <title>Tracer Study</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- JS Bootstrap -->

    @yield('head') <!-- For additional head content injected by individual pages -->

</head>


<body class="d-flex flex-column min-vh-100">

    <header>
        <!-- Logo dan Judul -->
        <div class="d-flex align-items-center ps-3">
            <img src="image/logo_polinema.png" alt="Logo Polinema" height="60">
            <div class="ms-3">
                <strong style="font-size: 22px;">TRACER STUDY</strong><br>
                <span style="font-size: 16px;">Politeknik Negeri Malang</span>
            </div>
        </div>
        <!-- Hamburger icon for mobile -->
        <button class="menu-toggle d-md-none" id="menu-toggle">
            ☰
        </button>

        <nav class="navbar d-none d-md-flex">
            <li><a href="{{ url('/') }}" class="text-dark {{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ url('/form-alumni') }}"
                    class="text-dark {{ Request::is('form-alumni') ? 'active' : '' }}">Data
                    Alumni</a></li>
            <li><a href="/form-atasan" class="text-dark {{ Request::is('form-atasan') ? 'active' : '' }}">Isi Survei</a>
            </li>
        </nav>
        <a href="/login" class="btn login-btn d-none d-md-inline">Login Admin</a>

        <!-- Mobile Menu -->
        <div class="mobile-menu d-md-none" id="mobile-menu">
            <ul>
                <li><a href="{{ url('/') }}">Beranda</a></li>
                <li><a href="{{ url('/form-alumni') }}">Data Alumni</a></li>
                <li><a href="#isi-survei">Isi Survei</a></li>
                <li><a href="/login" class="btn login-btn">Login Admin</a></li>
            </ul>
        </div>
    </header>


    @yield('content')
    @include('layouts.footerguest')


</body>

</html>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('show');
    });
</script>

<style>
    .navbar a {
        font-size: 22px;
        color: black !important;
    }

    .login-btn {
        font-size: 20px;
        color: white !important;
    }
</style>

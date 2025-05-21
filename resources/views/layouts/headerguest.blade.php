<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('head') <!-- For additional head content injected by individual pages -->
</head>

<body class="d-flex flex-column min-vh-100">

    <header>
        <a href="/" class="logo-wrapper" style="text-decoration: none;">
            <div class="logo-text">TRACER STUDY</div>
        </a>

        <!-- Hamburger icon for mobile -->
        <button class="menu-toggle d-md-none" id="menu-toggle">
            ☰
        </button>

        <nav class="navbar d-none d-md-flex">
            <li><a href="{{ url('/') }}" class="{{ Request::is('/') ? 'active' : '' }}">Beranda</a></li>
            <li><a href="{{ url('/form-alumni') }}" class="{{ Request::is('form-alumni') ? 'active' : '' }}">Data
                    Alumni</a></li>
            <li><a href="/form-atasan" class="{{ Request::is('form-atasan') ? 'active' : '' }}">Isi Survei</a></li>
            <a href="/login" class="btn login-btn d-none d-md-inline">Login Admin</a>
        </nav>

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

</body>

</html>
<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('show');
    });
</script>

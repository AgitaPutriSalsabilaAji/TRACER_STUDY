<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study</title>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    @yield('head')
</head>
<body class="d-flex flex-column min-vh-100">

    <header>
        <a href="/" class="logo-wrapper" style="text-decoration: none;">
            <div class="logo-text">TRACER STUDY</div>
        </a>
        <ul class="navbar">
            <li><a href="#home" class="home-active">Beranda</a></li>
            <li><a href="#data-alumni">Data Alumni</a></li>
            <li><a href="#isi-survei">Isi Survei</a></li>
        </ul>
        <a href="/login" class="btn login-btn">LOGIN SEBAGAI ADMIN</a>
    </header>

    @yield('content')

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

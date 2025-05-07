<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study</title>
    <!-- Bootstrap / AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <a href="#" class="logo-wrapper" style="text-decoration: none;">
            <div class="logo-text">
                TRACER STUDY
            </div>
        </a>
        
        
        
        <ul class="navbar">
            <li><a href="#home" class="home-active">Beranda</a></li>
            <li><a href="#data-alumni">Data Alumni</a></li>
            <li><a href="#isi-survei">Isi Survei</a></li>
        </ul>
        <a href="/login" class="btn login-btn">LOGIN SEBAGAI ADMIN</a>
        
    </header>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="home-image">
            <img src="image/image.png" alt="Ilustrasi Tracer Study">
        </div>
        <div class="home-text">
            <h1>Selamat Datang di Website Tracer Study <br>Politeknik Negeri Malang</h1>
            <h2>Langkah Kecil, Dampak Besar!</h2>
            <a href="#" class="btn">Isi Survei</a>
            <a href="#" class="play"><i class="bx bx-play"></i></a>
            
        </ul>
        </div>
    </section>

    <main>
        <!-- About Section -->
<section class="about" id="tentang">
    <div class="about-container">
        <h2>Apa itu Tracer Study ?</h2>
        <p>
            Tracer Study adalah salah satu metode yang digunakan oleh perguruan tinggi untuk mengumpulkan data dan umpan balik dari alumni mengenai pengalaman mereka setelah lulus.
            Informasi yang diperoleh digunakan sebagai bahan evaluasi untuk meningkatkan kualitas pendidikan, kurikulum, serta relevansi program studi dengan dunia kerja. 
        </p>
        <p>
            Tracer Study  juga bermanfaat dalam menyediakan informasi penting mengenai hubungan antara pendidikan tinggi dan dunia kerja professional, menilai relevansi pendidikan tinggi, informasi bagi pemangku kepentingan (stakeholders), 
            dan kelengkapan persyaratan bagi akreditasi pendidikan tinggi.
        </p>
        <p>
            Dalam proses Tracer Study, alumni diwajibkan untuk mengisi data pribadi terlebih dahulu sebelum atasan mereka diminta untuk mengisi survei mengenai kinerja dan kompetensi yang dimiliki alumni di tempat kerja. Hal ini bertujuan untuk mendapatkan gambaran yang lebih objektif mengenai kesiapan lulusan dalam menghadapi dunia kerja serta untuk meningkatkan mutu pendidikan di perguruan tinggi.
        </p>
    </div>
</section>

    </main>

    {{-- @include('layouts.footer') --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

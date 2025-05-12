@extends('layouts.headerguest')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<!-- Home Section -->
<section class="home" id="home">
    <div class="home-image">
        <img src="{{ asset('image/image.png') }}" alt="Ilustrasi Tracer Study">
    </div>
    <div class="home-text">
        <h1>Selamat Datang di Website Tracer Study <br>Politeknik Negeri Malang</h1>
        <h2>Langkah Kecil, Dampak Besar!</h2>
        <a href="#" class="btn">Isi Survei</a>
        <a href="#" class="play"><i class="bx bx-play"></i></a>
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
                Tracer Study juga bermanfaat dalam menyediakan informasi penting mengenai hubungan antara pendidikan tinggi dan dunia kerja profesional, menilai relevansi pendidikan tinggi, informasi bagi pemangku kepentingan (stakeholders),
                dan kelengkapan persyaratan bagi akreditasi pendidikan tinggi.
            </p>
            <p>
                Dalam proses Tracer Study, alumni diwajibkan untuk mengisi data pribadi terlebih dahulu sebelum atasan mereka diminta untuk mengisi survei mengenai kinerja dan kompetensi yang dimiliki alumni di tempat kerja. Hal ini bertujuan untuk mendapatkan gambaran yang lebih objektif mengenai kesiapan lulusan dalam menghadapi dunia kerja serta untuk meningkatkan mutu pendidikan di perguruan tinggi.
            </p>
        </div>
    </section>
</main>
@endsection

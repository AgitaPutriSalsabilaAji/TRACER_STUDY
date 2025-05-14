@extends('layouts.headerguest')

@section('content')
    <!-- Import Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="container py-5">
            <div class="card shadow-lg border-0">
                <div class="row g-0">
                    <!-- Left side: Image -->
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('image/wisuda6.png') }}" class="img-fluid" style="max-width: 80%;"
                            alt="Ilustrasi Tracer Study">
                    </div>
                    <!-- Right side: Text Content -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card-body">
                            <h2 class="card-title text-primary mb-3">Selamat Datang di Website Tracer Study <br>Politeknik
                                Negeri Malang</h2>
                            <h3 class="card-subtitle text-muted mb-4">Langkah Kecil, Dampak Besar!</h3>
                            <a href="/form-alumni" class="btn btn-primary btn-lg mb-3">Isi Survei</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main>
        <!-- About Section -->
        <section class="about bg-light py-5" id="tentang">
            <div class="container">
                <h2 class="text-center mb-4">Apa itu Tracer Study?</h2>
                <p class="lead text-justify">
                    Tracer Study adalah salah satu metode yang digunakan oleh perguruan tinggi untuk mengumpulkan data dan
                    umpan balik dari alumni mengenai pengalaman mereka setelah lulus.
                    Informasi yang diperoleh digunakan sebagai bahan evaluasi untuk meningkatkan kualitas pendidikan,
                    kurikulum, serta relevansi program studi dengan dunia kerja.
                </p>
                <p class="text-justify">
                    Tracer Study juga bermanfaat dalam menyediakan informasi penting mengenai hubungan antara pendidikan
                    tinggi dan dunia kerja profesional, menilai relevansi pendidikan tinggi, informasi bagi pemangku
                    kepentingan (stakeholders),
                    dan kelengkapan persyaratan bagi akreditasi pendidikan tinggi.
                </p>
                <p class="text-justify">
                    Dalam proses Tracer Study, alumni diwajibkan untuk mengisi data pribadi terlebih dahulu sebelum atasan
                    mereka diminta untuk mengisi survei mengenai kinerja dan kompetensi yang dimiliki alumni di tempat
                    kerja. Hal ini bertujuan untuk mendapatkan gambaran yang lebih objektif mengenai kesiapan lulusan dalam
                    menghadapi dunia kerja serta untuk meningkatkan mutu pendidikan di perguruan tinggi.
                </p>
            </div>
        </section>
    </main>

    <!-- Import Bootstrap 5 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
@endsection

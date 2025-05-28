@extends('layouts.headerguest')

@section('content')
    <!-- Import Bootstrap 5 CSS & AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Cursor Blink CSS for Typing Effect -->
    <style>
        .cursor {
            display: inline-block;
            animation: blink 0.7s infinite;
            color: #0d6efd;
            font-weight: bold;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
    </style>

@if (session('success'))
    <div id="alertSuccess" class="alert alert-success alert-dismissible fade show"
        role="alert"
        style="
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1100;
            min-width: 400px;
            max-width: 600px;
            padding: 25px 35px;
            font-size: 1.15rem;
            font-weight: 500;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 128, 0, 0.4);
            background: linear-gradient(135deg, #38b000, #70e000);
            color: #ffffff;
            animation: fadeInPop 0.5s ease-out;
        ">
        {{ session('success') }}
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
            data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <style>
        @keyframes fadeInPop {
            0% {
                opacity: 0;
                transform: translate(-50%, -60%) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }
    </style>


        <script>
            setTimeout(() => {
                const alert = document.getElementById('alertSuccess');
                if (alert) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 150);
                }
            }, 3000);
        </script>
    @endif

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="container py-5">
            <div class="card shadow-lg border-0" data-aos="zoom-in" data-aos-duration="1000">
                <div class="row g-0">
                    <!-- Left side: Image -->
                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                        <img src="{{ asset('image/wisuda6.png') }}" class="img-fluid" style="max-width: 80%;" alt="Ilustrasi Tracer Study">
                    </div>
                    <!-- Right side: Text Content -->
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card-body">
                            <h2 class="card-title text-primary mb-3">Selamat Datang di Website Tracer Study <br>Politeknik Negeri Malang</h2>
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
            <div class="container" data-aos="fade-up" data-aos-duration="1200">
                <h2 class="text-center mb-4">
                    <span id="typed-tracer" class="text-primary fw-bold"></span><span class="cursor">|</span>
                </h2>
                <p class="lead text-justify">
                    Tracer Study adalah salah satu metode yang digunakan oleh perguruan tinggi untuk mengumpulkan data dan
                    umpan balik dari alumni mengenai pengalaman mereka setelah lulus. Informasi yang diperoleh digunakan
                    sebagai bahan evaluasi untuk meningkatkan kualitas pendidikan,
                    kurikulum, serta relevansi program studi dengan dunia kerja.
                </p>
                <p class="lead text-justify">
                    Tracer Study juga bermanfaat dalam menyediakan informasi penting mengenai hubungan antara pendidikan
                    tinggi dan dunia kerja profesional, menilai relevansi pendidikan tinggi, informasi bagi pemangku
                    kepentingan (stakeholders),
                    dan kelengkapan persyaratan bagi akreditasi pendidikan tinggi.
                </p>
                <p class="lead text-justify">
                    Dalam proses Tracer Study, alumni diwajibkan untuk mengisi data pribadi terlebih dahulu sebelum atasan
                    mereka diminta untuk mengisi survei mengenai kinerja dan kompetensi yang dimiliki alumni di tempat
                    kerja. Hal ini bertujuan untuk mendapatkan gambaran yang lebih objektif mengenai kesiapan lulusan dalam
                    menghadapi dunia kerja serta untuk meningkatkan mutu pendidikan di perguruan tinggi.
                </p>
                <p class="lead text-justify">
                    Mari dukung dan sukseskan pelaksanaan Tracer Study PoliteknikNegeri Malang untuk kemajuan pendidikan dan karier alumni!
                </p>
            </div>
        </section>
    </main>

  
    <!-- Bootstrap JS, Popper.js, and AOS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Init AOS -->
    <script>
        AOS.init();
    </script>

    <!-- Typing Effect Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const text = "Apa itu Tracer Study?";
            const el = document.getElementById("typed-tracer");
            let i = 0;

            function typeText() {
                if (i < text.length) {
                    el.textContent += text.charAt(i);
                    i++;
                    setTimeout(typeText, 80);
                }
            }

            typeText();
        });
    </script>
@endsection

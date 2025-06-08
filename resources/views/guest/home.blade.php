@extends('layouts.headerguest')

@section('content')
    <!-- Import Bootstrap 5 & AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Cursor Blink CSS for Typing Effect -->
    <style>
        .team-card {
          background: linear-gradient(135deg, #ffffff, #f8fafc);
          border: none;
          border-radius: 1.5rem;
          transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .team-card:hover {
          transform: translateY(-8px);
          box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .team-card img {
          border: 5px solid #fff;
          box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease;
        }

        .team-card:hover img {
          transform: scale(1.05);
        }

        .team-card h5 {
          font-weight: 700;
          color: #2c3e50;
          margin-bottom: 4px;
        }

        .team-card p {
          font-size: 0.95rem;
          color: #6c757d;
        }

        .team-link {
          text-decoration: none;
          color: inherit;
        }

        .team-link:hover h5 {
          color: #0d6efd;
        }
        .cursor {
            display: inline-block;
            animation: blink 0.7s infinite;
            color: #0d6efd;
            font-weight: bold;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0;
            }
        }

        /* Style Card Informasi Tracer Study */
        .container .card {
            margin-top: 2rem;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s;
        }

        .container .card:hover {
            transform: translateY(-5px);
        }

        .icon {
            font-size: 2.5rem;
            color: #0d6efd;
            margin-bottom: 1rem;
            text-align: center;
        }

        .card p {
            font-size: 1.1rem;
            text-align: center;
        }

        .manfaat-section {
            padding: 80px 20px;
            background: #fff;
        }

        .subtitle {
            font-size: 14px;
            color: #a0a0a0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .title {
            font-size: 36px;
            font-weight: bold;
            color: #2c2c2c;
            margin-bottom: 20px;
        }

        .title .highlight {
            color: #0d2186;
        }

        .description {
            color: #4a4a4a;
            max-width: 800px;
            margin-bottom: 40px;
            line-height: 1.7;
        }

        .benefit-boxes {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .benefit-box {
            display: flex;
            flex-direction: row !important;
            /* Paksa horizontal */
            align-items: center;
            background: #fff;
            border-radius: 12px;
            padding: 20px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            gap: 20px;
        }

        .benefit-box .number {
            min-width: 60px;
            min-height: 60px;
            background-color: #0d2186;
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .benefit-box .content {
            flex: 1;
        }

        .benefit-box .content h4 {
            margin: 0;
            font-weight: bold;
            font-size: 1.2rem;
            color: #2c2c2c;
        }

        .benefit-box .content p {
            margin: 0;
            color: #4a4a4a;
            font-size: 1rem;
        }

        /* Tambahan gaya untuk card info */
        .tracer-card {
            border: 1px solid #dbe7f5;
            border-radius: 16px;
            background-color: #ffffff;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .tracer-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 25px rgba(38, 120, 186, 0.2);
        }

        /* Ikon bulat */
        .tracer-card .icon {
            background-color: #2678ba;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .tracer-card {
                padding: 2rem 1.2rem;
            }
        }
    </style>

    @if (session('success') || session('success_atasan'))
        <div id="alertSuccess" class="alert alert-success alert-dismissible fade show" role="alert"
            style="
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 1100;
                min-width: 400px;
                max-width: 600px;
                padding: 20px 30px;
                font-size: 1.2rem;
                font-weight: 600;
                text-align: center;
                border-radius: 15px;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
                background: linear-gradient(135deg, #007bff, #66b2ff);
                color: #ffffff;
                animation: fadeInPop 0.5s ease-out;
                backdrop-filter: blur(8px);
            ">
            <i class="bi bi-check-circle" style="font-size: 1.5rem; margin-right: 10px;"></i>
            🎓 {{ session('success') ?? session('success_atasan') }}
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
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3500);
        </script>
    @endif
    <style>
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animasi untuk gambar */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-heading {
            animation: fadeInDown 1s ease-in-out;
        }

        .animate-image {
            animation: fadeInUp 1s ease-in-out;
        }

        /* Hover efek sederhana untuk tombol */
        .btn-primary:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Hover efek untuk gambar di home */
        .home img:hover {
            transform: scale(1.03);
            transition: transform 0.4s ease;
        }

        /* Hover efek untuk kartu info */
        .card:hover {
            box-shadow: 0 8px 20px rgba(38, 120, 186, 0.4);
            transform: translateY(-8px);
            transition: all 0.3s ease;
        }

        .card-info {
            border-radius: 1rem;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            background: #ffffff;
        }

        .card-info:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 12px 30px rgba(38, 120, 186, 0.35);
            background: linear-gradient(to bottom, #ffffff, #f0f7ff);
        }

        .card-info .icon {
            transition: all 0.3s ease;
        }

        .card-info:hover .icon {
            transform: rotate(360deg) scale(1.1);
            background-color: #1d5d99 !important;
        }
    </style>

    <!-- Home Section -->
    <section class="home py-5" id="home"
        style="background: linear-gradient(to right, #f3f8ff, #e1ecfa); position: relative; overflow: hidden; margin-bottom: 0;">

        <svg style="position: absolute; top: -50px; left: 0; width: 100%; height: auto; z-index: 1;" viewBox="0 0 1440 320"
            data-aos="fade-down" data-aos-duration="1500">
            <path fill="#d0e4ff" fill-opacity="1"
                d="M0,160L60,149.3C120,139,240,117,360,128C480,139,600,181,720,197.3C840,213,960,203,1080,176C1200,149,1320,107,1380,85.3L1440,64L1440,0L1380,0C1320,0,1200,0,1080,0C960,0,840,0,720,0C600,0,480,0,360,0C240,0,120,0,60,0L0,0Z">
            </path>
        </svg>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">

                <!-- Gambar Anime dengan Background Shape -->
                <div class="col-lg-6 text-center mb-5 mb-lg-0 position-relative" data-aos="zoom-in"
                    data-aos-duration="1500">
                    <!-- Blob SVG background -->
                    <div
                        style="position: absolute; top: -30px; left: 50%; transform: translateX(-50%); width: 100%; height: 100%; z-index: -1;">
                        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: auto;">
                            <path fill="#cfe2ff"
                                d="M38.6,-58.2C50.4,-51.2,61.4,-42.4,67.5,-30.9C73.6,-19.5,74.9,-5.3,73.2,9.1C71.5,23.6,66.7,38.2,56.6,48.8C46.5,59.4,31,66,15.8,68.9C0.6,71.7,-14.3,70.8,-30.1,66.7C-45.9,62.5,-62.5,55.1,-70.7,42.5C-79,29.8,-78.9,11.9,-75.7,-4.9C-72.5,-21.6,-66.2,-37.2,-54.9,-46.5C-43.6,-55.9,-27.3,-59,-12.2,-63.2C2.9,-67.5,17.8,-72.9,31.5,-69.3C45.1,-65.6,57.4,-53.3,63.2,-39.8C69,-26.3,68.2,-11.6,64.2,1.3C60.1,14.2,52.8,25.1,41.8,36.2C30.9,47.3,16.4,58.6,0.9,64.2C-14.6,69.9,-29.2,69.9,-41.4,63.7C-53.5,57.5,-63.2,45.1,-67.6,31.1C-72,17.1,-71.1,1.6,-66.8,-11.4C-62.5,-24.3,-54.7,-34.7,-44.9,-43.5C-35.1,-52.2,-23.3,-59.3,-10.3,-62.9C2.7,-66.5,13.7,-66.6,25.5,-63.4C37.4,-60.2,49.9,-53.7,61.1,-44.6C72.4,-35.5,82.4,-24,84.8,-10.7C87.2,2.6,82.1,17.3,72.2,30.1C62.3,42.9,47.5,53.8,32.4,60.2C17.3,66.6,1.9,68.4,-11.9,65.3C-25.8,62.2,-38.1,54.1,-49.2,42.6C-60.3,31.1,-70.3,16.1,-72.3,0C-74.2,-16.1,-68.1,-32.3,-58.4,-46.5C-48.8,-60.7,-35.7,-73.1,-21.6,-77.5C-7.6,-81.8,7.5,-78.1,20.5,-69.7C33.6,-61.3,45.6,-48.1,53.8,-33.1C62.1,-18.1,66.7,-1.4,68.8,15.6C70.9,32.6,70.5,49.9,60.5,59.4C50.5,69,30.8,70.7,11.4,72.8C-7.9,74.9,-25.9,77.2,-41.5,72.1C-57.1,67,-70.3,54.5,-77.1,39.1C-83.9,23.7,-84.2,5.5,-81.3,-12.4C-78.4,-30.3,-72.2,-48.1,-60.4,-58.8C-48.7,-69.5,-31.3,-73,-14.3,-71.4C2.6,-69.8,19.5,-63.3,38.6,-58.2Z"
                                transform="translate(100 100)" />
                        </svg>
                    </div>

                    <!-- Foto -->
                    <div class="slideshow">
                        <img src="{{ asset('image/wisuda2.png') }}" class="slide active img-fluid" alt="Ilustrasi 1"
                            style="width: 100%; position: absolute; top: 0; left: 0; opacity: 1; transition: opacity 1.5s; ">
                        <img src="{{ asset('image/wisuda9.png') }}" class="slide img-fluid" alt="Ilustrasi 2"
                            style="width: 100%; position: absolute; top: 0; left: 0; opacity: 0; transition: opacity 1.5s;">
                        <img src="{{ asset('image/wisuda8.png') }}" class="slide img-fluid" alt="Ilustrasi 3"
                            style="width: 100%; position: absolute; top: 0; left: 0; opacity: 0; transition: opacity 1.5s;">
                        <img src="{{ asset('image/wisuda3.png') }}" class="slide img-fluid" alt="Ilustrasi 4"

                            style="width: 100%; position: absolute; top: 0; left: 0; opacity: 0; transition: opacity 1.5s; ">
                        <img src="{{ asset('image/wisuda5.png') }}" class="slide img-fluid" alt="Ilustrasi 5"
                            style="width: 100%; position: absolute; top: 0; left: 0; opacity: 0; transition: opacity 1.5s;">
                    </div>

                </div>

                <div class="col-lg-6 text-center text-lg-start" data-aos="fade-left" data-aos-duration="1500">
                    <h1 class="fw-bold mb-4 display-6" style="color: #1e2a4a;">
                        Selamat Datang di <br>
                        <span class="text-primary">Tracer Study</span><br>
                        Politeknik Negeri Malang
                    </h1>
                    <p class="lead text-muted mb-4">
                        <strong>Langkah Kecil, Dampak Besar!</strong>
                    </p>
                    <a href="/form-alumni" class="btn btn-lg btn-primary rounded-pill px-5 py-3 shadow-sm">
                        Isi Survei
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5" id="about"
        style="background: linear-gradient(to right, #f3f8ff, #e1ecfa); position: relative; overflow: hidden;">
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center">

                <!-- Teks -->
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1500">
                    <h3 class="display-5 mb-4 fw-bold text-primary">
                        Apa itu Tracer Study?</span>
                    </h3>
                    <p class="px-lg-2" style="font-size: 1.3rem; line-height: 1.6;">
                        <strong>Tracer Study</strong> salah satu metode yang digunakan oleh perguruan tinggi untuk
                        mengumpulkan data dan umpan balik dari alumni mengenai pengalaman mereka setelah lulus.Informasi
                        yang diperoleh digunakan sebagai bahan evaluasi untuk meningkatkan kualitas pendidikan, kurikulum,
                        serta relevansi program studi dengan dunia kerja.
                    </p>
                </div>

                <!-- Gambar -->
                <div class="col-lg-6 text-center mt-4 mt-lg-0" data-aos="fade-left" data-aos-duration="1500">
                    <img src="{{ asset('image/tracer-study.png') }}" class="img-fluid w-100" alt="Ilustrasi Tracer Study">

                </div>
    </section>


    <section class="py-5 bg-light" id="team">
        <div class="container">
            <div class="row text-center mb-5" data-aos="fade-down" data-aos-duration="1200">
                <div class="col">
                    <h2 class="fw-bold text-primary">Proses Tracer Study</h2>
                    </h3>
                </div>
            </div>

            <div class="row text-center mb-5" data-aos="zoom-in" data-aos-duration="1500">
                <div class="col-md-12 col-lg-12">
                    <p class="px-lg-2" style="font-size: 1.3rem; line-height: 1.6;">
                        Dalam proses <strong>Tracer Study</strong>, alumni diwajibkan untuk mengisi data pribadi terlebih
                        dahulu sebelum atasan mereka diminta untuk mengisi survei mengenai kinerja dan kompetensi yang
                        dimiliki alumni di tempat kerja. Hal ini bertujuan untuk mendapatkan gambaran yang lebih objektif
                        mengenai kesiapan lulusan dalam menghadapi dunia kerja serta untuk meningkatkan mutu pendidikan di
                        perguruan tinggi.
                    </p>
                </div>
            </div>
        </div>

        <section
            class="elementor-section elementor-top-section elementor-element elementor-element-0f3b447 elementor-section-boxed elementor-section-height-default elementor-section-height-default"
            data-id="0f3b447" data-element_type="section">
            <div class="elementor-container elementor-column-gap-default">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-6cdf037"
                    data-id="6cdf037" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                        <div class="elementor-element elementor-element-550df19 elementor-widget elementor-widget-heading"
                            data-id="550df19" data-element_type="widget" data-widget_type="heading.default">
                        </div>
                        <div class="elementor-element elementor-element-a316555 elementor-widget elementor-widget-image"
                            data-id="a316555" data-element_type="widget" data-widget_type="image.default">
                            <div class="elementor-widget-container">
                                <img src="{{ asset('image/alur.jpg') }}" alt="Mekanisme Pengisian Tracer Study"
                                    style="max-width: 100%; height: auto; display: block; margin: 0 auto;"
                                    class="animate-image" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="py-5 bg-light" id="team">
            <div class="container">
                <div class="row text-center mb-5" data-aos="fade-down" data-aos-duration="1200">
                    <div class="col">
                        <h2 class="fw-bold text-primary">Manfaat Tracer Study</h2>
                        <p class="text-muted">Beberapa manfaat penting dari pelaksanaan tracer study bagi perguruan tinggi
                            dan pemangku kepentingan</p>
                    </div>
                </div>

                <div class="row g-4">

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card tracer-card h-100 text-center p-4">
                            <div class="icon mb-3 mx-auto">
                                <i class="fas fa-clipboard-list text-white fs-4"></i>
                            </div>
                            <p class="mb-0">
                                Mengevaluasi relevansi kurikulum dengan kebutuhan dunia kerja untuk memastikan lulusan siap
                                menghadapi tantangan profesional.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card tracer-card h-100 text-center p-4">
                            <div class="icon mb-3 mx-auto">
                                <i class="fas fa-chart-pie text-white fs-4"></i>
                            </div>
                            <p class="mb-0">
                                Menyediakan data akurat sebagai dasar pengambilan keputusan dalam peningkatan mutu
                                pendidikan tinggi secara berkelanjutan.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                        <div class="card tracer-card h-100 text-center p-4">
                            <div class="icon mb-3 mx-auto">
                                <i class="fas fa-award text-white fs-4"></i>
                            </div>
                            <p class="mb-0">
                                Memberikan informasi penting yang dibutuhkan dalam proses akreditasi dan laporan kepada
                                pemangku kepentingan.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>

       <section class="py-5 bg-light" id="team">
  <div class="container">
    <!-- Judul Section -->
    <div class="row text-center mb-5" data-aos="fade-down" data-aos-duration="1200">
      <div class="col">
        <h2 class="fw-bold text-primary">Tim Kami</h2>
        <p class="text-muted">Tim profesional yang berdedikasi untuk memberikan yang terbaik</p>
      </div>
    </div>

    <!-- Baris Anggota Tim -->
    <div class="row g-4">
      
      <!-- Member 1: Purnama Rizky Nugraha -->
      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <a href="https://www.instagram.com/purnama_ridzkyn/" target="_blank" class="team-link">
            <img src="image/pur2.jpg" alt="Purnama Rizky Nugraha" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
            <h5>Purnama Rizky Nugraha</h5>
          </a>
          <p class="text-primary mb-1">2341760037</p>
          <p class="fst-italic text-muted small">
            "Purnama mengerjakan template dan dashboard admin lengkap dengan seluruh chart visualisasi. Ia juga membuat middleware untuk pengaturan akses dan validasi pengisian form. Serta pengaplikasian soft delete. Sebagai project manager, Purnama turut membackup semua anggota jika ada kendala teknis."
          </p>
        </div>
      </div>

      <!-- Member 2: Agita Putri Salsabila Aji -->
      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <a href="https://www.instagram.com/gitabillaa_/" target="_blank" class="team-link">
            <img src="image/2.jpg" alt="Agita Putri Salsabila Aji" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
            <h5>Agita Putri Salsabila Aji</h5>
          </a>
          <p class="text-primary mb-1">2341760092</p>
          <p class="fst-italic text-muted small">
            "Agita membuat fitur export dan import data untuk memudahkan pengelolaan data dalam jumlah besar. Ia juga mengembangkan CRUD untuk pengelola profesi dan kategori profesi, memastikan data tersimpan secara terstruktur."
          </p>
        </div>
      </div>

      <!-- Member 3: Desi Karmila -->
      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <a href="https://www.instagram.com/desikaaaml_/" target="_blank" class="team-link">
            <img src="image/1.png" alt="Desi Karmila" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
            <h5>Desi Karmila</h5>
          </a>
          <p class="text-primary mb-1">2341760177</p>
          <p class="fst-italic text-muted small">
            "Desi mengerjakan fitur lupa password dan ganti kata sandi, serta membuat CRUD untuk data admin dan data alumni. Ia memastikan proses manajemen akun dan data alumni berjalan lancar dan aman."
          </p>
        </div>
      </div>

      <!-- Member 4: Siska Nuri Aprilia -->
      <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <a href="https://www.instagram.com/siskanurii_/" target="_blank" class="team-link">
            <img src="image/3.png" alt="Siska Nuri Aprilia" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
            <h5>Siska Nuri Aprilia</h5>
          </a>
          <p class="text-primary mb-1">2341760038</p>
          <p class="fst-italic text-muted small">
            "Siska membuat tampilan front-end halaman user seperti halaman login, registrasi, beranda, dan halaman profesi. Ia juga bertugas dalam merancang struktur database awal dan membantu dokumentasi teknis proyek."
          </p>
        </div>
    </div>
    </div>
  </div>
</section>
<section class="py-5 bg-light" id="dosen">
  <div class="container">
    <!-- Judul Section -->
    <div class="row text-center mb-5" data-aos="fade-down" data-aos-duration="1200">
      <div class="col">
        <h2 class="fw-bold text-primary">Dosen Pengampu</h2>
        <p class="text-muted">Para dosen yang membimbing dan memberikan arahan selama proyek ini</p>
      </div>
    </div>

    <!-- Baris Dosen Pengampu -->
    <div class="row g-4">

      <!-- Dosen 1 -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <img src="image/dosen2.png" alt="Hj. Lilis Nurhayati" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
          <h5>Dr. Indra Dharma Wijaya, ST., MMT.</h5>
          <p class="text-primary mb-1">NIP: 197305102008011010</p>
          <p class="fst-italic text-muted small">"Memberikan arahan teknis dan mendampingi pengujian sistem."</p>
        </div>

      <!-- Dosen 2 -->
      </div>
        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <img src="image/dosen1.png" alt="Dr. Ir. Ahmad Santoso" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
          <h5>Muhammad Unggul Pamenang, S.ST., M.T.</h5>
          <p class="text-primary mb-1">NIP: 196512101991031002</p>
          <p class="fst-italic text-muted small">"Membimbing struktur proyek dan memastikan standar akademik."</p>
        </div>
      </div>

      <!-- Dosen 3 -->
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
        <div class="card team-card p-4 text-center h-100">
          <img src="image/dosen3.png" alt="Rama Dwi Saputra" class="rounded-circle mx-auto mb-3" style="width: 110px; height: 110px; object-fit: cover;">
          <h5>Farida Ulfa S.Pd., M.Pd.</h5>
          <p class="text-primary mb-1">NIP: 198201052010121001</p>
          <p class="fst-italic text-muted small">"Mengawasi kemajuan tim dan memberikan masukan dokumentasi."</p>
        </div>
      </div>

    </div>
  </div>
</section>




        <!-- JS Assets -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
        <script>
            AOS.init();
        </script>

        <!-- Typing Effect Script -->
        {{-- <script>
            document.addEventListener("DOMContentLoaded", function() {
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
        </script> --}}


        <style>
            .slideshow {
                position: relative;
                max-width: 71%;
                margin: auto;
                aspect-ratio: 1024 / 1293;
                /* Supaya tinggi div sesuai lebar dan proporsional */
                overflow: hidden;
                z-index: 2;

            }

            .slideshow-wrapper::after {
                content: "";
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 80px;
                background: linear-gradient(to bottom, rgba(255, 255, 255, 0), #ffffff);
                pointer-events: none;
            }
        </style>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const slides = document.querySelectorAll(".slide");
                let current = 0;

                setInterval(() => {
                    slides[current].style.opacity = 0;
                    current = (current + 1) % slides.length;
                    slides[current].style.opacity = 1;
                }, 5000);
            });
        </script>
    @endsection

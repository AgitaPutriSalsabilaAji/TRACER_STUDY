<!-- Footer -->
<div class="bg-light border-top mt-5 w-100">
  <footer class="container py-5">
    <div class="row">
      <!-- Logo dan Deskripsi -->
      <div class="col-md-5 mb-4 mb-md-0 d-flex flex-column justify-content-between">
        <div class="d-flex align-items-center mb-3">
          <img src="image/logo_polinema.png" alt="Logo Polinema" height="60" class="me-3">
          <div>
            <h5 class="mb-0 fw-bold text-dark">TRACER <span class="text-primary">STUDY</span></h5>
            <small class="text-muted">Politeknik Negeri Malang</small>
          </div>
        </div>
        <p class="text-muted mb-3">
          Direktorat Pembelajaran dan Kemahasiswaan<br>
          Politeknik Negeri Malang
        </p>
        <div class="d-flex gap-4">
          <a href="#" class="text-muted fs-5 social-icon" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-muted fs-5 social-icon" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-muted fs-5 social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-muted fs-5 social-icon" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
          <a href="#" class="text-muted fs-5 social-icon" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
        </div>
      </div>

      <!-- Alamat -->
      <div class="col-md-4 mb-4 mb-md-0">
        <h6 class="text-uppercase fw-bold text-muted mb-3">Alamat</h6>
        <p class="text-muted mb-0" style="line-height:1.6;">
          Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru<br>
          Kota Malang, Jawa Timur 65141
        </p>
      </div>

      <!-- Kontak -->
      <div class="col-md-3">
        <h6 class="text-uppercase fw-bold text-muted mb-3">Kontak</h6>
        <p class="text-muted mb-0">tracerstudy@polinema.ac.id</p>
      </div>
    </div>

    <hr class="my-4">

    <div class="text-center text-muted small">
      &copy; {{ date('Y') }} Politeknik Negeri Malang. All rights reserved.
    </div>
  </footer>
</div>

<style>
  /* Hover effect untuk icon sosial media */
  .social-icon {
    transition: color 0.3s ease;
  }
  .social-icon:hover {
    color: #0d6efd; /* warna biru bootstrap */
    text-decoration: none;
  }

  /* Tambahan agar footer responsif dan rapi */
  @media (max-width: 767.98px) {
    footer .row > div {
      text-align: center;
    }
    footer .d-flex.gap-4 {
      justify-content: center;
    }
  }
</style>

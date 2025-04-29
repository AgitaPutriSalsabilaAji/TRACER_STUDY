<header class="main-header bg-white shadow-sm py-2">
    <div class="container d-flex justify-content-between align-items-center">
        
        <!-- Logo dan Judul -->
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo_kemdikbud.png') }}" alt="Logo Kemdikbud" width="60" class="mr-3">
            <div>
                <h4 class="mb-0 font-weight-bold">TRACER <span class="text-primary">STUDY</span></h4>
                <small>Politeknik Negeri Malang</small>
            </div>
        </div>

        <!-- Menu Navigasi -->
        <nav class="d-none d-md-block">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'text-primary font-weight-bold' : '' }}" href="{{ url('/') }}">Homepage</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Data Alumni</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Isi Survei</a></li>
            </ul>
        </nav>

        <!-- Dropdown Bahasa + Tombol Login -->
        <div class="d-flex align-items-center">
            <!-- Dropdown Bahasa -->
            <div class="dropdown mr-2">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bahasa
                </button>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                    <a class="dropdown-item" href="?lang=id">Bahasa Indonesia</a>
                    <a class="dropdown-item" href="?lang=en">Bahasa Inggris</a>
                </div>
            </div>
            <!-- Tombol Login -->
            <a href="{{ url('/login') }}" class="btn btn-primary btn-sm">Login Atasan</a>
        </div>
    </div>
</header>

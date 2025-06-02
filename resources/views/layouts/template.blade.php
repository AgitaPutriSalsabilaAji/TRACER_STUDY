<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tracer Study Polinema</title>
    <link rel="icon" href="{{ asset('image/logo_polinema.png') }}" type="image/png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href={{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}>
    <!-- IonIcons -->
    <link rel="stylesheet" href='https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <!-- Theme style -->
    <link rel="stylesheet" href={{ asset('adminlte/dist/css/adminlte.css') }}>
    <link rel="stylesheet" href="{{ asset('css/dashboard/sidebar-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/datatables-csutom.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- data tables  --}}
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>


<body class="hold-transition sidebar-mini layout-navbar-fixed">
    <!-- Preloader -->
    <div class="preloader dark flex-column justify-content-center align-items-center">
        <img class="animation__wobble" src="{{ asset('image/logo_polinema.png') }}" alt="AdminLTELogo" height="60"
            width="60">
    </div>

<!-- Modal -->
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        
        <!-- Modal Header -->
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="changePasswordModalLabel">Ubah Password</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
  
        <!-- Modal Body -->
        <div class="modal-body bg-white">
          <form method="POST" action="{{ route('password.update') }}">
            @csrf
  
            <!-- Old Password -->
            <div class="mb-3">
              <label for="old_password" class="form-label">Password Lama</label>
              <div class="input-group">
                <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Masukkan password lama Anda" required>
                <span class="input-group-text">
                  <i class="fa-solid fa-eye toggle-password" data-target="old_password" style="cursor: pointer;"></i>
                </span>
              </div>
            </div>
  
            <!-- New Password -->
            <div class="mb-3">
              <label for="new_password" class="form-label">Password Baru</label>
              <div class="input-group">
                <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" placeholder="Masukkan password baru Anda" required>
                <span class="input-group-text">
                  <i class="fa-solid fa-eye toggle-password" data-target="new_password" style="cursor: pointer;"></i>
                </span>
              </div>
              <small class="text-muted">Password harus minimal 8 karakter.</small>
              @error('new_password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
  
            <!-- Confirm New Password -->
            <div class="mb-3">
              <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru Anda</label>
              <div class="input-group">
                <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" placeholder="Konfirmasi password baru Anda" required>
                <span class="input-group-text">
                  <i class="fa-solid fa-eye toggle-password" data-target="new_password_confirmation" style="cursor: pointer;"></i>
                </span>
              </div>
            </div>
  
            <button type="submit" class="btn btn-primary w-100">Update Password</button>
          </form>
        </div>
  
      </div>
    </div>
  </div>
  

    <div class="wrapper">

        @include('layouts.header')
        @include('layouts.sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->


        <!-- Main Footer -->
        <footer class="main-footer" style="text-align: center;">
            <strong>Copyright &copy; 2025 Tracer Study Politeknik Negeri Malang</strong>
        </footer>


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('adminlte\plugins\chart.js\Chart.min.js') }}"></script>

    <script src="{{ asset('js/navbar-custom.js') }}"></script>
    {{-- datatables --}}
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>
    {{-- Modal --}}
    <script>
        document.querySelectorAll('.toggle-password').forEach(function(icon) {
          icon.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
          });
        });
      </script>
      

</body>

</html>

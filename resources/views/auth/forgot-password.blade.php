<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .login-card {
            max-width: 900px;
            margin: auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        .login-image {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        @media (max-width: 768px) {
            .login-image {
                height: 250px;
            }
        }

        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 60px;
            padding-bottom: 60px;
        }
    </style>
</head>

<body class="bg-light">
<main>
    <div class="container py-5">
        <div class="card login-card">
            <div class="row g-0">
                <!-- Gambar -->
                <div class="col-md-6 order-0 order-md-0">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                         alt="forgot password image" class="login-image">
                </div>

                <!-- Form -->
                <div class="col-md-6 order-1 order-md-1">
                    <div class="card-body p-4">
                        <h4 class="card-title text-center mb-4">Lupa Password</h4>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email </label>
                                <input type="email" name="email" class="form-control" placeholder="Masukan email" required autofocus>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Kirim Password Baru</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('login') }}">Kemabali ke Halaman Login</a>
                            </div>
                        </form>

                        {{-- Pesan sukses dari reset --}}
                        @if (session('forgot_success') && session('from_forgot'))
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: '{{ session('forgot_success') }}',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                setTimeout(function () {
                                    window.location.href = "{{ route('login', ['login_msg' => 1]) }}";
                                }, 3000);
                            </script>
                            @php
                                session()->forget('from_forgot');
                            @endphp
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-primary text-white text-center py-3 mt-5">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div>Copyright © 2020. All rights reserved.</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
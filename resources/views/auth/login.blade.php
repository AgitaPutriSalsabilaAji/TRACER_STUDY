<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url("{{ asset('image/polinema.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .login-box {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            overflow: hidden;
            background-color: #fff;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
        }

        .card-body {
            padding: 2rem;
        }

        .login-logo a {
            font-size: 2rem;
            font-weight: 600;
            color: #4e73df;
            text-decoration: none;
            letter-spacing: 1px;
        }

        .login-box-msg {
            font-size: 16px;
            margin-bottom: 20px;
            text-align: center;
            color: #555;
        }

        .form-control {
            font-size: 15px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .password-wrapper .toggle-password:hover {
            color: #4e73df;
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3b5fc3;
            border-color: #3b5fc3;
        }

        .btn-primary:active {
            background-color: #2c4bb6;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .forgot-password {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password a {
            color: #4e73df;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="overlay"></div>

    <div class="login-box">
        <div class="card">
            <div class="card-body login-card-body">
                <div class="login-logo mb-3 text-center">
                    <a href="#"><b>Tracer</b>Study</a>
                </div>

                <p class="login-box-msg">Login to start your session</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username or Email"
                            required>
                    </div>
                    <div class="mb-3 position-relative">
                        <input type="password" name="password" class="form-control" placeholder="Password"
                            id="password" required>
                        <span class="fas fa-eye position-absolute" id="togglePassword"
                            style="top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember Me</label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>


                <p class="forgot-password">
                    <a href="#">I forgot my password</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        // Toggle password visibility
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>

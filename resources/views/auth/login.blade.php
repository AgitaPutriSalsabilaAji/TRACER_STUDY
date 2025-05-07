<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
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
            /* Atur sesuai kebutuhan */
            padding-bottom: 60px;
        }
    </style>
</head>

<body class="bg-light">
    <main>
        <div class="container py-5">
            <div class="card login-card">
                <div class="row g-0">
                    <!-- Gambar: Di atas saat mobile, di kiri saat desktop -->
                    <div class="col-md-6 order-0 order-md-0">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                            alt="login image" class="login-image">
                    </div>

                    <!-- Form: Di bawah saat mobile, di kanan saat desktop -->
                    <div class="col-md-6 order-1 order-md-1">
                        <div class="card-body p-4">
                            <h4 class="card-title text-center mb-4">Login</h4>
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                  <label class="form-label" for="username">Username address</label>
                                  <input type="text" id="username" name="username" class="form-control" placeholder="Enter a valid username" />
                                </div>
                              
                                <div class="form-outline mb-3 position-relative">
                                  <label class="form-label" for="password">Password</label>
                                  <div class="input-group">
                                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" />
                                    <span class="input-group-text">
                                      <i class="fa-solid fa-eye" id="togglePassword" style="cursor: pointer;"></i>
                                    </span>
                                  </div>
                                </div>
                              
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="remember" name="remember" />
                                    <label class="form-check-label" for="remember">Remember me</label>
                                  </div>
                                  <a href="#" class="text-decoration-none">Forgot password?</a>
                                </div>
                              
                                <div class="d-grid">
                                  <button type="submit" class="btn btn-primary">Login</button>
                                </div>
                              </form>
                              
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
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>

</html>

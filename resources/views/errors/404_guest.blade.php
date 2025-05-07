
    <style>
        .center-404-wrapper {
            min-height: calc(100vh - 4.5rem);
            /* kurangi header/footer kalau ada */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .error-card {
            max-width: 700px;
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .error-header {
            background-color: #5a8dee;
            /* Warna biru template */
            border-radius: 15px 15px 0 0;
            padding: 1rem;
            color: #fff;
            font-weight: bold;
        }

        .error-message {
            text-align: center;
            margin: 2rem 0;
        }

        .error-message h1 {
            font-size: 5rem;
            font-weight: 700;
            color: #ff6347;
            /* Oranye untuk aksen */
        }

        .error-message h4 {
            font-size: 1.5rem;
            color: #333;
        }

        .error-message p {
            font-size: 1.2rem;
            color: #555;
        }

        .error-message a {
            color: #5a8dee;
            /* Sesuaikan warna dengan template */
            font-weight: 500;
            text-decoration: none;
        }

        .error-message a:hover {
            text-decoration: underline;
        }

        .btn-light {
            background-color: #fff;
            color: #5a8dee;
            border: 1px solid #5a8dee;
        }

        .btn-light:hover {
            background-color: #e2e8f0;
            color: #5a8dee;
            border-color: #5a8dee;
        }
    </style>
    {{-- <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 white">
              <h1>Tidak ada apa apa</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard" class="breadcrumb-item">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tidak ditemukan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section> --}}
    <div class="center-404-wrapper">
        <div class="card error-card">
            <div class="card-header error-header">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">404 Error</h3>
                    <a href="{{ url('/') }}" class="btn btn-light">Return Home</a>
                </div>
            </div>

            <div class="card-body">
                <div class="error-message">
                    <h1>404</h1>
                    <h4><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h4>
                    <p>
                        We couldn't find the page you were looking for. Maybe it was moved or never existed.
                        Meanwhile, you may <a href="{{ url('/dashboard') }}">return to the dashboard</a>.
                    </p>
                </div>

                <div class="d-flex justify-content-center">
                    <span class="text-muted">Error code: 404</span>
                </div>
            </div>
        </div>
    </div>


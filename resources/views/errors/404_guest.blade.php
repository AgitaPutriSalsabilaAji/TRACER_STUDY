<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
        }

        .error-card {
            max-width: 600px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .error-header {
            background-color: #5a8dee;
            color: white;
            padding: 1rem 1.5rem;
        }

        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: #ff6347;
        }

        .error-message p {
            color: #6c757d;
        }

        .btn-home {
            background-color: #fff;
            color: #5a8dee;
            border: 1px solid #5a8dee;
        }

        .btn-home:hover {
            background-color: #e2e8f0;
        }
    </style>
</head>

<body>

    <div class="error-wrapper">
        <div class="card error-card">
            <div class="card-header error-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">404 Error</h5>
                <a href="{{ url('/') }}" class="btn btn-sm btn-home">Return Home</a>
            </div>
            <div class="card-body text-center error-message">
                <div class="error-code">404</div>
                <h4 class="mb-3"><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h4>
                <p class="mb-4">The page you are looking for might have been removed, had its name changed, or is
                    temporarily unavailable.</p>
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
            <div class="card-footer text-center text-muted">
                Error code: 404
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>

</html>

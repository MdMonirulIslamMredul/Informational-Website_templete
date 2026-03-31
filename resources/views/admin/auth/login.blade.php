<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Admin Login</h4>
                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif
                        <form method="POST" action="{{ route('admin.login.submit') }}">@csrf<div class="mb-3"><label
                                    class="form-label">Email</label><input name="email" type="email"
                                    class="form-control" value="admin@admin.com" required></div>
                            <div class="mb-3"><label class="form-label">Password</label><input name="password"
                                    type="password" class="form-control" value="12345678" required></div><button
                                class="btn btn-dark w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

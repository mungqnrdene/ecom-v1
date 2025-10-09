<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Нэвтрэх | Манай Дэлгүүр</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: #fff;
        }
        .form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.5);
        }
        .btn-primary {
            background-color: #2575fc;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #1a52c0;
        }
        .form-error {
            color: #dc3545;
            font-size: 0.9rem;
        }
        .logo {
            font-weight: 700;
            font-size: 1.8rem;
            color: #2575fc;
            text-align: center;
            margin-bottom: 1.5rem;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="card shadow">
        <div class="logo">Манай Дэлгүүр</div>
        <h3 class="text-center mb-4">Нэвтрэх</h3>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Имэйл хаяг</label>
                <input id="email" type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Нууц үг</label>
                <input id="password" type="password"
                    class="form-control @error('password') is-invalid @enderror"
                    name="password" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Намайг сана</label>

            </div>

            <button type="submit" class="btn btn-primary w-100">Нэвтрэх</button>

            <div class="text-center mt-3">
                <p>Хэрэв бүртгэлгүй бол?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-secondary">Шинээр бүртгүүлэх</a>
            </div>


            {{-- <div class="mt-3 text-center">
                <a href="{{ route('password.request') }}">Нууц үгээ мартсан?</a>
            </div> --}}
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

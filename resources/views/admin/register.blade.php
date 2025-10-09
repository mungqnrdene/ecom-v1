<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Бүртгүүлэх | Манай Онлайн Дэлгүүр</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .card {
            border-radius: 1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            max-width: 480px;
            width: 100%;
            background-color: #ffffffcc;
            backdrop-filter: saturate(180%) blur(10px);
            padding: 2rem;
        }

        .card h2 {
            font-weight: 700;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #34495e;
        }

        input.form-control {
            border-radius: 0.5rem;
            border: 1.8px solid #ddd;
            transition: border-color 0.3s ease;
        }

        input.form-control:focus {
            border-color: #2575fc;
            box-shadow: 0 0 8px rgba(37, 117, 252, 0.4);
        }

        .btn-primary {
            background-color: #2575fc;
            border: none;
            font-weight: 600;
            border-radius: 0.7rem;
            padding: 0.6rem 1.2rem;
            width: 100%;
            box-shadow: 0 4px 14px rgba(37, 117, 252, 0.4);
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1859d6;
        }

        .text-muted {
            color: #7f8c8d !important;
        }

        .form-error {
            color: #e74c3c;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .login-link {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.9rem;
            color: #34495e;
        }

        .login-link a {
            color: #2575fc;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
    <div class="card shadow-sm">
        <h2>Шинэ хэрэглэгч бүртгүүлэх</h2>

        <form method="POST" action="{{ route('register.submit') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="form-label">Нэр</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label">И-мэйл хаяг</label>
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Нууц үг</label>
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Нууц үг давтах</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Бүртгүүлэх</button>
        </form>

        <div class="login-link">
            <p>Бүртгэлтэй юу? <a href="{{ route('login') }}">Нэвтрэх</a></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

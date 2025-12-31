<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Light Shop')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
        }

        .navbar {
            backdrop-filter: blur(20px);
            background: rgba(15, 23, 42, 0.9) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dropdown-menu {
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(16px);
        }

        .dropdown-item:hover {
            background: rgba(59, 130, 246, 0.2);
        }
    </style>
</head>

<body class="bg-dark text-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark border-bottom border-secondary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold"
                href="{{ Auth::guard('admin')->check() ? route('admin.dashboard') : (Auth::guard('web')->check() ? route('users.welcome') : route('welcome')) }}">
                ✨ Light Shop
            </a>

            <div class="d-flex align-items-center gap-3">

                {{-- ================= ADMIN ================= --}}
                @if (Auth::guard('admin')->check())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            👤 {{ Auth::guard('admin')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.login') }}">
                                    🏠 Нүүр
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    📊 Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.products.index') }}">
                                    📦 Бараа
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        🚪 Гарах
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    {{-- ================= USER ================= --}}
                @elseif (Auth::guard('web')->check())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            👤 {{ Auth::guard('web')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('users.welcome') }}">
                                    🏠 Нүүр
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('users.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        🚪 Гарах
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    {{-- ================= GUEST ================= --}}
                @else
                    <a href="{{ route('users.login') }}" class="btn btn-sm btn-outline-light">
                        Нэвтрэх
                    </a>
                    <a href="{{ route('users.register') }}" class="btn btn-sm btn-light">
                        Бүртгүүлэх
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <!-- FLASH MESSAGES -->
    <main>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show m-3">
                <strong>Алдаа:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-black text-secondary py-4 mt-5">
        <div class="container text-center">
            <small>&copy; 2025 Light Shop — Бүх эрх хүлээлэгдэнэ</small>
        </div>
    </footer>
    <script>
        // Save scroll position
        window.addEventListener("beforeunload", function() {
            localStorage.setItem("scrollY", window.scrollY);
        });

        // Restore scroll position
        window.addEventListener("load", function() {
            const scrollY = localStorage.getItem("scrollY");
            if (scrollY !== null) {
                window.scrollTo(0, parseInt(scrollY));
            }
        });
    </script>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

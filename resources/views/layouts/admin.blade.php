<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Light Shop')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
        }
    </style>

    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark admin-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                🏪 Light Shop Admin
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">📊 Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link admin-nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                            href="{{ route('admin.products.index') }}">📦 Бараа</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link admin-nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
                            href="{{ route('admin.orders') }}">🛒 Захиалга</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link admin-nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}"
                            href="{{ route('admin.reports') }}">📈 Тайлан</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle admin-nav-link" href="#" data-bs-toggle="dropdown">
                            👤 {{ Auth::guard('admin')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.settings') }}">⚙️ Тохиргоо</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">🚪 Гарах</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>

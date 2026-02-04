<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Light Shop')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Custom CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">

    @stack('styles')

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            padding-top: 64px;
            /* Reserve space for fixed navbar */
        }

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            backdrop-filter: blur(20px);
            background: rgba(15, 23, 42, 0.95) !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform;
        }

        .navbar.navbar-hidden {
            transform: translateY(-100%);
            box-shadow: none;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Enhanced Dropdown Styles */
        .dropdown-toggle {
            border: 1.5px solid rgba(59, 130, 246, 0.35);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.18), rgba(139, 92, 246, 0.18));
            color: #e5e7eb;
            backdrop-filter: blur(12px);
            padding: 0.6rem 1rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.2);
        }

        .dropdown-toggle:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.28), rgba(139, 92, 246, 0.28));
            border-color: rgba(59, 130, 246, 0.6);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
        }

        .dropdown-toggle:focus,
        .dropdown-toggle:active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.32), rgba(139, 92, 246, 0.32));
            border-color: rgba(59, 130, 246, 0.7);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            color: #fff;
        }

        .dropdown-menu {
            border: 1px solid rgba(59, 130, 246, 0.2);
            background: rgba(10, 15, 30, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 14px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.6);
            animation: dropdownFadeIn 0.25s ease;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 0.25rem;
            font-weight: 500;
            color: #e2e8f0;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:last-child {
            margin-bottom: 0;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.35), rgba(139, 92, 246, 0.35));
            color: #fff;
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        }

        .dropdown-item:active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.35), rgba(139, 92, 246, 0.35));
        }

        .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        .dropdown-item.text-danger:hover {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(220, 38, 38, 0.25));
            color: #fca5a5;
        }

        /* Profile Picture in Dropdown Toggle */
        .dropdown-toggle img,
        .dropdown-toggle span[style*="border-radius: 50%"] {
            transition: all 0.3s ease;
        }

        .dropdown-toggle:hover img,
        .dropdown-toggle:hover span[style*="border-radius: 50%"] {
            transform: scale(1.1);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        /* Smooth scroll for better UX */
        html {
            scroll-behavior: smooth;
        }

        /* Ensure main content starts below navbar */
        main {
            min-height: calc(100vh - 64px);
        }

        /* Search Bar Styles */
        .search-container {
            position: relative;
            max-width: 500px;
            width: 100%;
        }

        .search-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: #e5e7eb;
            padding: 10px 45px 10px 20px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .search-input::placeholder {
            color: #9ca3af;
        }

        .search-btn {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-50%) scale(1.05);
        }

        .search-results {
            position: absolute;
            top: calc(100% + 10px);
            left: 0;
            right: 0;
            background: rgba(30, 41, 59, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            max-height: 400px;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            z-index: 1000;
            display: none;
        }

        .search-results.show {
            display: block;
        }

        .search-result-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .search-result-item:hover {
            background: rgba(59, 130, 246, 0.15);
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .search-result-info {
            flex: 1;
        }

        .search-result-name {
            color: #e5e7eb;
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }

        .search-result-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1rem;
        }

        .search-no-results {
            padding: 30px;
            text-align: center;
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 56px;
            }

            .navbar {
                padding: 0.5rem 1rem;
            }
        }
    </style>
</head>

<body class="bg-dark text-light">

    @php
        $brandRoute = \Illuminate\Support\Facades\Route::has('welcome') ? route('welcome') : url('/');

        if (Auth::guard('admin')->check() && \Illuminate\Support\Facades\Route::has('admin.dashboard')) {
            $brandRoute = route('admin.dashboard');
        } elseif (Auth::guard('web')->check() && \Illuminate\Support\Facades\Route::has('users.dashboard')) {
            $brandRoute = route('users.dashboard');
        }
    @endphp

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark border-bottom border-secondary" id="mainNavbar">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ $brandRoute }}">
                ✨ Light Shop
            </a>

            {{-- Search Bar (Only for logged-in users) --}}
            @if (Auth::guard('web')->check())
                <div class="search-container mx-3 flex-grow-1" style="max-width: 450px;">
                    <form
                        action="{{ \Illuminate\Support\Facades\Route::has('users.search') ? route('users.search') : '#' }}"
                        method="GET" id="searchForm">
                        <input type="text" name="q" id="searchInput" class="search-input"
                            placeholder="🔍 Бараа хайх..." autocomplete="off">
                        <button type="submit" class="search-btn">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                    <div class="search-results" id="searchResults"></div>
                </div>
            @endif

            <div class="d-flex align-items-center gap-3">

                {{-- ================= ADMIN ================= --}}
                @if (Auth::guard('admin')->check())
                    <div class="dropdown">
                        <button class="btn btn-sm btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            👤 {{ Auth::guard('admin')->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('admin.welcome') ? route('admin.welcome') : '#' }}">
                                    🏠 Нүүр
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}">
                                    📊 Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('admin.products.index') ? route('admin.products.index') : '#' }}">
                                    📦 Бараа
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('admin.orders') ? route('admin.orders') : '#' }}">
                                    🛒 Захиалга
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('admin.reports') ? route('admin.reports') : '#' }}">
                                    📈 Тайлан
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST"
                                    action="{{ \Illuminate\Support\Facades\Route::has('admin.logout') ? route('admin.logout') : '#' }}">
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
                        <button class="btn btn-sm btn-light dropdown-toggle d-flex align-items-center gap-2"
                            type="button" data-bs-toggle="dropdown">
                            @if (Auth::guard('web')->user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::guard('web')->user()->profile_picture) }}"
                                    alt="Profile"
                                    style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(59, 130, 246, 0.5);">
                            @else
                                <span
                                    style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #8b5cf6); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; color: white;">
                                    {{ strtoupper(substr(Auth::guard('web')->user()->name, 0, 1)) }}
                                </span>
                            @endif
                            <span>{{ Auth::guard('web')->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('users.dashboard') ? route('users.dashboard', ['section' => 'profile']) : '#' }}">
                                    👤 Профайл
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('users.dashboard') ? route('users.dashboard') : '#' }}">
                                    🏠 Нүүр
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('users.dashboard') ? route('users.dashboard', ['section' => 'orders']) : '#' }}">
                                    📦 Захиалга
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item"
                                    href="{{ \Illuminate\Support\Facades\Route::has('users.dashboard') ? route('users.dashboard', ['section' => 'settings']) : '#' }}">
                                    ⚙️ Тохиргоо
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST"
                                    action="{{ \Illuminate\Support\Facades\Route::has('users.logout') ? route('users.logout') : '#' }}">
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
                    <a href="{{ \Illuminate\Support\Facades\Route::has('users.login') ? route('users.login') : '#' }}"
                        class="btn btn-sm btn-outline-light">
                        Нэвтрэх
                    </a>
                    <a href="{{ \Illuminate\Support\Facades\Route::has('users.register') ? route('users.register') : '#' }}"
                        class="btn btn-sm btn-light">
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

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3">
                {{ session('error') }}
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
        // ==================== SMART AUTO-HIDE NAVBAR ====================
        (function() {
            const navbar = document.getElementById('mainNavbar');
            if (!navbar) return;

            let lastScrollTop = 0;
            let scrollThreshold = 10; // Minimum scroll distance to trigger hide/show
            let isScrolling = false;
            let ticking = false;

            // Use requestAnimationFrame for smooth performance
            function updateNavbar(scrollTop) {
                const scrollDelta = scrollTop - lastScrollTop;

                // Only act if scroll distance exceeds threshold
                if (Math.abs(scrollDelta) < scrollThreshold) {
                    return;
                }

                if (scrollTop > lastScrollTop && scrollTop > 80) {
                    // Scrolling DOWN and past threshold - hide navbar
                    navbar.classList.add('navbar-hidden');
                } else {
                    // Scrolling UP - show navbar
                    navbar.classList.remove('navbar-hidden');
                }

                lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
            }

            // Optimized scroll handler with requestAnimationFrame
            function handleScroll() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (!ticking) {
                    window.requestAnimationFrame(function() {
                        updateNavbar(scrollTop);
                        ticking = false;
                    });
                    ticking = true;
                }
            }

            // Attach scroll listener with passive for better performance
            window.addEventListener('scroll', handleScroll, {
                passive: true
            });

            // Optional: Show navbar when dropdown is opened
            const dropdownToggles = navbar.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    navbar.classList.remove('navbar-hidden');
                });
            });

            // Ensure navbar is visible on page load
            navbar.classList.remove('navbar-hidden');
        })();

        // ==================== SCROLL POSITION PERSISTENCE ====================
        window.addEventListener("beforeunload", function() {
            localStorage.setItem("scrollY", window.scrollY);
        });

        window.addEventListener("load", function() {
            const scrollY = localStorage.getItem("scrollY");
            if (scrollY !== null) {
                window.scrollTo(0, parseInt(scrollY));
            }
        });

        // ==================== LIVE SEARCH ====================
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        if (searchInput && searchResults) {
            let searchTimeout;

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.classList.remove('show');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`/users/search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.products && data.products.length > 0) {
                                let html = '';
                                data.products.forEach(product => {
                                    html += `
                                        <a href="/products/${product.id}" class="search-result-item">
                                            <img src="${product.image || 'https://via.placeholder.com/50'}" 
                                                 alt="${product.name}" 
                                                 class="search-result-img">
                                            <div class="search-result-info">
                                                <div class="search-result-name">${product.name}</div>
                                                <div class="search-result-price">${product.price_formatted}₮</div>
                                            </div>
                                        </a>
                                    `;
                                });
                                searchResults.innerHTML = html;
                                searchResults.classList.add('show');
                            } else {
                                searchResults.innerHTML = `
                                    <div class="search-no-results">
                                        <i class="bi bi-search" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">Бараа олдсонгүй</p>
                                    </div>
                                `;
                                searchResults.classList.add('show');
                            }
                        })
                        .catch(error => {
                            console.error('Search error:', error);
                            searchResults.classList.remove('show');
                        });
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.remove('show');
                }
            });

            // Navigate when clicking a search result item
            searchResults.addEventListener('click', function(e) {
                const link = e.target.closest('.search-result-item');
                if (link && link.href) {
                    window.location.href = link.href;
                }
            });

            // Show results again when input is focused and has value
            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2 && searchResults.innerHTML) {
                    searchResults.classList.add('show');
                }
            });
        }
    </script>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <title>E-Commerce | User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #020617, #0f172a);
            color: #e5e7eb;
        }

        /* ================= HEADER ================= */
        .header {
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1000;
        }

        .logo {
            font-weight: 800;
            font-size: 20px;
            letter-spacing: .2px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            color: #a78bfa;
            filter: drop-shadow(0 8px 18px rgba(167, 139, 250, .25));
        }

        /* AUTH BUTTONS */
        .auth-buttons {
            display: flex;
            gap: 12px;
        }

        .login-btn {
            padding: 10px 22px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.35);
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all .25s ease;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.22);
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.14);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(255, 255, 255, 0.12);
        }

        .register-btn {
            padding: 10px 22px;
            border-radius: 999px;
            border: 1px solid rgba(34, 197, 94, .35);
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #03120a;
            font-size: 15px;
            font-weight: 800;
            text-decoration: none;
            transition: all .25s ease;
            box-shadow: 0 10px 28px rgba(34, 197, 94, 0.25);
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(34, 197, 94, 0.38);
        }

        /* ================= MAIN ================= */
        .main {
            margin-top: 70px;
            padding: 30px;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ================= HERO SECTION ================= */
        .hero-section {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 92px 44px;
            text-align: center;
            margin-bottom: 70px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            box-shadow: 0 30px 90px rgba(0, 0, 0, 0.55);

            background:
                radial-gradient(600px 280px at 20% 20%, rgba(96, 165, 250, .25), transparent 55%),
                radial-gradient(520px 260px at 85% 55%, rgba(167, 139, 250, .22), transparent 60%),
                linear-gradient(135deg, rgba(2, 6, 23, .92), rgba(15, 23, 42, .88));
        }

        .hero-section::before {
            content: "";
            position: absolute;
            inset: -2px;
            background: linear-gradient(120deg,
                    rgba(96, 165, 250, .22),
                    rgba(167, 139, 250, .18),
                    rgba(236, 72, 153, .12));
            filter: blur(48px);
            opacity: .55;
            pointer-events: none;
        }

        .hero-inner {
            position: relative;
            max-width: 900px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #cbd5f5;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 18px;
            backdrop-filter: blur(10px);
        }

        .hero-section h1 {
            font-size: 64px;
            font-weight: 800;
            margin-bottom: 14px;
            letter-spacing: -1px;

            background: linear-gradient(90deg, #60a5fa, #a78bfa, #ec4899);
            background-size: 220% 220%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;

            animation: heroGlow 6s ease infinite;
        }

        @keyframes heroGlow {
            0% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }

            100% {
                background-position: 0% 50%
            }
        }

        .hero-section p {
            font-size: 18px;
            color: #d1d5db;
            max-width: 760px;
            margin: 0 auto;
            line-height: 1.85;
        }

        .hero-actions {
            margin-top: 28px;
            display: flex;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .hero-btn {
            padding: 12px 22px;
            border-radius: 999px;
            font-weight: 800;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: .25s ease;
        }

        .hero-primary {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #03120a;
            box-shadow: 0 16px 44px rgba(34, 197, 94, .22);
            border: 1px solid rgba(34, 197, 94, .30);
        }

        .hero-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 60px rgba(34, 197, 94, .35);
        }

        .hero-ghost {
            border: 1px solid rgba(255, 255, 255, 0.22);
            background: rgba(255, 255, 255, 0.06);
            color: #e5e7eb;
            backdrop-filter: blur(10px);
        }

        .hero-ghost:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.32);
        }

        .hero-features {
            margin-top: 26px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .hero-features span {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #cbd5f5;
            font-weight: 700;
            font-size: 14px;
        }

        /* ================= SECTION CARDS ================= */
        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 70px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.30);
        }

        .title-gradient-blue {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .title-gradient-purple {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 45px;
            text-align: center;
            background: linear-gradient(135deg, #a78bfa, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .title-gradient-green {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 40px;
            text-align: center;
            background: linear-gradient(135deg, #34d399, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-card p {
            font-size: 1.1rem;
            line-height: 1.85;
            color: #d1d5db;
        }

        /* ================= TECH ================= */
        .tech-section {
            background:
                radial-gradient(650px 260px at 20% 30%, rgba(139, 92, 246, 0.14), transparent 55%),
                radial-gradient(560px 260px at 85% 55%, rgba(59, 130, 246, 0.12), transparent 60%),
                rgba(255, 255, 255, 0.04);
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 70px;
            border: 1px solid rgba(139, 92, 246, 0.22);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.30);
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 22px;
            margin-top: 10px;
        }

        .tech-item {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 20px;
            padding: 28px 18px;
            text-align: center;
            transition: all .25s ease;
            cursor: pointer;
        }

        .tech-item:hover {
            transform: translateY(-10px) scale(1.04);
            box-shadow: 0 22px 46px rgba(139, 92, 246, 0.35);
            border-color: rgba(139, 92, 246, 0.50);
            background: rgba(139, 92, 246, 0.14);
        }

        .tech-item i {
            font-size: 3.6rem;
            margin-bottom: 14px;
            display: block;
            transition: transform .35s ease;
        }

        .tech-item:hover i {
            transform: rotate(360deg);
        }

        .tech-item .tech-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #e5e7eb;
            margin: 0;
        }

        /* colors keep */
        .fa-html5 {
            color: #e34c26;
        }

        .fa-css3-alt {
            color: #264de4;
        }

        .fa-js {
            color: #f0db4f;
        }

        .fa-php {
            color: #777bb4;
        }

        .fa-laravel {
            color: #ff2d20;
        }

        .fa-database {
            color: #00758f;
        }

        /* ================= CONTACT ================= */
        .contact-section {
            background:
                radial-gradient(650px 260px at 20% 30%, rgba(34, 197, 94, 0.16), transparent 55%),
                radial-gradient(560px 260px at 85% 55%, rgba(16, 185, 129, 0.14), transparent 60%),
                rgba(255, 255, 255, 0.04);
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 50px;
            border: 1px solid rgba(34, 197, 94, 0.25);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.30);
        }

        .contact-section a {
            color: #93c5fd;
            text-decoration: none;
            transition: all .2s;
        }

        .contact-section a:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 26px;
            border: 1px solid rgba(255, 255, 255, 0.10);
        }

        .section-title {
            font-weight: 800;
            margin-bottom: 10px;
            color: #f3f4f6;
            font-size: 1.05rem;
        }

        .contact-text {
            color: #d1d5db;
            font-size: 1.05rem;
            margin-bottom: 0;
        }

        /* ================= PRODUCTS SECTION ================= */
        .products-section {
            background:
                radial-gradient(650px 260px at 20% 30%, rgba(251, 191, 36, 0.14), transparent 55%),
                radial-gradient(560px 260px at 85% 55%, rgba(245, 158, 11, 0.12), transparent 60%),
                rgba(255, 255, 255, 0.04);
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 50px;
            border: 1px solid rgba(251, 191, 36, 0.25);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.30);
        }

        .title-gradient-orange {
            font-size: 2.6rem;
            font-weight: 800;
            margin-bottom: 40px;
            text-align: center;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(251, 191, 36, 0.3);
            border-color: rgba(251, 191, 36, 0.4);
        }

        .product-img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .product-body {
            padding: 20px;
        }

        .product-name {
            color: #f3f4f6;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 12px;
        }

        .product-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .product-badge {
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-stock {
            background: rgba(34, 197, 94, 0.15);
            color: #34d399;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .badge-size {
            background: rgba(139, 92, 246, 0.15);
            color: #a78bfa;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .product-description {
            color: #9ca3af;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 0;
        }

        .view-all-btn {
            display: inline-block;
            margin: 30px auto 0;
            padding: 14px 32px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border: 1px solid rgba(251, 191, 36, 0.4);
            border-radius: 999px;
            color: #0f172a;
            font-weight: 800;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 8px 24px rgba(251, 191, 36, 0.3);
        }

        .view-all-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(251, 191, 36, 0.4);
            color: #020617;
        }

        .no-products {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .no-products i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #4b5563;
        }

        .social-links {
            display: flex;
            gap: 18px;
            margin-top: 26px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .social-links a {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            font-size: 1.7rem;
            transition: all .25s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            transform: translateY(-5px) scale(1.08);
            box-shadow: 0 10px 26px rgba(59, 130, 246, 0.45);
            border-color: #93c5fd;
            background: rgba(59, 130, 246, 0.18);
        }

        .social-links .fa-envelope {
            color: #ef4444;
        }

        .social-links .fa-x-twitter {
            color: #1da1f2;
        }

        .social-links .fa-facebook {
            color: #1877f2;
        }

        .social-links .fa-instagram {
            color: #e4405f;
        }

        .map-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 18px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.10);
            margin-top: 30px;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {
            .hero-section {
                padding: 60px 22px;
            }

            .hero-section h1 {
                font-size: 38px;
            }

            .hero-section p {
                font-size: 16px;
            }

            .glass-card,
            .tech-section,
            .contact-section {
                padding: 40px 25px;
            }

            .title-gradient-blue,
            .title-gradient-purple,
            .title-gradient-green {
                font-size: 2rem;
            }

            .tech-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 18px;
            }

            .tech-item i {
                font-size: 3rem;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">
            <i class="fa-solid fa-lightbulb"></i>
            <span>Light Shop</span>
        </div>

        @if (!Auth::guard('web')->check())
            <div class="auth-buttons">
                <a href="{{ route('users.login') }}" class="login-btn">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Нэвтрэх
                </a>
                <a href="{{ route('users.register') }}" class="register-btn">
                    <i class="fa-solid fa-user-plus me-2"></i>Бүртгүүлэх
                </a>
            </div>
        @else
            <div class="d-flex align-items-center gap-2">
                <span class="text-light fw-bold">
                    <i class="fa-solid fa-circle-user me-2"></i>{{ Auth::guard('web')->user()->name }}
                </span>
                <form method="POST" action="{{ route('users.logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-arrow-right-from-bracket me-2"></i>Гарах
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">

        <!-- HERO SECTION -->
        <section class="hero-section">
            <div class="hero-inner">
                <div class="hero-badge">
                    <i class="fa-solid fa-sparkles"></i>
                    Modern online shopping
                </div>

                <h1>Light Shop</h1>

                <p>
                    Light Shop нь орчин үеийн технологид суурилсан онлайн худалдааны вэбсайт юм.
                    Бид хэрэглэгчдэд хялбар, найдвартай, аюулгүй онлайн худалдааны туршлага санал болгодог.
                </p>

                <div class="hero-actions">
                    <a href="#about" class="hero-btn hero-primary">
                        <i class="fa-solid fa-store"></i>Танилцах
                    </a>
                    <a href="#contact" class="hero-btn hero-ghost">
                        <i class="fa-solid fa-headset"></i>Холбоо барих
                    </a>
                </div>

                <div class="hero-features">
                    <span><i class="fa-solid fa-shield-halved"></i>Аюулгүй</span>
                    <span><i class="fa-solid fa-bolt"></i>Хурдан</span>
                    <span><i class="fa-solid fa-truck-fast"></i>Хүргэлттэй</span>
                </div>
            </div>
        </section>

        <!-- ABOUT US SECTION -->
        <section class="glass-card" id="about">
            <h2 class="title-gradient-blue">
                <i class="fa-solid fa-book-open me-2"></i>Бидний тухай
            </h2>

            <p class="mb-4">
                Light Shop нь орчин үеийн технологид суурилсан онлайн худалдааны вэбсайт юм.
                Бид хэрэглэгчдэд хялбар, найдвартай, аюулгүй онлайн худалдааны туршлага санал болгодог.
            </p>
            <p class="mb-0">
                Манай систем нь Laravel framework дээр бүтээгдсэн бөгөөд хэрэглэгчид бараа үзэх, хадгалах,
                захиалах, төлбөр төлөх зэрэг бүх үйлдлийг хялбараар гүйцэтгэх боломжтой.
            </p>
        </section>

        <!-- NEW PRODUCTS SECTION -->
        <section class="products-section" id="products">
            <h2 class="title-gradient-orange">
                <i class="fa-solid fa-star me-2"></i>Шинэ бүтээгдэхүүн
            </h2>

            @if ($products->isEmpty())
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <h5>Одоогоор бараа байхгүй байна</h5>
                    <p>Удахгүй шинэ бүтээгдэхүүнүүд нэмэгдэх болно!</p>
                </div>
            @else
                <div class="products-grid">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/280x200' }}"
                                alt="{{ $product->name }}" class="product-img">
                            <div class="product-body">
                                <h5 class="product-name">{{ $product->name }}</h5>
                                <div class="product-price">{{ number_format($product->price) }}₮</div>

                                <div class="product-meta">
                                    @if ($product->quantity > 0)
                                        <span class="product-badge badge-stock">
                                            <i class="fas fa-box me-1"></i>{{ $product->quantity }} ширхэг
                                        </span>
                                    @endif
                                    @if ($product->size)
                                        <span class="product-badge badge-size">
                                            <i class="fas fa-ruler me-1"></i>{{ $product->size }}
                                        </span>
                                    @endif
                                </div>

                                <p class="product-description">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    <a href="{{ route('users.login') }}" class="view-all-btn">
                        <i class="fas fa-shopping-bag me-2"></i>Бүх бүтээгдэхүүн үзэх
                    </a>
                </div>
            @endif
        </section>

        <!-- TECHNOLOGY STACK SECTION -->
        <section class="tech-section">
            <h2 class="title-gradient-purple">
                <i class="fa-solid fa-gears me-2"></i>Ашигласан технологи
            </h2>

            <div class="tech-grid">
                <div class="tech-item">
                    <i class="fab fa-html5"></i>
                    <p class="tech-name">HTML</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-css3-alt"></i>
                    <p class="tech-name">CSS3</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-js"></i>
                    <p class="tech-name">JavaScript</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-php"></i>
                    <p class="tech-name">PHP</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-laravel"></i>
                    <p class="tech-name">Laravel</p>
                </div>
                <div class="tech-item">
                    <i class="fas fa-database"></i>
                    <p class="tech-name">MySQL</p>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION -->
        <section class="contact-section" id="contact">
            <h2 class="title-gradient-green">
                <i class="fa-solid fa-phone-volume me-2"></i>Холбоо барих
            </h2>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="contact-info">
                        <p class="section-title"><i class="fas fa-envelope me-2"></i>Имэйл</p>
                        <p class="contact-text">
                            <a href="mailto:mongoldei0212@gmail.com">mongoldei0212@gmail.com</a>
                        </p>

                        <p class="section-title mt-4"><i class="fas fa-phone me-2"></i>Утас</p>
                        <p class="contact-text">
                            <a href="tel:+97695297999">+976 9529 7999</a>
                        </p>

                        <p class="section-title mt-4"><i class="fas fa-map-marker-alt me-2"></i>Хаяг</p>
                        <p class="contact-text">Улаанбаатар, Сүхбаатар дүүрэг, 1-р хороо, ЮНЕСКО-гийн гудамж C-Блок</p>

                        <p class="section-title mt-4"><i class="fas fa-clock me-2"></i>Ажлын цаг</p>
                        <p class="contact-text mb-0">Даваа - Баасан: 09:00 - 18:00</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="contact-info text-center">
                        <p class="section-title"><i class="fas fa-share-alt me-2"></i>Интернет хаягууд</p>
                        <div class="social-links">
                            <a href="mailto:mongoldei0212@gmail.com" title="Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="https://x.com/mungunrs?s=21" target="_blank" rel="noopener"
                                title="Twitter / X">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/share/1FoBAfhNLL/?mibextid=wwXIfr" target="_blank"
                                rel="noopener" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/_mungqn_erdene?igsh=MW1oYWpteHFyNHc3MA%3D%3D&utm_source=qr"
                                target="_blank" rel="noopener" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>

                    <div class="row mt-0">
                        <div class="col-12">
                            <div class="map-container">
                                <p class="section-title text-center mb-3">
                                    <i class="fas fa-map-marked-alt me-2"></i>Манай байршил
                                </p>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2900.7628324966427!2d106.92761217647187!3d47.90904976704308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5d9693d56738aaa1%3A0x30b065f0d3ca97e5!2sM%20Smart%20Academy!5e1!3m2!1sen!2smn!4v1767289859757!5m2!1sen!2smn"
                                    width="100%" height="360"
                                    style="border:0; border-radius:16px; box-shadow:0 12px 30px rgba(0,0,0,.25);"
                                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </div>

</body>

</html>

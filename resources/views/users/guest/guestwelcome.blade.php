<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <title>E-Commerce | User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

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
            font-weight: 700;
            font-size: 20px;
        }

        /* HEADER RIGHT */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icon-btn {
            position: relative;
            cursor: pointer;
            font-size: 18px;
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: #ef4444;
            font-size: 10px;
        }

        /* AUTH BUTTONS */
        .auth-buttons {
            display: flex;
            gap: 10px;
        }

        .login-btn {
            padding: 8px 18px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: transparent;
            color: #fff;
            font-size: 14px;
            text-decoration: none;
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.15);
        }

        .register-btn {
            padding: 8px 18px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            font-size: 14px;
            text-decoration: none;
        }

        .register-btn:hover {
            opacity: 0.9;
        }

        /* ================= SIDEBAR ================= */
        .sidebar {
            position: fixed;
            top: 70px;
            left: 0;
            width: 240px;
            height: calc(100vh - 70px);
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(14px);
            padding: 20px;
        }

        .sidebar a {
            display: block;
            padding: 12px 16px;
            margin-bottom: 6px;
            border-radius: 10px;
            color: #e5e7eb;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar a.active {
            background-color: #434343ff;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        /* ================= MAIN ================= */
        .main {
            margin-left: 240px;
            margin-top: 70px;
            padding: 30px;
        }

        /* PRODUCT CARD */
        .product-card {
            background: rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            overflow: hidden;
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-6px);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-body {
            padding: 16px;
        }
        .product-body a{
            text-decoration: none;
            color: #e5e7eb;
        }

        .buy-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 999px;
            padding: 8px;
            color: #fff;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">🛒 Light Shop</div>

        <div class="header-actions">
            <div class="icon-btn">🔍</div>

            <div class="icon-btn">
                <a href="{{ route('users.login') }}">🛍️</a>
                <span class="badge">0</span>
            </div>

            <!-- GUEST: LOGIN / REGISTER BUTTONS -->
            @if (!Auth::guard('web')->check())
                <div class="auth-buttons">
                    <a href="{{ route('users.login') }}" class="login-btn">Нэвтрэх</a>
                    <a href="{{ route('users.register') }}" class="register-btn">Бүртгүүлэх</a>
                </div>
            @else
                <!-- LOGGED IN: PROFILE & LOGOUT -->
                <div class="d-flex align-items-center gap-2">
                    <span class="text-light fw-bold">{{ Auth::guard('web')->user()->name }}</span>
                    <form method="POST" action="{{ route('users.logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Гарах</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <a href="{{ route('welcome') }}" class="{{ request()->routeIs('welcome') ? 'active' : '' }}">🛒 Бараанууд</a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">📞 Холбоо барих</a>
    </div>

    <!-- MAIN -->
    <div class="main">
        <h3>Бараанууд</h3>

        <div class="row g-4 mt-2">
            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="product-card">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x250?text={{ urlencode($product->name) }}"
                                alt="{{ $product->name }}">
                        @endif
                        <div class="product-body">
                            <h5>{{ $product->name }}</h5>
                            <p>💰 {{ number_format($product->price) }}₮</p>
                            @if (Auth::guard('web')->check())
                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <button class="buy-btn">Сагсанд нэмэх</button>
                                </form>
                            @else
                                <a href="{{ route('users.login') }}" class="buy-btn text-center d-block">
                                    Нэвтэрч байж сагсанд нэмнэ
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Бараа олдсонгүй</p>
                </div>
            @endforelse
        </div>
    </div>

</body>
<script>
    < /html>

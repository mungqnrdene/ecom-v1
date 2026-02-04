@extends('layouts.user')

@section('title', 'Бараа - Light Shop')

@push('styles')
    <style>
        /* Page Header */
        .products-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(147, 51, 234, 0.25));
            border-radius: 22px;
            padding: 28px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.5);
        }

        .products-header h3 {
            color: #e5e7eb;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        .products-header p {
            color: #9ca3af;
            margin: 0;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cart-btn {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #e5e7eb;
            padding: 10px 20px;
            border-radius: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
            color: #60a5fa;
            transform: translateY(-2px);
        }

        .badge-pill {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #fff;
            border-radius: 20px;
            padding: 4px 10px;
            font-size: 0.85rem;
            font-weight: 700;
            min-width: 24px;
            text-align: center;
        }

        /* Product Cards */
        .product-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 16px 50px rgba(59, 130, 246, 0.4);
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 220px;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            color: #e5e7eb;
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 12px;
        }

        .product-description {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 16px;
            line-height: 1.5;
            flex: 1;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .buy-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 14px;
            padding: 12px 20px;
            color: #fff;
            flex: 1;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
        }

        .buy-btn:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.5);
        }

        .wishlist-btn {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #f87171;
            padding: 12px 16px;
            border-radius: 14px;
            transition: all 0.3s ease;
        }

        .wishlist-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            border-color: rgba(239, 68, 68, 0.5);
            color: #ef4444;
        }

        /* Stock Info */
        .product-meta-info {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .product-stock {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(34, 197, 94, 0.3);
            transition: all 0.3s ease;
        }

        .product-stock.low-stock {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.3);
            animation: pulse 2s infinite;
        }

        .product-stock.out-of-stock {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.3);
        }

        .product-size {
            background: rgba(139, 92, 246, 0.15);
            color: #a78bfa;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .out-of-stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .product-card.out-of-stock .out-of-stock-overlay {
            opacity: 1;
        }

        .out-of-stock-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 16px 32px;
            border-radius: 16px;
            font-size: 1.2rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 10px 40px rgba(239, 68, 68, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: fadeInScale 0.5s ease;
        }

        .buy-btn:disabled {
            background: rgba(75, 85, 99, 0.5);
            cursor: not-allowed;
            opacity: 0.6;
        }

        .buy-btn:disabled:hover {
            transform: none;
            box-shadow: none;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Empty State */
        .empty-state {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 60px 40px;
            text-align: center;
        }

        .empty-state i {
            color: #374151;
            font-size: 4rem;
        }

        .empty-state h5 {
            color: #9ca3af;
            margin-top: 20px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .products-header {
                padding: 20px;
            }

            .header-actions {
                flex-direction: column;
                width: 100%;
            }

            .cart-btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('page')
    @php
        $cartCount = 0;
        if (Auth::guard('web')->user() && Auth::guard('web')->user()->cart) {
            $cartCount = Auth::guard('web')->user()->cart->cartItems()->sum('quantity');
        }
    @endphp

    <!-- Page Header -->
    <div class="products-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h3>
                    <i class="bi bi-shop me-2"></i>
                    Сайн байна уу, {{ Auth::guard('web')->user()->name ?? 'Зочин' }}
                </h3>
                <p>Онцлох бараануудыг үзэж, сагсанд нэмээрэй 🛍️</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('cart.index') }}" class="cart-btn">
                    <i class="bi bi-cart3"></i>
                    Сагс
                    @if ($cartCount > 0)
                        <span class="badge-pill">{{ $cartCount }}</span>
                    @endif
                </a>
                <a href="{{ route('users.wishlist') }}" class="cart-btn">
                    <i class="bi bi-heart"></i>
                    Хадгалсан
                </a>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-lg-4 col-md-6">
                <div class="product-card {{ $product->quantity <= 0 ? 'out-of-stock' : '' }}">
                    <div class="product-img-wrapper">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x220' }}"
                            alt="{{ $product->name }}">
                        <div class="product-overlay"></div>
                        @if ($product->quantity <= 0)
                            <div class="out-of-stock-overlay">
                                <div class="out-of-stock-badge">
                                    <i class="bi bi-x-circle me-2"></i>ДУУССАН
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="product-body">
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <div class="product-price">{{ number_format($product->price) }}₮</div>

                        <div class="product-meta-info">
                            @if ($product->quantity > 0)
                                <span class="product-stock {{ $product->quantity <= 5 ? 'low-stock' : '' }}">
                                    <i class="bi bi-box-seam"></i>
                                    {{ $product->quantity }} ширхэг
                                </span>
                            @else
                                <span class="product-stock out-of-stock">
                                    <i class="bi bi-x-circle"></i>
                                    Дууссан
                                </span>
                            @endif
                            @if ($product->size)
                                <span class="product-size">
                                    <i class="bi bi-rulers"></i>
                                    {{ $product->size }}
                                </span>
                            @endif
                        </div>

                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        <div class="product-actions">
                            <form method="POST" action="{{ route('cart.add', $product->id) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="buy-btn w-100"
                                    {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                    @if ($product->quantity <= 0)
                                        <i class="bi bi-x-circle me-1"></i>
                                        Дууссан
                                    @else
                                        <i class="bi bi-cart-plus me-1"></i>
                                        Сагсанд нэмэх
                                    @endif
                                </button>
                            </form>
                            <form method="POST" action="{{ route('users.wishlist.add', $product) }}">
                                @csrf
                                <button type="submit" class="wishlist-btn">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="bi bi-box-seam"></i>
                    <h5>Бараа олдсонгүй</h5>
                </div>
            </div>
        @endforelse
    </div>
@endsection

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
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x220' }}"
                            alt="{{ $product->name }}">
                        <div class="product-overlay"></div>
                    </div>
                    <div class="product-body">
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <div class="product-price">{{ number_format($product->price) }}₮</div>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        <div class="product-actions">
                            <form method="POST" action="{{ route('cart.add', $product->id) }}" style="flex: 1;">
                                @csrf
                                <button type="submit" class="buy-btn w-100">
                                    <i class="bi bi-cart-plus me-1"></i>
                                    Сагсанд нэмэх
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

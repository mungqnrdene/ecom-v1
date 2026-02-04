@extends('layouts.app')

@section('title', $product->name ?? 'Барааны дэлгэрэнгүй')

@push('styles')
    <style>
        .product-detail-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.4);
            overflow: hidden;
        }

        .product-detail-media {
            min-height: 320px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.95));
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-detail-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-detail-body {
            padding: 24px;
        }

        .product-detail-title {
            font-weight: 700;
            font-size: 1.6rem;
            color: #e5e7eb;
            margin-bottom: 10px;
        }

        .product-detail-price {
            color: #34d399;
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 12px;
        }

        .product-detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 18px;
        }

        .product-detail-pill {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .product-detail-desc {
            color: #cbd5f5;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .product-detail-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .product-detail-actions .btn {
            border-radius: 12px;
            font-weight: 600;
        }

        .btn-cart {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: #fff;
            border: none;
        }

        .btn-cart:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
        }

        .btn-buy {
            background: linear-gradient(135deg, #34d399, #10b981);
            color: #fff;
            border: none;
        }

        .btn-buy:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #fff;
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h3 class="mb-0">Барааны дэлгэрэнгүй</h3>
            <a href="{{ route('products') }}" class="btn btn-sm btn-outline-light">Бараа руу буцах</a>
        </div>

        <div class="product-detail-card">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="product-detail-media">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="text-muted">Зураг байхгүй</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="product-detail-body">
                        <div class="product-detail-title">{{ $product->name }}</div>
                        <div class="product-detail-price">₮ {{ number_format($product->price) }}</div>

                        <div class="product-detail-meta">
                            <span class="product-detail-pill">
                                <i class="bi bi-tag me-1"></i>
                                {{ $product->category?->name ?? 'Ангилаагүй' }}
                            </span>
                            <span class="product-detail-pill">
                                <i class="bi bi-box-seam me-1"></i>
                                Үлдэгдэл: {{ $product->quantity ?? 0 }}
                            </span>
                            @if ($product->size)
                                <span class="product-detail-pill">
                                    <i class="bi bi-aspect-ratio me-1"></i>
                                    {{ $product->size }}
                                </span>
                            @endif
                        </div>

                        <div class="product-detail-desc">
                            {{ $product->description ?: 'Дэлгэрэнгүй мэдээлэл оруулаагүй байна.' }}
                        </div>

                        <div class="product-detail-actions">
                            @if (Auth::guard('web')->check())
                                <form method="POST" action="{{ route('cart.add', $product) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-cart">
                                        <i class="bi bi-cart-plus me-1"></i>Сагсанд хийх
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('cart.buy', $product) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-buy">
                                        <i class="bi bi-bag-check me-1"></i>Шууд авах
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('users.login') }}" class="btn btn-cart">
                                    <i class="bi bi-box-arrow-in-right me-1"></i>Нэвтрээд авах
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

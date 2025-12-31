@extends('layouts.user')

@section('title', 'Нүүр - Light Shop')

@push('styles')
    <style>
        .product-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.02));
            border-radius: 20px;
            overflow: hidden;
            transition: all .4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .product-card:hover {
            transform: translateY(-8px) scale(1.02);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 12px 48px rgba(59, 130, 246, 0.3);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover
        }

        .product-body {
            padding: 16px
        }

        .buy-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 999px;
            padding: 12px 24px;
            color: #fff;
            width: 100%;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all .3s ease;
            box-shadow: 0 4px 16px rgba(34, 197, 94, 0.3);
        }

        .buy-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(34, 197, 94, 0.5);
        }

        .badge-pill {
            background: #ef4444;
            color: #fff;
            border-radius: 999px;
            padding: 2px 8px;
            font-size: 12px
        }
    </style>
@endpush

@section('page')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="mb-1">Сайн байна уу, {{ Auth::guard('web')->user()->name ?? 'Зочин' }}</h3>
            <p class="text-muted mb-0">Онцлох бараануудыг үзэж, сагсанд нэмээрэй.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('cart.index') }}" class="btn btn-outline-light btn-sm d-flex align-items-center gap-2">
                🛍️ Сагс <span class="badge-pill">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>
            <a href="{{ route('users.payment-card') }}" class="btn btn-outline-success btn-sm">💳 Төлбөр</a>
        </div>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4">
                <div class="product-card h-100">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x200' }}"
                        alt="{{ $product->name }}">
                    <div class="product-body">
                        <h5 class="mb-1">{{ $product->name }}</h5>
                        <p class="text-success fw-semibold mb-2">₮ {{ number_format($product->price) }}</p>
                        <p class="text-muted small mb-3">{{ Str::limit($product->description, 90) }}</p>
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <button class="buy-btn">Сагсанд нэмэх</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-secondary">Бараа олдсонгүй.</div>
            </div>
        @endforelse
    </div>
@endsection

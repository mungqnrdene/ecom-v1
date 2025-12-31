@extends('layouts.user')

@section('title', 'User Dashboard')

@push('styles')
    <style>
        .dash-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 24px;
            transition: all .3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .dash-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            border-color: rgba(59, 130, 246, 0.3);
        }
    </style>
@endpush

@section('page')
    <h3 class="mb-4">👋 Сайн байна уу, {{ Auth::guard('web')->user()->name ?? 'User' }}</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="dash-card">
                <p class="text-muted mb-1">Нийт бараа</p>
                <h4 class="mb-0">{{ $products->count() }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-card">
                <p class="text-muted mb-1">Сагс дахь бараа</p>
                <h4 class="mb-0">{{ session('cart') ? count(session('cart')) : 0 }}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dash-card">
                <p class="text-muted mb-1">Шинэ санал</p>
                <h4 class="mb-0">🔥</h4>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Шинэ бүтээгдэхүүн</h5>
    <div class="row g-3">
        @foreach ($products->take(12) as $product)
            <div class="col-md-4">
                <div class="dash-card h-100">
                    
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <strong>{{ $product->name }}</strong>
                        <span class="text-success">₮ {{ number_format($product->price) }}</span>
                    </div>
                    <p class="text-muted small mb-3">{{ Str::limit($product->description, 70) }}</p>
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-primary w-100">Сагсанд нэмэх</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection

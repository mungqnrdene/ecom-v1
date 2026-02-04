@extends('layouts.admin')

@section('title', 'Бараа управлах - Light Shop')

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Product catalog</span>
                <h1 class="admin-page-title">📦 Бүтээгдэхүүний удирдлага</h1>
                <p class="admin-page-subtitle">Каталог дахь бүх бүтээгдэхүүн, тайлбар, үнэ болон ангиллыг нэг дороос
                    удирдана.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success admin-cta-btn">+ Шинэ бараа нэмэх</a>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light admin-cta-btn">← Самбар руу буцах</a>
            </div>
        </div>

        @if ($products->isEmpty())
            <div class="alert alert-info">
                Бараа байхгүй байна. <a href="{{ route('admin.products.create') }}">Шинэ бараа нэмнэ үү</a>
            </div>
        @else
            <div class="admin-product-grid">
                @foreach ($products as $product)
                    <div class="admin-product-card">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x250?text={{ urlencode($product->name) }}"
                                alt="{{ $product->name }}">
                        @endif
                        <div class="p-3">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                <div>
                                    <h5 class="mb-1">{{ $product->name }}</h5>
                                    <small class="text-muted">{{ $product->category->name ?? 'Ангилаагүй' }}</small>
                                </div>
                                <span class="admin-chip">₮ {{ number_format($product->price, 0, '.', ' ') }}</span>
                            </div>
                            <p class="text-muted small mb-2">
                                {{ $product->description ? Str::limit($product->description, 90) : 'Тайлбар оруулаагүй' }}
                            </p>
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <i class="bi bi-calendar-event text-muted" style="font-size: 0.85rem;"></i>
                                <small class="text-muted">{{ $product->created_at->format('Y он m сар d') }}</small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                    class="btn btn-sm btn-outline-light flex-fill">✏️ Засах</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100"
                                        onclick="return confirm('Устгахдаа итгэлтэй байна уу?')">🗑️ Устгах</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

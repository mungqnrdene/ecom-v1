@extends('layouts.admin')

@section('title', 'Ангиллын бараанууд - Light Shop')

@push('styles')
    <style>
        .admin-category-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }

        .admin-category-title {
            color: #e5e7eb;
            font-weight: 700;
            margin: 0;
        }

        .admin-product-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .admin-product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .admin-product-body {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .admin-product-name {
            color: #e5e7eb;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .admin-product-price {
            color: #34d399;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .admin-product-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .admin-product-actions .btn {
            flex: 1;
            border-radius: 10px;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <div class="container admin-page">
        <div class="admin-category-header">
            <div>
                <h2 class="admin-category-title">{{ $category->name }}</h2>
                <p class="text-muted mb-0">Нийт {{ $products->total() }} бараа</p>
            </div>
            <a href="{{ route('admin.welcome') }}" class="btn btn-outline-light">← Буцах</a>
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="admin-product-card">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center text-muted" style="height: 200px;">
                                Зураг байхгүй
                            </div>
                        @endif
                        <div class="admin-product-body">
                            <div class="admin-product-name">{{ $product->name }}</div>
                            <div class="admin-product-price">₮ {{ number_format($product->price) }}</div>
                            <p class="text-muted small mb-3">
                                {{ $product->description ? Str::limit($product->description, 70) : 'Тайлбар байхгүй' }}
                            </p>
                            <div class="admin-product-actions">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-pencil-square me-1"></i>Засах
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                    onsubmit="return confirm('Энэ барааг устгах уу?')" class="flex-fill">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-trash me-1"></i>Устгах
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">Энэ ангилалд бараа байхгүй байна.</div>
                </div>
            @endforelse
        </div>

        @if ($products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection

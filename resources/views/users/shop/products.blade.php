@extends('layouts.user')

@section('title', 'Бараанууд - Light Shop')

@push('styles')
    <style>
        .product-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            transition: .2s
        }

        .product-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25)
        }

        .product-thumb {
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08)
        }

        .price {
            color: #22c55e;
            font-weight: 700
        }
    </style>
@endpush

@section('page')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">🛒 Бараанууд</h3>
    </div>

    <div class="row g-4">
        @forelse($products as $product)
            <div class="col-md-4 col-lg-3">
                <div class="product-card h-100">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-100 product-thumb"
                            alt="{{ $product->name }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center product-thumb text-muted">
                            Зураг байхгүй
                        </div>
                    @endif
                    <div class="p-3">
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <p class="small text-muted mb-2">{{ Str::limit($product->description, 80) }}</p>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="price">₮ {{ number_format($product->price) }}</span>
                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-primary">Сагсанд нэмэх</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Бараа байхгүй байна</div>
            </div>
        @endforelse
    </div>

    @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages())
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    @endif
@endsection

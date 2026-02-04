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

        .product-thumb-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .product-thumb {
            height: 100%;
            object-fit: cover;
        }

        .product-category-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            color: #fbbf24;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(251, 191, 36, 0.45);
            z-index: 5;
        }

        .price {
            color: #22c55e;
            font-weight: 700
        }
    </style>
@endpush

<div class="d-flex align-items-center justify-content-between mb-4">
    <h3 class="mb-0">Бараанууд</h3>
</div>

<div class="row g-4">
    @forelse($data['products'] as $product)
        <div class="col-md-4 col-lg-3">
            <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                <div class="product-card h-100">
                    <div class="product-thumb-wrapper">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-100 product-thumb"
                                alt="{{ $product->name }}">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                Зураг байхгүй
                            </div>
                        @endif
                        @if ($product->category)
                            <span class="product-category-badge">
                                {{ $product->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="p-3">
                        <h6 class="mb-1">{{ $product->name }}</h6>
                        <p class="small text-muted mb-2">
                            {{ $product->description ? Str::limit($product->description, 80) : 'Тайлбар байхгүй' }}
                        </p>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-calendar3" style="font-size: 0.75rem; opacity: 0.7;"></i>
                            <small class="text-muted"
                                style="font-size: 0.75rem;">{{ $product->created_at->format('Y/m/d') }}</small>
                        </div>
                        <span class="price d-block mb-2">₮ {{ number_format($product->price) }}</span>
                        <div class="d-flex gap-2 mb-2">
                            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="flex-fill">
                                @csrf
                                <button class="btn btn-sm btn-primary w-100">Сагсанд нэмэх</button>
                            </form>
                            <form method="POST" action="{{ route('users.wishlist.add', $product->id) }}"
                                class="flex-fill">
                                @csrf
                                <button class="btn btn-sm btn-outline-light w-100">❤️ Хадгалах</button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('cart.buy', $product->id) }}">
                            @csrf
                            <button class="btn btn-sm btn-success w-100">⚡ Худалдан авах</button>
                        </form>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">Бараа байхгүй байна</div>
        </div>
    @endforelse
</div>

@if ($data['products'] instanceof \Illuminate\Pagination\LengthAwarePaginator && $data['products']->hasPages())
    <div class="mt-4">
        {{ $data['products']->links() }}
    </div>
@endif

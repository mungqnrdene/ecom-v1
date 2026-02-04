@push('styles')
    <style>
        .wishlist-card {
            background: rgba(15, 23, 42, .85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .08);
            overflow: hidden;
            transition: .25s;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .35);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .wishlist-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
            border-color: rgba(59, 130, 246, .45);
        }

        .wishlist-thumb {
            height: 220px;
            position: relative;
            background: linear-gradient(180deg, rgba(15, 23, 42, .6), rgba(15, 23, 42, .95));
        }

        .wishlist-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .wishlist-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            padding: 6px 14px;
            background: rgba(15, 23, 42, .85);
            border-radius: 999px;
            font-size: .8rem;
            font-weight: 600;
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, .45);
        }

        .wishlist-body {
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .wishlist-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.05rem;
        }

        .wishlist-actions {
            margin-top: auto;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .wishlist-actions .btn {
            width: 100%;
            height: 50px;
            padding: 0;
            border-radius: 14px;
            font-weight: 600;
            font-size: .9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        @media (max-width: 767px) {
            .wishlist-actions {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .wishlist-actions .btn {
                height: 52px;
                font-size: .95rem;
            }
        }
    </style>
@endpush

<div class="d-flex align-items-center justify-content-between mb-4">
    <h3 class="mb-0">Миний хадгалсан</h3>
    <a href="{{ route('users.dashboard', 'products') }}" class="btn btn-sm btn-outline-light">Бараа үзэх</a>
</div>

@if ($data['wishlistItems']->isEmpty())
    <div class="alert alert-info">
        📌 Хадгалсан бараа байхгүй байна.
    </div>
@else
    <div class="row g-4">
        @foreach ($data['wishlistItems'] as $item)
            @php($product = $item->product)

            <div class="col-md-4 col-lg-3">
                <div class="wishlist-card">
                    <div class="wishlist-thumb">
                        @if ($product && $product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                                Зураг байхгүй
                            </div>
                        @endif

                        <span class="wishlist-badge">
                            {{ $product?->category?->name ?? 'ON SALE' }}
                        </span>
                    </div>

                    <div class="wishlist-body">
                        <h6 class="mb-1">{{ $product->name ?? 'Бараа устсан' }}</h6>

                        <p class="small text-muted mb-2">
                            {{ $product && $product->description ? Str::limit($product->description, 80) : 'Тайлбар байхгүй' }}
                        </p>

                        <span class="wishlist-price mb-3">
                            @if ($product)
                                ₮ {{ number_format($product->price) }}
                            @else
                                Үнэ байхгүй
                            @endif
                        </span>

                        <div class="wishlist-actions">
                            <form method="POST" action="{{ route('cart.wishlist.move', $item->product_id) }}">
                                @csrf
                                <button class="btn btn-outline-light" {{ $product ? '' : 'disabled' }}>
                                    🛒 Сагсанд
                                </button>
                            </form>

                            <form method="POST" action="{{ route('cart.wishlist.buy', $item->product_id) }}">
                                @csrf
                                <button class="btn btn-primary" {{ $product ? '' : 'disabled' }}>
                                    ⚡ Худалдан
                                </button>
                            </form>

                            <form method="POST" action="{{ route('users.wishlist.remove', $item->product_id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">
                                    ✖ Устгах
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

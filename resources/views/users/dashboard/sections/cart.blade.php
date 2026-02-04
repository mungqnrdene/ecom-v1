@push('styles')
    <style>
        .cart-card {
            background: rgba(15, 23, 42, .85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .08);
            overflow: hidden;
            transition: .25s;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .35);
            height: 100%;
            display: flex;
            flex-direction: column;
            width: 350px;
        }

        .cart-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 40px rgba(0, 0, 0, .45);
            border-color: rgba(34, 197, 94, .45);
        }

        .cart-thumb {
            height: 220px;
            position: relative;
            background: linear-gradient(180deg, rgba(15, 23, 42, .6), rgba(15, 23, 42, .95));
        }

        .cart-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-badge {
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

        .cart-body {
            padding: 16px 14px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .cart-name {
            font-weight: 600;
            font-size: 1.05rem;
            margin-bottom: 8px;
            color: #e5e7eb;
        }

        .cart-quantity {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .cart-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 12px;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 8px 12px;
        }

        .quantity-control label {
            color: #9ca3af;
            font-size: 0.85rem;
            font-weight: 600;
            margin: 0;
            white-space: nowrap;
        }

        .quantity-input-wrapper {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        .quantity-btn {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(139, 92, 246, 0.15));
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .quantity-btn:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(139, 92, 246, 0.25));
            border-color: rgba(59, 130, 246, 0.5);
            transform: scale(1.05);
        }

        .quantity-btn:active {
            transform: scale(0.95);
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            color: #e5e7eb;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 6px;
            transition: all 0.2s ease;
        }

        .quantity-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .update-btn {
            background: linear-gradient(135deg, #34d399, #10b981);
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 7px;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .update-btn:hover {
            background: linear-gradient(135deg, #10b981, #059669);
            transform: scale(1.05);
        }

        .cart-actions {
            margin-top: auto;
            display: flex;
            gap: 8px;
        }

        .cart-actions .btn {
            flex: 1;
            height: 42px;
            padding: 0;
            border-radius: 12px;
            font-weight: 600;
            font-size: .85rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        @media (max-width: 767px) {
            .cart-actions {
                flex-direction: column;
            }

            .cart-actions .btn {
                height: 44px;
                font-size: .9rem;
            }
        }
    </style>
@endpush

<div class="d-flex align-items-center justify-content-between mb-4">
    <h3 class="mb-0">Сагс</h3>
    <a href="{{ route('users.dashboard', 'products') }}" class="btn btn-sm btn-outline-light">Бараа үзэх</a>
</div>

@if ($data['cartItems']->isEmpty())
    <div class="alert alert-secondary">Сагс хоосон байна.</div>
@else
    <div class="row g-4 mb-4">
        @foreach ($data['cartItems'] as $item)
            @php($product = $item->product)

            <div class="col-md-4 col-lg-3">
                <div class="cart-card">
                    <div class="cart-thumb">
                        @if ($product && $product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <div class="h-100 d-flex align-items-center justify-content-center text-muted">
                                Зураг байхгүй
                            </div>
                        @endif

                        <span class="cart-badge">
                            {{ $product?->category?->name ?? 'Ангилаагүй' }}
                        </span>
                    </div>

                    <div class="cart-body">
                        <h6 class="cart-name">{{ $product->name ?? 'Бараа устсан' }}</h6>

                        <form method="POST" action="{{ route('cart.update', $item->product_id) }}"
                            class="quantity-control">
                            @csrf
                            <label><i class="bi bi-box-seam"></i> Тоо:</label>
                            <div class="quantity-input-wrapper">
                                <button type="button" class="quantity-btn quantity-decrease"
                                    data-product-id="{{ $item->product_id }}">−</button>
                                <input type="number" name="quantity" id="quantity-{{ $item->product_id }}"
                                    class="quantity-input" value="{{ $item->quantity }}" min="1"
                                    max="{{ $product->quantity ?? 99 }}" required>
                                <button type="button" class="quantity-btn quantity-increase"
                                    data-product-id="{{ $item->product_id }}"
                                    data-max="{{ $product->quantity ?? 99 }}">+</button>
                                <button type="submit" class="update-btn">
                                    <i class="bi bi-check2"></i> Шинэчлэх
                                </button>
                            </div>
                        </form>

                        <span class="cart-price">
                            @if ($product)
                                ₮ {{ number_format($item->total_price) }}
                            @else
                                Үнэ байхгүй
                            @endif
                        </span>

                        <div class="cart-actions">
                            <form method="POST" action="{{ route('cart.remove', $item->product_id) }}"
                                style="flex: 1;">
                                @csrf
                                <button class="btn btn-danger w-100">
                                    ✖ Хасах
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-center">
        <a href="{{ route('order.create') }}" class="btn btn-success btn-lg px-5">
            <i class="bi bi-box-seam me-2"></i>Захиалга үүсгэх
        </a>
    </div>
@endif

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Decrease quantity
            document.querySelectorAll('.quantity-decrease').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const input = document.getElementById(`quantity-${productId}`);
                    const currentValue = parseInt(input.value);

                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                });
            });

            // Increase quantity
            document.querySelectorAll('.quantity-increase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.productId;
                    const maxQty = parseInt(this.dataset.max);
                    const input = document.getElementById(`quantity-${productId}`);
                    const currentValue = parseInt(input.value);

                    if (currentValue < maxQty) {
                        input.value = currentValue + 1;
                    } else {
                        alert(`Үлдэгдэл хүрэлцэхгүй байна. Зөвхөн ${maxQty} ширхэг байна.`);
                    }
                });
            });

            // Prevent manual input exceeding max
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    const max = parseInt(this.max);
                    const value = parseInt(this.value);

                    if (value > max) {
                        this.value = max;
                        alert(`Үлдэгдэл хүрэлцэхгүй байна. Зөвхөн ${max} ширхэг байна.`);
                    } else if (value < 1) {
                        this.value = 1;
                    }
                });
            });
        });
    </script>
@endpush

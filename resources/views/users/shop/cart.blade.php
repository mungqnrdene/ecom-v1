@extends('layouts.user')
@section('title', 'Миний сагс')

@push('styles')
    <style>
        .cart-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px
        }

        .cart-item {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            border-radius: 16px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            transition: all .3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .cart-item:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12), rgba(255, 255, 255, 0.06));
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .cart-img {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0
        }

        .cart-info {
            flex: 1
        }

        .cart-name {
            font-weight: 600;
            font-size: 16px
        }

        .cart-price {
            font-size: 14px;
            color: #9ca3af
        }

        .cart-remove button {
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center
        }
    </style>
@endpush

@section('page')
    <h2 class="mb-4">🛍️ Миний сагс</h2>

    @if ($cartItems->isEmpty())
        <div class="alert alert-secondary">Сагс хоосон байна.</div>
    @else
        <div class="cart-grid">
            @foreach ($cartItems as $item)
                @php($product = $item->product)
                <div class="cart-item">
                    @if ($product && $product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="cart-img" alt="{{ $product->name }}">
                    @else
                        <img src="https://via.placeholder.com/80" class="cart-img" alt="{{ $product->name ?? 'Product' }}">
                    @endif

                    <div class="cart-info">
                        <div class="cart-name">{{ $product->name ?? 'Бараа устсан' }}</div>
                        <div class="cart-price">{{ $item->quantity }} × {{ number_format($item->unit_price) }} ₮</div>
                    </div>

                    <div class="cart-remove">
                        <form method="POST" action="{{ route('cart.remove', $item->product_id) }}">
                            @csrf
                            <button class="btn btn-danger btn-sm">✖</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <a href="{{ route('order.create') }}" class="btn btn-success mt-4">📦 Захиалга үүсгэх</a>
    @endif
@endsection

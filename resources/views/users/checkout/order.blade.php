@extends('layouts.user')
@section('title', 'Захиалга')

@section('page')

    <style>
        /* Header Section */
        .checkout-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(147, 51, 234, 0.25));
            border-radius: 22px;
            padding: 28px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.5);
        }

        .checkout-header h2 {
            color: #e5e7eb;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .checkout-header p {
            color: #9ca3af;
            margin-bottom: 0;
        }

        /* Order Card */
        .order-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }

        .order-card .card-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(147, 51, 234, 0.3));
            color: #e5e7eb;
            border: none;
            padding: 18px 24px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Product Items */
        .product-item {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            margin: 16px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .product-item:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            color: #e5e7eb;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 8px;
        }

        .product-meta {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .product-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.2rem;
            white-space: nowrap;
        }

        /* Total Section */
        .total-section {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.15));
            padding: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .total-section strong {
            color: #e5e7eb;
            font-size: 1.1rem;
        }

        .total-section h4 {
            color: #34d399;
            font-weight: 700;
        }

        /* Info Card */
        .info-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }

        .info-card .card-header {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.3), rgba(245, 158, 11, 0.3));
            color: #e5e7eb;
            border: none;
            padding: 18px 24px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-card .card-body {
            padding: 24px;
        }

        /* Form Elements */
        .form-label {
            color: #d1d5db;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-label i {
            color: #60a5fa;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 12px 16px;
            color: #e5e7eb;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            color: #e5e7eb;
        }

        .form-control::placeholder {
            color: #6b7280;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .invalid-feedback {
            color: #fca5a5;
        }

        /* Submit Button */
        .btn-submit {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 16px;
            padding: 16px 32px;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.3);
            width: 100%;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(34, 197, 94, 0.5);
        }

        /* Info Text */
        .info-text {
            background: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #60a5fa;
            padding: 16px;
            border-radius: 12px;
            margin-top: 20px;
            color: #d1d5db;
        }

        .info-text i {
            color: #60a5fa;
        }

        /* List Group Override */
        .list-group-flush {
            padding: 0;
        }

        .list-group-item {
            background: transparent;
            border: none;
            padding: 0;
        }

        /* Icon Colors */
        .section-icon {
            font-size: 1.5rem;
            margin-right: 8px;
        }

        /* Empty State */
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #9ca3af;
        }

        .empty-cart i {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        /* Payment Methods */
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 12px;
        }

        .payment-option {
            position: relative;
        }

        .payment-radio {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .payment-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            height: 100%;
        }

        .payment-label i {
            font-size: 2rem;
            margin-bottom: 8px;
            color: #60a5fa;
        }

        .payment-label span {
            font-weight: 600;
            color: #e5e7eb;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .payment-label small {
            color: #9ca3af;
            font-size: 0.75rem;
        }

        .payment-radio:checked+.payment-label {
            background: rgba(59, 130, 246, 0.2);
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .payment-radio:checked+.payment-label i {
            color: #34d399;
        }

        .payment-label:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }

        /* Saved Cards Styles */
        .saved-cards-list {
            display: grid;
            gap: 12px;
        }

        .saved-card-item {
            background: rgba(30, 41, 59, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .saved-card-item:hover {
            background: rgba(30, 41, 59, 0.8);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .saved-card-item.default {
            border-color: #34d399;
            background: rgba(52, 211, 153, 0.05);
        }

        .saved-card-item input[type="radio"] {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .saved-card-item label {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 0;
            cursor: pointer;
        }

        .card-brand-icon {
            color: #60a5fa;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .card-number {
            font-family: 'Courier New', monospace;
            color: #e5e7eb;
            flex: 1;
        }

        .card-expiry {
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .saved-card-item:has(input:checked) {
            border-color: #60a5fa;
            background: rgba(59, 130, 246, 0.15);
        }

        .btn-link {
            color: #60a5fa;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-link:hover {
            color: #93c5fd;
            text-decoration: underline;
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #93c5fd;
            padding: 15px;
            border-radius: 10px;
        }

        .alert-link {
            color: #60a5fa;
            font-weight: 600;
            text-decoration: underline;
        }
    </style>

    <!-- Header -->
    <div class="checkout-header">
        <h2>
            <i class="bi bi-cart-check section-icon"></i>Захиалга баталгаажуулах
        </h2>
        <p>Захиалгын мэдээллээ шалгаж, хүргэлтийн хаягаа бөглөнө үү</p>
    </div>

    <form method="POST" action="{{ route('order.store') }}">
        @csrf

        <!-- Захиалгын жагсаалт -->
        <div class="order-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-bag-check me-2"></i>Захиалгын жагсаалт
                </h5>
            </div>
            <div class="list-group list-group-flush">
                @foreach ($cartItems as $item)
                    @php($product = $item->product)
                    <div class="product-item">
                        <img src="{{ $product && $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/80' }}"
                            alt="{{ $product->name ?? 'Product' }}" class="product-img">

                        <div class="product-details">
                            <div class="product-name">{{ $product->name ?? 'Бараа устсан' }}</div>
                            <div class="product-meta">
                                <i class="bi bi-hash"></i>{{ $item->quantity }} ширхэг ×
                                <i class="bi bi-currency-exchange"></i>{{ number_format($item->unit_price) }}₮
                            </div>
                        </div>

                        <div class="product-price">
                            {{ number_format($item->total_price) }}₮
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="total-section">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Нийт дүн:</strong>
                        <small class="d-block text-muted mt-1">{{ count($cartItems) }} бараа</small>
                    </div>
                    <h4 class="mb-0">{{ number_format($cartItems->sum('total_price')) }}₮</h4>
                </div>
            </div>
        </div>

        <!-- Хүргэлтийн мэдээлэл -->
        <div class="info-card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-truck me-2"></i>Хүргэлтийн мэдээлэл
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="phone" class="form-label">
                        <i class="bi bi-telephone me-2"></i>Утасны дугаар <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                        name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Жнь: 99001122" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="shipping_address" class="form-label">
                        <i class="bi bi-geo-alt me-2"></i>Хүргэлтийн хаяг <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control @error('shipping_address') is-invalid @enderror" id="shipping_address"
                        name="shipping_address" rows="3" placeholder="Хот, дүүрэг, хороо, гудамж, байр, тоот" required>{{ old('shipping_address', ($user->city ? $user->city . ', ' : '') . ($user->district ? $user->district . ', ' : '') . ($user->address ?? '')) }}</textarea>
                    @error('shipping_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">
                        <i class="bi bi-chat-left-text me-2"></i>Нэмэлт тэмдэглэл
                    </label>
                    <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Хүргэлтийн зааварчилгаа...">{{ old('notes') }}</textarea>
                </div>

                <!-- Payment Method Selection -->
                <div class="mb-3">
                    <label class="form-label">
                        <i class="bi bi-credit-card me-2"></i>Төлбөрийн хэлбэр <span class="text-danger">*</span>
                    </label>

                    @if (!isset($paymentMethods['card']) && !isset($paymentMethods['cod']))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> Төлбөрийн аргагүй. Админ тал дээр тохиргоо хийнэ үү.
                        </div>
                    @else
                        <div class="payment-methods">
                            @if ($paymentMethods['card'] ?? false)
                                <div class="payment-option">
                                    <input type="radio" id="payment_card" name="payment_method" value="card"
                                        class="payment-radio"
                                        {{ old('payment_method', $paymentMethods['card'] ? 'card' : '') === 'card' ? 'checked' : '' }}
                                        required>
                                    <label for="payment_card" class="payment-label">
                                        <i class="bi bi-credit-card-2-front"></i>
                                        <span>Карт</span>
                                        <small>Visa, Mastercard</small>
                                    </label>
                                </div>
                            @endif

                            @if ($paymentMethods['cod'] ?? false)
                                <div class="payment-option">
                                    <input type="radio" id="payment_cash" name="payment_method" value="cash_on_delivery"
                                        class="payment-radio"
                                        {{ old('payment_method', !($paymentMethods['card'] ?? false) ? 'cash_on_delivery' : '') === 'cash_on_delivery' ? 'checked' : '' }}>
                                    <label for="payment_cash" class="payment-label">
                                        <i class="bi bi-cash-coin"></i>
                                        <span>Бэлэн мөнгө</span>
                                        <small>Хүргэхдээ төлнө</small>
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endif

                    @error('payment_method')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Saved Cards (shown when card payment selected) -->
                @if ($paymentMethods['card'] ?? false)
                    <div id="savedCardsSection" style="display: none;">
                        <label class="form-label">
                            <i class="bi bi-wallet2 me-2"></i>Хадгалсан картууд
                        </label>
                        @if ($savedCards->isNotEmpty())
                            <div class="saved-cards-list mb-3">
                                @foreach ($savedCards as $card)
                                    <div class="saved-card-item {{ $card->is_default ? 'default' : '' }}"
                                        onclick="selectCard('{{ $card->id }}')">
                                        <input type="radio" name="saved_card_id" value="{{ $card->id }}"
                                            id="saved_card_{{ $card->id }}" {{ $card->is_default ? 'checked' : '' }}>
                                        <label for="saved_card_{{ $card->id }}">
                                            <div class="card-brand-icon">
                                                <i class="bi bi-credit-card"></i>
                                                {{ $card->card_brand ?? 'Карт' }}
                                            </div>
                                            <div class="card-number">{{ $card->masked_card_number }}</div>
                                            <div class="card-expiry">{{ $card->expiry_month }}/{{ $card->expiry_year }}
                                            </div>
                                            @if ($card->is_default)
                                                <span class="badge bg-success">Үндсэн</span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="text-center">
                                <a href="{{ route('users.saved-cards') }}" class="btn btn-link" target="_blank">
                                    <i class="bi bi-gear"></i> Картуудаа удирдах
                                </a>
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                Хадгалсан карт байхгүй байна.
                                <a href="{{ route('users.saved-cards') }}" target="_blank" class="alert-link">Карт
                                    нэмэх</a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <button type="submit" class="btn btn-submit">
            <i class="bi bi-check-circle me-2"></i>
            Захиалга батлах
        </button>

        <div class="info-text text-center">
            <small>
                <i class="bi bi-info-circle me-1"></i>
                Захиалга баталснаар үйлчилгээний нөхцөлтэй танилцсанд тооцогдоно.
            </small>
        </div>

    </form>

    <script>
        // Toggle saved cards section based on payment method
        function toggleSavedCards() {
            const cardRadio = document.getElementById('payment_card');
            const savedCardsSection = document.getElementById('savedCardsSection');

            if (cardRadio && savedCardsSection) {
                savedCardsSection.style.display = cardRadio.checked ? 'block' : 'none';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSavedCards();

            // Listen for payment method changes
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', toggleSavedCards);
            });
        });

        // Helper function to select card
        function selectCard(cardId) {
            const cardRadio = document.getElementById('saved_card_' + cardId);
            if (cardRadio) {
                cardRadio.checked = true;
            }
        }
    </script>

@endsection

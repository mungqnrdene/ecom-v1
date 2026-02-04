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

        /* Bank Transfer Section */
        .bank-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .bank-item {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .bank-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(59, 130, 246, 0.4);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .bank-item.selected {
            background: rgba(59, 130, 246, 0.15);
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }

        .bank-logo {
            width: 60px;
            height: 60px;
            margin: 0 auto 10px;
            border-radius: 12px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .bank-logo.khan {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            color: white;
        }

        .bank-logo.golomt {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
        }

        .bank-logo.tdb {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
        }

        .bank-logo.state {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
            color: white;
        }

        .bank-name {
            color: #e5e7eb;
            font-weight: 600;
            font-size: 0.9rem;
            margin-top: 8px;
        }

        .bank-account-details {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin-top: 15px;
            display: none;
        }

        .bank-account-details.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .account-info {
            margin-bottom: 15px;
        }

        .account-label {
            color: #9ca3af;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .account-value {
            color: #e5e7eb;
            font-size: 1.1rem;
            font-weight: 600;
            font-family: 'Courier New', monospace;
            background: rgba(255, 255, 255, 0.05);
            padding: 10px 15px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .copy-btn {
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.4);
            color: #60a5fa;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .copy-btn:hover {
            background: rgba(59, 130, 246, 0.3);
            transform: scale(1.05);
        }

        .copy-btn.copied {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.4);
            color: #22c55e;
        }

        .transfer-note {
            background: rgba(251, 191, 36, 0.1);
            border-left: 4px solid #fbbf24;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .transfer-note p {
            color: #fbbf24;
            font-size: 0.9rem;
            margin: 0;
        }

        /* QPay QR Section */
        .qpay-section {
            background: rgba(15, 23, 42, 0.95);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 12px;
            padding: 25px;
            margin-top: 15px;
            text-align: center;
            display: none;
        }

        .qpay-section.show {
            display: block;
            animation: slideDown 0.3s ease;
        }

        .qr-container {
            background: white;
            padding: 20px;
            border-radius: 16px;
            display: inline-block;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            margin: 20px 0;
        }

        .qr-code {
            width: 250px;
            height: 250px;
            margin: 0 auto;
        }

        .qpay-info {
            color: #cbd5e1;
            margin-top: 20px;
            padding: 15px;
            background: rgba(139, 92, 246, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .qpay-info h5 {
            color: #a78bfa;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .qpay-info p {
            margin: 5px 0;
            font-size: 0.9rem;
        }

        .qpay-amount {
            background: rgba(34, 197, 94, 0.15);
            color: #34d399;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 15px 0;
            border: 2px solid rgba(34, 197, 94, 0.3);
        }

        .qpay-instructions {
            background: rgba(59, 130, 246, 0.1);
            border-left: 4px solid #60a5fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: left;
        }

        .qpay-instructions ol {
            margin: 10px 0;
            padding-left: 20px;
            color: #cbd5e1;
        }

        .qpay-instructions li {
            margin: 8px 0;
            font-size: 0.9rem;
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

                    @if (
                        !($paymentMethods['card'] ?? false) &&
                            !($paymentMethods['qpay'] ?? false) &&
                            !($paymentMethods['bank_transfer'] ?? false))
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

                            @if ($paymentMethods['qpay'] ?? false)
                                <div class="payment-option">
                                    <input type="radio" id="payment_qpay" name="payment_method" value="qpay"
                                        class="payment-radio"
                                        {{ old('payment_method', !($paymentMethods['card'] ?? false) && ($paymentMethods['qpay'] ?? false) ? 'qpay' : '') === 'qpay' ? 'checked' : '' }}>
                                    <label for="payment_qpay" class="payment-label">
                                        <i class="bi bi-qr-code"></i>
                                        <span>QPay</span>
                                        <small>QR код төлбөр</small>
                                    </label>
                                </div>
                            @endif

                            <!-- Bank Transfer Option -->
                            @if ($paymentMethods['bank_transfer'] ?? false)
                                <div class="payment-option">
                                    <input type="radio" id="payment_transfer" name="payment_method" value="bank_transfer"
                                        class="payment-radio"
                                        {{ old('payment_method') === 'bank_transfer' ? 'checked' : '' }}>
                                    <label for="payment_transfer" class="payment-label">
                                        <i class="bi bi-bank"></i>
                                        <span>Дансаар шилжүүлэх</span>
                                        <small>Банкны шилжүүлэг</small>
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endif

                    @error('payment_method')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                @if ($paymentMethods['bank_transfer'] ?? false)
                    <!-- Bank Transfer Section (shown when bank transfer selected) -->
                    <div id="bankTransferSection" style="display: none;">
                        <label class="form-label">
                            <i class="bi bi-bank me-2"></i>Банк сонгох
                        </label>
                        <div class="bank-list">
                            <div class="bank-item" onclick="selectBank('khan')" data-bank="khan">
                                <div class="bank-logo khan">
                                    <i class="bi bi-bank"></i>
                                </div>
                                <div class="bank-name">Хаан банк</div>
                            </div>
                            <div class="bank-item" onclick="selectBank('golomt')" data-bank="golomt">
                                <div class="bank-logo golomt">
                                    <i class="bi bi-building"></i>
                                </div>
                                <div class="bank-name">Голомт банк</div>
                            </div>
                            <div class="bank-item" onclick="selectBank('tdb')" data-bank="tdb">
                                <div class="bank-logo tdb">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="bank-name">Худалдаа Хөгжлийн банк</div>
                            </div>
                            <div class="bank-item" onclick="selectBank('state')" data-bank="state">
                                <div class="bank-logo state">
                                    <i class="bi bi-star-fill"></i>
                                </div>
                                <div class="bank-name">Төрийн банк</div>
                            </div>
                        </div>

                        <!-- Bank Account Details -->
                        <div id="bankAccountDetails" class="bank-account-details">
                            <div class="account-info">
                                <div class="account-label">Банкны нэр:</div>
                                <div class="account-value">
                                    <span id="selectedBankName"></span>
                                </div>
                            </div>
                            <div class="account-info">
                                <div class="account-label">Дансны дугаар:</div>
                                <div class="account-value">
                                    <span id="accountNumber"></span>
                                    <button type="button" class="copy-btn" onclick="copyAccount()">
                                        <i class="bi bi-clipboard"></i> Хуулах
                                    </button>
                                </div>
                            </div>
                            <div class="account-info">
                                <div class="account-label">Дансны нэр:</div>
                                <div class="account-value">
                                    <span id="accountName"></span>
                                </div>
                            </div>
                            <div class="transfer-note">
                                <p>
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Анхаар:</strong> Гүйлгээний утга н дээр н өөрийн хаягны ID утасны дугаар бичнэ үү!.
                                </p>
                            </div>
                        </div>

                        <input type="hidden" name="selected_bank" id="selectedBankInput">
                    </div>
                @endif

                @if ($paymentMethods['qpay'] ?? false)
                    <!-- QPay QR Section (shown when QPay selected) -->
                    <div id="qpaySection" class="qpay-section">
                        <div class="qpay-info">
                            <h5>
                                <i class="bi bi-qr-code me-2"></i>QPay QR код уншуулна уу
                            </h5>
                            <p>Өөрийн банкны аппликэйшн эсвэл QPay апп ашиглан QR код уншуулна уу</p>
                        </div>

                        <div class="qpay-amount">
                            <i
                                class="bi bi-currency-exchange me-2"></i>{{ number_format($cartItems->sum('total_price')) }}₮
                        </div>

                        <div class="qr-container">
                            <div class="qr-code" id="qrCode">
                                <!-- QR Code will be generated here -->
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=qpay://order/{{ uniqid() }}?amount={{ $cartItems->sum('total_price') }}"
                                    alt="QPay QR Code" style="width: 100%; height: 100%; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="qpay-instructions">
                            <p><strong><i class="bi bi-info-circle me-2"></i>Төлбөр төлөх заавар:</strong></p>
                            <ol>
                                <li>Банкны эсвэл QPay аппликэйшн нээнэ үү</li>
                                <li>QR код уншуулах хэсэг рүү орно уу</li>
                                <li>Дээрх QR кодыг уншуулна уу</li>
                                <li>Төлбөрийн дүн болон мэдээллийг шалгана уу</li>
                                <li>Төлбөр баталгаажуулна уу</li>
                                <li>"Захиалга батлах" товч дарж захиалгаа дуусгана уу</li>
                            </ol>
                        </div>
                    </div>
                @endif

                <!-- Saved Cards (shown when card payment selected) -->
                @if ($paymentMethods['card'] ?? false)
                    <div id="savedCardsSection" style="display: none;">
                        <label class="form-label">
                            <i class="bi bi-wallet2 me-2"></i>Хадгалсан картууд
                        </label>
                        <div class="alert alert-info mb-3"
                            style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); padding: 12px; border-radius: 10px;">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Хадгалсан картаа сонгоход төлбөрийн хуудсанд картын мэдээлэл автоматаар
                                бөглөгдөнө</small>
                        </div>
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
        // Bank account data
        const bankAccounts = {
            khan: {
                name: 'Хаан банк',
                accountNumber: 'MN45000500 57300088570',
                accountName: 'Light Shop ХХК'
            },
            golomt: {
                name: 'Голомт банк',
                accountNumber: 'MN45001500 1805269937',
                accountName: 'Light Shop ХХК'
            },
            tdb: {
                name: 'Худалдаа Хөгжлийн банк',
                accountNumber: 'MN45000500 57300088570',
                accountName: 'Light Shop ХХК'
            },
            state: {
                name: 'Төрийн банк',
                accountNumber: 'MN45000500 57300088570',
                accountName: 'Light Shop ХХК'
            }
        };

        // Toggle saved cards section based on payment method
        function toggleSavedCards() {
            const cardRadio = document.getElementById('payment_card');
            const savedCardsSection = document.getElementById('savedCardsSection');

            if (cardRadio && savedCardsSection) {
                savedCardsSection.style.display = cardRadio.checked ? 'block' : 'none';
            }
        }

        // Toggle bank transfer section
        function toggleBankTransfer() {
            const transferRadio = document.getElementById('payment_transfer');
            const bankTransferSection = document.getElementById('bankTransferSection');

            if (transferRadio && bankTransferSection) {
                bankTransferSection.style.display = transferRadio.checked ? 'block' : 'none';
            }
        }

        // Toggle QPay section
        function toggleQPay() {
            const qpayRadio = document.getElementById('payment_qpay');
            const qpaySection = document.getElementById('qpaySection');

            if (qpayRadio && qpaySection) {
                if (qpayRadio.checked) {
                    qpaySection.classList.add('show');
                } else {
                    qpaySection.classList.remove('show');
                }
            }
        }

        // Select bank and show account details
        function selectBank(bankCode) {
            // Remove selected class from all banks
            document.querySelectorAll('.bank-item').forEach(item => {
                item.classList.remove('selected');
            });

            // Add selected class to clicked bank
            const selectedBank = document.querySelector(`[data-bank="${bankCode}"]`);
            if (selectedBank) {
                selectedBank.classList.add('selected');
            }

            // Get bank details
            const bank = bankAccounts[bankCode];
            if (bank) {
                // Update account details
                document.getElementById('selectedBankName').textContent = bank.name;
                document.getElementById('accountNumber').innerHTML = `
                    <span>${bank.accountNumber}</span>
                    <button type="button" class="copy-btn" onclick="copyAccount()">
                        <i class="bi bi-clipboard"></i> Хуулах
                    </button>
                `;
                document.getElementById('accountName').textContent = bank.accountName;
                document.getElementById('selectedBankInput').value = bankCode;

                // Show account details section
                const detailsSection = document.getElementById('bankAccountDetails');
                detailsSection.classList.add('show');
            }
        }

        // Copy account number to clipboard
        function copyAccount() {
            const accountNumber = document.getElementById('accountNumber').querySelector('span').textContent;
            navigator.clipboard.writeText(accountNumber).then(() => {
                // Show success feedback
                const copyBtn = document.querySelector('.copy-btn');
                const originalHTML = copyBtn.innerHTML;
                copyBtn.classList.add('copied');
                copyBtn.innerHTML = '<i class="bi bi-check-circle"></i> Хуулагдсан';

                setTimeout(() => {
                    copyBtn.classList.remove('copied');
                    copyBtn.innerHTML = originalHTML;
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy:', err);
            });
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleSavedCards();
            toggleBankTransfer();
            toggleQPay();

            // Listen for payment method changes
            const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
            paymentRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    toggleSavedCards();
                    toggleBankTransfer();
                    toggleQPay();
                });
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

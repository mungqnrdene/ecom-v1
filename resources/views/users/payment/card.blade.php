@extends('layouts.user')
@section('title', 'Картаар төлөх')

@section('page')
    <style>
        .payment-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }

        .payment-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-header h3 {
            color: #e5e7eb;
            margin-bottom: 10px;
        }

        .order-summary {
            background: rgba(59, 130, 246, 0.1);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .order-summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #d1d5db;
        }

        .order-summary-total {
            display: flex;
            justify-content: space-between;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-weight: 700;
            font-size: 1.2rem;
            color: #34d399;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            color: #d1d5db;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            padding: 12px 16px;
            color: #e5e7eb;
            width: 100%;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: #60a5fa;
            outline: none;
        }

        .card-row {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
        }

        .btn-pay {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 12px;
            padding: 14px;
            width: 100%;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .btn-pay:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            color: #d1d5db;
            font-weight: 600;
            margin-top: 10px;
        }
    </style>

    <div class="payment-card">
        <div class="payment-header">
            <h3><i class="bi bi-credit-card-2-front"></i> Картаар төлөх</h3>
            <p class="text-muted">Картын мэдээллээ оруулна уу</p>
        </div>

        <div class="order-summary">
            <div class="order-summary-item">
                <span>Захиалгын дугаар:</span>
                <strong>{{ $order->order_number }}</strong>
            </div>
            <div class="order-summary-item">
                <span>Барааны тоо:</span>
                <span>{{ $order->orderItems->count() }} бараа</span>
            </div>
            <div class="order-summary-total">
                <span>Нийт дүн:</span>
                <span>{{ number_format($order->total_amount) }}₮</span>
            </div>
        </div>

        <form method="POST" action="{{ route('payment.card.process', $order->id) }}">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-credit-card"></i> Картын дугаар
                </label>
                <input type="text" name="card_number" class="form-control @error('card_number') is-invalid @enderror"
                    placeholder="1234 5678 9012 3456" maxlength="16" required>
                @error('card_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-person"></i> Картын эзэмшигч
                </label>
                <input type="text" name="card_holder" class="form-control @error('card_holder') is-invalid @enderror"
                    placeholder="BOLD MUNKHBAT" required>
                @error('card_holder')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="card-row">
                <div class="form-group">
                    <label class="form-label">Сар</label>
                    <input type="text" name="expiry_month"
                        class="form-control @error('expiry_month') is-invalid @enderror" placeholder="12" maxlength="2"
                        required>
                </div>
                <div class="form-group">
                    <label class="form-label">Жил</label>
                    <input type="text" name="expiry_year" class="form-control @error('expiry_year') is-invalid @enderror"
                        placeholder="2026" maxlength="4" required>
                </div>
                <div class="form-group">
                    <label class="form-label">CVV</label>
                    <input type="text" name="cvv" class="form-control @error('cvv') is-invalid @enderror"
                        placeholder="123" maxlength="3" required>
                </div>
            </div>

            <div class="form-check mb-3" style="padding-left: 0;">
                <div
                    style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 10px; padding: 15px; display: flex; align-items: center; gap: 12px;">
                    <input type="checkbox" name="save_card" id="save_card" value="1" class="form-check-input"
                        style="width: 20px; height: 20px; margin: 0; cursor: pointer;">
                    <label for="save_card" class="form-check-label"
                        style="color: #93c5fd; margin: 0; cursor: pointer; font-size: 0.95rem;">
                        <i class="bi bi-bookmark-check me-1"></i>
                        Энэ картыг дараа дахин ашиглахаар хадгалах
                    </label>
                </div>
                <small style="color: #6b7280; display: block; margin-top: 8px; padding-left: 8px;">
                    <i class="bi bi-shield-check me-1"></i>
                    Зөвхөн сүүлийн 4 орон болон дуусах хугацаа хадгалагдана. CVV код хадгалагдахгүй.
                </small>
            </div>

            <button type="submit" class="btn btn-pay">
                <i class="bi bi-check-circle me-2"></i>Төлбөр төлөх
            </button>

            <a href="{{ route('users.orders') }}" class="btn btn-cancel">
                <i class="bi bi-x-circle me-2"></i>Цуцлах
            </a>
        </form>
    </div>
@endsection

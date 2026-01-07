@extends('layouts.user')

@section('title', 'Карт төлбөр - Light Shop')

@push('styles')
    <style>
        .checkout-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        .card-preview {
            background: radial-gradient(circle at top, rgba(59, 130, 246, 0.6), rgba(15, 23, 42, 0.95));
            border-radius: 28px;
            padding: 32px;
            color: #fff;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 30px 80px rgba(15, 23, 42, 0.6);
        }

        .card-preview::after {
            content: '';
            position: absolute;
            bottom: -60px;
            right: -40px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.15);
            filter: blur(50px);
        }

        .card-chip {
            width: 50px;
            height: 36px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.4);
            margin-bottom: 20px;
        }

        .glass-panel {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 18px 60px rgba(0, 0, 0, 0.45);
        }

        .glass-panel label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .summary-card {
            background: rgba(15, 23, 42, 0.7);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .summary-item+.summary-item {
            margin-top: 14px;
            border-top: 1px dashed rgba(255, 255, 255, 0.08);
            padding-top: 14px;
        }

        .summary-total {
            font-size: 1.25rem;
            font-weight: 700;
            color: #34d399;
        }
    </style>
@endpush

@section('page')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">💳 Карт төлбөр</h2>
            <p class="text-muted mb-0">Картын мэдээллээ баталгаатайгаар оруулж, шууд төлбөрөө гүйцэтгээрэй.</p>
        </div>
        <a href="{{ route('cart.index') }}" class="btn btn-outline-light">Сагс руу буцах</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success d-flex justify-content-between align-items-center">
            <span>{{ session('success') }}</span>
            @if (session('payment_reference'))
                <span class="fw-semibold">Reference: {{ session('payment_reference') }}</span>
            @endif
        </div>
    @endif

    @error('cart')
        <div class="alert alert-warning">{{ $message }}</div>
    @enderror

    <div class="checkout-grid">
        <div class="card-preview">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="badge bg-light text-dark px-3 py-2">Light Shop</span>
                <span class="text-uppercase small">Secure 3D</span>
            </div>
            <div class="card-chip"></div>
            <div class="mb-4">
                <div class="text-uppercase text-muted small">Картын дугаар</div>
                <div class="fs-4 fw-bold tracking-wide">**** **** ****
                    {{ substr(preg_replace('/\D/', '', old('card_number', '4580 0024 7788 3344')), -4) }}</div>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <div class="text-uppercase text-muted small">Эзэмшигч</div>
                    <div class="fw-semibold">{{ old('card_name', Auth::user()->name) }}</div>
                </div>
                <div>
                    <div class="text-uppercase text-muted small">Дүн</div>
                    <div class="summary-total">₮ {{ number_format($cartTotal, 0) }}</div>
                </div>
            </div>
        </div>

        <div class="glass-panel">
            <form method="POST" action="{{ route('users.payment-card.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Карт эзэмшигч</label>
                    <input type="text" name="card_name" class="form-control @error('card_name') is-invalid @enderror"
                        placeholder="Жишээ: Batbold A." value="{{ old('card_name', Auth::user()->name) }}">
                    @error('card_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Карт дугаар</label>
                    <input type="text" name="card_number" inputmode="numeric"
                        class="form-control @error('card_number') is-invalid @enderror" placeholder="1234 5678 9012 3456"
                        value="{{ old('card_number') }}" maxlength="19">
                    @error('card_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Хүчинтэй хугацаа</label>
                        <input type="text" name="expiry" class="form-control @error('expiry') is-invalid @enderror"
                            placeholder="MM/YY" value="{{ old('expiry') }}" maxlength="5">
                        @error('expiry')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CVV</label>
                        <input type="text" name="cvv" class="form-control @error('cvv') is-invalid @enderror"
                            placeholder="123" value="{{ old('cvv') }}" maxlength="4">
                        @error('cvv')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-check form-switch my-4">
                    <input class="form-check-input" type="checkbox" role="switch" id="saveCard" name="save_card"
                        value="1" {{ old('save_card') ? 'checked' : '' }}>
                    <label class="form-check-label" for="saveCard">Дараагийн удаа карт хадгалах</label>
                </div>

                <button class="btn btn-primary w-100 py-2 fw-semibold">₮ {{ number_format($cartTotal, 0) }} төлөх</button>
            </form>
        </div>
    </div>

    <div class="summary-card mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Захиалгын тойм</h5>
            <span class="badge bg-primary">{{ $cartItems->count() }} бараа</span>
        </div>

        @if ($cartItems->isEmpty())
            <p class="text-muted mb-0">Сагс хоосон байна. Бараа нэмээд дахин оролдоно уу.</p>
        @else
            @foreach ($cartItems as $item)
                @php($product = $item->product)
                <div class="summary-item d-flex align-items-center justify-content-between">
                    <div>
                        <div class="fw-semibold">{{ $product->name ?? 'Бараа устсан' }}</div>
                        <small class="text-muted">{{ $item->quantity }} × {{ number_format($item->unit_price) }} ₮</small>
                    </div>
                    <span class="fw-semibold">₮ {{ number_format($item->total_price) }}</span>
                </div>
            @endforeach

            <div class="d-flex justify-content-between align-items-center mt-4">
                <span class="text-muted">Нийт төлөх</span>
                <span class="summary-total">₮ {{ number_format($cartTotal, 0) }}</span>
            </div>
        @endif
    </div>
@endsection

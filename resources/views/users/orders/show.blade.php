@extends('layouts.user')
@section('title', 'Захиалгын дэлгэрэнгүй')

@section('page')

    <style>
        /* Header Section */
        .order-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(147, 51, 234, 0.25));
            border-radius: 22px;
            padding: 28px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.5);
        }

        .order-header h4 {
            color: #e5e7eb;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .order-header p {
            color: #9ca3af;
            margin-bottom: 0;
        }

        /* Status Badges */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
        }

        .status-pending {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .status-processing {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .status-paid {
            background: rgba(34, 197, 94, 0.2);
            color: #34d399;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-completed {
            background: rgba(34, 197, 94, 0.2);
            color: #34d399;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-refunded {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-failed {
            background: rgba(239, 68, 68, 0.2);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        /* Product Items Card */
        .items-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }

        .items-card-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(147, 51, 234, 0.3));
            color: #e5e7eb;
            padding: 18px 24px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Product Item */
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
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 14px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            color: #e5e7eb;
            font-weight: 600;
            font-size: 1.15rem;
            margin-bottom: 10px;
        }

        .product-meta {
            color: #9ca3af;
            font-size: 0.95rem;
        }

        .product-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.3rem;
            white-space: nowrap;
        }

        /* Info Cards */
        .info-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            height: 100%;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        }

        .info-card-header {
            background: linear-gradient(135deg, rgba(251, 191, 36, 0.25), rgba(245, 158, 11, 0.25));
            color: #e5e7eb;
            padding: 16px 20px;
            font-weight: 600;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px 20px 0 0;
        }

        .info-card-body {
            padding: 20px;
        }

        .info-row {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row small {
            color: #9ca3af;
            font-size: 0.85rem;
            display: block;
            margin-bottom: 5px;
        }

        .info-row strong,
        .info-row p {
            color: #e5e7eb;
        }

        .info-total {
            background: rgba(34, 197, 94, 0.1);
            border-radius: 12px;
            padding: 15px;
            margin-top: 10px;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .info-total h5 {
            color: #34d399;
            font-weight: 700;
            margin: 0;
        }

        /* Refund Alert */
        .refund-alert {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            color: #fca5a5;
        }

        .refund-alert i {
            color: #ef4444;
            font-size: 1.8rem;
        }

        /* Buttons */
        .btn-back {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #d1d5db;
            border-radius: 12px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            color: #e5e7eb;
        }

        .btn-refund {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border: none;
            border-radius: 14px;
            padding: 12px 24px;
            color: white;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(239, 68, 68, 0.3);
        }

        .btn-refund:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
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
    </style>

    <div class="mb-4">
        <a href="{{ route('users.orders') }}" class="btn btn-back">
            <i class="bi bi-arrow-left me-1"></i> Буцах
        </a>
    </div>

    <!-- Order Header -->
    <div class="order-header">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
            <div>
                <h4>
                    <i class="bi bi-receipt me-2"></i>{{ $order->order_number }}
                </h4>
                <p>
                    <i class="bi bi-calendar me-1"></i>
                    {{ $order->created_at->format('Y оны m сарын d, H:i') }}
                </p>
            </div>
            <div>
                @if ($order->status === 'pending')
                    <span class="status-badge status-pending">
                        <i class="bi bi-clock-history me-1"></i>Хүлээгдэж байна
                    </span>
                @elseif($order->status === 'processing')
                    <span class="status-badge status-processing">
                        <i class="bi bi-gear me-1"></i>Боловсруулж байна
                    </span>
                @elseif($order->status === 'paid')
                    <span class="status-badge status-paid">
                        <i class="bi bi-check-circle me-1"></i>Төлөгдсөн
                    </span>
                @elseif($order->status === 'completed')
                    <span class="status-badge status-completed">
                        <i class="bi bi-check-circle me-1"></i>Хүргэгдсэн
                    </span>
                @elseif($order->status === 'refunded')
                    <span class="status-badge status-refunded">
                        <i class="bi bi-arrow-return-left me-1"></i>Буцаасан
                    </span>
                @elseif($order->status === 'failed')
                    <span class="status-badge status-failed">
                        <i class="bi bi-x-circle me-1"></i>Амжилтгүй
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="items-card">
        <div class="items-card-header">
            <h5 class="mb-0">
                <i class="bi bi-bag-check me-2"></i>Барааны жагсаалт
            </h5>
        </div>
        <div class="list-group list-group-flush">
            @foreach ($order->orderItems as $item)
                <div class="product-item">
                    <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/90' }}"
                        alt="{{ $item->product_name ?? 'Product' }}" class="product-img">

                    <div class="product-details">
                        <div class="product-name">{{ $item->product_name ?? ($item->product->name ?? 'Устсан бараа') }}
                        </div>
                        <div class="product-meta">
                            <span class="me-3">
                                <i class="bi bi-hash"></i>{{ $item->quantity }} ширхэг
                            </span>
                            <span>
                                <i class="bi bi-currency-exchange"></i>{{ number_format($item->price_at_purchase) }}₮
                            </span>
                        </div>
                    </div>

                    <div class="product-price">
                        {{ number_format($item->subtotal) }}₮
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Information -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-truck me-2"></i>Хүргэлтийн мэдээлэл
                    </h6>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <small>Утас</small>
                        <strong>{{ $order->phone }}</strong>
                    </div>
                    <div class="info-row">
                        <small>Хаяг</small>
                        <strong>{{ $order->shipping_address }}</strong>
                    </div>
                    @if ($order->notes)
                        <div class="info-row">
                            <small>Тэмдэглэл</small>
                            <p class="mb-0">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-card">
                <div class="info-card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-credit-card me-2"></i>Төлбөрийн мэдээлэл
                    </h6>
                </div>
                <div class="info-card-body">
                    <div class="info-row">
                        <small>Төлбөрийн статус</small>
                        <strong class="text-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                            {{ $order->payment_status === 'paid' ? '✓ Төлөгдсөн' : '⏳ Төлөгдөөгүй' }}
                        </strong>
                    </div>
                    <div class="info-row">
                        <small>Дэд дүн</small>
                        <strong>{{ number_format($order->subtotal) }}₮</strong>
                    </div>
                    <div class="info-row">
                        <small>Хүргэлт</small>
                        <strong
                            class="text-success">{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost) . '₮' : 'Үнэгүй' }}</strong>
                    </div>
                    <div class="info-total">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">Нийт</small>
                            <h5>{{ number_format($order->total_amount) }}₮</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Refund Info -->
    @if ($order->status === 'refunded')
        <div class="refund-alert d-flex align-items-center">
            <i class="bi bi-info-circle me-3"></i>
            <div>
                <strong class="d-block mb-1">Буцаагдсан захиалга</strong>
                <small>Буцаасан огноо: {{ $order->refunded_at->format('Y-m-d H:i') }}</small>
            </div>
        </div>
    @endif

    <!-- Actions -->
    @if (setting('allow_refund', 1) == 1 && $order->status !== 'refunded' && $order->canRefund())
        <div class="text-end">
            <form action="{{ route('users.orders.refund', $order) }}" method="POST"
                onsubmit="return confirm('Та энэ захиалгыг буцаахдаа итгэлтэй байна уу?')" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-refund">
                    <i class="bi bi-arrow-return-left me-2"></i>Захиалга буцаах
                </button>
            </form>
        </div>
    @endif

@endsection

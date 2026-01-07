@extends('layouts.admin')

@section('title', 'Захиалгын дэлгэрэнгүй')

@section('content')
    <style>
        :root {
            --bg-dark-primary: #0f172a;
            --bg-dark-secondary: #1e293b;
            --bg-card: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            --border-subtle: rgba(255, 255, 255, 0.08);
            --accent-purple: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --accent-amber: #fbbf24;
        }

        .container-fluid {
            background: linear-gradient(to bottom, var(--bg-dark-primary), var(--bg-dark-secondary));
            min-height: 10vh;
        }

        .order-detail-card {
            background: var(--bg-card);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            animation: slideUp 0.5s ease;
            border: 1px solid var(--border-subtle);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-header {
            background: var(--accent-purple);
            color: white;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .order-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .order-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            animation: float 8s ease-in-out infinite reverse;
        }

        .info-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.8) 0%, rgba(51, 65, 85, 0.9) 100%);
            border: 2px solid var(--border-subtle);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .info-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .info-card:hover {
            border-color: rgba(102, 126, 234, 0.5);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
            transform: translateY(-5px);
        }

        .info-card h5 {
            color: #818cf8;
            font-weight: 800;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid rgba(129, 140, 248, 0.3);
            position: relative;
            z-index: 1;
        }

        .info-card .info-row {
            padding: 0.5rem 0;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-secondary);
        }

        .info-card .info-row:last-child {
            border-bottom: none;
        }

        .info-card div {
            color: var(--text-secondary);
            position: relative;
            z-index: 1;
        }

        .info-card strong {
            color: var(--text-primary);
            font-weight: 700;
        }

        .product-item {
            padding: 1.5rem;
            border-bottom: 2px solid var(--border-subtle);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(30, 41, 59, 0.3);
            margin-bottom: 0.5rem;
            border-radius: 12px;
        }

        .product-item:hover {
            background: linear-gradient(to right, rgba(129, 140, 248, 0.1), rgba(102, 126, 234, 0.1));
            border-left: 4px solid #818cf8;
            transform: translateX(6px);
            box-shadow: 0 4px 16px rgba(129, 140, 248, 0.2);
        }

        .product-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .product-item h6 {
            color: var(--text-primary);
            font-weight: 700;
        }

        .product-item .text-muted {
            color: var(--text-muted) !important;
        }

        .product-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 14px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            border: 2px solid var(--border-subtle);
        }

        .product-img:hover {
            transform: scale(1.15) rotate(3deg);
            box-shadow: 0 8px 24px rgba(129, 140, 248, 0.4);
            border-color: #818cf8;
        }

        .status-badge {
            padding: 0.7rem 1.4rem;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 800;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
            text-transform: uppercase;
            letter-spacing: 1px;
            border: 2px solid;
        }

        .status-pending {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #78350f;
            border-color: rgba(245, 158, 11, 0.5);
        }

        .status-processing {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e3a8a;
            border-color: rgba(59, 130, 246, 0.5);
        }

        .status-shipped {
            background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
            color: #3730a3;
            border-color: rgba(99, 102, 241, 0.5);
        }

        .status-delivered {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #064e3b;
            border-color: rgba(16, 185, 129, 0.5);
        }

        .status-cancelled {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #7f1d1d;
            border-color: rgba(239, 68, 68, 0.5);
        }

        /* Legacy status classes */
        .status-completed {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #064e3b;
            border-color: rgba(16, 185, 129, 0.5);
        }

        .status-refunded {
            background: linear-gradient(135deg, #fee2e2, #fecaca);
            color: #7f1d1d;
            border-color: rgba(239, 68, 68, 0.5);
        }

        .action-section {
            background: linear-gradient(to right, rgba(30, 41, 59, 0.6), rgba(51, 65, 85, 0.6));
            border-radius: 16px;
            padding: 2rem;
            margin-top: 2rem;
            border: 1px solid var(--border-subtle);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }

        .status-select {
            background: rgba(30, 41, 59, 0.8);
            border: 2px solid var(--border-subtle);
            border-radius: 12px;
            padding: 0.85rem 1.2rem;
            transition: all 0.3s ease;
            color: var(--text-primary);
            font-weight: 600;
        }

        .status-select:focus {
            background: rgba(30, 41, 59, 1);
            border-color: #818cf8;
            box-shadow: 0 0 0 0.25rem rgba(129, 140, 248, 0.25);
            color: var(--text-primary);
        }

        .status-select option {
            background: #1e293b;
            color: var(--text-primary);
        }

        .btn-save {
            background: var(--accent-purple);
            border: none;
            padding: 0.85rem 2rem;
            border-radius: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        }

        .btn-save:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.6);
            background: linear-gradient(135deg, #5568d3, #6a3f8f);
        }

        .back-btn {
            background: rgba(30, 41, 59, 0.8);
            border: 2px solid #818cf8;
            color: #818cf8;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .back-btn:hover {
            background: var(--accent-purple);
            color: white;
            border-color: transparent;
            transform: translateX(-8px);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        }

        .section-title {
            color: #818cf8;
            font-weight: 800;
            font-size: 1.35rem;
            margin-bottom: 1.25rem;
            padding-left: 1.25rem;
            border-left: 4px solid #818cf8;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.1));
            border: 2px solid rgba(16, 185, 129, 0.5);
            border-radius: 12px;
            color: #d1fae5;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.1));
            border: 2px solid rgba(59, 130, 246, 0.5);
            color: #dbeafe;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.1));
            border: 2px solid rgba(245, 158, 11, 0.5);
            color: #fef3c7;
        }

        .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .text-primary {
            color: var(--accent-amber) !important;
        }

        .badge.bg-success {
            background: linear-gradient(135deg, #10b981, #059669) !important;
            padding: 0.5rem 1rem;
            font-weight: 700;
            border-radius: 50px;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706) !important;
            padding: 0.5rem 1rem;
            font-weight: 700;
            border-radius: 50px;
        }

        h2,
        h5,
        h6 {
            position: relative;
            z-index: 1;
        }

        hr {
            border-color: var(--border-subtle);
            opacity: 1;
        }
    </style>

    <div class="container-fluid py-4">
        <div class="mb-4">
            <a href="{{ route('admin.orders') }}" class="btn back-btn">
                <i class="bi bi-arrow-left me-2"></i> Буцах
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="order-detail-card">
            <!-- Header -->
            <div class="order-header">
                <div class="d-flex justify-content-between align-items-start position-relative">
                    <div>
                        <h2 class="mb-2">
                            <i class="bi bi-receipt me-2"></i>{{ $order->order_number }}
                        </h2>
                        <p class="mb-0 opacity-90">
                            <i class="bi bi-calendar-event me-2"></i>
                            {{ $order->created_at->format('Y оны m сарын d, H:i') }}
                        </p>
                    </div>
                    <div>
                        @if ($order->status === 'pending')
                            <span class="status-badge status-pending">⏳ Хүлээгдэж байна</span>
                        @elseif($order->status === 'processing')
                            <span class="status-badge status-processing">🔄 Боловсруулж байна</span>
                        @elseif($order->status === 'completed')
                            <span class="status-badge status-completed">✅ Хүргэгдсэн</span>
                        @elseif($order->status === 'refunded')
                            <span class="status-badge status-refunded">↩️ Буцаасан</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4">
                <div class="row g-4">
                    <!-- Customer Info -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <h5 class="mb-3">
                                <i class="bi bi-person-circle me-2"></i>Хэрэглэгчийн мэдээлэл
                            </h5>
                            <div class="mb-2">
                                <strong>Нэр:</strong> {{ $order->user->name ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <strong>Имэйл:</strong> {{ $order->user->email ?? 'N/A' }}
                            </div>
                            <div class="mb-2">
                                <strong>Утас:</strong> {{ $order->phone }}
                            </div>
                            <div>
                                <strong>Хаяг:</strong> {{ $order->shipping_address }}
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-md-6">
                        <div class="info-card">
                            <h5 class="mb-3">
                                <i class="bi bi-card-list me-2"></i>Захиалгын хураангуй
                            </h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Бараа:</span>
                                <strong>{{ number_format($order->subtotal) }}₮</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Хүргэлт:</span>
                                <strong>{{ $order->shipping_cost > 0 ? number_format($order->shipping_cost) . '₮' : 'Үнэгүй' }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Татвар:</span>
                                <strong>{{ $order->tax > 0 ? number_format($order->tax) . '₮' : '0₮' }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h6>Нийт:</h6>
                                <h5 class="text-primary mb-0">{{ number_format($order->total_amount) }}₮</h5>
                            </div>
                            <div class="mt-3">
                                <strong>Төлбөрийн статус:</strong>
                                <span
                                    class="ms-2 badge {{ $order->payment_status === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $order->payment_status === 'paid' ? 'Төлөгдсөн' : 'Төлөгдөөгүй' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mt-4">
                    <h5 class="section-title">
                        <i class="bi bi-box-seam me-2"></i>Барааны жагсаалт
                    </h5>
                    <div class="info-card">
                        @foreach ($order->orderItems as $item)
                            <div class="product-item d-flex align-items-center">
                                <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/80' }}"
                                    alt="{{ $item->product->name ?? ($item->product_name ?? 'Product') }}"
                                    class="product-img me-3">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $item->product->name ?? ($item->product_name ?? 'Устсан бараа') }}
                                    </h6>
                                    <p class="text-muted mb-0">
                                        <i class="bi bi-hash me-1"></i>Тоо ширхэг: {{ $item->quantity }}
                                        <span class="mx-2">×</span>
                                        <i
                                            class="bi bi-currency-exchange me-1"></i>{{ number_format($item->price_at_purchase) }}₮
                                    </p>
                                </div>
                                <div class="text-end">
                                    <strong class="h4 mb-0 text-primary">{{ number_format($item->subtotal) }}₮</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Notes -->
                @if ($order->notes)
                    <div class="mt-4">
                        <h5 class="section-title">
                            <i class="bi bi-chat-left-text me-2"></i>Тэмдэглэл
                        </h5>
                        <div class="alert alert-info border-0">
                            <i class="bi bi-info-circle me-2"></i>{{ $order->notes }}
                        </div>
                    </div>
                @endif

                <!-- Refund Info -->
                @if ($order->refunded_at)
                    <div class="mt-4">
                        <div class="alert alert-warning border-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Буцаагдсан захиалга</strong><br>
                            <small>Буцаасан огноо: {{ $order->refunded_at->format('Y-m-d H:i') }}</small>
                        </div>
                    </div>
                @endif

                <!-- Status Update Form -->
                <div class="action-section">
                    <h5 class="section-title mb-3">
                        <i class="bi bi-pencil-square me-2"></i>Статус өөрчлөх
                    </h5>
                    <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST"
                        class="d-flex gap-3 align-items-center flex-wrap">
                        @csrf
                        @method('PATCH')
                        <div class="flex-grow-1" style="min-width: 250px;">
                            <select name="status" class="form-select status-select">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ Хүлээгдэж
                                    байна</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>🔄
                                    Боловсруулж байна</option>
                                <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>🚚
                                    Хүргэгдэж байна</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>✅
                                    Хүргэгдсэн</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌
                                    Цуцлагдсан
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-save">
                            <i class="bi bi-check-lg me-2"></i>Хадгалах
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

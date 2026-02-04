<style>
    /* Orders Page Header */
    .orders-header {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(147, 51, 234, 0.25));
        border-radius: 22px;
        padding: 28px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 20px 60px rgba(15, 23, 42, 0.5);
    }

    .orders-header h3 {
        color: #e5e7eb;
        font-weight: 700;
        margin: 0;
    }



    /* Order Card */

    .card-content {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        align-items: stretch;
    }

    @media (max-width: 1200px) {
        .card-content {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .card-content {
            grid-template-columns: 1fr;
        }
    }

    .order-card {
        background: rgba(15, 23, 42, 0.85);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
        display: flex;
        flex-direction: column;
        height: auto;
    }

    .order-card:hover {
        transform: translateY(-4px);
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.45);
    }

    .order-header {
        background: linear-gradient(135deg, rgba(251, 191, 36, 0.25), rgba(245, 158, 11, 0.25));
        color: #e5e7eb;
        padding: 14px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-number {
        font-size: 1rem;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #e5e7eb;
    }

    .order-date {
        color: #9ca3af;
        font-size: 0.85rem;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
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

    /* Order Body */
    .order-body {
        padding: 16px 20px;
    }

    .order-items-label {
        color: #9ca3af;
        font-size: 0.8rem;
        margin-bottom: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Order Items Grid */
    .order-items-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        margin-bottom: 12px;
    }

    @media (max-width: 768px) {
        .order-items-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 480px) {
        .order-items-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Order Item */
    .order-item {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        padding: 10px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .order-item:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(59, 130, 246, 0.2);
        transform: translateY(-2px);
    }

    .order-item-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .order-item-name {
        color: #e5e7eb;
        font-weight: 600;
        font-size: 0.8rem;
        line-height: 1.3;
        width: 100%;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .order-item-meta {
        color: #9ca3af;
        font-size: 0.75rem;
        width: 100%;
    }

    .order-item-price {
        color: #34d399;
        font-weight: 700;
        font-size: 0.9rem;
        width: 100%;
    }

    /* Order Details */
    .order-details {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        padding: 16px;
        margin: 16px 0;
    }

    .detail-label {
        color: #9ca3af;
        font-size: 0.85rem;
        display: block;
        margin-bottom: 4px;
    }

    .detail-value {
        color: #e5e7eb;
        font-weight: 500;
    }

    /* Order Footer */
    .order-footer {
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }

    .order-actions {
        gap: 8px !important;
    }

    .order-actions .btn {
        padding: 8px 14px;
        font-size: 0.85rem;
        border-radius: 10px;
    }

    .total-section {
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.2);
        border-radius: 12px;
        padding: 12px 16px;
    }

    .total-label {
        color: #9ca3af;
        font-size: 0.85rem;
    }

    .total-amount {
        color: #34d399;
        font-weight: 700;
        font-size: 1.4rem;
        margin: 0;
    }

    /* Buttons */
    .view-btn {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
    }

    .view-btn:hover {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: white;
    }

    .refund-btn {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(239, 68, 68, 0.3);
    }

    .refund-btn:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.4);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #9ca3af;
    }

    /* Empty State */
    .empty-state {
        background: rgba(15, 23, 42, 0.85);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 60px 40px;
        text-align: center;
    }

    .empty-state i {
        color: #374151;
    }

    .empty-state .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #8b5cf6);
        border: none;
        padding: 12px 28px;
        border-radius: 14px;
        font-weight: 600;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
    }

    .empty-state .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
    }

    /* More Items Badge */
    .more-items-badge {
        background: rgba(59, 130, 246, 0.15);
        color: #60a5fa;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 0.8rem;
        border: 1px solid rgba(59, 130, 246, 0.3);
        display: inline-block;
    }

    /* Alert */
    .alert-success {
        background: rgba(34, 197, 94, 0.15);
        border: 1px solid rgba(34, 197, 94, 0.3);
        color: #34d399;
        border-radius: 16px;
    }
</style>

<!-- Page Header -->
<div class="orders-header">
    <h3>
        <i class="bi bi-box-seam me-2"></i>
        Миний захиалгууд
    </h3>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if ($data['orders']->isEmpty())
    <div class="empty-state">
        <i class="bi bi-inbox" style="font-size: 4rem;"></i>
        <h5 class="mt-3 text-muted">Захиалга олдсонгүй</h5>
        <p class="text-muted">Та одоогоор ямар ч захиалга хийгээгүй байна.</p>
        <a href="{{ route('users.dashboard') }}" class="btn btn-primary mt-3">
            <i class="bi bi-shop me-2"></i>Дэлгүүр рүү очих
        </a>
    </div>
@else
    <div class="card-content">
        @foreach ($data['orders'] as $order)
            <div class="order-card">
                <!-- Order Header -->
                <div class="order-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <div class="order-number">{{ $order->order_number }}</div>
                        <small class="order-date">{{ $order->created_at->format('Y-m-d H:i') }}</small>
                    </div>
                    <div>
                        @if ($order->status === 'pending')
                            <span class="status-badge status-pending">
                                <i class="bi bi-clock-history"></i> Хүлээгдэж байна
                            </span>
                        @elseif($order->status === 'processing')
                            <span class="status-badge status-processing">
                                <i class="bi bi-gear"></i> Боловсруулж байна
                            </span>
                        @elseif($order->status === 'paid')
                            <span class="status-badge status-paid">
                                <i class="bi bi-check-circle"></i> Төлөгдсөн
                            </span>
                        @elseif($order->status === 'completed')
                            <span class="status-badge status-completed">
                                <i class="bi bi-check-circle"></i> Хүргэгдсэн
                            </span>
                        @elseif($order->status === 'refunded')
                            <span class="status-badge status-refunded">
                                <i class="bi bi-arrow-return-left"></i> Буцаасан
                            </span>
                        @elseif($order->status === 'failed')
                            <span class="status-badge status-failed">
                                <i class="bi bi-x-circle"></i> Амжилтгүй
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Order Body -->
                <div class="order-body">
                    <!-- Order Items Preview -->
                    <div class="mb-3">
                        <div class="order-items-label">
                            <i class="bi bi-bag-check me-1"></i>Барааны жагсаалт ({{ $order->orderItems->count() }})
                        </div>
                        <div class="order-items-grid">
                            @foreach ($order->orderItems as $item)
                                <div class="order-item">
                                    <img src="{{ $item->product && $item->product->image ? asset('storage/' . $item->product->image) : 'https://via.placeholder.com/70' }}"
                                        alt="{{ $item->product_name ?? 'Product' }}" class="order-item-img">
                                    <div class="order-item-name">
                                        {{ $item->product_name ?? ($item->product->name ?? 'Устсан бараа') }}
                                    </div>
                                    <div class="order-item-meta">
                                        <i class="bi bi-x" style="font-size: 0.7rem;"></i>{{ $item->quantity }} ×
                                        {{ number_format($item->price_at_purchase) }}₮
                                    </div>
                                    <div class="order-item-price">{{ number_format($item->subtotal) }}₮</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="order-details">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <span class="detail-label">Хэрэглэгчийн код:</span>
                                <span class="detail-value">{{ Auth::user()->user_code ?? $order->user_id }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="detail-label">Утас:</span>
                                <span class="detail-value">{{ $order->phone }}</span>
                            </div>
                            <div class="col-md-6">
                                <span class="detail-label">Хүргэлтийн хаяг:</span>
                                <span class="detail-value">{{ Str::limit($order->shipping_address, 50) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total & Actions -->
                    <div class="order-footer">
                        <div class="total-section">
                            <div class="total-label">Нийт дүн</div>
                            <h5 class="total-amount">{{ number_format($order->total_amount) }}₮</h5>
                        </div>
                        <div class="d-flex gap-2 flex-wrap order-actions">
                            <a href="{{ route('users.orders.show', $order) }}" class="btn view-btn">
                                <i class="bi bi-eye me-1"></i>Дэлгэрэнгүй
                            </a>
                            @php
                                $refundDeadline = $order->created_at->copy()->addMinutes(5);
                                $canRefund = now()->lessThanOrEqualTo($refundDeadline) && $order->status !== 'refunded';
                            @endphp
                            @if (setting('allow_refund', 1) == 1 && $canRefund)
                                <form action="{{ route('users.orders.refund', $order) }}" method="POST"
                                    onsubmit="return confirm('Та энэ захиалгыг буцаахдаа итгэлтэй байна уу?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn refund-btn">
                                        <i class="bi bi-arrow-return-left me-1"></i>Буцаах
                                    </button>
                                </form>
                            @elseif(setting('allow_refund', 1) == 1 && $order->status !== 'refunded')
                                <button type="button" class="btn btn-sm btn-secondary" disabled
                                    title="Буцаалтын хугацаа дууссан (5 минут)">
                                    <i class="bi bi-clock-history me-1"></i>Хугацаа дууссан
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $data['orders']->links() }}
    </div>
@endif

@extends('layouts.admin')

@section('title', 'Захиалгууд')

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
            --pending: #f59e0b;
            --processing: #3b82f6;
            --completed: #10b981;
            --refunded: #ef4444;
        }

        .container-fluid {
            background: linear-gradient(to bottom, var(--bg-dark-primary), var(--bg-dark-secondary));
            min-height: 10vh;
        }

        .admin-header {
            background: var(--accent-purple);
            border-radius: 20px;
            padding: 2.5rem;
            color: white;
            margin-bottom: 2rem;
            box-shadow: 0 12px 40px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }

        .admin-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
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

        .admin-header h2,
        .admin-header p,
        .admin-header .text-end {
            position: relative;
            z-index: 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--border-subtle);
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            transition: width 0.4s ease;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.03) 0%, transparent 70%);
            border-radius: 50%;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
        }

        .stat-card:hover::before {
            width: 100%;
            opacity: 0.08;
        }

        .stat-card.pending::before {
            background: var(--pending);
        }

        .stat-card.processing::before {
            background: var(--processing);
        }

        .stat-card.completed::before {
            background: var(--completed);
        }

        .stat-card.refunded::before {
            background: var(--refunded);
        }

        .stat-icon {
            font-size: 2.8rem;
            opacity: 0.9;
            position: relative;
            z-index: 1;
            display: block;
            animation: pulse 3s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        .stat-value {
            font-size: 2.8rem;
            font-weight: 800;
            margin: 0.75rem 0;
            position: relative;
            z-index: 1;
            line-height: 1;
        }

        .stat-card.pending .stat-value {
            color: var(--pending);
        }

        .stat-card.processing .stat-value {
            color: var(--processing);
        }

        .stat-card.completed .stat-value {
            color: var(--completed);
        }

        .stat-card.refunded .stat-value {
            color: var(--refunded);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            position: relative;
            z-index: 1;
        }

        .order-table {
            background: var(--bg-card);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            border: 1px solid var(--border-subtle);
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: linear-gradient(to bottom, rgba(30, 41, 59, 0.9), rgba(51, 65, 85, 0.9));
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1.2px;
            padding: 1.25rem 1rem;
            color: var(--text-secondary);
        }

        .table tbody td {
            padding: 1.25rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid var(--border-subtle);
            color: var(--text-primary);
        }

        .table tbody tr {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .table tbody tr:hover {
            background: linear-gradient(to right, rgba(100, 116, 139, 0.15), rgba(71, 85, 105, 0.15));
            transform: translateX(6px);
            box-shadow: inset 4px 0 0 var(--accent-amber);
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody td small {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .order-number {
            font-weight: 800;
            color: #818cf8;
            font-size: 1rem;
            font-family: 'Courier New', monospace;
            background: rgba(129, 140, 248, 0.15);
            padding: 0.4rem 0.9rem;
            border-radius: 10px;
            display: inline-block;
            border: 1px solid rgba(129, 140, 248, 0.3);
        }

        .user-name {
            color: var(--text-primary);
            font-weight: 600;
        }

        .date-display {
            color: var(--text-primary);
            font-weight: 600;
        }

        .amount-display {
            color: var(--accent-amber);
            font-size: 1.15rem;
            font-weight: 800;
            text-shadow: 0 0 20px rgba(251, 191, 36, 0.3);
        }

        .status-badge {
            padding: 0.55rem 1.3rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 800;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border: 2px solid;
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.08);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
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

        /* Legacy status classes for backwards compatibility */
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

        .payment-status {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .payment-status i {
            font-size: 1.4rem;
        }

        .payment-status.paid {
            color: var(--completed);
        }

        .payment-status.unpaid {
            color: var(--pending);
        }

        .table-action-btn {
            padding: 0.65rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 700;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--accent-purple);
            border: none;
            color: white;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
            letter-spacing: 0.5px;
        }

        .table-action-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(102, 126, 234, 0.6);
            background: linear-gradient(135deg, #5568d3, #6a3f8f);
        }

        .table-action-btn:active {
            transform: translateY(-2px);
        }

        .empty-state {
            color: var(--text-muted);
            padding: 5rem 2rem;
        }

        .empty-state i {
            font-size: 4.5rem;
            opacity: 0.2;
            display: block;
            margin-bottom: 1.5rem;
            animation: float 4s ease-in-out infinite;
        }

        .empty-state p {
            font-size: 1.2rem;
            font-weight: 600;
        }

        .pagination-wrapper {
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.8), transparent);
            border-top: 1px solid var(--border-subtle);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(16, 185, 129, 0.1));
            border: 2px solid var(--completed);
            border-radius: 16px;
            color: #d1fae5;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
            margin-bottom: 1.5rem;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .btn-close:hover {
            opacity: 1;
        }=

        .payment-icon {
            font-size: 1.2rem;
        }

        /* TABLE BODY BACKGROUND FIX */
        .order-table .table tbody tr {
            background: rgba(15, 23, 42, 0.85);
            /* бараан card өнгө */
        }

        .order-table .table tbody td {
            background: transparent !important;
        }
    </style>

    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-2">
                        <i class="bi bi-box-seam me-2"></i>Захиалгын удирдлага
                    </h2>
                    <p class="mb-0 opacity-75">Бүх захиалгуудыг харах, засах, статус өөрчлөх</p>
                </div>
                <div class="text-end">
                    <div class="h3 mb-0">{{ $orders->total() }}</div>
                    <small class="opacity-75">Нийт захиалга</small>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-icon text-warning">⏳</div>
                <div class="stat-value text-warning">{{ $orders->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Хүлээгдэж байна</div>
            </div>
            <div class="stat-card processing">
                <div class="stat-icon text-primary">🔄</div>
                <div class="stat-value text-primary">{{ $orders->where('status', 'processing')->count() }}</div>
                <div class="stat-label">Боловсруулж байна</div>
            </div>
            <div class="stat-card shipped">
                <div class="stat-icon text-info">🚚</div>
                <div class="stat-value text-info">{{ $orders->where('status', 'shipped')->count() }}</div>
                <div class="stat-label">Хүргэгдэж байна</div>
            </div>
            <div class="stat-card delivered">
                <div class="stat-icon text-success">✅</div>
                <div class="stat-value text-success">{{ $orders->where('status', 'delivered')->count() }}</div>
                <div class="stat-label">Хүргэгдсэн</div>
            </div>
            <div class="stat-card cancelled">
                <div class="stat-icon text-danger">❌</div>
                <div class="stat-value text-danger">{{ $orders->where('status', 'cancelled')->count() }}</div>
                <div class="stat-label">Цуцлагдсан</div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="order-table">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Захиалгын №</th>
                            <th>Хэрэглэгч</th>
                            <th>Огноо</th>
                            <th>Дүн</th>
                            <th>Статус</th>
                            <th>Төлбөр</th>
                            <th class="text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <span class="order-number">{{ $order->order_number }}</span>
                                </td>
                                <td>
                                    <div class="user-name">{{ $order->user->name ?? 'N/A' }}</div>
                                    <small>{{ $order->user->email ?? '' }}</small>
                                </td>
                                <td>
                                    <div class="date-display">{{ $order->created_at->format('Y-m-d') }}</div>
                                    <small>{{ $order->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <span class="amount-display">{{ number_format($order->total_amount) }}₮</span>
                                </td>
                                <td>
                                    @if ($order->status === 'pending')
                                        <span class="status-badge status-pending">Хүлээгдэж байна</span>
                                    @elseif($order->status === 'processing')
                                        <span class="status-badge status-processing">Боловсруулж байна</span>
                                    @elseif($order->status === 'shipped')
                                        <span class="status-badge status-shipped">Хүргэгдэж байна</span>
                                    @elseif($order->status === 'delivered')
                                        <span class="status-badge status-delivered">Хүргэгдсэн</span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="status-badge status-cancelled">Цуцлагдсан</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->payment_status === 'paid')
                                        <div class="payment-status paid">
                                            <i class="bi bi-check-circle-fill"></i>
                                            <span>Төлөгдсөн</span>
                                        </div>
                                    @else
                                        <div class="payment-status unpaid">
                                            <i class="bi bi-clock-fill"></i>
                                            <span>Төлөгдөөгүй</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm table-action-btn">
                                        <i class="bi bi-eye me-1"></i> Харах
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mb-0">Захиалга олдсонгүй</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="pagination-wrapper">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

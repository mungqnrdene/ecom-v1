@extends('layouts.admin')

@section('title', 'Тайлан - Light Shop')

@push('styles')
    <style>
        /* Export Buttons Styling */
        .export-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.25rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .export-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .export-btn:hover::before {
            left: 100%;
        }

        .export-btn-primary {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .export-btn-primary:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            color: white;
        }

        .export-btn-secondary {
            background: rgba(16, 185, 129, 0.15);
            color: #10b981;
            border: 1.5px solid rgba(16, 185, 129, 0.3);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .export-btn-secondary:hover {
            background: rgba(16, 185, 129, 0.25);
            border-color: rgba(16, 185, 129, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(16, 185, 129, 0.2);
            color: #059669;
        }

        .export-btn i {
            font-size: 1.1rem;
        }

        /* Period Filter Card */
        .filter-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
        }

        .filter-card .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-card .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            color: #fff;
        }

        .filter-card .form-select option {
            background: #1e293b;
            color: #e5e7eb;
        }

        /* Table Improvements */
        .report-table {
            border-radius: 12px;
            overflow: hidden;
        }

        .report-table thead th {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.2));
            border-bottom: 2px solid rgba(59, 130, 246, 0.3);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .report-table tbody tr {
            transition: all 0.2s ease;
        }

        .report-table tbody tr:hover {
            background: rgba(59, 130, 246, 0.08);
            transform: scale(1.01);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .export-actions {
                justify-content: stretch;
            }

            .export-btn {
                flex: 1 1 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Insights & Analytics</span>
                <h1 class="admin-page-title">📊 Борлуулалтын тайлан</h1>
                <p class="admin-page-subtitle">Хугацаагаар шүүж, Excel/CSV татаж авах боломжтой дэлгэрэнгүй тайлан.</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light admin-cta-btn">← Самбар руу буцах</a>
        </div>

        {{-- Period Filter & Export Buttons --}}
        <div class="card filter-card mb-4">
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.reports') }}">
                            <div class="d-flex gap-2">
                                <select name="period" class="form-select" onchange="this.form.submit()">
                                    <option value="10_days"
                                        {{ request('period', '10_days') == '10_days' ? 'selected' : '' }}>
                                        📅 Сүүлийн 10 хоног
                                    </option>
                                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>
                                        📆 Сүүлийн 1 сарын тайлан
                                    </option>
                                </select>
                            </div>
                        </form>
                        <small class="text-muted mt-2 d-block">
                            <i class="bi bi-calendar-range me-1"></i>
                            <strong>Хугацаа:</strong> {{ $reportData['start_date']->format('Y-m-d') }} -
                            {{ $reportData['end_date']->format('Y-m-d') }}
                        </small>
                    </div>
                    <div class="col-md-6">
                        <div class="export-actions">
                            <a href="{{ route('admin.reports.export.' . (request('period', '10_days') == '10_days' ? '10days' : 'monthly')) }}"
                                class="export-btn export-btn-primary">
                                <i class="bi bi-file-earmark-spreadsheet"></i>
                                Бүтэн тайлан татах
                            </a>
                            <a href="{{ route('admin.reports.export.users') }}" class="export-btn export-btn-secondary">
                                <i class="bi bi-people-fill"></i>
                                Хэрэглэгч
                            </a>
                            <a href="{{ route('admin.reports.export.orders') }}" class="export-btn export-btn-secondary">
                                <i class="bi bi-receipt"></i>
                                Захиалга
                            </a>
                            <a href="{{ route('admin.reports.export.refunds') }}" class="export-btn export-btn-secondary">
                                <i class="bi bi-arrow-return-left"></i>
                                Буцаалт
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Statistics --}}
        <div class="admin-stat-grid">
            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Шинэ хэрэглэгч</p>
                <h2>{{ number_format($reportData['new_users_count']) }}</h2>
                <span class="admin-chip">Энэ хугацаанд бүртгүүлсэн</span>
            </div>
            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Нийт захиалга</p>
                <h2>{{ number_format($reportData['total_orders_count']) }}</h2>
                <span class="admin-chip">Дундаж: ₮
                    {{ number_format($reportData['total_orders_count'] > 0 ? $reportData['total_sales_amount'] / $reportData['total_orders_count'] : 0, 0, '.', ' ') }}</span>
            </div>
            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Нийт борлуулалт</p>
                <h2>₮ {{ number_format($reportData['total_sales_amount'], 0, '.', ' ') }}</h2>
                <span class="admin-chip">Цэвэр орлого</span>
            </div>
            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Буцаалт (Refund)</p>
                <h2>₮ {{ number_format($reportData['refunded_amount'], 0, '.', ' ') }}</h2>
                <span class="admin-chip">{{ $reportData['refunded_orders_count'] }} захиалга</span>
            </div>
        </div>

        {{-- Daily Orders Breakdown --}}
        <div class="row g-4 mt-1">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bi bi-calendar-day me-2"></i>Өдрийн задаргаа</h5>
                        @if (!empty($reportData['daily_orders']))
                            <div class="table-responsive report-table">
                                <table class="table table-dark table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Огноо</th>
                                            <th class="text-end">Захиалгын тоо</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportData['daily_orders'] as $date => $count)
                                            <tr>
                                                <td><i class="bi bi-calendar3 me-2"></i>{{ $date }}</td>
                                                <td class="text-end">
                                                    <span class="badge bg-primary">{{ $count }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Энэ хугацаанд захиалга байхгүй байна.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Sold Products --}}
        <div class="row g-4 mt-1">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3"><i class="bi bi-box-seam me-2"></i>Зарагдсан бүтээгдэхүүн</h5>
                        @if (!empty($reportData['sold_products']))
                            <div class="table-responsive report-table">
                                <table class="table table-dark table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Бүтээгдэхүүн</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Үнэ</th>
                                            <th class="text-center">Тоо ширхэг</th>
                                            <th class="text-end">Нийт дүн</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reportData['sold_products'] as $product)
                                            <tr>
                                                <td>
                                                    <strong>{{ $product['name'] }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    @if ($product['image_url'])
                                                        <img src="{{ $product['image_url'] }}"
                                                            alt="{{ $product['name'] }}" class="img-fluid"
                                                            style="max-height: 50px;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">₮
                                                    {{ number_format($product['price'], 0, '.', ' ') }}
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">{{ $product['quantity'] }}</span>
                                                </td>
                                                <td class="text-end">
                                                    <strong>₮
                                                        {{ number_format($product['subtotal'], 0, '.', ' ') }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-primary">
                                            <th colspan="4" class="text-start">НИЙТ ДҮН:</th>
                                            <th class="text-end">₮
                                                {{ number_format(collect($reportData['sold_products'])->sum('subtotal'), 0, '.', ' ') }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <p class="text-muted mb-0">Энэ хугацаанд борлуулалт хийгдээгүй байна.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

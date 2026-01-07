@extends('layouts.app')

@section('title', 'Тайлан - Light Shop')

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
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('admin.reports') }}">
                            <div class="d-flex gap-2">
                                <select name="period" class="form-select" onchange="this.form.submit()">
                                    <option value="10_days"
                                        {{ request('period', '10_days') == '10_days' ? 'selected' : '' }}>
                                        Сүүлийн 10 хоног
                                    </option>
                                    <option value="monthly" {{ request('period') == 'monthly' ? 'selected' : '' }}>
                                        Сүүлийн сарын тайлан
                                    </option>
                                </select>
                            </div>
                        </form>
                        <small class="text-muted mt-2 d-block">
                            <strong>Хугацаа:</strong> {{ $reportData['start_date']->format('Y-m-d') }} -
                            {{ $reportData['end_date']->format('Y-m-d') }}
                        </small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.reports.export.' . (request('period', '10_days') == '10_days' ? '10days' : 'monthly')) }}"
                                class="btn btn-success btn-sm">
                                📥 Бүтэн тайлан татах
                            </a>
                            <a href="{{ route('admin.reports.export.users') }}" class="btn btn-outline-success btn-sm">
                                👥 Хэрэглэгч
                            </a>
                            <a href="{{ route('admin.reports.export.orders') }}" class="btn btn-outline-success btn-sm">
                                🧾 Захиалга
                            </a>
                            <a href="{{ route('admin.reports.export.refunds') }}" class="btn btn-outline-success btn-sm">
                                ↩️ Буцаалт
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
                        <h5 class="mb-3">📅 Өдрийн задаргаа</h5>
                        @if (!empty($reportData['daily_orders']))
                            <div class="table-responsive">
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
                                                <td>{{ $date }}</td>
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
                        <h5 class="mb-3">📦 Зарагдсан бүтээгдэхүүн</h5>
                        @if (!empty($reportData['sold_products']))
                            <div class="table-responsive">
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
                                                        <img src="{{ $product['image_url'] }}" alt="{{ $product['name'] }}"
                                                            class="img-fluid" style="max-height: 50px;">
                                                    @else
                                                        <span class="text-muted">No Image</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">₮ {{ number_format($product['price'], 0, '.', ' ') }}
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

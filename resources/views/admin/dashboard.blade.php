@extends('layouts.app')

@section('title', 'Dashboard - Light Shop')

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Admin overview</span>
                <h1 class="admin-page-title">Төвлөрсөн самбар</h1>
                <p class="admin-page-subtitle">
                    👋 Сайн байна уу, {{ $admin->name }}. Таны мэдээлэл, борлуулалт болон системийн гол үзүүлэлтүүд эндээс
                    харагдана.
                </p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success admin-cta-btn">
                    ➕ Шинэ бараа нэмэх
                </a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light admin-cta-btn">
                    📦 Бүтээгдэхүүний жагсаалт
                </a>
            </div>
        </div>

        <div class="admin-stat-grid">
            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Нийт бүтээгдэхүүн</p>
                <h2 class="mb-1">{{ number_format($productCount) }}</h2>
                <span class="admin-chip">
                    📦 Сүүлийн нэмэлт: {{ $latestProducts->first()?->created_at?->diffForHumans() ?? 'өгөгдөл байхгүй' }}
                </span>
            </div>

            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Нийт борлуулалт</p>
                <h2 class="mb-1">₮ {{ number_format($totalRevenue, 0, '.', ' ') }}</h2>
                <span class="admin-chip">💰 Өнөөдөр: ₮ {{ number_format($todayRevenue, 0, '.', ' ') }}</span>
            </div>

            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Идэвхтэй захиалга</p>
                <h2 class="mb-1">{{ number_format($activeOrders) }}</h2>
                <span class="admin-chip">📋 Хүргэгдсэн: {{ number_format($completedOrders) }}</span>
            </div>

            <div class="admin-stat-card">
                <p class="text-muted text-uppercase mb-1">Бүртгүүлсэн хэрэглэгч</p>
                <h2 class="mb-1">{{ number_format($customerCount) }}</h2>
                <span class="admin-chip">👥 Admin: {{ $admin->email }}</span>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                    <div>
                        <h5 class="mb-1">Түргэн үйлдлүүд</h5>
                        <p class="text-muted mb-0">Хамгийн их ашигладаг цэснүүдийг шууд нээх товчлуурууд.</p>
                    </div>
                </div>
                <div class="admin-quick-actions">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary admin-cta-btn">
                        ➕ Шинэ бүтээгдэхүүн
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-success admin-cta-btn">
                        🗂️ Бүтээгдэхүүний жагсаалт
                    </a>
                    <a href="{{ route('admin.reports') }}" class="btn btn-info admin-cta-btn">
                        📊 Тайлан үзэх
                    </a>
                    <a href="{{ route('admin.settings') }}" class="btn btn-secondary admin-cta-btn">
                        ⚙️ Тохиргоо
                    </a>
                    <a href="{{ route('users.login') }}" class="btn btn-warning admin-cta-btn">
                        👤 Хэрэглэгчийн хэсэг рүү очих
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                <div>
                    <h5 class="mb-1">Сүүлийн бүтээгдэхүүн</h5>
                    <p class="text-muted mb-0">Хамгийн сүүлд нэмсэн бараануудын товч мэдээлэл.</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm">Бүх бүтээгдэхүүн</a>
            </div>

            @if ($latestProducts->isEmpty())
                <div class="alert alert-info">
                    📦 Бүтээгдэхүүн бүртгэл хоосон байна. Шинэ бүтээгдэхүүн нэмээрэй!
                </div>
            @else
                <div class="table-responsive admin-table-wrapper">
                    <table class="table table-dark align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Нэр</th>
                                <th>Ангилал</th>
                                <th>Үнэ</th>
                                <th>Огноо</th>
                                <th class="text-end">Үйлдэл</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($latestProducts as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name ?? 'Ангилаагүй' }}</td>
                                    <td>₮ {{ number_format($product->price, 0, '.', ' ') }}</td>
                                    <td>{{ optional($product->created_at)->format('Y.m.d') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.products.edit', $product->id) }}"
                                            class="btn btn-sm btn-outline-light">Засах</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection

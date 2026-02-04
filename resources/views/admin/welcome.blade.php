@extends('layouts.admin')

@section('title', 'Нүүр хуудас - Light Shop')

@push('styles')
    <style>
        .admin-category-strip {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .admin-category-item {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 14px 12px;
            text-align: center;
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #cbd5e1;
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .admin-category-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top, rgba(99, 102, 241, 0.22), transparent 60%);
            opacity: 0;
            transition: opacity 0.25s ease;
            pointer-events: none;
        }

        .admin-category-item:hover {
            transform: translateY(-4px) scale(1.01);
            border-color: rgba(99, 102, 241, 0.6);
            box-shadow: 0 14px 35px rgba(99, 102, 241, 0.25);
            color: #fff;
        }

        .admin-category-item:hover::after {
            opacity: 1;
        }

        .admin-category-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.25), rgba(139, 92, 246, 0.2));
            color: #e0e7ff;
            font-size: 1.35rem;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.12);
            transition: all 0.25s ease;
        }

        .admin-category-item:hover .admin-category-icon {
            transform: translateY(-1px) scale(1.05);
            box-shadow: 0 10px 22px rgba(99, 102, 241, 0.35);
            color: #fff;
        }

        .admin-category-label {
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.2;
        }

        .admin-section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            margin-top: 10px;
        }

        .admin-section-title {
            color: #e5e7eb;
            font-weight: 700;
            font-size: 1.2rem;
            margin: 0;
        }

        .admin-result-count {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .admin-product-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .admin-product-card img {
            width: 100%;
            height: 190px;
            object-fit: cover;
        }

        .admin-product-body {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .admin-product-name {
            color: #e5e7eb;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .admin-product-price {
            color: #34d399;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .admin-product-actions {
            display: flex;
            gap: 8px;
            margin-top: auto;
        }

        .admin-product-actions .btn {
            flex: 1;
            border-radius: 10px;
            font-weight: 600;
        }

        .admin-empty-state {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 40px;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Welcome back</span>
                <h1 class="admin-page-title">✨ Light Shop админ хэсэг</h1>
                <p class="admin-page-subtitle">Сайн байна уу, {{ $admin->name }}. Доорх товчлууруудыг ашиглан гол самбарууд
                    руу
                    хурдан шилжинэ үү.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary admin-cta-btn">📊 Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-info admin-cta-btn">📦 Бүтээгдэхүүн</a>
                <a href="{{ route('admin.reports') }}" class="btn btn-success admin-cta-btn">📈 Тайлан</a>
            </div>
        </div>
        @php
            $categoryIcons = [
                'Эмэгтэй' => 'bi bi-handbag',
                'Эрэгтэй' => 'bi bi-person-badge',
                'Гоо сайхан' => 'bi bi-stars',
                'Спорт & Аялал' => 'bi bi-compass',
                'Хүүхдийн' => 'bi bi-balloon',
                'Гэрийн & Тавилга' => 'bi bi-house-door',
                'Гоёл чимэглэл' => 'bi bi-gem',
                'Технологи' => 'bi bi-cpu',
                'Тоглоом & Хобби' => 'bi bi-controller',
                'Бичиг хэрэг' => 'bi bi-pencil-square',
                'Эрүүл мэнд & Эрүүл ахуй' => 'bi bi-heart-pulse',
                'Үл хөдлөх' => 'bi bi-building',
                'Цахилгаан хэрэгсэл' => 'bi bi-lightning-charge',
                'Ном & цомог, пянз' => 'bi bi-book',
                'Авто' => 'bi bi-car-front',
                'Тэжээвэр амьтны хангамж' => 'bi bi-emoji-smile',
                'Цахим тасалбар' => 'bi bi-ticket-perforated',
                'Спорт' => 'bi bi-trophy',
                'Бусад' => 'bi bi-collection',
            ];
        @endphp

        <div class="admin-category-strip">
            @foreach ($categoriesForStrip as $category)
                @php($icon = $categoryIcons[$category->name] ?? 'bi bi-tags')
                <a class="admin-category-item" href="{{ route('admin.categories.products', $category) }}">
                    <span class="admin-category-icon"><i class="{{ $icon }}"></i></span>
                    <span class="admin-category-label">{{ $category->name }}</span>
                    <small class="text-muted">{{ $category->admin_products_count }} бараа</small>
                </a>
            @endforeach
        </div>
        @forelse ($categories as $category)
            @if ($category->products->isNotEmpty())
                <div class="admin-section-header">
                    @php($icon = $categoryIcons[$category->name] ?? 'bi bi-tags')
                    <h5 class="admin-section-title"><i class="{{ $icon }} me-2"></i>{{ $category->name }}</h5>
                    <span class="admin-result-count">{{ $category->products->count() }} бараа</span>
                </div>

                <div class="row g-4 mb-4">
                    @foreach ($category->products as $product)
                        <div class="col-md-4 col-lg-3">
                            <div class="admin-product-card">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <div class="d-flex align-items-center justify-content-center text-muted"
                                        style="height: 190px;">
                                        Зураг байхгүй
                                    </div>
                                @endif
                                <div class="admin-product-body">
                                    <div class="admin-product-name">{{ $product->name }}</div>
                                    <div class="admin-product-price">₮ {{ number_format($product->price) }}</div>
                                    <p class="text-muted small mb-3">
                                        {{ $product->description ? Str::limit($product->description, 70) : 'Тайлбар байхгүй' }}
                                    </p>
                                    <div class="admin-product-actions">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                            class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-pencil-square me-1"></i>Засах
                                        </a>
                                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                            onsubmit="return confirm('Энэ барааг устгах уу?')" class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="bi bi-trash me-1"></i>Устгах
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @empty
            <div class="admin-empty-state">
                <i class="bi bi-inbox" style="font-size: 2.5rem;"></i>
                <h5 class="mt-3">Бараа байхгүй байна</h5>
                <p class="text-muted">Эхний бараагаа нэмээд ангиллаар нь удирдаарай.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary mt-2">Бараа нэмэх</a>
            </div>
        @endforelse

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">📦 Бүтээгдэхүүн</h5>
                        <p class="card-text">Каталог, зураг, тайлбар, төрөлүүдийг нэг газраас удирд.</p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm mt-2">Жагсаалт
                            руу очих</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">👥 Хэрэглэгч</h5>
                        <p class="card-text">Хэрэглэгчдийн идэвх, захиалгын мэдээллийг real-time хар.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm mt-2">Самбар руу
                            очих</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">📊 Тайлан</h5>
                        <p class="card-text">Борлуулалт, төлбөрийн статистикаа тайлангийн хэсгээр нэг дор хараарай.</p>
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-light btn-sm mt-2">Тайлан руу
                            очих</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

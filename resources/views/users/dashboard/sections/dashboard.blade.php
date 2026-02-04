@push('styles')
    <style>
        /* Category Strip */
        .category-strip {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .category-item {
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
        }

        .category-item:hover {
            transform: translateY(-3px);
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.2);
            color: #fff;
        }

        .category-item.active {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.22), rgba(139, 92, 246, 0.2));
            border-color: rgba(99, 102, 241, 0.6);
            color: #fff;
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.3);
        }

        .category-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: rgba(99, 102, 241, 0.15);
            color: #a5b4fc;
            font-size: 1.4rem;
        }

        .category-item.active .category-icon {
            background: rgba(99, 102, 241, 0.3);
            color: #fff;
        }

        .category-label {
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.2;
        }

        /* Search Bar */
        .dashboard-search-form {
            position: relative;
            max-width: 600px;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .dashboard-search-form input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: #e5e7eb;
            padding: 12px 50px 12px 20px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .dashboard-search-form input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dashboard-search-form input::placeholder {
            color: #9ca3af;
        }

        .dashboard-search-form button {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .dashboard-search-form button:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-50%) scale(1.05);
        }

        /* Section Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .section-title {
            color: #e5e7eb;
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
        }

        .result-count {
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        /* Product Card */
        .product-card {
            background: rgba(15, 23, 42, 0.85);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 16px 50px rgba(59, 130, 246, 0.4);
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover img {
            transform: scale(1.1);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 0%, rgba(0, 0, 0, 0.7) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-body {
            padding: 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            color: #e5e7eb;
            font-weight: 700;
            font-size: 1rem;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .product-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 6px;
        }

        .product-description {
            color: #9ca3af;
            font-size: 0.85rem;
            margin-bottom: 8px;
            line-height: 1.4;
            flex: 1;
        }

        .product-category {
            position: absolute;
            top: 14px;
            right: 14px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(8px);
            color: #fbbf24;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
            border: 1px solid rgba(251, 191, 36, 0.45);
            z-index: 5;
        }

        .product-meta-info {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
            flex-wrap: wrap;
        }

        .product-stock {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid rgba(34, 197, 94, 0.3);
            transition: all 0.3s ease;
        }

        .product-stock.low-stock {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            border-color: rgba(251, 191, 36, 0.3);
            animation: pulse 2s infinite;
        }

        .product-stock.out-of-stock {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.3);
        }

        .product-size {
            background: rgba(139, 92, 246, 0.15);
            color: #a78bfa;
            padding: 6px 14px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(139, 92, 246, 0.3);
        }

        .out-of-stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .product-card.out-of-stock .out-of-stock-overlay {
            opacity: 1;
        }

        .out-of-stock-badge {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 16px 32px;
            border-radius: 16px;
            font-size: 1.2rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            box-shadow: 0 10px 40px rgba(239, 68, 68, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.2);
            animation: fadeInScale 0.5s ease;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .add-cart-btn {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            border: none;
            border-radius: 14px;
            padding: 12px 20px;
            color: #fff;
            width: 100%;
            font-weight: 700;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
        }

        .add-cart-btn:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.5);
        }

        .product-actions {
            position: relative;
            z-index: 2;
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
            font-size: 4rem;
        }

        .empty-state h5 {
            color: #9ca3af;
            margin-top: 20px;
        }

        .empty-state .btn {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            padding: 12px 28px;
            border-radius: 14px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
@endpush

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

<!-- Categories -->
<div class="category-strip">
    <a class="category-item {{ empty($data['selectedCategory']) ? 'active' : '' }}" href="{{ route('users.dashboard') }}">
        <span class="category-icon"><i class="bi bi-grid-3x3-gap"></i></span>
        <span class="category-label">Бүгд</span>
        <small class="text-muted">{{ $data['totalProducts'] ?? 0 }} бараа</small>
    </a>
    @foreach ($data['allCategories'] as $category)
        @php($icon = $categoryIcons[$category->name] ?? 'bi bi-tags')
        <a class="category-item {{ $data['selectedCategory']?->id === $category->id ? 'active' : '' }}"
            href="{{ route('users.dashboard', ['category' => $category->id]) }}">
            <span class="category-icon"><i class="{{ $icon }}"></i></span>
            <span class="category-label">{{ $category->name }}</span>
            <small class="text-muted">{{ $category->products_count ?? 0 }} бараа</small>
        </a>
    @endforeach
</div>

<!-- Products by Category -->
@forelse ($data['categories'] as $category)
    @if ($category->products->isNotEmpty())
        <!-- Category Section Header -->
        <div class="section-header">
            @php($icon = $categoryIcons[$category->name] ?? 'bi bi-tags')
            <h5 class="section-title">
                <i class="{{ $icon }} me-2"></i>{{ $category->name }}
            </h5>
            <span class="result-count">{{ $category->products->count() }} бараа</span>
        </div>

        <!-- Products Grid -->
        <div class="row g-4 mb-5">
            @foreach ($category->products as $product)
                <div class="col-md-4 col-lg-3">
                    <div class="product-card {{ $product->quantity <= 0 ? 'out-of-stock' : '' }}">
                        <div class="product-img-wrapper">
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x220' }}"
                                alt="{{ $product->name }}">
                            <div class="product-overlay"></div>
                            @if ($product->category)
                                <span class="product-category">
                                    {{ $product->category->name }}
                                </span>
                            @endif
                            @if ($product->quantity <= 0)
                                <div class="out-of-stock-overlay">
                                    <div class="out-of-stock-badge">
                                        <i class="bi bi-x-circle me-2"></i>ДУУССАН
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="product-body">
                            <h5 class="product-name">{{ $product->name }}</h5>
                            <div class="product-price">{{ number_format($product->price) }}₮</div>

                            <div class="product-meta-info">
                                @if ($product->quantity > 0)
                                    <span class="product-stock {{ $product->quantity <= 5 ? 'low-stock' : '' }}">
                                        <i class="bi bi-box-seam"></i>
                                        {{ $product->quantity }} ширхэг
                                    </span>
                                @else
                                    <span class="product-stock out-of-stock">
                                        <i class="bi bi-x-circle"></i>
                                        Дууссан
                                    </span>
                                @endif
                                @if ($product->size)
                                    <span class="product-size">
                                        <i class="bi bi-rulers"></i>
                                        {{ $product->size }}
                                    </span>
                                @endif
                            </div>

                            <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            <a href="{{ route('products.show', $product) }}" class="stretched-link"
                                aria-label="{{ $product->name }}"></a>
                            <div class="product-actions">
                                <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                    @csrf
                                    <button type="submit" class="add-cart-btn"
                                        {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                        @if ($product->quantity <= 0)
                                            <i class="bi bi-x-circle me-2"></i>Дууссан
                                        @else
                                            <i class="bi bi-cart-plus me-2"></i>Сагсанд нэмэх
                                        @endif
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
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h5>Бараа олдсонгүй</h5>
        <p class="text-muted">Одоогоор бараа байхгүй байна</p>
        <a href="{{ route('users.dashboard') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-2"></i>Буцах
        </a>
    </div>
@endforelse

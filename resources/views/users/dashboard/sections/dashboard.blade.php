@push('styles')
    <style>
        /* Dashboard Header */
        .dashboard-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(147, 51, 234, 0.25));
            border-radius: 22px;
            padding: 28px;
            margin-bottom: 30px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.5);
        }

        .dashboard-header h3 {
            color: #e5e7eb;
            font-weight: 700;
            margin: 0 0 8px 0;
        }

        /* Search Bar */
        .dashboard-search {
            position: relative;
            max-width: 600px;
            margin-top: 20px;
        }

        .dashboard-search input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            color: #e5e7eb;
            padding: 12px 50px 12px 20px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .dashboard-search input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.5);
            outline: none;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .dashboard-search input::placeholder {
            color: #9ca3af;
        }

        .dashboard-search button {
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

        .dashboard-search button:hover {
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
        }

        .product-card:hover {
            transform: translateY(-8px);
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 16px 50px rgba(59, 130, 246, 0.4);
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            height: 220px;
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
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-name {
            color: #e5e7eb;
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            color: #34d399;
            font-weight: 700;
            font-size: 1.4rem;
            margin-bottom: 12px;
        }

        .product-description {
            color: #9ca3af;
            font-size: 0.9rem;
            margin-bottom: 16px;
            line-height: 1.5;
            flex: 1;
        }

        .product-category {
            background: rgba(251, 191, 36, 0.15);
            color: #fbbf24;
            padding: 4px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            display: inline-block;
            margin-bottom: 12px;
            border: 1px solid rgba(251, 191, 36, 0.3);
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

<!-- Dashboard Header -->
<div class="dashboard-header">
    <h3>
        <i class="bi bi-grid-1x2 me-2"></i>
        👋 Сайн байна уу, {{ Auth::guard('web')->user()->name ?? 'User' }}
    </h3>

    <!-- Search Bar -->
    <div class="dashboard-search">
        <form action="{{ route('users.dashboard') }}" method="GET" id="dashboardSearchForm">
            <input type="text" name="q" value="{{ $data['searchQuery'] ?? '' }}" placeholder="🔍 Бараа хайх..."
                autocomplete="off">
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Section Header -->
<div class="section-header">
    @if ($data['isSearching'])
        <h5 class="section-title">
            <i class="bi bi-search me-2"></i>Хайлтын үр дүн: "{{ $data['searchQuery'] }}"
        </h5>
        <span class="result-count">{{ $data['products']->count() }} бараа олдсон</span>
    @else
        <h5 class="section-title">
            <i class="bi bi-stars me-2"></i>Шинэ бүтээгдэхүүн
        </h5>
        <span class="result-count">{{ $data['products']->count() }} бараа</span>
    @endif
</div>

<!-- Products Grid -->
@if ($data['products']->isEmpty())
    <div class="empty-state">
        <i class="bi bi-search"></i>
        <h5>"{{ $data['searchQuery'] }}" гэсэн хайлтаар бараа олдсонгүй</h5>
        <p class="text-muted">Өөр түлхүүр үгээр дахин оролдоно уу</p>
        <a href="{{ route('users.dashboard') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-2"></i>Буцах
        </a>
    </div>
@else
    <div class="row g-4">
        @foreach ($data['products']->take(12) as $product)
            <div class="col-lg-4 col-md-6">
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x220' }}"
                            alt="{{ $product->name }}">
                        <div class="product-overlay"></div>
                    </div>
                    <div class="product-body">
                        @if ($product->category)
                            <span class="product-category">
                                <i class="bi bi-tag-fill me-1"></i>{{ $product->category->name }}
                            </span>
                        @endif
                        <h5 class="product-name">{{ $product->name }}</h5>
                        <div class="product-price">{{ number_format($product->price) }}₮</div>
                        <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <button type="submit" class="add-cart-btn">
                                <i class="bi bi-cart-plus me-2"></i>Сагсанд нэмэх
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

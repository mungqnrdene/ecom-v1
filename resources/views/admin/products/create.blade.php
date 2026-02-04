@extends('layouts.admin')

@section('title', 'Шинэ барау - Light Shop')

@push('styles')
    <style>
        .product-create-card .form-label {
            color: #e2e8f0;
            margin-bottom: 0.75rem;
            font-size: 1rem;
        }

        .product-create-card .form-control,
        .product-create-card .form-select {
            background-color: #1e2028;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            transition: all 0.3s ease;
        }

        .product-create-card .form-control:focus,
        .product-create-card .form-select:focus {
            background-color: #252936;
            border-color: #4299e1;
            box-shadow: 0 0 0 0.2rem rgba(66, 153, 225, 0.25);
            color: #fff;
        }

        .product-create-card .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .product-create-card .input-group-text {
            color: #a0aec0;
            font-weight: 600;
        }

        .product-create-card textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }

        .product-create-card .form-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .btn-success {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(72, 187, 120, 0.4);
        }

        .btn-secondary {
            background-color: #4a5568;
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #2d3748;
            transform: translateY(-2px);
        }

        .bi {
            font-size: 1.1rem;
        }
    </style>
@endpush

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Create product</span>
                <h1 class="admin-page-title">➕ Шинэ бараа нэмэх</h1>
                <p class="admin-page-subtitle">Бүтээгдэхүүний үндсэн мэдээллийг бөглөөд, зургийг нь хавсаргана уу.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light admin-cta-btn">← Жагсаалт руу
                буцах</a>
        </div>

        <div class="card product-create-card">
            <div class="card-body p-4">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
                    class="row g-4">
                    @csrf

                    {{-- Product Name --}}
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">
                            <i class="bi bi-tag-fill text-primary me-2"></i>Бүтээгдэхүүний нэр *
                        </label>
                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}" placeholder="Жишээ: iPhone 15 Pro Max"
                            required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Price --}}
                    <div class="col-md-6">
                        <label for="price" class="form-label fw-semibold">
                            <i class="bi bi-currency-exchange text-success me-2"></i>Үнэ (₮) *
                        </label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-dark border-secondary">₮</span>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                                id="price" name="price" value="{{ old('price') }}" placeholder="0.00" required>
                        </div>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Quantity --}}
                    <div class="col-md-3">
                        <label for="quantity" class="form-label fw-semibold">
                            <i class="bi bi-box-seam text-info me-2"></i>Тоо ширхэг *
                        </label>
                        <input type="number" min="0"
                            class="form-control form-control-lg @error('quantity') is-invalid @enderror" id="quantity"
                            name="quantity" value="{{ old('quantity', 0) }}" placeholder="0" required>
                        @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Size --}}
                    <div class="col-md-3">
                        <label for="size" class="form-label fw-semibold">
                            <i class="bi bi-aspect-ratio text-warning me-2"></i>Size / Хэмжээ
                        </label>
                        <input type="text" class="form-control form-control-lg @error('size') is-invalid @enderror"
                            id="size" name="size" value="{{ old('size') }}" placeholder="Жишээ: S, M, L, 128GB"
                            list="sizeOptions">
                        <datalist id="sizeOptions"></datalist>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-semibold">
                            <i class="bi bi-bookmarks-fill text-warning me-2"></i>Категори *
                        </label>
                        <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id" required>
                            <option value="">-- Категори сонгоно уу --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold">
                            <i class="bi bi-image-fill text-info me-2"></i>Зураг
                        </label>
                        <input type="file" class="form-control form-control-lg @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/*">
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>JPG, PNG, GIF форматтай. Максимум хэмжээ: 2MB
                        </div>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">
                            <i class="bi bi-card-text text-secondary me-2"></i>Дэлгэрэнгүй тайлбар
                        </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="5" placeholder="Бүтээгдэхүүний онцлог, давуу тал, техник үзүүлэлтүүдийг энд бичнэ үү...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Keywords --}}
                    <div class="col-12">
                        <label for="keywords" class="form-label fw-semibold">
                            <i class="bi bi-key-fill text-danger me-2"></i>Түлхүүр үгс (Keywords)
                        </label>
                        <input type="text" class="form-control form-control-lg @error('keywords') is-invalid @enderror"
                            id="keywords" name="keywords" value="{{ old('keywords') }}"
                            placeholder="Жишээ: утас, phone, mobile, smartphone, гар утас, apple">
                        <div class="form-text">
                            <i class="bi bi-lightbulb me-1"></i>Хайлтыг сайжруулах түлхүүр үгсийг
                            <strong>таслалаар</strong>
                            тусгаарлан оруулна уу
                        </div>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="col-12 d-flex gap-3 mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5">
                            <i class="bi bi-check-circle me-2"></i>Бүтээгдэхүүн нэмэх
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg px-4">
                            <i class="bi bi-arrow-left me-2"></i>Буцах
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            (function() {
                const categorySelect = document.getElementById('category_id');
                const keywordsInput = document.getElementById('keywords');
                const sizeInput = document.getElementById('size');
                const sizeOptions = document.getElementById('sizeOptions');

                if (!categorySelect || !keywordsInput || !sizeInput || !sizeOptions) return;

                const sizePresets = {
                    techPhone: ['64GB', '128GB', '256GB', '512GB'],
                    techLaptop: ['256GB SSD', '512GB SSD', '1TB SSD', '2TB SSD'],
                    techTablet: ['64GB', '128GB', '256GB'],
                    clothing: ['XS', 'S', 'M', 'L', 'XL', 'XXL'],
                    shoes: ['36', '37', '38', '39', '40', '41', '42', '43', '44'],
                };

                const keywordMatchers = {
                    phone: ['утас', 'phone', 'smartphone', 'iphone', 'android'],
                    laptop: ['laptop', 'notebook', 'зөөврийн', 'компьютер'],
                    tablet: ['tablet', 'ipad', 'планшет'],
                };

                function setOptions(options) {
                    sizeOptions.innerHTML = '';
                    options.forEach(option => {
                        const opt = document.createElement('option');
                        opt.value = option;
                        sizeOptions.appendChild(opt);
                    });
                }

                function getSelectedCategoryName() {
                    const selected = categorySelect.options[categorySelect.selectedIndex];
                    return selected ? selected.text.trim().toLowerCase() : '';
                }

                function matchKeyword(input, keywords) {
                    return keywords.some(keyword => input.includes(keyword));
                }

                function updateSizeSuggestions() {
                    const categoryName = getSelectedCategoryName();
                    const keywords = (keywordsInput.value || '').toLowerCase();

                    if (categoryName.includes('технологи')) {
                        if (matchKeyword(keywords, keywordMatchers.phone)) {
                            setOptions(sizePresets.techPhone);
                            sizeInput.placeholder = 'Жишээ: 128GB';
                            return;
                        }
                        if (matchKeyword(keywords, keywordMatchers.laptop)) {
                            setOptions(sizePresets.techLaptop);
                            sizeInput.placeholder = 'Жишээ: 512GB SSD';
                            return;
                        }
                        if (matchKeyword(keywords, keywordMatchers.tablet)) {
                            setOptions(sizePresets.techTablet);
                            sizeInput.placeholder = 'Жишээ: 128GB';
                            return;
                        }

                        setOptions(sizePresets.techPhone);
                        sizeInput.placeholder = 'Жишээ: 128GB';
                        return;
                    }

                    if (categoryName.includes('эрэгтэй') || categoryName.includes('эмэгтэй') || categoryName.includes(
                            'хүүхдийн')) {
                        setOptions(sizePresets.clothing);
                        sizeInput.placeholder = 'Жишээ: M';
                        return;
                    }

                    if (categoryName.includes('гутал')) {
                        setOptions(sizePresets.shoes);
                        sizeInput.placeholder = 'Жишээ: 39';
                        return;
                    }

                    setOptions([]);
                    sizeInput.placeholder = 'Жишээ: S, M, L, 128GB';
                }

                categorySelect.addEventListener('change', updateSizeSuggestions);
                keywordsInput.addEventListener('input', updateSizeSuggestions);

                updateSizeSuggestions();
            })();
        </script>
    @endpush


@endsection

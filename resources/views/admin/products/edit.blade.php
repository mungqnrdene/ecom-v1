@extends('layouts.app')

@section('title', 'Барау засах - Light Shop')

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Update product</span>
                <h1 class="admin-page-title">✏️ Бараа засварлах</h1>
                <p class="admin-page-subtitle">{{ $product->name }} бүтээгдэхүүний мэдээллийг шинэчилнэ үү.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light admin-cta-btn">← Жагсаалт руу
                буцах</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="row g-4"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-md-6">
                        <label for="name" class="form-label">Нэр *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="price" class="form-label">Үнэ (₮) *</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror"
                            id="price" name="price" value="{{ old('price', $product->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Категори *</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                            name="category_id" required>
                            <option value="">-- Сонгоно уу --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label">Зураг</label>
                        @if ($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    style="max-width: 200px; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" accept="image/*">
                        <small class="text-muted">JPG, PNG, GIF (max 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Тайлбар</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                            rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="keywords" class="form-label">Түлхүүр үгс (Keywords)</label>
                        <input type="text" class="form-control @error('keywords') is-invalid @enderror" id="keywords"
                            name="keywords" value="{{ old('keywords', $product->keywords) }}"
                            placeholder="Жишээ: утас, phone, mobile, smartphone, гар утас">
                        <small class="text-muted">Хайлтыг сайжруулах түлхүүр үгсийг таслалаар тусгаарлан оруулна уу</small>
                        @error('keywords')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-warning">✅ Өөрчлөх</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Буцах</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

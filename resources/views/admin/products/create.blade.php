@extends('layouts.app')

@section('title', 'Шинэ барау - Light Shop')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">➕ Шинэ бараа нэмэх</h1>

        <form action="{{ route('admin.products.store') }}" method="POST" class="bg-dark p-4 rounded-3"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Нэр *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Зураг</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                    name="image" accept="image/*">
                <small class="text-muted">JPG, PNG, GIF (max 2MB)</small>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Категори *</label>
                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id"
                    required>
                    <option value="">-- Сонгоно уу --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Үнэ (₮) *</label>
                <input type="number" step="0." class="form-control @error('price') is-invalid @enderror"
                    id="price" name="price" value="{{ old('price') }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Тайлбар</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="3">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success btn-lg">✅ Нэмэх</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">⬅️ Буцах</a>
        </form>
    </div>
@endsection

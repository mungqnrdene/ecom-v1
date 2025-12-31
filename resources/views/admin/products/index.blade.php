@extends('layouts.app')

@section('title', 'Бараа управлах - Light Shop')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>📦 Бараанууд</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Шинэ бараа нэмэх</a>
        </div>

        @if ($products->isEmpty())
            <div class="alert alert-info">
                Бараа байхгүй байна. <a href="{{ route('admin.products.create') }}">Шинэ барау нэмнэ үү</a>
            </div>
        @else
            <div class="row g-4 mt-2">
            @forelse($products as $product)
                <div class="col-md-4">
                    <div class="product-card">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/400x250?text={{ urlencode($product->name) }}"
                                alt="{{ $product->name }}">
                        @endif
                        <div class="product-body">
                            <h5>{{ $product->name }}</h5>
                            <p>💰 {{ number_format($product->price) }}₮</p>
                            <p>{{ $product->description }}</p>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary">✏️
                                    Засах</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Устгахдаа итгэлтэй байна уу?')">🗑️ Устгах</button>
                                </form>
                            </td>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted">Бараа олдсонгүй</p>
                </div>
            @endforelse
        </div>
        @endif
    </div>
@endsection

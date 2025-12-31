@extends('layouts.user')

@section('title', 'Хадгалсан - Light Shop')

@section('page')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h3 class="mb-0">❤️ Миний хадгалсан</h3>
        <a href="{{ route('products') }}" class="btn btn-sm btn-outline-light">Бараа үзэх</a>
    </div>

    <div class="alert alert-info">
        📌 Хадгалсан бараа байхгүй байна.
    </div>
@endsection

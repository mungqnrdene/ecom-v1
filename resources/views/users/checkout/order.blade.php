@extends('layouts.user')
@section('title', 'Захиалга')

@section('page')

    <h3 class="mb-3">📦 Захиалга баталгаажуулах</h3>

    <ul class="list-group mb-3">
        @foreach ($cart as $item)
            <li class="list-group-item d-flex align-items-center justify-content-between gap-3">

                <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}"
                    style="width:60px; height:60px; object-fit:cover; border-radius:8px;">

                <div class="flex-grow-1">
                    <strong>{{ $item['name'] }}</strong><br>
                    {{ $item['qty'] }} × {{ number_format($item['price']) }} ₮
                </div>

                <span class="fw-bold">
                    {{ number_format($item['qty'] * $item['price']) }} ₮
                </span>

            </li>
        @endforeach
    </ul>

    <form method="POST" action="{{ route('order.store') }}">
        @csrf
        <button class="btn btn-success w-100">
            Захиалга үүсгэх
        </button>
    </form>

@endsection

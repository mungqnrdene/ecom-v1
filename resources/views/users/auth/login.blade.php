@extends('layouts.app')

@section('title', 'Нэвтрэх')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card bg-dark text-light">
                <div class="card-body p-4">
                    <h3 class="text-center mb-4">Нэвтрэх</h3>

                    <form method="POST" action="{{ route('users.login.submit') }}">
                        @csrf

                        <div class="mb-3">
                            <label>Имэйл</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Нууц үг</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button class="btn btn-primary w-100">Нэвтрэх</button>
                    </form>

                    <p class="text-center mt-3">
                        Бүртгэлгүй юу?
                        <a href="{{ route('users.register') }}">Бүртгүүлэх</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
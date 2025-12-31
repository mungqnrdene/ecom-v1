@extends('layouts.app')

@section('title', 'Бүртгүүлэх - Light Shop')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card bg-dark border-light">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4">✨ Бүртгүүлэх</h2>

                        <form method="POST" action="{{ route('users.register.submit') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Нэр</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Имэйл</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Нууц үг</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Нууц үг баталгаажуулах</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">Бүртгүүлэх</button>
                        </form>

                        <hr class="bg-light">

                        <p class="text-center mb-0">
                            Аль хэдийн бүртгүүлсэн үү?
                            <a href="{{ route('users.login') }}" class="text-info">Нэвтрэх</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

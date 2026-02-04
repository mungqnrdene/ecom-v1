@extends('layouts.app')

@section('title', 'OTP код баталгаажуулах')

@push('styles')
    <style>
        .otp-input {
            width: 100%;
            padding: 16px;
            font-size: 1.4rem;
            text-align: center;
            letter-spacing: 0.3em;
            border-radius: 16px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #f8fafc;
        }

        .otp-input:focus {
            outline: none;
            border-color: rgba(34, 197, 94, 0.6);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
        }

        .otp-input.is-invalid {
            border-color: rgba(248, 113, 113, 0.6);
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 24px;
        }

        .ghost-btn,
        .link-btn {
            width: 100%;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.15);
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            transition: border-color 0.3s ease, color 0.3s ease;
        }

        .ghost-btn:hover,
        .link-btn:hover {
            border-color: rgba(148, 163, 184, 0.6);
            color: #e2e8f0;
        }

        .link-btn {
            background: none;
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-card">
                <h1 class="auth-title">OTP кодыг баталгаажуулна уу</h1>
                <p class="auth-subtitle">
                    {{ $channel === 'email' ? 'Имэйл' : 'SMS' }} рүү илгээсэн кодыг оруулна уу.
                    Код {{ $expiresIn }} минутын дотор хүчинтэй.
                </p>

                @if (!empty($status))
                    <div class="auth-alert">{{ $status }}</div>
                @endif

                @error('channel')
                    <div class="auth-alert auth-alert-error">{{ $message }}</div>
                @enderror

                <div class="auth-alert" style="border-color: rgba(248, 250, 252, 0.2); color: #e2e8f0;">
                    Код илгээгдсэн: <strong>{{ $identifier }}</strong>
                </div>

                <form method="POST" action="{{ route('users.register.otp.verify') }}">
                    @csrf
                    <label for="code" class="auth-label">6 оронтой код</label>
                    <input type="text" maxlength="6" inputmode="numeric" pattern="[0-9]*"
                        class="otp-input @error('code') is-invalid @enderror" name="code" id="code"
                        placeholder="000000" required autofocus>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="actions">
                        <button type="submit" class="auth-btn">Баталгаажуулах</button>
                    </div>
                </form>

                <div class="actions">
                    <form method="POST" action="{{ route('users.register.otp.resend') }}">
                        @csrf
                        <button type="submit" class="ghost-btn">OTP дахин илгээх</button>
                    </form>
                    <a href="{{ route('users.register.otp.channel') }}" class="link-btn"
                        style="text-align: center; display: inline-block;">
                        Сувгаа өөрчлөх
                    </a>
                    <a href="{{ route('users.register') }}" class="link-btn"
                        style="text-align: center; display: inline-block;">
                        Бүртгэлийн мэдээллээ засах
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

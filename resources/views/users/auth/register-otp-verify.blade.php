@extends('layouts.app')

@section('title', 'OTP код баталгаажуулах')

@push('styles')
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: radial-gradient(circle at top, rgba(59, 130, 246, 0.25), rgba(15, 23, 42, 0.95));
        }

        .auth-container {
            width: 100%;
            max-width: 500px;
        }

        .auth-card {
            background: rgba(15, 23, 42, 0.92);
            border-radius: 24px;
            padding: clamp(24px, 5vw, 40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.5);
        }

        .auth-title {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 700;
            color: #f8fafc;
            margin-bottom: 12px;
            text-align: center;
        }

        .auth-subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }

        .auth-alert {
            display: block;
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            border: 1px solid rgba(59, 130, 246, 0.4);
            background: rgba(59, 130, 246, 0.1);
            color: #bfdbfe;
        }

        .auth-alert.auth-alert-error {
            border-color: rgba(248, 113, 113, 0.4);
            background: rgba(248, 113, 113, 0.1);
            color: #fecaca;
        }

        .auth-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #cbd5e1;
        }

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

        .invalid-feedback {
            display: block;
            margin-top: 10px;
            font-size: 0.85rem;
            color: #fca5a5;
        }

        .actions {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 24px;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 12px 30px rgba(34, 197, 94, 0.35);
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 45px rgba(34, 197, 94, 0.5);
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

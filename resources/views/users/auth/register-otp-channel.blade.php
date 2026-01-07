@extends('layouts.app')

@section('title', 'Баталгаажуулах сувгаа сонгох')

@push('styles')
    <style>
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
        }

        .auth-container {
            width: 100%;
            max-width: 540px;
        }

        .auth-card {
            background: rgba(15, 23, 42, 0.9);
            border-radius: 24px;
            padding: clamp(24px, 5vw, 40px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.45);
        }

        .auth-title {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 700;
            text-align: center;
            margin-bottom: 12px;
            color: #f1f5f9;
        }

        .auth-subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .auth-alert {
            display: block;
            margin-bottom: 20px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.9rem;
            border: 1px solid rgba(34, 197, 94, 0.4);
            background: rgba(34, 197, 94, 0.1);
            color: #bbf7d0;
        }

        .auth-alert.auth-alert-error {
            border-color: rgba(248, 113, 113, 0.4);
            background: rgba(248, 113, 113, 0.1);
            color: #fecaca;
        }

        .channel-grid {
            display: grid;
            gap: 16px;
            margin-bottom: 8px;
        }

        .channel-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px;
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(15, 23, 42, 0.5);
            cursor: pointer;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .channel-card input[type="radio"] {
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid rgba(148, 163, 184, 0.8);
            display: grid;
            place-items: center;
            transition: border-color 0.3s ease, background 0.3s ease;
        }

        .channel-card input[type="radio"]::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: transparent;
            transition: background 0.3s ease;
        }

        .channel-card:hover {
            border-color: rgba(168, 85, 247, 0.5);
            background: rgba(76, 29, 149, 0.25);
        }

        .channel-card input[type="radio"]:checked {
            border-color: #a855f7;
            background: rgba(168, 85, 247, 0.15);
        }

        .channel-card input[type="radio"]:checked::after {
            background: #a855f7;
        }

        .channel-details {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .channel-label {
            font-size: 0.95rem;
            font-weight: 600;
            color: #f8fafc;
        }

        .channel-value {
            font-size: 0.9rem;
            color: #94a3b8;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            margin-top: 16px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #a855f7, #ec4899);
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 12px 30px rgba(168, 85, 247, 0.35);
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 40px rgba(168, 85, 247, 0.5);
        }

        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .auth-footer a {
            color: #c084fc;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    @php
        $defaultChannel = old('channel', array_key_first($channels));
    @endphp
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-card">
                <h1 class="auth-title">Баталгаажуулах сувгаа сонгоно уу</h1>
                <p class="auth-subtitle">
                    OTP кодыг илгээх сувгаа сонгож, {{ config('auth.otp_expiry_minutes') }} минутын дотор баталгаажуулна уу.
                    Мэдээллээ засах шаардлагатай бол бүртгэлийн хуудас руу буцах боломжтой.
                </p>

                @if (!empty($status))
                    <div class="auth-alert">{{ $status }}</div>
                @endif

                @error('channel')
                    <div class="auth-alert auth-alert-error">{{ $message }}</div>
                @enderror

                <form method="POST" action="{{ route('users.register.otp.send') }}">
                    @csrf
                    <div class="channel-grid">
                        @foreach ($channels as $channel => $value)
                            <label class="channel-card">
                                <input type="radio" name="channel" value="{{ $channel }}"
                                    @checked($defaultChannel === $channel)>

                                <div class="channel-details">
                                    <span class="channel-label">{{ $channel === 'email' ? 'Имэйл' : 'SMS / Утас' }}</span>
                                    <span class="channel-value">
                                        {{ $channel === 'email' ? $value : sprintf('+976 %s', trim(chunk_split($value, 4, ' '))) }}
                                    </span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <button type="submit" class="auth-btn">OTP илгээх</button>
                </form>

                <p class="auth-footer">
                    Мэдээллээ өөрчлөх хэрэгтэй байна уу?
                    <a href="{{ route('users.register') }}">Бүртгэлийн форм руу буцах</a>
                </p>
            </div>
        </div>
    </div>
@endsection

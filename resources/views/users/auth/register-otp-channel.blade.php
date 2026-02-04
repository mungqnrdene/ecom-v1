@extends('layouts.app')

@section('title', 'Баталгаажуулах сувгаа сонгох')

@push('styles')
    <style>
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

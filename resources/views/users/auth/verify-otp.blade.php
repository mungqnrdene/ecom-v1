@extends('layouts.app')

@section('title', 'OTP баталгаажуулах')

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
            max-width: 460px;
        }

        .auth-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: clamp(24px, 5vw, 40px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .auth-form-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 28px;
            color: #f1f5f9;
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

        .auth-input {
            width: 100%;
            padding: 14px 16px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 1.2rem;
            text-align: center;
            letter-spacing: 0.4rem;
        }

        .auth-input:focus {
            outline: none;
            border-color: rgba(14, 165, 233, 0.4);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .invalid-feedback {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: #fca5a5;
        }

        .success-message {
            display: block;
            margin-bottom: 20px;
            padding: 12px 16px;
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.3);
            border-radius: 12px;
            color: #7dd3fc;
            font-size: 0.9rem;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0ea5e9, #6366f1);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(99, 102, 241, 0.35);
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(99, 102, 241, 0.55);
        }

        .auth-footer {
            margin-top: 16px;
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .auth-footer a {
            color: #7dd3fc;
            font-weight: 600;
            text-decoration: none;
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-card">
                <h2 class="auth-form-title">OTP кодоо баталгаажуулна уу</h2>

                <p class="auth-footer" style="margin-bottom: 24px;">
                    Илгээгдсэн хаяг: <strong>{{ $identifier }}</strong>
                </p>

                @if (session('status'))
                    <div class="success-message">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('otp.verify') }}">
                    @csrf

                    <div class="auth-form-group">
                        <label for="code" class="auth-label">6 оронтой OTP код</label>
                        <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="6" name="code"
                            id="code" class="auth-input @error('code') is-invalid @enderror"
                            value="{{ old('code') }}" placeholder="000000" required>
                        @error('code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="auth-btn">OTP код баталгаажуулах</button>
                </form>

                <p class="auth-footer">
                    Код аваагүй юу?
                    <a href="{{ route('users.password.request') }}">Дахин илгээх</a>
                </p>
            </div>
        </div>
    </div>
@endsection

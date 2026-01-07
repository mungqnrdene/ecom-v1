@extends('layouts.app')

@section('title', 'Нэвтрэх - Light Shop')

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
            max-width: 480px;
        }

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-badge {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(147, 51, 234, 0.2));
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #60a5fa;
            margin-bottom: 16px;
        }

        .auth-title {
            font-size: clamp(1.75rem, 5vw, 2.5rem);
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 12px;
        }

        .auth-subtitle {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .auth-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: clamp(24px, 5vw, 48px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .auth-form-title {
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 28px;
            color: #f1f5f9;
        }

        .auth-form-group {
            margin-bottom: 20px;
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
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .auth-input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .auth-input.is-invalid {
            border-color: rgba(239, 68, 68, 0.5);
        }

        .auth-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .invalid-feedback {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: #fca5a5;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.5);
        }

        .auth-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 24px 0;
        }

        .auth-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        .auth-footer a {
            color: #60a5fa;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #93c5fd;
        }

        @media (max-width: 576px) {
            .auth-wrapper {
                padding: 16px;
            }

            .auth-header {
                margin-bottom: 24px;
            }

            .auth-card {
                padding: 24px;
            }

            .auth-form-title {
                font-size: 1.25rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-header">
                <span class="auth-badge">🔐 Secure zone</span>
                <h1 class="auth-title">Админ нэвтрэх</h1>
                <p class="auth-subtitle">Системийн удирдлагын хэсэгт нэвтрэхийн тулд бүртгэлтэй админ хаягаа ашиглана уу.</p>
            </div>

            <div class="auth-card">
                <h2 class="auth-form-title">Нэвтрэх мэдээллээ оруулна уу</h2>

                <form method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="auth-form-group">
                        <label for="email" class="auth-label">Имэйл</label>
                        <input type="email" class="auth-input @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Нууц үг</label>
                        <input type="password" class="auth-input @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="auth-btn">Нэвтрэх</button>
                </form>

                <div class="auth-divider"></div>

                <p class="auth-footer">
                    Хэрэглэгч болгон нэвтрэх үү?
                    <a href="{{ route('users.login') }}">Хэрэглэгчийн нэвтрэх хэсэг</a>
                </p>
            </div>
        </div>
    </div>
@endsection

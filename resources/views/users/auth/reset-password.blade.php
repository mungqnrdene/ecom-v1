@extends('layouts.app')

@section('title', 'Нууц үг сэргээх')

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

        .auth-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-badge {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.2), rgba(59, 130, 246, 0.2));
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #4ade80;
            margin-bottom: 16px;
        }

        .auth-title {
            font-size: clamp(1.75rem, 5vw, 2.5rem);
            font-weight: 700;
            background: linear-gradient(135deg, #4ade80, #60a5fa);
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

        .auth-form-group {
            margin-bottom: 20px;
        }

        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #cbd5e1;
            transition: color 0.3s ease;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
        }

        .password-toggle:hover {
            color: #4ade80;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
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
            border-color: rgba(34, 197, 94, 0.5);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
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

        .success-message {
            display: block;
            margin-bottom: 20px;
            padding: 12px 16px;
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 12px;
            color: #4ade80;
            font-size: 0.9rem;
        }

        .auth-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(34, 197, 94, 0.3);
        }

        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(34, 197, 94, 0.5);
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
                <span class="auth-badge">🔐 OTP баталгаажсан</span>
                <h1 class="auth-title">Шинэ нууц үг үүсгэх</h1>
                <p class="auth-subtitle">OTP баталгаажуулсан хаяг дээрээ шинэ нууц үгээ тохируулна уу.</p>
            </div>

            <div class="auth-card">
                <h2 class="auth-form-title">Шинэ нууц үгээ оруулна уу</h2>

                @if (session('status'))
                    <div class="success-message">{{ session('status') }}</div>
                @endif

                <form method="POST" action="{{ route('otp.reset') }}">
                    @csrf

                    <div class="auth-form-group">
                        <label for="identifier" class="auth-label">Баталгаажсан хаяг</label>
                        <input type="text" id="identifier" class="auth-input" value="{{ $identifier }}" readonly>
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Шинэ нууц үг</label>
                        <div class="password-wrapper">
                            <input type="password" name="password" id="password"
                                class="auth-input @error('password') is-invalid @enderror" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" data-target="password"
                                aria-label="Toggle password visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                                    <path data-eye-path
                                        d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <label for="password_confirmation" class="auth-label">Нууц үг баталгаажуулах</label>
                        <div class="password-wrapper">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="auth-input" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" data-target="password_confirmation"
                                aria-label="Toggle password visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                                    <path data-eye-path
                                        d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="auth-btn">Нууц үг солих</button>
                </form>
            </div>
        </div>
    </div>
    <script>
        (function() {
            const eyeVisiblePath =
                'M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z';
            const eyeSlashPath =
                'M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2 4.27l2.28 2.28.46.46C3.08 8.3 1.78 10.02 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l.42.42L19.73 22 21 20.73 3.27 3 2 4.27zM7.53 9.8l1.55 1.55c-.05.21-.08.43-.08.65 0 1.66 1.34 3 3 3 .22 0 .44-.03.65-.08l1.55 1.55c-.67.33-1.41.53-2.2.53-2.76 0-5-2.24-5-5 0-.79.2-1.53.53-2.2zm4.31-.78l3.15 3.15.02-.16c0-1.66-1.34-3-3-3l-.17.01z';

            document.querySelectorAll('.password-toggle').forEach((button) => {
                const target = document.getElementById(button.dataset.target);
                const path = button.querySelector('[data-eye-path]');

                if (!target || !path) {
                    return;
                }

                button.addEventListener('click', () => {
                    const isHidden = target.getAttribute('type') === 'password';
                    target.setAttribute('type', isHidden ? 'text' : 'password');
                    path.setAttribute('d', isHidden ? eyeSlashPath : eyeVisiblePath);
                });
            });
        })();
    </script>
@endsection

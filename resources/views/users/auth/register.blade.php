@extends('layouts.app')

@section('title', 'Бүртгүүлэх - Light Shop')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-container">
            <div class="auth-header">
                <span class="auth-badge">✨ Join us</span>
                <h1 class="auth-title">Бүртгүүлэх</h1>
                <p class="auth-subtitle">Light Shop-д тавтай морилно уу. Эндээс та хүссэн бараагаа хүргүүлж, таалагдсан
                    бараагаа тав тухтайгаар худалдан аваарай.</p>
            </div>

            <div class="auth-card">
                <h2 class="auth-form-title">Бүртгэлийн мэдээлэл</h2>
                <p style="text-align: center; color: #94a3b8; font-size: 0.9rem; margin-bottom: 24px;">
                    Имэйл эсвэл утасны дугаараа баталгаажуулсны дараа таны бүртгэл идэвхжинэ.
                </p>

                @if (session('register_error'))
                    <div class="auth-alert auth-alert-error">{{ session('register_error') }}</div>
                @endif

                <form method="POST" action="{{ route('users.register.submit') }}">
                    @csrf

                    <div class="auth-form-group">
                        <label for="name" class="auth-label">Нэр</label>
                        <input type="text" class="auth-input @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" placeholder="Таны нэр" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <label for="phone" class="auth-label">Утасны дугаар</label>
                        <input type="tel" class="auth-input @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}" placeholder="99123456">
                        {{-- <p class="field-hint">Имэйл эсвэл утасны дугаарын аль нэгийг заавал оруулна.</p> --}}
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <label for="email" class="auth-label">Имэйл </label>
                        <input type="email" class="auth-input @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" placeholder="example@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="auth-form-group">
                        <label for="password" class="auth-label">Нууц үг</label>
                        <div class="password-wrapper">
                            <input type="password" class="auth-input @error('password') is-invalid @enderror" id="password"
                                name="password" placeholder="••••••••" required>
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
                            <input type="password" class="auth-input" id="password_confirmation"
                                name="password_confirmation" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" data-target="password_confirmation"
                                aria-label="Toggle password visibility">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true">
                                    <path data-eye-path
                                        d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="auth-btn">Бүртгүүлэх</button>
                </form>

                <div class="auth-divider"></div>

                <p class="auth-footer">
                    Аль хэдийн бүртгүүлсэн үү?
                    <a href="{{ route('users.login') }}">Нэвтрэх</a>
                </p>
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

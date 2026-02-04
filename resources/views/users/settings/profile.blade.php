@extends('layouts.user')

@section('title', 'Тохиргоо - Light Shop')

@push('styles')
    <style>
        .settings-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        .settings-header {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
            border-radius: 20px;
            padding: clamp(20px, 4vw, 32px);
            margin-bottom: 28px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .settings-title {
            font-size: clamp(1.5rem, 4vw, 2rem);
            font-weight: 700;
            background: linear-gradient(135deg, #60a5fa, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .settings-subtitle {
            color: #94a3b8;
            font-size: 0.95rem;
        }

        .user-code-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 12px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.12);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #cbd5e1;
            font-weight: 700;
            letter-spacing: 0.05em;
        }

        .settings-card {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: clamp(20px, 4vw, 32px);
            margin-bottom: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        .settings-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #f1f5f9;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .profile-upload-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 16px;
            padding: 24px;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 16px;
            border: 2px dashed rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .profile-upload-area:hover {
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(30, 41, 59, 0.7);
        }

        .profile-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(59, 130, 246, 0.3);
            box-shadow: 0 8px 24px rgba(59, 130, 246, 0.2);
        }

        .profile-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(147, 51, 234, 0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #60a5fa;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #cbd5e1;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .form-control.is-invalid {
            border-color: rgba(239, 68, 68, 0.5);
        }

        .invalid-feedback {
            display: block;
            margin-top: 6px;
            font-size: 0.85rem;
            color: #fca5a5;
        }

        .btn-save {
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

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.5);
        }

        .file-upload-btn {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-upload-btn input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-upload-btn label {
            display: inline-block;
            padding: 10px 20px;
            background: rgba(59, 130, 246, 0.2);
            border: 1px solid rgba(59, 130, 246, 0.4);
            border-radius: 8px;
            color: #60a5fa;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .file-upload-btn label:hover {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.6);
        }

        @media (max-width: 768px) {
            .settings-wrapper {
                padding: 0 12px;
            }

            .settings-card {
                padding: 20px;
            }

            .profile-preview,
            .profile-placeholder {
                width: 100px;
                height: 100px;
            }
        }
    </style>
@endpush

@section('page')
    <div class="settings-wrapper">
        <div class="settings-header">
            <h1 class="settings-title">⚙️ Тохиргоо</h1>
            <p class="settings-subtitle">Профайл болон хаягийн мэдээллээ засаж, хадгална уу.</p>
            <div class="mt-2">
                <span class="user-code-chip"><i class="bi bi-hash"></i> {{ Auth::user()->user_code }}</span>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('users.settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Profile Picture Section -->
            <div class="settings-card">
                <h2 class="settings-section-title">👤 Профайл зураг</h2>
                <div class="profile-upload-area">
                    @if (Auth::user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile"
                            class="profile-preview" id="profilePreview">
                    @else
                        <div class="profile-placeholder" id="profilePlaceholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="file-upload-btn">
                        <input type="file" name="profile_picture" id="profilePicture" accept="image/*"
                            onchange="previewImage(event)">
                        <label for="profilePicture">📷 Зураг сонгох</label>
                    </div>

                    <small class="text-muted">JPG, PNG, GIF зөвшөөрөгдөнө (Max: 2MB)</small>

                    @error('profile_picture')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Personal Information -->
            <div class="settings-card">
                <h2 class="settings-section-title">📋 Хувийн мэдээлэл</h2>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Нэр</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', Auth::user()->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Имэйл</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email', Auth::user()->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="phone" class="form-label">Утасны дугаар</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="99999999">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information -->
            <div class="settings-card">
                <h2 class="settings-section-title">🏠 Хаягийн мэдээлэл</h2>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="city" class="form-label">Хот/Аймаг</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                name="city" value="{{ old('city', Auth::user()->city) }}" placeholder="Улаанбаатар">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="district" class="form-label">Сум/Дүүрэг</label>
                            <input type="text" class="form-control @error('district') is-invalid @enderror"
                                id="district" name="district" value="{{ old('district', Auth::user()->district) }}"
                                placeholder="Сүхбаатар дүүрэг">
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="address" class="form-label">Байр/Гудамж</label>
                            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                                placeholder="Жишээ: 1-р хороо, Сүхбаатарын талбай">{{ old('address', Auth::user()->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="apartment_number" class="form-label">Тоот</label>
                            <input type="text" class="form-control @error('apartment_number') is-invalid @enderror"
                                id="apartment_number" name="apartment_number"
                                value="{{ old('apartment_number', Auth::user()->apartment_number) }}"
                                placeholder="Жишээ: 5-р байр, 23 тоот">
                            @error('apartment_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-save">💾 Хадгалах</button>
        </form>
    </div>

    @push('scripts')
        <script>
            function previewImage(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const placeholder = document.getElementById('profilePlaceholder');
                        let preview = document.getElementById('profilePreview');

                        if (!preview) {
                            preview = document.createElement('img');
                            preview.id = 'profilePreview';
                            preview.className = 'profile-preview';
                            placeholder.replaceWith(preview);
                        }

                        preview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>
    @endpush
@endsection

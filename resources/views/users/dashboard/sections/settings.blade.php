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

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #f1f5f9;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.5);
            background: rgba(30, 41, 59, 0.8);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        }

        .btn-save {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border: none;
            border-radius: 12px;
            color: #fff;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.5);
        }
    </style>
@endpush

<div class="settings-wrapper">
    <div class="settings-header">
        <h1 class="settings-title">⚙️ Тохиргоо</h1>
        <p class="text-muted">Профайл болон хаягийн мэдээллээ засаж, хадгална уу.</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('users.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="settings-card">
            <h2 class="settings-section-title">👤 Профайл зураг</h2>
            <div class="profile-upload-area">
                @if ($data['user']->profile_picture)
                    <img src="{{ asset('storage/' . $data['user']->profile_picture) }}" alt="Profile"
                        class="profile-preview" id="profilePreview">
                @else
                    <div class="profile-placeholder" id="profilePlaceholder">
                        {{ strtoupper(substr($data['user']->name, 0, 1)) }}
                    </div>
                @endif

                <div class="file-upload-btn">
                    <input type="file" name="profile_picture" id="profilePicture" accept="image/*"
                        class="form-control">
                </div>

                <small class="text-muted">JPG, PNG, GIF зөвшөөрөгдөнө (Max: 2MB)</small>
            </div>
        </div>

        <div class="settings-card">
            <h2 class="settings-section-title">📋 Хувийн мэдээлэл</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Нэр</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                            value="{{ old('name', $data['user']->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Имэйл</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', $data['user']->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Утасны дугаар</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone', $data['user']->phone) }}" placeholder="99999999">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="settings-card">
            <h2 class="settings-section-title">🏠 Хаягийн мэдээлэл</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Хот/Аймаг</label>
                        <input type="text" class="form-control" name="city"
                            value="{{ old('city', $data['user']->city) }}" placeholder="Улаанбаатар">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Сум/Дүүрэг</label>
                        <input type="text" class="form-control" name="district"
                            value="{{ old('district', $data['user']->district) }}" placeholder="Сүхбаатар дүүрэг">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Байр/Гудамж</label>
                        <textarea class="form-control" name="address" rows="3" placeholder="Жишээ: 1-р хороо, Сүхбаатарын талбай">{{ old('address', $data['user']->address) }}</textarea>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <label class="form-label">Тоот</label>
                        <input type="text" class="form-control" name="apartment_number"
                            value="{{ old('apartment_number', $data['user']->apartment_number) }}"
                            placeholder="Жишээ: 5-р байр, 23 тоот">
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-save">💾 Хадгалах</button>
    </form>
</div>

@push('styles')
    <style>
        .profile-wrapper {
            max-width: 1100px;
            margin: 0 auto;
        }

        .profile-hero {
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.12), rgba(139, 92, 246, 0.12));
            border: 1px solid rgba(147, 197, 253, 0.2);
            border-radius: 24px;
            padding: clamp(20px, 3vw, 28px);
            margin-bottom: 24px;
            display: flex;
            gap: 24px;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.08), transparent);
            border-radius: 50%;
            pointer-events: none;
        }

        .profile-hero::after {
            content: '👤';
            position: absolute;
            bottom: 10px;
            right: 20px;
            font-size: 6rem;
            opacity: 0.03;
            pointer-events: none;
        }

        .profile-avatar-lg {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(99, 102, 241, 0.4);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3), 0 0 0 6px rgba(99, 102, 241, 0.08);
            transition: all 0.3s ease;
        }

        .profile-hero:hover .profile-avatar-lg {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.4), 0 0 0 6px rgba(99, 102, 241, 0.12);
        }

        .profile-avatar-placeholder {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: grid;
            place-items: center;
            color: #fff;
            font-size: 2rem;
            font-weight: 700;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.3), 0 0 0 6px rgba(99, 102, 241, 0.08);
            transition: all 0.3s ease;
        }

        .profile-hero:hover .profile-avatar-placeholder {
            transform: scale(1.05);
        }

        .profile-meta {
            color: #cbd5e1;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .profile-name {
            font-size: clamp(1.4rem, 3vw, 1.8rem);
            font-weight: 800;
            margin: 0;
            color: #f8fafc;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .profile-card {
            background: rgba(15, 23, 42, 0.92);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 20px;
            padding: clamp(20px, 3vw, 32px);
            margin-bottom: 20px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(12px);
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 55px rgba(0, 0, 0, 0.5);
            border-color: rgba(255, 255, 255, 0.18);
        }

        .profile-card h5 {
            color: #f1f5f9;
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(59, 130, 246, 0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-card h5::before {
            content: '';
            width: 4px;
            height: 20px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 2px;
        }

        .profile-info-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        .profile-info-item {
            padding: 14px 16px;
            border-radius: 14px;
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .profile-info-item:hover {
            background: rgba(30, 41, 59, 0.9);
            border-color: rgba(59, 130, 246, 0.3);
            transform: translateX(4px);
        }

        .profile-info-label {
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            color: #94a3b8;
            margin-bottom: 6px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .profile-info-value {
            color: #f1f5f9;
            font-weight: 600;
            font-size: 1rem;
        }

        .profile-id-display {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #94a3b8;
            font-size: 0.95rem;
            background: rgba(30, 41, 59, 0.4);
            padding: 8px 14px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .profile-id-number {
            color: #e2e8f0;
            font-weight: 700;
            letter-spacing: 0.08em;
            font-size: 1rem;
        }

        .profile-copy-icon {
            color: #6366f1;
            cursor: pointer;
            transition: all 0.25s ease;
            padding: 7px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(99, 102, 241, 0.15);
            border: 1.5px solid rgba(99, 102, 241, 0.35);
            position: relative;
            line-height: 0;
        }

        .profile-copy-icon svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
        }

        .profile-copy-icon::after {
            content: 'Хуулах';
            position: absolute;
            bottom: -28px;
            left: 50%;
            transform: translateX(-50%) scale(0);
            background: rgba(15, 23, 42, 0.95);
            color: #e2e8f0;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.75rem;
            line-height: 1.2;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            transition: all 0.2s ease;
            border: 1px solid rgba(99, 102, 241, 0.3);
            font-weight: 600;
        }

        .profile-copy-icon:hover::after {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }

        .profile-copy-icon:hover {
            color: #fff;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-color: rgba(99, 102, 241, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
        }

        .profile-copy-icon:active {
            transform: scale(0.95);
        }

        .profile-id-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 12px;
            background: rgba(59, 130, 246, 0.18);
            border: 1px solid rgba(59, 130, 246, 0.4);
            color: #60a5fa;
            font-weight: 700;
            letter-spacing: 0.08em;
            font-size: 0.95rem;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .profile-id-badge:hover {
            background: rgba(59, 130, 246, 0.25);
            border-color: rgba(59, 130, 246, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(59, 130, 246, 0.35);
        }

        .profile-id-badge:active {
            transform: translateY(0);
        }

        .profile-id-badge i {
            font-size: 1.1rem;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
        }

        .profile-stat-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.22), rgba(139, 92, 246, 0.15));
            border: 1px solid rgba(59, 130, 246, 0.35);
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.35);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .profile-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.5);
        }

        .profile-stat-card:hover::before {
            opacity: 1;
        }

        .profile-stat-label {
            color: #cbd5e1;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            margin-bottom: 8px;
            font-weight: 600;
            position: relative;
            z-index: 1;
        }

        .profile-stat-value {
            color: #fff;
            font-weight: 800;
            font-size: 1.6rem;
            position: relative;
            z-index: 1;
        }

        .profile-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 4px;
        }

        .profile-actions a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .profile-actions .btn-primary {
            padding: 10px 18px;
            border-radius: 12px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .profile-actions .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
        }

        .btn-ghost {
            border: 1px solid rgba(255, 255, 255, 0.3);
            background: rgba(255, 255, 255, 0.08);
            color: #e2e8f0;
            border-radius: 12px;
            padding: 10px 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(255, 255, 255, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            color: #f8fafc;
        }

        .text-success {
            color: #34d399 !important;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            background: rgba(52, 211, 153, 0.12);
            border-radius: 8px;
            border: 1px solid rgba(52, 211, 153, 0.25);
            align-self: flex-start;
        }

        .text-success::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #34d399;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .profile-meta>div {
            margin-bottom: 8px;
        }

        .profile-meta .d-flex {
            margin-bottom: 0;
        }

        .profile-meta .d-flex span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: rgba(30, 41, 59, 0.5);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            font-size: 0.9rem;
        }

        .profile-meta .d-flex span i {
            color: #60a5fa;
        }

        @media (max-width: 576px) {
            .profile-hero {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .profile-actions {
                justify-content: center;
            }

            .profile-info-row {
                grid-template-columns: 1fr;
            }

            .profile-stats {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

<div class="profile-wrapper">
    <div class="profile-hero">
        @if ($data['user']->profile_picture)
            <img src="{{ asset('storage/' . $data['user']->profile_picture) }}" alt="Profile" class="profile-avatar-lg">
        @else
            <div class="profile-avatar-placeholder">
                {{ strtoupper(substr($data['user']->name, 0, 1)) }}
            </div>
        @endif

        <div class="profile-meta">
            <p class="text-success">Идэвхтэй хэрэглэгч</p>
            <div class="profile-id-display">
                <span>ID:</span>
                <span class="profile-id-number" id="userCodeText">{{ $data['user']->user_code }}</span>
                <button type="button" class="profile-copy-icon"
                    onclick="copyUserCode('{{ $data['user']->user_code }}', this)" title="Хуулах" aria-label="Хуулах">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <rect x="9" y="9" width="13" height="13" rx="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                </button>
            </div>
            <h1 class="profile-name">{{ $data['user']->name }}</h1>
            <div class="profile-actions">
                <a href="{{ route('users.dashboard', ['section' => 'settings']) }}" class="btn btn-primary btn-sm">
                    ✏️ Мэдээлэл засах
                </a>
                <a href="{{ route('users.dashboard', ['section' => 'orders']) }}" class="btn-ghost btn-sm">
                    📦 Миний захиалгууд
                </a>
            </div>
        </div>
    </div>

    <div class="profile-card">
        <h5>Хувийн мэдээлэл</h5>
        <div class="profile-info-row">
            <div class="profile-info-item">
                <div class="profile-info-label">Хэрэглэгчийн ID</div>
                <div class="profile-info-value">{{ $data['user']->user_code }}</div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Нэр</div>
                <div class="profile-info-value">{{ $data['user']->name }}</div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Имэйл</div>
                <div class="profile-info-value">{{ $data['user']->email }}</div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Утас</div>
                <div class="profile-info-value">{{ $data['user']->phone ?? 'Бүртгээгүй' }}</div>
            </div>
        </div>
    </div>

    <div class="profile-card">
        <h5>Хаягийн мэдээлэл</h5>
        <div class="profile-info-row">
            <div class="profile-info-item">
                <div class="profile-info-label">Хот / Аймаг</div>
                <div class="profile-info-value">{{ $data['user']->city ?? 'Бүртгээгүй' }}</div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Сум / Дүүрэг</div>
                <div class="profile-info-value">{{ $data['user']->district ?? 'Бүртгээгүй' }}</div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Байр / Гудамж</div>
                <div class="profile-info-value">{{ $data['user']->address ?? 'Бүртгээгүй' }}</div>
            </div>
            <div class="profile-info-item">
                <div class="profile-info-label">Тоот</div>
                <div class="profile-info-value">{{ $data['user']->apartment_number ?? 'Бүртгээгүй' }}</div>
            </div>
        </div>
    </div>

    <div class="profile-card">
        <h5>Тойм</h5>
        <div class="profile-stats">
            <div class="profile-stat-card">
                <div class="profile-stat-label">Захиалга</div>
                <div class="profile-stat-value">{{ $data['stats']['orders'] }}</div>
            </div>
            <div class="profile-stat-card">
                <div class="profile-stat-label">Хүслийн жагсаалт</div>
                <div class="profile-stat-value">{{ $data['stats']['wishlist'] }}</div>
            </div>
            <div class="profile-stat-card">
                <div class="profile-stat-label">Хадгалсан карт</div>
                <div class="profile-stat-value">{{ $data['stats']['savedCards'] }}</div>
            </div>
            <div class="profile-stat-card">
                <div class="profile-stat-label">Сагсны бараа</div>
                <div class="profile-stat-value">{{ $data['stats']['cartItems'] }}</div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function copyUserCode(code, el) {
            // Copy to clipboard
            navigator.clipboard.writeText(code).then(() => {
                // Show success feedback
                const badge = el;
                const originalBg = badge.style.background;

                badge.style.background = 'rgba(34, 197, 94, 0.25)';
                badge.style.borderColor = 'rgba(34, 197, 94, 0.5)';

                // Create temporary tooltip
                const tooltip = document.createElement('div');
                tooltip.textContent = '✓ Хуулагдлаа';
                tooltip.style.cssText = `
            position: absolute;
            top: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(34, 197, 94, 0.95);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 600;
            white-space: nowrap;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 1000;
            animation: fadeIn 0.2s ease;
        `;

                badge.appendChild(tooltip);

                // Reset after 2 seconds
                setTimeout(() => {
                    badge.style.background = '';
                    badge.style.borderColor = '';
                    tooltip.remove();
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy:', err);
                alert('Хуулж чадсангүй');
            });
        }
    </script>
@endpush

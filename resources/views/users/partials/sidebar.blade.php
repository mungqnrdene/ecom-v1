<style>
    .sidebar {
        height: 100vh;
        position: sticky;
        top: 0;
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.95) 100%);
        backdrop-filter: blur(16px);
        border-right: 1px solid rgba(255, 255, 255, 0.12);
        padding: clamp(16px, 3vw, 24px) clamp(12px, 2vw, 18px);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
        overflow-y: auto;
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(15, 23, 42, 0.3);
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(59, 130, 246, 0.5);
        border-radius: 3px;
    }

    .sidebar-brand {
        padding: 12px 0 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        margin-bottom: 16px;
    }

    .sidebar-brand-text {
        font-size: clamp(1rem, 2.5vw, 1.25rem);
        font-weight: 700;
        background: linear-gradient(135deg, #60a5fa, #a78bfa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .sidebar-section {
        color: #9ca3af;
        font-size: clamp(0.7rem, 1.5vw, 0.75rem);
        letter-spacing: 0.05em;
        text-transform: uppercase;
        margin: 16px 0 8px;
        font-weight: 600;
    }

    .sidebar-link {
        display: block;
        position: relative;
        padding: clamp(10px, 2vw, 14px) clamp(12px, 2vw, 16px);
        border-radius: 12px;
        color: #e5e7eb;
        text-decoration: none;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: clamp(0.85rem, 1.8vw, 0.95rem);
        transition: all .3s ease;
        border: 1px solid transparent;
    }

    .sidebar-link.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(139, 92, 246, 0.2));
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .sidebar-link:hover {
        background: rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateX(4px);
    }

    .sidebar-badge {
        position: absolute;
        top: clamp(4px, 1vw, 8px);
        right: clamp(4px, 1vw, 8px);
        min-width: 20px;
        height: 20px;
        padding: 0 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        border-radius: 999px;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        animation: pulse 2s infinite;
    }

    .sidebar-badge.success {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        box-shadow: 0 2px 8px rgba(34, 197, 94, 0.4);
    }

    .sidebar-badge.warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.4);
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.05);
            opacity: 0.9;
        }
    }

    .sidebar-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    @media (max-width: 768px) {
        .sidebar {
            height: auto;
            position: relative;
            padding: 12px;
        }

        .sidebar-link {
            padding: 10px 12px;
            font-size: 0.85rem;
        }

        .sidebar-badge {
            top: 6px;
            right: 6px;
            min-width: 18px;
            height: 18px;
            font-size: 0.65rem;
        }

        .sidebar-section {
            margin: 12px 0 6px;
        }
    }

    @media (max-width: 576px) {
        .sidebar-link {
            padding: 8px 10px;
            margin-bottom: 4px;
        }

        .sidebar-brand-text {
            font-size: 1rem;
        }
    }
</style>

@php
    $cartCount = 0;
    $wishlistCount = 0;

    if (Auth::guard('web')->check()) {
        if ($userCart = Auth::user()->cart) {
            $cartCount = $userCart->cartItems()->sum('quantity');
        }
        $wishlistCount = \App\Models\WishlistItem::where('user_id', Auth::id())->count();
    }

    $currentSection = $section ?? 'dashboard';
@endphp

<div class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-brand-text">🌟 WELCOME</div>
    </div>

    <h6 class="sidebar-section">Навигаци</h6>

    <a href="{{ route('users.dashboard') }}" class="sidebar-link {{ $currentSection === 'dashboard' ? 'active' : '' }}">
        🏠 Нүүр
    </a>

    <a href="{{ route('users.dashboard', ['section' => 'products']) }}"
        class="sidebar-link {{ $currentSection === 'products' ? 'active' : '' }}">
        🛒 Бараанууд
    </a>

    <a href="{{ route('users.dashboard', ['section' => 'wishlist']) }}"
        class="sidebar-link {{ $currentSection === 'wishlist' ? 'active' : '' }}">
        ❤️ Хадгалсан
        @if ($wishlistCount > 0)
            <span class="sidebar-badge success">{{ $wishlistCount }}</span>
        @endif
    </a>

    <a href="{{ route('users.dashboard', ['section' => 'cart']) }}"
        class="sidebar-link {{ $currentSection === 'cart' ? 'active' : '' }}">
        🛍️ Миний сагс
        @if ($cartCount > 0)
            <span class="sidebar-badge">{{ $cartCount }}</span>
        @endif
    </a>

    <a href="{{ route('users.dashboard', ['section' => 'orders']) }}"
        class="sidebar-link {{ $currentSection === 'orders' ? 'active' : '' }}">
        📦 Захиалга
    </a>

    <h6 class="sidebar-section">Төлбөр</h6>

    <a href="{{ route('users.dashboard', ['section' => 'payment']) }}"
        class="sidebar-link {{ $currentSection === 'payment' ? 'active' : '' }}">
        💳 Карт төлбөр
    </a>

    <h6 class="sidebar-section">Бусад</h6>

    <a href="{{ route('users.dashboard', ['section' => 'settings']) }}"
        class="sidebar-link {{ $currentSection === 'settings' ? 'active' : '' }}">
        ⚙️ Тохиргоо
    </a>

    <a href="{{ route('users.dashboard', ['section' => 'contact']) }}"
        class="sidebar-link {{ $currentSection === 'contact' ? 'active' : '' }}">
        📞 Холбоо барих
    </a>
</div>

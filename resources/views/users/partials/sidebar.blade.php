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

    <a href="{{ route('users.dashboard', ['section' => 'contact']) }}"
        class="sidebar-link {{ $currentSection === 'contact' ? 'active' : '' }}">
        📞 Холбоо барих
    </a>
</div>

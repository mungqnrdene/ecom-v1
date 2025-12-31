<style>
    .sidebar {
        height: 100vh;
        position: sticky;
        top: 0;
        background: linear-gradient(180deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.95) 100%);
        backdrop-filter: blur(16px);
        border-right: 1px solid rgba(255, 255, 255, 0.12);
        padding: 24px 18px;
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.2);
    }

    .sidebar a {
        display: block;
        padding: 14px 16px;
        border-radius: 12px;
        color: #e5e7eb;
        text-decoration: none;
        margin-bottom: 6px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all .3s ease;
        border: 1px solid transparent;
    }

    .sidebar a.active {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(139, 92, 246, 0.2));
        border-color: rgba(59, 130, 246, 0.4);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .sidebar a:hover {
        background: rgba(59, 130, 246, 0.15);
        border-color: rgba(59, 130, 246, 0.3);
        transform: translateX(4px);
    }

    .sidebar h6 {
        color: #9ca3af;
        font-size: 12px;
        letter-spacing: 0.05em;
        margin: 10px 0 6px
    }
</style>
<div class="sidebar">
    <h6>Навигаци</h6>
    <a href="{{ route('users.welcome') }}" class="{{ request()->routeIs('users.welcome') ? 'active' : '' }}">🏠 Нүүр</a>
    <a href="{{ route('products') }}" class="{{ request()->routeIs('products') ? 'active' : '' }}">🛒 Бараанууд</a>
    <a href="{{ route('users.wishlist') }}" class="{{ request()->routeIs('users.wishlist') ? 'active' : '' }}">❤️
        Хадгалсан</a>
    <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.index') ? 'active' : '' }}">🛍️ Миний сагс</a>
    <a href="{{ route('users.payment-card') }}" class="{{ request()->routeIs('users.payment-card') ? 'active' : '' }}">💳
        Карт төлбөр</a>
    <a href="{{ route('users.qpay') }}" class="{{ request()->routeIs('users.qpay') ? 'active' : '' }}">🏦 QPay</a>
    <a href="{{ route('users.contact') }}" class="{{ request()->routeIs('users.contact') ? 'active' : '' }}">📞 Холбоо
        барих</a>
</div>

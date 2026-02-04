<style>
    .payment-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .payment-section-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    .btn-add-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-add-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .payment-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .payment-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        border-color: rgba(102, 126, 234, 0.3);
    }

    .payment-card.default {
        border: 2px solid #10b981;
        box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
    }

    .card-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-brand-icon {
        font-size: 2rem;
        color: #667eea;
    }

    .default-badge {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .card-brand-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: #e5e7eb;
        margin-bottom: 15px;
    }

    .card-number {
        font-family: 'Courier New', monospace;
        font-size: 1.2rem;
        color: #9ca3af;
        letter-spacing: 2px;
        margin-bottom: 15px;
    }

    .card-expiry-info {
        color: #6b7280;
        font-size: 0.85rem;
    }

    .btn-manage-cards {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e5e7eb;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all 0.3s;
    }

    .btn-manage-cards:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(102, 126, 234, 0.3);
        color: white;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: rgba(255, 255, 255, 0.05);
        border: 2px dashed rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        margin-bottom: 20px;
    }

    .empty-state i {
        font-size: 4rem;
        color: #6b7280;
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #9ca3af;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #6b7280;
    }
</style>

<div class="payment-section-header">
    <h2>💳 Хадгалсан картууд</h2>
    @if (!$data['savedCards']->isEmpty())
        <a href="{{ route('users.saved-cards') }}" class="btn-add-card">
            <i class="fas fa-plus"></i>
            Карт нэмэх
        </a>
    @endif
</div>

@if ($data['savedCards']->isEmpty())
    <div class="empty-state">
        <i class="fas fa-credit-card"></i>
        <h3>Хадгалсан карт байхгүй байна</h3>
        <p>Доорх товч дарж шинэ карт нэмнэ үү</p>
    </div>
    <a href="{{ route('users.saved-cards') }}" class="btn-add-card" style="width: 100%; justify-content: center;">
        <i class="fas fa-plus"></i>
        Карт нэмэх
    </a>
@else
    <div class="cards-grid">
        @foreach ($data['savedCards'] as $card)
            <div class="payment-card {{ $card->is_default ? 'default' : '' }}">
                <div class="card-header-row">
                    <i class="fas fa-credit-card card-brand-icon"></i>
                    @if ($card->is_default)
                        <span class="default-badge">
                            <i class="fas fa-star me-1"></i>Үндсэн
                        </span>
                    @endif
                </div>

                <div class="card-brand-name">
                    {{ $card->card_brand ?? 'Карт' }}
                </div>

                <div class="card-number">
                    {{ $card->masked_card_number }}
                </div>

                <div class="card-expiry-info">
                    <i class="far fa-calendar-alt me-1"></i>
                    {{ $card->expiry_month }}/{{ $card->expiry_year }}
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('users.saved-cards') }}" class="btn-manage-cards">
        <i class="fas fa-cog"></i>
        Картуудаа удирдах
    </a>
@endif

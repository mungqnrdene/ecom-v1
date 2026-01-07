<h2 class="mb-4">💳 Хадгалсан картууд</h2>

@if ($data['savedCards']->isEmpty())
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>Хадгалсан карт байхгүй байна.
    </div>
    <a href="{{ route('users.saved-cards') }}" class="btn btn-primary">Карт нэмэх</a>
@else
    <div class="row g-3">
        @foreach ($data['savedCards'] as $card)
            <div class="col-md-6 col-lg-4">
                <div class="card {{ $card->is_default ? 'border-success' : '' }}">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <i class="bi bi-credit-card fs-3"></i>
                            </div>
                            @if ($card->is_default)
                                <span class="badge bg-success">Үндсэн</span>
                            @endif
                        </div>
                        <h5 class="mt-3">{{ $card->card_brand ?? 'Карт' }}</h5>
                        <p class="mb-1">{{ $card->masked_card_number }}</p>
                        <p class="text-muted small">{{ $card->expiry_month }}/{{ $card->expiry_year }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <a href="{{ route('users.saved-cards') }}" class="btn btn-outline-light mt-3">Картуудаа удирдах</a>
@endif

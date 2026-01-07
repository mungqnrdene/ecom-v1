@extends('layouts.user')
@section('title', 'Миний картууд')

@section('page')
    <style>
        .cards-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-header h2 {
            color: #e5e7eb;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .page-header p {
            color: #9ca3af;
            font-size: 1rem;
        }

        .add-card-btn {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 30px;
        }

        .add-card-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .card-item {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.95) 0%, rgba(15, 23, 42, 0.95) 100%);
            border-radius: 20px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            position: relative;
            transition: all 0.3s;
        }

        .card-item:hover {
            transform: translateY(-5px);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        }

        .card-item.default-card {
            border: 2px solid #34d399;
            box-shadow: 0 10px 25px rgba(52, 211, 153, 0.2);
        }

        .default-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #34d399;
            color: #0f172a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .card-brand {
            font-size: 1.2rem;
            font-weight: 700;
            color: #60a5fa;
            margin-bottom: 15px;
        }

        .card-number {
            font-family: 'Courier New', monospace;
            font-size: 1.3rem;
            color: #e5e7eb;
            margin-bottom: 20px;
            letter-spacing: 2px;
        }

        .card-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .card-holder {
            color: #9ca3af;
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .card-expiry {
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .card-expired {
            color: #ef4444;
            font-weight: 600;
        }

        .card-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-set-default {
            flex: 1;
            background: rgba(52, 211, 153, 0.1);
            color: #34d399;
            border: 1px solid rgba(52, 211, 153, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-set-default:hover {
            background: rgba(52, 211, 153, 0.2);
            border-color: #34d399;
        }

        .btn-delete {
            flex: 1;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: #ef4444;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: rgba(15, 23, 42, 0.5);
            border-radius: 20px;
            border: 2px dashed rgba(255, 255, 255, 0.1);
        }

        .empty-state i {
            font-size: 4rem;
            color: #4b5563;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #9ca3af;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6b7280;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: rgba(15, 23, 42, 0.98);
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        }

        .modal-header {
            margin-bottom: 25px;
        }

        .modal-header h3 {
            color: #e5e7eb;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #9ca3af;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: #e5e7eb;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #3b82f6;
            background: rgba(30, 41, 59, 0.7);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .checkbox-group input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }

        .checkbox-group label {
            color: #d1d5db;
            margin: 0;
            cursor: pointer;
        }

        .modal-actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-submit {
            flex: 1;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 12px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
        }

        .btn-cancel {
            flex: 1;
            background: rgba(100, 116, 139, 0.2);
            color: #94a3b8;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid rgba(148, 163, 184, 0.3);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: rgba(100, 116, 139, 0.3);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .alert-success {
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.3);
            color: #34d399;
        }
    </style>

    <div class="cards-container">
        <div class="page-header">
            <h2>Миний картууд</h2>
            <p>Хадгалсан картуудаа удирдаж, захиалга хийхдээ хурдан төлбөр төлөөрэй</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <button class="add-card-btn" onclick="openModal()">
            <i class="fas fa-plus"></i> Шинэ карт нэмэх
        </button>

        @if ($savedCards->isEmpty())
            <div class="empty-state">
                <i class="fas fa-credit-card"></i>
                <h3>Хадгалсан карт байхгүй байна</h3>
                <p>Дээрх товч дарж шинэ карт нэмнэ үү</p>
            </div>
        @else
            <div class="cards-grid">
                @foreach ($savedCards as $card)
                    <div class="card-item {{ $card->is_default ? 'default-card' : '' }}">
                        @if ($card->is_default)
                            <div class="default-badge">Үндсэн</div>
                        @endif

                        <div class="card-brand">
                            {{ $card->card_brand ?? 'Карт' }}
                        </div>

                        <div class="card-number">
                            {{ $card->masked_card_number }}
                        </div>

                        <div class="card-info">
                            <div>
                                <div style="font-size: 0.7rem; color: #6b7280; margin-bottom: 3px;">ЭЗЭМШИГЧ</div>
                                <div class="card-holder">{{ $card->card_holder }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.7rem; color: #6b7280; margin-bottom: 3px;">ДУУСАХ ОГНОО</div>
                                <div class="card-expiry {{ $card->isExpired() ? 'card-expired' : '' }}">
                                    {{ $card->expiry_month }}/{{ $card->expiry_year }}
                                    @if ($card->isExpired())
                                        <i class="fas fa-exclamation-circle" title="Карт дууссан"></i>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-actions">
                            @if (!$card->is_default)
                                <form action="{{ route('users.saved-cards.default', $card->id) }}" method="POST"
                                    style="flex: 1;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-set-default">
                                        <i class="fas fa-star"></i> Үндсэн болгох
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('users.saved-cards.destroy', $card->id) }}" method="POST"
                                onsubmit="return confirm('Энэ картыг устгахдаа итгэлтэй байна уу?')" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-trash"></i> Устгах
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Add Card Modal -->
    <div class="modal" id="addCardModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Шинэ карт нэмэх</h3>
            </div>

            <form action="{{ route('users.saved-cards.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="card_holder">Картны эзэмшигч</label>
                    <input type="text" id="card_holder" name="card_holder" required placeholder="ӨВӨРТҮвШИН ГАЛ">
                </div>

                <div class="form-group">
                    <label for="card_number">Картны дугаар</label>
                    <input type="text" id="card_number" name="card_number" required placeholder="1234567890123456"
                        maxlength="16" pattern="\d{16}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry_month">Сар</label>
                        <input type="text" id="expiry_month" name="expiry_month" required placeholder="12" maxlength="2"
                            pattern="\d{2}">
                    </div>
                    <div class="form-group">
                        <label for="expiry_year">Жил</label>
                        <input type="text" id="expiry_year" name="expiry_year" required placeholder="2025" maxlength="4"
                            pattern="\d{4}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="card_brand">Картын төрөл (заавал биш)</label>
                    <input type="text" id="card_brand" name="card_brand" placeholder="Visa, Mastercard, гэх мэт">
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="is_default" name="is_default" value="1">
                    <label for="is_default">Үндсэн карт болгох</label>
                </div>

                <div class="modal-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Хадгалах
                    </button>
                    <button type="button" class="btn-cancel" onclick="closeModal()">
                        <i class="fas fa-times"></i> Болих
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById('addCardModal').classList.add('active');
        }

        function closeModal() {
            document.getElementById('addCardModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('addCardModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endsection

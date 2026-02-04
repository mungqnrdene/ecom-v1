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
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .form-group input::placeholder {
            color: #6b7280;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 1.1rem;
        }

        .input-with-icon input {
            padding-left: 45px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        /* Card Preview */
        .card-preview {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            min-height: 200px;
        }

        .card-preview::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-preview-chip {
            width: 50px;
            height: 40px;
            background: linear-gradient(135deg, #fbbf24, #f59e0b);
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-preview-number {
            font-family: 'Courier New', monospace;
            font-size: 1.4rem;
            letter-spacing: 3px;
            color: white;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .card-preview-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .card-preview-holder {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.75rem;
            margin-bottom: 3px;
            text-transform: uppercase;
        }

        .card-preview-holder-name {
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            text-transform: uppercase;
        }

        .card-preview-expiry {
            color: white;
            font-family: 'Courier New', monospace;
            font-size: 1rem;
        }

        .card-preview-brand {
            position: absolute;
            top: 25px;
            right: 25px;
            color: white;
            font-weight: 800;
            font-size: 1.2rem;
            text-transform: uppercase;
        }

        .input-helper {
            font-size: 0.75rem;
            color: #6b7280;
            margin-top: 5px;
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
                <h3><i class="fas fa-credit-card me-2"></i>Шинэ карт нэмэх</h3>
            </div>

            <!-- Card Preview -->
            <div class="card-preview">
                <div class="card-preview-brand" id="previewBrand">VISA</div>
                <div class="card-preview-chip"></div>
                <div class="card-preview-number" id="previewNumber">•••• •••• •••• ••••</div>
                <div class="card-preview-info">
                    <div>
                        <div class="card-preview-holder">Эзэмшигч</div>
                        <div class="card-preview-holder-name" id="previewHolder">ТА НЭР</div>
                    </div>
                    <div>
                        <div class="card-preview-expiry" id="previewExpiry">MM/YYYY</div>
                    </div>
                </div>
            </div>

            <form action="{{ route('users.saved-cards.store') }}" method="POST">
                @csrf

                <div class="form-group input-with-icon">
                    <i class="fas fa-user"></i>
                    <label for="card_holder">Картны эзэмшигч</label>
                    <input type="text" id="card_holder" name="card_holder" required placeholder=""
                        oninput="updatePreview()">
                    <div class="input-helper">Карт дээр бичигдсэнээр оруулна уу</div>
                </div>

                <div class="form-group input-with-icon">
                    <i class="fas fa-credit-card"></i>
                    <label for="card_number">Картны дугаар</label>
                    <input type="text" id="card_number" name="card_number" required placeholder="1234 5678 9012 3456"
                        maxlength="19" oninput="formatCardNumber(this); updatePreview()">
                    <div class="input-helper">16 оронтой дугаар оруулна уу</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry_month"><i class="far fa-calendar-alt me-1"></i>Дуусах сар</label>
                        <input type="text" id="expiry_month" name="expiry_month" required placeholder="12" maxlength="2"
                            oninput="formatMonth(this); updatePreview()">
                        <div class="input-helper">01-12</div>
                    </div>
                    <div class="form-group">
                        <label for="expiry_year"><i class="far fa-calendar-alt me-1"></i>Дуусах жил</label>
                        <input type="text" id="expiry_year" name="expiry_year" required placeholder="2025" maxlength="4"
                            oninput="formatYear(this); updatePreview()">
                        <div class="input-helper">YYYY</div>
                    </div>
                </div>

                <!-- Hidden field for auto-detected card brand -->
                <input type="hidden" id="card_brand" name="card_brand" value="">

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
            updatePreview();
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

        // Detect card type based on card number
        function detectCardType(cardNumber) {
            const cleanNumber = cardNumber.replace(/\s/g, '');

            // Visa: starts with 4
            if (/^4/.test(cleanNumber)) {
                return 'Visa';
            }
            // Mastercard: starts with 51-55 or 2221-2720
            if (/^5[1-5]/.test(cleanNumber) || /^2[2-7]/.test(cleanNumber)) {
                return 'Mastercard';
            }
            // American Express: starts with 34 or 37
            if (/^3[47]/.test(cleanNumber)) {
                return 'American Express';
            }
            // Discover: starts with 6011, 622126-622925, 644-649, 65
            if (/^6011|^62[2-8]|^64[4-9]|^65/.test(cleanNumber)) {
                return 'Discover';
            }
            // UnionPay: starts with 62
            if (/^62/.test(cleanNumber)) {
                return 'UnionPay';
            }
            // JCB: starts with 3528-3589
            if (/^35[2-8]/.test(cleanNumber)) {
                return 'JCB';
            }

            return 'Card';
        }

        // Format card number with spaces
        function formatCardNumber(input) {
            let value = input.value.replace(/\s/g, '').replace(/\D/g, '');
            let formatted = value.match(/.{1,4}/g)?.join(' ') || value;
            input.value = formatted;

            // Auto-detect and set card brand
            const cardType = detectCardType(value);
            document.getElementById('card_brand').value = cardType;
        }

        // Format month (01-12)
        function formatMonth(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length === 1 && parseInt(value) > 1) {
                value = '0' + value;
            }
            if (value.length === 2) {
                let month = parseInt(value);
                if (month < 1) value = '01';
                if (month > 12) value = '12';
            }
            input.value = value;
        }

        // Format year (YYYY)
        function formatYear(input) {
            input.value = input.value.replace(/\D/g, '');
        }

        // Mask middle 8 digits of card number
        function maskCardNumber(cardNumber) {
            const cleanNumber = cardNumber.replace(/\s/g, '');
            if (cleanNumber.length < 12) {
                // If less than 12 digits, show as is with spaces
                return cardNumber || '•••• •••• •••• ••••';
            }

            // Format: first 4 + masked 8 + last 4
            const first4 = cleanNumber.substring(0, 4);
            const last4 = cleanNumber.substring(cleanNumber.length - 4);
            const masked = first4 + ' •••• •••• ' + last4;

            return masked;
        }

        // Update card preview
        function updatePreview() {
            const holder = document.getElementById('card_holder').value || 'ТА НЭР';
            const number = document.getElementById('card_number').value || '';
            const month = document.getElementById('expiry_month').value || 'MM';
            const year = document.getElementById('expiry_year').value || 'YYYY';
            const brand = document.getElementById('card_brand').value || detectCardType(number) || 'CARD';

            document.getElementById('previewHolder').textContent = holder.toUpperCase();
            document.getElementById('previewNumber').textContent = maskCardNumber(number);
            document.getElementById('previewExpiry').textContent = `${month}/${year}`;
            document.getElementById('previewBrand').textContent = brand.toUpperCase();
        }

        // Prevent non-numeric input for card number
        document.getElementById('card_number')?.addEventListener('keypress', function(e) {
            if (!/\d/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
                e.preventDefault();
            }
        });

        // Prevent non-numeric input for month and year
        ['expiry_month', 'expiry_year'].forEach(id => {
            document.getElementById(id)?.addEventListener('keypress', function(e) {
                if (!/\d/.test(e.key) && e.key !== 'Backspace' && e.key !== 'Delete') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endsection

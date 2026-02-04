@extends('layouts.admin')

@section('title', 'Тохиргоо - Light Shop')

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Settings</span>
                <h1 class="admin-page-title">⚙️ Системийн тохиргоо</h1>
                <p class="admin-page-subtitle">Дэлгүүрийн бүх үндсэн тохиргоог энд удирдана уу</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light admin-cta-btn">← Самбар руу буцах</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-4" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile" type="button">
                    <i class="fas fa-user"></i> Профайл
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#store" type="button">
                    <i class="fas fa-store"></i> Дэлгүүр
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payment" type="button">
                    <i class="fas fa-credit-card"></i> Төлбөр
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#order" type="button">
                    <i class="fas fa-shopping-cart"></i> Захиалга
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#security" type="button">
                    <i class="fas fa-shield-alt"></i> Аюулгүй байдал
                </button>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Profile Tab -->
            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Профайл мэдээлэл</h5>
                                <form method="POST" action="{{ route('admin.settings.profile') }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Нэр *</label>
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $admin->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="email" class="form-label">Имэйл *</label>
                                        <input type="email" id="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $admin->email) }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-success">Хадгалах</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Нууц үг шинэчлэх</h5>
                                <form method="POST" action="{{ route('admin.settings.password') }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Шинэ нууц үг</label>
                                        <input type="password" id="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="new password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_confirmation" class="form-label">Нууц үг давтах</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            class="form-control" placeholder="confirm password">
                                    </div>
                                    <button type="submit" class="btn btn-warning">Нууц үг шинэчлэх</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Store Settings Tab -->
            <div class="tab-pane fade" id="store" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Дэлгүүрийн мэдээлэл</h5>
                        <form method="POST" action="{{ route('admin.settings.store') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Дэлгүүрийн нэр *</label>
                                        <input type="text" id="site_name" name="site_name"
                                            class="form-control @error('site_name') is-invalid @enderror"
                                            value="{{ old('site_name', setting('site_name')) }}" required>
                                        @error('site_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_email" class="form-label">Имэйл *</label>
                                        <input type="email" id="site_email" name="site_email"
                                            class="form-control @error('site_email') is-invalid @enderror"
                                            value="{{ old('site_email', setting('site_email')) }}" required>
                                        @error('site_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="site_phone" class="form-label">Утас *</label>
                                        <input type="text" id="site_phone" name="site_phone"
                                            class="form-control @error('site_phone') is-invalid @enderror"
                                            value="{{ old('site_phone', setting('site_phone')) }}" required>
                                        @error('site_phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">Валют *</label>
                                        <input type="text" id="currency" name="currency"
                                            class="form-control @error('currency') is-invalid @enderror"
                                            value="{{ old('currency', setting('currency', 'MNT')) }}" required>
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="site_address" class="form-label">Хаяг *</label>
                                        <textarea id="site_address" name="site_address" class="form-control" rows="2" required>{{ old('site_address', setting('site_address')) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Лого</label>
                                        @if (setting('logo_path'))
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/' . setting('logo_path')) }}" alt="Logo"
                                                    style="max-height: 80px;">
                                            </div>
                                        @endif
                                        <input type="file" id="logo" name="logo" class="form-control"
                                            accept="image/*">
                                        <small class="text-muted">PNG, JPG, SVG. Max 2MB</small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Хадгалах</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Payment Settings Tab -->
            <div class="tab-pane fade" id="payment" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Төлбөрийн сонголтууд</h5>
                        <form method="POST" action="{{ route('admin.settings.payment') }}">
                            @csrf
                            @method('PATCH')

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i> Идэвхгүй болгосон төлбөрийн хэрэгсэл хэрэглэгчийн
                                худалдан авагчын
                                хуудсанд харагдахгүй.
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="hidden" name="card_enabled" value="0">
                                <input class="form-check-input" type="checkbox" id="card_enabled" name="card_enabled"
                                    value="1" {{ setting('card_enabled', 1) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="card_enabled">
                                    <strong>Карт төлбөр идэвхтэй</strong>
                                    <br><small class="text-muted">Visa, Mastercard картаар төлөх</small>
                                </label>
                            </div>

                            <div class="form-check form-switch mb-3">
                                <input type="hidden" name="qpay_enabled" value="0">
                                <input class="form-check-input" type="checkbox" id="qpay_enabled" name="qpay_enabled"
                                    value="1"
                                    {{ setting('qpay_enabled', setting('cod_enabled', 1)) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="qpay_enabled">
                                    <strong>QPay идэвхтэй</strong>
                                    <br><small class="text-muted">QR кодоор төлөх</small>
                                </label>
                            </div>

                            <div class="form-check form-switch mb-4">
                                <input type="hidden" name="bank_transfer_enabled" value="0">
                                <input class="form-check-input" type="checkbox" id="bank_transfer_enabled"
                                    name="bank_transfer_enabled" value="1"
                                    {{ setting('bank_transfer_enabled', 1) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="bank_transfer_enabled">
                                    <strong>Дансаар шилжүүлэх идэвхтэй</strong>
                                    <br><small class="text-muted">Банкны шилжүүлэг</small>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success">Хадгалах</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Settings Tab -->
            <div class="tab-pane fade" id="order" role="tabpanel">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-3">Захиалгын тохиргоо</h5>
                        <form method="POST" action="{{ route('admin.settings.order') }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-check form-switch mb-3">
                                <input type="hidden" name="order_auto_pending" value="0">
                                <input class="form-check-input" type="checkbox" id="order_auto_pending"
                                    name="order_auto_pending" value="1"
                                    {{ setting('order_auto_pending', 1) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="order_auto_pending">
                                    <strong>Шинэ захиалгыг автоматаар "Хүлээгдэж байна" статустай үүсгэх</strong>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label for="free_shipping_threshold" class="form-label">Үнэгүй хүргэлтийн доод дүн
                                    ({{ setting('currency', 'MNT') }})</label>
                                <input type="number" id="free_shipping_threshold" name="free_shipping_threshold"
                                    class="form-control"
                                    value="{{ old('free_shipping_threshold', setting('free_shipping_threshold', 100000)) }}"
                                    required>
                                <small class="text-muted">Энэ дүнгээс дээш захиалгад хүргэлт үнэгүй</small>
                            </div>

                            <div class="form-check form-switch mb-4">
                                <input type="hidden" name="allow_refund" value="0">
                                <input class="form-check-input" type="checkbox" id="allow_refund" name="allow_refund"
                                    value="1" {{ setting('allow_refund', 1) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="allow_refund">
                                    <strong>Буцаалт зөвшөөрөх</strong>
                                    <br><small class="text-muted">Идэвхгүй бол буцаалтын товч харагдахгүй</small>
                                </label>
                            </div>

                            <button type="submit" class="btn btn-success">Хадгалах</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Security Tab -->
            <div class="tab-pane fade" id="security" role="tabpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Нэвтрэлтийн түүх</h5>

                                <div class="mb-3">
                                    <label class="form-label">Сүүлд нэвтэрсэн</label>
                                    <p class="form-control-plaintext">
                                        @if ($admin->last_login_at)
                                            {{ $admin->last_login_at instanceof \Carbon\Carbon ? $admin->last_login_at->format('Y-m-d H:i:s') : $admin->last_login_at }}
                                        @else
                                            Мэдээлэл байхгүй
                                        @endif
                                    </p>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">IP хаяг</label>
                                    <p class="form-control-plaintext">
                                        {{ $admin->last_login_ip ?? 'Мэдээлэл байхгүй' }}
                                    </p>
                                </div>

                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Хэрэв танай бус хэн нэгэн нэвтэрсэн бол нууц үгээ даруй солино уу.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="mb-3">Аюулгүй байдал</h5>
                                <form method="POST" action="{{ route('admin.settings.security') }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-check form-switch mb-3">
                                        <input type="hidden" name="admin_email_notifications" value="0">
                                        <input class="form-check-input" type="checkbox" id="admin_email_notifications"
                                            name="admin_email_notifications" value="1"
                                            {{ setting('admin_email_notifications', 1) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="admin_email_notifications">
                                            <strong>Имэйл мэдэгдэл илгээх</strong>
                                            <br><small class="text-muted">Шинэ захиалга, төлбөрийн мэдээлэл</small>
                                        </label>
                                    </div>

                                    <div class="form-check form-switch mb-4">
                                        <input type="hidden" name="maintenance_mode" value="0">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode"
                                            name="maintenance_mode" value="1"
                                            {{ setting('maintenance_mode', 0) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            <strong>Засвар үйлчилгээний горим</strong>
                                            <br><small class="text-muted text-danger">Дэлгүүр түр хаагдана</small>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-success">Хадгалах</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard - Light Shop')

@push('styles')
    <style>
        .stat-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(139, 92, 246, 0.1));
            border: 1px solid rgba(59, 130, 246, 0.2);
            transition: all .3s ease;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .stat-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.4);
        }

        .action-btn {
            transition: all .3s ease;
            border-radius: 12px;
            font-weight: 600;
            padding: 12px 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-lg-8">
                <h1 class="display-5">👋 Сайн байна уу, {{ $admin->name }}!</h1>
                <p class="lead text-muted"> админ панель-д хүлээлтэй байна</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success me-2">
                    ➕ Бараа нэмэх
                </a>
                <div class="card bg-dark border-light">
                    <div class="card-body">
                        <p class="mb-1">Нэвтэрсэн хэрэглэгч</p>
                        <h5>{{ $admin->email }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stat-card bg-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1 text-muted">Нийт бүтээгдэхүүн</p>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div style="font-size: 2rem;">📦</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1 text-muted">Нийт борлуулалт</p>
                                <h3 class="mb-0">₮ 0</h3>
                            </div>
                            <div style="font-size: 2rem;">💰</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1 text-muted">Идэвхтэй захиалга</p>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div style="font-size: 2rem;">📋</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card bg-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-1 text-muted">Зочид</p>
                                <h3 class="mb-0">0</h3>
                            </div>
                            <div style="font-size: 2rem;">👥</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <h5 class="mb-3">Үйлдлүүд</h5>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-primary action-btn">➕ Шинэ бүтээгдэхүүн нэмэх</button>
                    <button class="btn btn-success action-btn">📊 Тайлан үзэх</button>
                    <button class="btn btn-info action-btn">⚙️ Тохиргоо</button>
                    <a href="{{ route('users.login') }}" class="btn btn-warning action-btn">👤 Хэрэглэгч нэвтрэх</a>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="row">
            <div class="col-lg-12">
                <h5 class="mb-3">Сүүлийн үеийн бүтээгдэхүүн</h5>
                <div class="alert alert-info">
                    📦 Бүтээгдэхүүн бүртгэл хоосон байна. Шинэ бүтээгдэхүүн нэмээрэй!
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Нүүр хуудас - Light Shop')

@section('content')
    <div class="container admin-page">
        <div class="admin-page-header">
            <div>
                <span class="admin-eyebrow">Welcome back</span>
                <h1 class="admin-page-title">✨ Light Shop админ хэсэг</h1>
                <p class="admin-page-subtitle">Сайн байна уу, {{ $admin->name }}. Доорх товчлууруудыг ашиглан гол самбарууд
                    руу
                    хурдан шилжинэ үү.</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary admin-cta-btn">📊 Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="btn btn-info admin-cta-btn">📦 Бүтээгдэхүүн</a>
                <a href="{{ route('admin.reports') }}" class="btn btn-success admin-cta-btn">📈 Тайлан</a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">📦 Бүтээгдэхүүн</h5>
                        <p class="card-text">Каталог, зураг, тайлбар, төрөлүүдийг нэг газраас удирд.</p>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light btn-sm mt-2">Жагсаалт
                            руу очих</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">👥 Хэрэглэгч</h5>
                        <p class="card-text">Хэрэглэгчдийн идэвх, захиалгын мэдээллийг real-time хар.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light btn-sm mt-2">Самбар руу
                            очих</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">📊 Тайлан</h5>
                        <p class="card-text">Борлуулалт, төлбөрийн статистикаа тайлангийн хэсгээр нэг дор хараарай.</p>
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-light btn-sm mt-2">Тайлан руу очих</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

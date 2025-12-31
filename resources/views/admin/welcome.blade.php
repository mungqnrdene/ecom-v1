@extends('layouts.app')

@section('title', 'Нүүр хуудас - Light Shop')

@section('content')
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4">
                <h1 class="display-4 fw-bold mb-4">✨ WELCOME :)</h1>
                <p class="lead mb-4">Сайн байна уу, {{ $admin->name }}!</p>
                <p class="lead mb-4">Ene bol admin</p>

                <div class="d-flex gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">📊 Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-info btn-lg">📦 Baraa bvteegdehvvn</a>
                </div>
            </div>

        </div>

        <!-- Features -->
        <div class="row mt-5 g-4">
            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">📦 Бүтээгдэхүүн</h5>
                        <p class="card-text">Бүтээгдэхүүн удирдах систем</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">👥 Хэрэглэгч</h5>
                        <p class="card-text">Хэрэглэгчийн нэхэмжлэл удирдах</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-dark border-light text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">📊 Тайлан</h5>
                        <p class="card-text">Борлуулалтын тайлан үзэх</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

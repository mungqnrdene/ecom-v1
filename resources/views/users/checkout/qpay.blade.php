@extends('layouts.user')

@section('title', 'QPay төлбөр - Light Shop')

@section('page')
    <div class="container py-3">
        <h2 class="mb-4">🏦 QPay төлбөр</h2>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <div class="card bg-dark border-light">
                    <div class="card-body text-center">
                        <h5 class="card-title">QPay системээр төлөх</h5>
                        <p class="text-muted">Та QPay системээр төлбөрөө гүйцэтгэх боломжтой</p>

                        <div class="my-4">
                            <p class="h6">Төлбөрийн дүн</p>
                            <p class="h4">₮ 0</p>
                        </div>

                        <button class="btn btn-primary w-100 mb-2">QPay системээр төлөх</button>
                        <a href="{{ route('users.welcome') }}" class="btn btn-outline-light w-100">Буцах</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

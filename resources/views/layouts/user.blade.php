@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 p-0">
                @include('users.partials.sidebar')
            </div>
            <div class="col-md-9 col-lg-10 py-4">
                @yield('page')
            </div>
        </div>
    </div>
@endsection

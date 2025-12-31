@extends('layouts.user')

@section('title', 'Карт төлбөр - Light Shop')

@section('page')
    <div class="container py-3">
        <h2 class="mb-4">💳 Карт төлбөр</h2>

        <div class="row">
            <div class="col-md-6">
                <div class="card bg-dark border-light">
                    <div class="card-body">
                        <h5 class="card-title">Карт мэдээлэл</h5>
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Карт дугаар</label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Хүчинтэй эхлэх</label>
                                        <input type="text" class="form-control" placeholder="MM/YY" maxlength="5">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-control" placeholder="000" maxlength="3">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Төлөх</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

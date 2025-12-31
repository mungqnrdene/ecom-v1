@extends('layouts.user')

@section('title', 'Холбоо барих - Light Shop')

@push('styles')
    <style>
        .contact-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.04));
            border-radius: 20px;
            padding: 32px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            transition: all .3s ease;
        }

        .contact-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.3);
        }

        .contact-label {
            font-weight: 600
        }
    </style>
@endpush

@section('page')
    <h2 class="mb-4">📞 Холбоо барих</h2>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="contact-card">
                <h5 class="mb-3">Холбогдох мэдээлэл</h5>
                <p class="mb-1 contact-label">📧 Имэйл</p>
                <p class="text-muted">mongoldei0212@gmail.mn</p>
                <p class="mb-1 contact-label">📱 Утас</p>
                <p class="text-muted">+976 9529 7999</p>
                <p class="mb-1 contact-label">📍 Хаяг</p>
                <p class="text-muted">Улаанбаатар, Монгол</p>
                <p class="mb-1 contact-label">🕐 Ажлын цаг</p>
                <p class="text-muted">Даваа - Баасан: 09:00 - 18:00</p>
                <p class="mb-1 contact-label">Сошиал холбоос:</p>

                <ul class="mb-0 d-flex gap-4 list-unstyled align-items-center mt-2">
                    <li>
                        <a href="mailto:yourgmail@gmail.com" class="text-white fs-6">
                            <i class="fa-solid fa-envelope fa-xl"></i>
                        </a>
                    </li>

                    <li>
                        <a href="https://twitter.com/mongoldei0212" target="_blank" class="text-white fs-6">
                            <i class="fa-brands fa-x-twitter fa-xl"></i>
                        </a>
                    </li>

                    <li>
                        <a href="https://www.facebook.com/yourpage" target="_blank" class="text-white fs-6">
                            <i class="fa-brands fa-facebook fa-xl"></i>
                        </a>
                    </li>

                    <li>
                        <a href="https://www.instagram.com/yourpage" target="_blank" class="text-white fs-6">
                            <i class="fa-brands fa-instagram fa-xl"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-7">
            <div class="contact-card">
                <h5 class="mb-3">Санал илгээх</h5>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Нэр</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Имэйл</label>
                        <input type="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Сэдэв</label>
                        <input type="text" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Санал</label>
                        <textarea class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Илгээх</button>
                </form>
            </div>
        </div>
    </div>
@endsection

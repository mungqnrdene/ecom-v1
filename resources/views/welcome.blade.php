<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Манай Дэлгүүр</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar {
            background-color: #7b858f;
        }
        .navbar-toggler-icon {
        background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba(255, 255, 255, 1)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .hero {
            background-image: url('{{asset('images/background_img1.jpg')}}');
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
            height: 500px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.7);
        }
        .hero h1 {
            font-size: 4rem;
        }
        .product-card {
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: scale(1.03);
        }
        .footer {
            background-color: #343a40;
            color: #fff;
            padding: 30px 0;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">Ecommerce</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon "></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Нүүр</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Бүтээгдэхүүн</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Холбоо барих</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Сагс</a></li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-3" href="{{ route('login') }}">Нэвтрэх</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- Hero section -->
    <section class="hero">
        <div class="text-center">
            <h1>Манай Онлайн Дэлгүүрт Тавтай Морил</h1>
            <p class="lead">Шинэ, шилдэг бүтээгдэхүүнүүдийг яг одоо аваарай!</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Онцлох бүтээгдэхүүнүүд</h2>
            <div class="row g-4">
                <!-- Product 1 -->
                <div class="col-md-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="https://source.unsplash.com/400x300/?shoes" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Спорт Гутал</h5>
                            <p class="card-text">Тав тухтай, загварлаг спорт гутал.</p>
                            <p class="text-primary fw-bold">₮120,000</p>
                            <a href="#" class="btn btn-outline-primary">Сагсанд хийх</a>
                        </div>
                    </div>
                </div>
                <!-- Product 2 -->
                <div class="col-md-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="https://source.unsplash.com/400x300/?watch" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Бугуйн цаг</h5>
                            <p class="card-text">Дээд зэрэглэлийн кварц бугуйн цаг.</p>
                            <p class="text-primary fw-bold">₮250,000</p>
                            <a href="#" class="btn btn-outline-primary">Сагсанд хийх</a>
                        </div>
                    </div>
                </div>
                <!-- Product 3 -->
                <div class="col-md-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="https://source.unsplash.com/400x300/?backpack" class="card-img-top" alt="Product">
                        <div class="card-body">
                            <h5 class="card-title">Үүргэвч</h5>
                            <p class="card-text">Ачаа даах чадал сайтай аяллын үүргэвч.</p>
                            <p class="text-primary fw-bold">₮95,000</p>
                            <a href="#" class="btn btn-outline-primary">Сагсанд хийх</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Ecommerce. Бүх эрх хуулиар хамгаалагдсан.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

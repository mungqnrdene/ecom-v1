<!DOCTYPE html>
<html lang="mn">
<head>
    <meta charset="UTF-8">
    <title>Админ Хуудас | Манай Дэлгүүр</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #2575fc;
        }

        .navbar-brand, .nav-link, .navbar-text {
            color: #fff !important;
        }

        .card {
            border-radius: 0.75rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .card-title {
            color: #2575fc;
            font-weight: 600;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Админ Хяналтын Самбар</a>
            <div class="d-flex">
                <span class="navbar-text me-3">
                    {{ Auth::guard('admin')->user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn logout-btn btn-sm">Гарах</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Dashboard content -->
    <div class="container mt-5">
        <h3 class="mb-4">Тавтай морил, {{ Auth::guard('admin')->user()->name }}!</h3>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4">
                    <h5 class="card-title">Хэрэглэгчид</h5>
                    <p class="card-text">Шинэ хэрэглэгч нэмэх, засах болон устгах.</p>
                    <a href="#" class="btn btn-primary">Удирдах</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4">
                    <h5 class="card-title">Захиалгууд</h5>
                    <p class="card-text">Ирсэн захиалгуудыг хянах болон статусаа өөрчлөх.</p>
                    <a href="#" class="btn btn-primary">Үзэх</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4">
                    <h5 class="card-title">Бараа бүтээгдэхүүн</h5>
                    <p class="card-text">Бараа нэмэх, устгах болон засварлах.</p>
                    <a href="#" class="btn btn-primary">Засах</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

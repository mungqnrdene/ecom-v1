<!DOCTYPE html>
<html lang="mn">

<head>
    <meta charset="UTF-8">
    <title>E-Commerce | User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #020617, #0f172a);
            color: #e5e7eb;
        }

        /* ================= HEADER ================= */
        .header {
            height: 70px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            z-index: 1000;
        }

        .logo {
            font-weight: 700;
            font-size: 20px;
        }

        /* HEADER RIGHT */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .icon-btn {
            position: relative;
            cursor: pointer;
            font-size: 18px;
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background: #ef4444;
            font-size: 10px;
        }

        /* AUTH BUTTONS */
        .auth-buttons {
            display: flex;
            gap: 12px;
        }

        .login-btn {
            padding: 10px 24px;
            border-radius: 999px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
        }

        .register-btn {
            padding: 10px 24px;
            border-radius: 999px;
            border: 2px solid transparent;
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .register-btn:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(34, 197, 94, 0.5);
        }

        /* ================= SIDEBAR (HIDDEN) ================= */
        .sidebar {
            display: none;
        }

        .sidebar a {
            display: block;
            padding: 12px 16px;
            margin-bottom: 6px;
            border-radius: 10px;
            color: #e5e7eb;
            text-decoration: none;
            font-size: 14px;
        }

        .sidebar a.active {
            background-color: #434343ff;
        }

        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.18);
        }

        /* ================= MAIN ================= */
        .main {
            margin-left: 0;
            margin-top: 70px;
            padding: 30px;
            max-width: 1400px;
            margin: 70px auto 0;
        }



        /* ================= HERO SECTION ================= */
        .hero-section {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(147, 51, 234, 0.2));
            border-radius: 28px;
            padding: 100px 40px;
            text-align: center;
            margin-bottom: 70px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .hero-section h1 {
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 25px;
            background: linear-gradient(135deg, #60a5fa, #a78bfa, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: fadeInDown 1s ease;
        }

        .hero-section p {
            font-size: 1.35rem;
            color: #d1d5db;
            max-width: 750px;
            margin: 0 auto;
            line-height: 1.8;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================= ABOUT SECTION ================= */
        .about-section {
            background: rgba(255, 255, 255, 0.06);
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 70px;
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .about-section h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            background: linear-gradient(135deg, #60a5fa, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .about-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #d1d5db;
        }

        /* ================= TECHNOLOGY STACK SECTION ================= */
        .tech-section {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.1), rgba(59, 130, 246, 0.1));
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 70px;
            border: 1px solid rgba(139, 92, 246, 0.2);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .tech-section h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 50px;
            text-align: center;
            background: linear-gradient(135deg, #a78bfa, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .tech-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }

        .tech-item {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 20px;
            padding: 30px 20px;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .tech-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(139, 92, 246, 0.4);
            border-color: rgba(139, 92, 246, 0.6);
            background: rgba(139, 92, 246, 0.15);
        }

        .tech-item i {
            font-size: 4rem;
            margin-bottom: 15px;
            display: block;
            transition: transform 0.3s ease;
        }

        .tech-item:hover i {
            transform: rotate(360deg);
        }

        .tech-item .tech-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #e5e7eb;
            margin: 0;
        }

        .fa-html5 {
            color: #e34c26;
        }

        .fa-css3-alt {
            color: #264de4;
        }

        .fa-js {
            color: #f0db4f;
        }

        .fa-php {
            color: #777bb4;
        }

        .fa-laravel {
            color: #ff2d20;
        }

        .fa-database {
            color: #00758f;
        }

        /* ================= CONTACT SECTION ================= */
        .contact-section {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(16, 185, 129, 0.15));
            border-radius: 28px;
            padding: 60px 50px;
            margin-bottom: 50px;
            border: 1px solid rgba(34, 197, 94, 0.25);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .contact-section h2 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 40px;
            text-align: center;
            background: linear-gradient(135deg, #34d399, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .contact-section a {
            color: #60a5fa;
            text-decoration: none;
            transition: all 0.2s;
        }

        .contact-section a:hover {
            color: #3b82f6;
            text-decoration: underline;
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-links {
            display: flex;
            gap: 25px;
            margin-top: 30px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .social-links a {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            font-size: 1.8rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .social-links a:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.5);
            border-color: #60a5fa;
            background: rgba(59, 130, 246, 0.2);
        }

        .social-links .fa-envelope {
            color: #ef4444;
        }

        .social-links .fa-x-twitter {
            color: #1da1f2;
        }

        .social-links .fa-facebook {
            color: #1877f2;
        }

        .social-links .fa-instagram {
            color: #e4405f;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #f3f4f6;
            font-size: 1.05rem;
        }

        .contact-text {
            color: #d1d5db;
            font-size: 1.05rem;
            margin-bottom: 0;
        }

        .map-container {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 30px;
        }

        .map-container iframe {
            width: 100%;
            height: 280px;
            border-radius: 12px;
            border: none;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .hero-section p {
                font-size: 1.1rem;
            }

            .about-section h2,
            .tech-section h2,
            .contact-section h2 {
                font-size: 2rem;
            }

            .tech-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }

            .tech-item i {
                font-size: 3rem;
            }

            .hero-section,
            .about-section,
            .tech-section,
            .contact-section {
                padding: 40px 25px;
            }

            .map-container iframe {
                height: 250px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <div class="logo">✨ Light Shop</div>



        <!-- GUEST: LOGIN / REGISTER BUTTONS -->
        @if (!Auth::guard('web')->check())
            <div class="auth-buttons">
                <a href="{{ route('users.login') }}" class="login-btn">Нэвтрэх</a>
                <a href="{{ route('users.register') }}" class="register-btn">Бүртгүүлэх</a>
            </div>
        @else
            <!-- LOGGED IN: PROFILE & LOGOUT -->
            <div class="d-flex align-items-center gap-2">
                <span class="text-light fw-bold">{{ Auth::guard('web')->user()->name }}</span>
                <form method="POST" action="{{ route('users.logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger">Гарах</button>
                </form>
            </div>
        @endif
    </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main">
        <!-- HERO SECTION -->
        <section class="hero-section">
            <h1>✨ Light Shop</h1>
        </section>

        <!-- ABOUT US SECTION -->
        <section class="about-section">
            <h2>📖 Бидний тухай</h2>
            <p class="mb-4">
                Light Shop нь орчин үеийн технологид суурилсан онлайн худалдааны вэбсайт юм.
                Бид хэрэглэгчдэд хялбар, найдвартай, аюулгүй онлайн худалдааны туршлага санал болгодог.
            </p>
            <p class="mb-0">
                Манай систем нь Laravel framework дээр бүтээгдсэн бөгөөд хэрэглэгчид бараа үзэх, хадгалах,
                захиалах, төлбөр төлөх зэрэг бүх үйлдлийг хялбараар гүйцэтгэх боломжтой.
            </p>
        </section>

        <!-- TECHNOLOGY STACK SECTION -->
        <section class="tech-section">
            <h2>⚙️ Ашигласан технологи</h2>
            <div class="tech-grid">
                <div class="tech-item">
                    <i class="fab fa-html5"></i>
                    <p class="tech-name">HTML5</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-css3-alt"></i>
                    <p class="tech-name">CSS3</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-js"></i>
                    <p class="tech-name">JavaScript</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-php"></i>
                    <p class="tech-name">PHP</p>
                </div>
                <div class="tech-item">
                    <i class="fab fa-laravel"></i>
                    <p class="tech-name">Laravel</p>
                </div>
                <div class="tech-item">
                    <i class="fas fa-database"></i>
                    <p class="tech-name">MySQL</p>
                </div>
            </div>
        </section>

        <!-- CONTACT SECTION -->
        <section class="contact-section" id="contact">
            <h2>📞 Холбоо барих</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="contact-info">
                        <p class="section-title"><i class="fas fa-envelope me-2"></i>Имэйл</p>
                        <p class="contact-text">
                            <a href="mailto:mongoldei0212@gmail.com">mongoldei0212@gmail.com</a>
                        </p>

                        <p class="section-title mt-4"><i class="fas fa-phone me-2"></i>Утас</p>
                        <p class="contact-text">
                            <a href="tel:+97695297999">+976 9529 7999</a>
                        </p>

                        <p class="section-title mt-4"><i class="fas fa-map-marker-alt me-2"></i>Хаяг</p>
                        <p class="contact-text">Улаанбаатар, Сүхбаатар дүүрэг, 1-р хороо, ЮНЕСКО-гийн гудамж C-Блок</p>

                        <p class="section-title mt-4"><i class="fas fa-clock me-2"></i>Ажлын цаг</p>
                        <p class="contact-text mb-0">Даваа - Баасан: 09:00 - 18:00</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="contact-info text-center">
                        <p class="section-title"><i class="fas fa-share-alt me-2"></i>Интернет хаягууд</p>
                        <div class="social-links">
                            <a href="mailto:mongoldei0212@gmail.com" title="Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                            <a href="https://x.com/mungunrs?s=21" target="_blank" rel="noopener" title="Twitter / X">
                                <i class="fab fa-x-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/share/1FoBAfhNLL/?mibextid=wwXIfr" target="_blank"
                                rel="noopener" title="Facebook">
                                <i class="fab fa-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/_mungqn_erdene?igsh=MW1oYWpteHFyNHc3MA%3D%3D&utm_source=qr"
                                target="_blank" rel="noopener" title="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </div>
                    </div>
                    <!-- GOOGLE MAP -->
                    <div class="row mt-0">
                        <div class="col-12">
                            <div class="map-container">
                                <p class="section-title text-center mb-3">
                                    <i class="fas fa-map-marked-alt me-2"></i>Манай байршил
                                </p>
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2900.7628324966427!2d106.92761217647187!3d47.90904976704308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x5d9693d56738aaa1%3A0x30b065f0d3ca97e5!2sM%20Smart%20Academy!5e1!3m2!1sen!2smn!4v1767289859757!5m2!1sen!2smn"
                                    width="100%" height="360"
                                    style="border:0; border-radius:16px; box-shadow:0 12px 30px rgba(0,0,0,.25);"
                                    allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </div>

</body>

</html>

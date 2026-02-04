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

        /* Social Icons Styling */
        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-icon {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e5e7eb;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .social-icon::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, transparent, rgba(255, 255, 255, 0.1));
            opacity: 0;
            transition: opacity 0.4s;
        }

        .social-icon:hover::before {
            opacity: 1;
        }

        .social-icon i {
            font-size: 1.5rem;
            z-index: 1;
            transition: all 0.4s;
        }

        /* Email Icon */
        .social-icon.email:hover {
            background: linear-gradient(135deg, #ea4335, #c5221f);
            border-color: #ea4335;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 30px rgba(234, 67, 53, 0.4);
        }

        .social-icon.email:hover i {
            color: white;
            transform: rotateY(360deg);
        }

        /* Twitter/X Icon */
        .social-icon.twitter:hover {
            background: linear-gradient(135deg, #000000, #1a1a1a);
            border-color: #000000;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        }

        .social-icon.twitter:hover i {
            color: white;
            transform: rotateY(360deg);
        }

        /* Facebook Icon */
        .social-icon.facebook:hover {
            background: linear-gradient(135deg, #1877f2, #0d5dbf);
            border-color: #1877f2;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 30px rgba(24, 119, 242, 0.4);
        }

        .social-icon.facebook:hover i {
            color: white;
            transform: rotateY(360deg);
        }

        /* Instagram Icon */
        .social-icon.instagram:hover {
            background: linear-gradient(135deg, #833ab4, #fd1d1d, #fcb045);
            border-color: #833ab4;
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 30px rgba(131, 58, 180, 0.4);
        }

        .social-icon.instagram:hover i {
            color: white;
            transform: rotateY(360deg);
        }

        /* Pulse animation on hover */
        @keyframes pulse {

            0%,
            100% {
                transform: translateY(-5px) scale(1.05);
            }

            50% {
                transform: translateY(-7px) scale(1.08);
            }
        }

        .social-icon:hover {
            animation: pulse 2s ease-in-out infinite;
        }

        /* Remove animation on specific hover for rotation effect */
        .social-icon:active {
            animation: none;
            transform: translateY(-2px) scale(0.98);
        }
    </style>
@endpush

<h2 class="mb-4">📞 Холбоо барих</h2>

<div class="row g-4">
    <div class="col-md-5">
        <div class="contact-card">
            <h5 class="mb-3">Холбогдох мэдээлэл</h5>
            <p class="mb-1 contact-label">📧 Имэйл</p>
            <p class="text-muted">
                <a href="mailto:mongoldei0212@gmail.mn" class="text-decoration-none text-info">mongoldei0212@gmail.mn</a>
            </p>
            <p class="mb-1 contact-label">📱 Утас</p>
            <p class="text-muted">
                <a href="tel:+97695297999" class="text-decoration-none text-info">+976 9529 7999</a>
            </p>
            <p class="mb-1 contact-label">📍 Хаяг</p>
            <p class="text-muted">Улаанбаатар, Монгол</p>
            <p class="mb-1 contact-label">🕐 Ажлын цаг</p>
            <p class="text-muted">Даваа - Баасан: 09:00 - 18:00</p>
            <p class="mb-1 contact-label">Сошиал холбоос:</p>

            <ul class="social-links mb-0 list-unstyled">
                <li>
                    <a href="mailto:mongoldei0212@gmail.mn" class="social-icon email" title="Имэйл">
                        <i class="fa-solid fa-envelope"></i>
                    </a>
                </li>

                <li>
                    <a href="https://x.com/mungunrs?s=21" target="_blank" class="social-icon twitter" title="Twitter/X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                </li>

                <li>
                    <a href="https://www.facebook.com/share/1FoBAfhNLL/?mibextid=wwXIfr" target="_blank"
                        class="social-icon facebook" title="Facebook">
                        <i class="fa-brands fa-facebook"></i>
                    </a>
                </li>

                <li>
                    <a href="https://www.instagram.com/_mungqn_erdene?igsh=MW1oYWpteHFyNHc3MA%3D%3D&utm_source=qr"
                        target="_blank" class="social-icon instagram" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
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

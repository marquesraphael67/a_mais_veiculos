<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+ Veículos - @yield('title', 'Início')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        :root {
            --primary: #0f172a;
            --secondary: #1e3c72;
            --accent: #dc3545;
            --light: #f5f7fb;
            --text: #111827;
            --muted: #6b7280;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            color: var(--text);
        }

        a { text-decoration: none; }

        .site-header {
            background: rgba(15, 23, 42, .96);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 10px 30px rgba(0,0,0,.12);
        }

        .navbar { padding: 16px 0; }

        .navbar-brand {
            color: white !important;
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -.5px;
        }

        .navbar-brand span { color: var(--accent); }

        .logo-img {
            height: 52px;
            object-fit: contain;
        }

        .navbar-toggler {
            border: 1px solid rgba(255,255,255,.25);
        }

        .navbar-toggler:focus { box-shadow: none; }

        .navbar-toggler-icon { filter: invert(1); }

        .nav-link {
            color: rgba(255,255,255,.82) !important;
            font-weight: 600;
            margin-left: 14px;
            transition: .2s;
        }

        .nav-link:hover { color: white !important; }

        .btn-header {
            background: var(--accent);
            color: white !important;
            padding: 10px 18px;
            border-radius: 999px;
            margin-left: 18px;
            font-weight: 700;
            transition: .2s;
        }

        .btn-header:hover {
            background: #b91c1c;
            transform: translateY(-2px);
        }

        .hero {
            position: relative;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(15,23,42,.92), rgba(30, 59, 114, 0.34)),
                url('images/racing.jpg') no-repeat center center;
            background-size: cover;
            background-position: center;
            color: white;
            padding: 95px 0 110px;
        }

        

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 760px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.18);
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 64px);
            font-weight: 900;
            line-height: 1.05;
            margin-bottom: 18px;
        }

        .hero p {
            font-size: 19px;
            color: rgba(255,255,255,.82);
            max-width: 620px;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-main {
            background: var(--accent);
            color: white;
            border-radius: 999px;
            padding: 13px 24px;
            font-weight: 800;
            transition: .2s;
        }

        .btn-main:hover {
            background: #b91c1c;
            color: white;
            transform: translateY(-2px);
        }

        .btn-outline-main {
            border: 1px solid rgba(255,255,255,.35);
            color: white;
            border-radius: 999px;
            padding: 13px 24px;
            font-weight: 800;
            transition: .2s;
        }

        .btn-outline-main:hover {
            background: white;
            color: var(--primary);
        }

        main { min-height: 55vh; }

        .footer {
            background: var(--primary);
            color: white;
            padding: 60px 0 25px;
            margin-top: 70px;
        }

        .footer h4,
        .footer h5 {
            font-weight: 900;
        }

        .footer p {
            color: rgba(255,255,255,.72);
        }

        .footer a {
            color: rgba(255,255,255,.86);
            transition: .2s;
        }

        .footer a:hover {
            color: white;
        }

        .footer-info-item {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            color: rgba(255,255,255,.78);
        }

        .footer-info-item i {
            color: var(--accent);
            margin-top: 4px;
            width: 18px;
        }

        .social-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .social-btn:hover {
            background: var(--accent);
        }

        .map-card {
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 22px;
            padding: 12px;
        }

        .map-card iframe {
            width: 100%;
            height: 250px;
            border: 0;
            border-radius: 16px;
        }

        .btn-map {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            background: var(--accent);
            color: white !important;
            border-radius: 999px;
            padding: 12px 18px;
            font-weight: 900;
            width: 100%;
            margin-top: 12px;
        }

        .btn-map:hover {
            background: #b91c1c;
        }

        .whatsapp-float {
            position: fixed;
            right: 22px;
            bottom: 22px;
            width: 58px;
            height: 58px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            z-index: 999;
            box-shadow: 0 12px 30px rgba(37,211,102,.35);
        }

        .whatsapp-float:hover {
            color: white;
            transform: scale(1.05);
        }

        @media (max-width: 991px) {
            .btn-header {
                margin-left: 0;
                margin-top: 10px;
                display: inline-block;
            }

            .nav-link {
                margin-left: 0;
                padding: 10px 0;
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 70px 0 85px;
            }

            .hero p {
                font-size: 16px;
            }

            .footer {
                text-align: left;
            }

            .map-card iframe {
                height: 230px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
<header class="site-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="A+ Veículos" class="logo-img">
                @else
                    A+<span>Veículos</span>
                @endif
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Início</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#veiculos">Veículos</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contato">Contato</a>
                    </li>

                    <li class="nav-item">
                        <a class="btn-header" href="https://wa.me/5518996737473" target="_blank">
                            <i class="fab fa-whatsapp me-1"></i> WhatsApp
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

@if(request()->routeIs('home'))
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-shield-alt"></i>
                    Seminovos selecionados
                </div>

                <h1>Encontre o veículo ideal para você</h1>

                <p>
                    Carros, motos e veículos selecionados com qualidade, transparência
                    e atendimento profissional.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('home') }}#veiculos" class="btn-main">
                        Ver veículos
                    </a>

                    <a href="https://wa.me/5518996737473" target="_blank" class="btn-outline-main">
                        Falar com vendedor
                    </a>
                </div>
            </div>
        </div>
    </section>
@endif

<main>
    @yield('content')
</main>

<footer class="footer" id="contato">
    <div class="container">
        <div class="row g-4 align-items-start">
            <div class="col-lg-4">
                <h4 class="mb-3">A+<span style="color:#dc3545">Veículos</span></h4>
                <p>
                    Loja especializada em veículos seminovos, com atendimento rápido,
                    negociação transparente e veículos selecionados.
                </p>

                <div class="d-flex gap-2 mt-3">
                    <a href="https://www.facebook.com/profile.php?id=61578578399359&sk=photos&locale=pt_BR" class="social-btn" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>

                    <a href="https://www.instagram.com/amaisveiculos/" class="social-btn" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>

                    <a href="https://wa.me/5518996737473" target="_blank" class="social-btn">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <h5 class="mb-3">Atendimento</h5>

                <div class="footer-info-item">
                    <i class="fas fa-phone"></i>
                    <span>(18) 99673-7473</span>
                </div>

                <div class="footer-info-item">
                    <i class="fas fa-envelope"></i>
                    <span>contato@amaisveiculos.com</span>
                </div>

                <div class="footer-info-item">
                    <i class="fas fa-clock"></i>
                    <span>Segunda a sábado • 08h às 18h</span>
                </div>

                <div class="footer-info-item">
                    <i class="fas fa-location-dot"></i>
                    <span>Av. Tibiriçá, 995<br>Presidente Epitácio - SP</span>
                </div>
            </div>

            <div class="col-lg-4">
                <h5 class="mb-3">Nossa localização</h5>

                <div class="map-card">
                    <iframe
                        src="https://www.google.com/maps?q=995%20Av.%20Tibiri%C3%A7%C3%A1,%20Presidente%20Epit%C3%A1cio,%20SP&output=embed"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <a href="https://www.google.com/maps/search/?api=1&query=995%20Av.%20Tibiri%C3%A7%C3%A1%20Presidente%20Epit%C3%A1cio%20SP"
                       target="_blank"
                       class="btn-map">
                        <i class="fas fa-location-arrow"></i>
                        Como chegar
                    </a>
                </div>
            </div>
        </div>

        <div class="text-center pt-4 mt-4 border-top border-secondary">
            <p class="mb-0">&copy; {{ date('Y') }} A+ Veículos - Todos os direitos reservados.</p>
        </div>
    </div>
</footer>

<a href="https://wa.me/5518996737473" target="_blank" class="whatsapp-float">
    <i class="fab fa-whatsapp"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
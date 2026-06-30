<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>A+ Veículos Admin - @yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow-x: hidden;
            max-width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fb;
        }

        .container,
        .main-content,
        .dashboard-container {
            overflow-x: hidden;
            max-width: 100%;
        }

        .top-nav {
            background: linear-gradient(135deg, #111827 0%, #1e3c72 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .logo h2 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 800;
        }

        .logo span {
            color: #ff4444;
            font-weight: 900;
        }

        .logo small {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .nav-links {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            transition: all 0.25s ease;
            display: block;
            font-weight: 600;
        }

        .nav-links li a:hover {
            background: rgba(255,255,255,0.12);
            transform: translateY(-2px);
        }

        .nav-links li a.active {
            background: #ff4444;
            box-shadow: 0 8px 18px rgba(255,68,68,0.25);
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            width: 100%;
            text-align: left;
            padding: 0.6rem 1rem;
            border-radius: 10px;
            transition: all 0.25s ease;
            cursor: pointer;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,0.12);
            transform: translateY(-2px);
        }

        .hamburger {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            padding: 0.5rem;
        }

        .main-content {
            min-height: calc(100vh - 70px);
            padding: 2rem;
        }

        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border-left-color: #dc3545;
        }

        @media (max-width: 768px) {
            .top-nav {
                padding: 0.8rem 1rem;
            }

            .hamburger {
                display: block;
            }

            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 0;
                margin-top: 1rem;
            }

            .nav-links.show {
                display: flex;
            }

            .nav-links li {
                width: 100%;
            }

            .nav-links li a,
            .logout-btn {
                padding: 0.85rem 1rem;
                text-align: center;
            }

            .main-content {
                padding: 1rem;
            }

            .btn,
            button {
                min-height: 44px;
                min-width: 44px;
            }
        }

        @media (max-width: 480px) {
            .logo h2 {
                font-size: 1.2rem;
            }

            .logo small {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

<nav class="top-nav">
    <div class="logo">
        <h2>A+<span>Veículos</span> <small>Admin</small></h2>
    </div>

    <button class="hamburger" id="hamburgerBtn">☰</button>

    <ul class="nav-links" id="navLinks">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin.veiculos.index') }}" class="{{ request()->routeIs('admin.veiculos.*') && !request()->routeIs('admin.veiculos.create') && !request()->routeIs('admin.veiculos.observacoes') ? 'active' : '' }}">
                <i class="fas fa-car me-2"></i> Veículos
            </a>
        </li>

        <li>
            <a href="{{ route('admin.veiculos.create') }}" class="{{ request()->routeIs('admin.veiculos.create') ? 'active' : '' }}">
                <i class="fas fa-plus me-2"></i> Novo Veículo
            </a>
        </li>

        <li>
            <a href="{{ route('admin.veiculos.observacoes') }}" class="{{ request()->routeIs('admin.veiculos.observacoes') ? 'active' : '' }}">
                <i class="fas fa-lock me-2"></i> Obs. Internas
            </a>
        </li>

        <li>
            <a href="{{ route('admin.marcas.index') }}" class="{{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
                <i class="fas fa-trademark me-2"></i> Marcas
            </a>
        </li>

        <li>
            <form method="POST" action="{{ route('admin.logout') }}" id="logoutForm">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt me-2"></i> Sair
                </button>
            </form>
        </li>
    </ul>
</nav>

<main class="main-content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const hamburger = document.getElementById('hamburgerBtn');
    const navLinks = document.getElementById('navLinks');

    if (hamburger && navLinks) {
        hamburger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            navLinks.classList.toggle('show');
        });

        document.querySelectorAll('.nav-links li a, .logout-btn').forEach(link => {
            link.addEventListener('click', function () {
                if (window.innerWidth <= 768) {
                    setTimeout(() => {
                        navLinks.classList.remove('show');
                    }, 100);
                }
            });
        });

        document.addEventListener('click', function (event) {
            if (window.innerWidth <= 768) {
                const isClickInsideNav = navLinks.contains(event.target);
                const isClickOnHamburger = hamburger.contains(event.target);

                if (!isClickInsideNav && !isClickOnHamburger && navLinks.classList.contains('show')) {
                    navLinks.classList.remove('show');
                }
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 768) {
                navLinks.classList.remove('show');
            }
        });
    }

    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});
</script>

@stack('scripts')
</body>
</html>
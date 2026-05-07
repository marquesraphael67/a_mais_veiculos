<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+ Veículos - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        
        /* Header profissional */
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }
        
        .navbar {
            padding: 20px 0;
        }
        
        .navbar-brand {
            font-size: 28px;
            font-weight: bold;
            color: white !important;
        }
        
        .navbar-brand span {
            color: #dc3545;
        }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            transition: 0.3s;
        }
        
        .nav-link:hover {
            color: #dc3545 !important;
        }
        
        /* Hero section */
        .hero {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 80px 0;
            text-align: center;
        }
        
        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        
        .hero p {
            font-size: 20px;
            opacity: 0.9;
        }
        
        /* Filtros */
        .filtros-section {
            background: white;
            padding: 40px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .filtro-card {
            background: white;
            border-radius: 10px;
        }
        
        .btn-filtrar {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            transition: 0.3s;
        }
        
        .btn-filtrar:hover {
            background: #c82333;
            transform: translateY(-2px);
        }
        
        .btn-limpar {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            transition: 0.3s;
        }
        
        .btn-limpar:hover {
            background: #5a6268;
        }
        
        /* Cards de veículos */
        .veiculos-section {
            padding: 60px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 50px;
            color: #1e3c72;
            font-weight: bold;
        }
        
        .card-veiculo {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 30px;
            cursor: pointer;
        }
        
        .card-veiculo:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .card-img {
            height: 220px;
            object-fit: cover;
            width: 100%;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-size: 20px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 10px;
        }
        
        .card-marca {
            color: #dc3545;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .card-detalhes {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
            color: #666;
        }
        
        .card-preco {
            font-size: 24px;
            font-weight: bold;
            color: #dc3545;
            margin-bottom: 15px;
        }
        
        .btn-detalhes {
            background: #1e3c72;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            width: 100%;
            transition: 0.3s;
        }
        
        .btn-detalhes:hover {
            background: #2a5298;
        }
        
        .badge-status {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #dc3545;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            background: #1e3c72;
            color: white;
            padding: 40px 0;
            margin-top: 60px;
        }
        
        .footer a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        
        .footer a:hover {
            color: #dc3545;
        }
        
        /* Responsivo */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 32px;
            }
            .hero p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid px-0">
                    <!-- LOGO - Mude aqui para colocar sua imagem -->
                    <a class="navbar-brand" href="/">
                        @if(file_exists(public_path('images/logo.png')))
                            <img src="{{ asset('images/logo.png') }}" alt="A+ Veículos" style="height: 50px;">
                        @else
                            A+<span>Veículos</span>
                        @endif
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#veiculos">Veículos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contato">Contato</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Encontre o Veículo dos Seus Sonhos</h1>
            <p>As melhores ofertas em carros seminovos de qualidade</p>
        </div>
    </section>
    
    <!-- Main Content -->
    <main>
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer" id="contato">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h4>A+<span style="color:#dc3545">Veículos</span></h4>
                    <p>Excelência em venda de veículos seminovos com garantia de qualidade.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4>Contato</h4>
                    <p>
                        <i class="fas fa-phone me-2"></i> (11) 99999-9999<br>
                        <i class="fas fa-envelope me-2"></i> contato@amaisveiculos.com<br>
                        <i class="fas fa-map-marker-alt me-2"></i> São Paulo - SP
                    </p>
                </div>
                <div class="col-md-4 mb-4">
                    <h4>Redes Sociais</h4>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-whatsapp fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center pt-4 border-top border-secondary">
                <p>&copy; 2024 A+ Veículos - Todos os direitos reservados</p>
            </div>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
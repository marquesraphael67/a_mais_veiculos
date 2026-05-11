<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>A+ Veículos Admin - @yield('title', 'Dashboard')</title>
    
    <!-- Bootstrap 5 -->
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
            background: #f5f5f5;
            overflow-x: hidden;
        }

        /* ========== IMPEDIR ARRASTE LATERAL NO CELULAR ========== */
        html, body {
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            max-width: 100%;
        }

        .container, .main-content, .dashboard-container {
            overflow-x: hidden;
            max-width: 100%;
        }

        /* ========== NAVBAR TOPO COM ANIMAÇÃO ========== */
        .top-nav {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .logo h2 {
            font-size: 1.5rem;
            margin: 0;
            transition: transform 0.3s ease;
        }

        .logo h2:hover {
            transform: scale(1.05);
        }

        /* LOGO - VERMELHO */
        .logo span {
            font-size: 0.75rem;
            color: #ff4444;
            font-weight: bold;
            text-shadow: 0 0 2px rgba(0,0,0,0.3);
        }

        .logo small {
            font-size: 0.7rem;
            opacity: 0.8;
        }

        /* Menu Desktop */
        .nav-links {
            display: flex;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: block;
            position: relative;
        }

        /* Efeito de underline animado */
        .nav-links li a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #ff4444;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-links li a:hover::after {
            width: 70%;
        }

        .nav-links li a:hover {
            background: rgba(255, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        .nav-links li a.active {
            background: #ff4444;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .nav-links li a.active::after {
            width: 70%;
            background: white;
        }

        /* Botão de logout */
        .logout-btn {
            background: none;
            border: none;
            color: white;
            width: 100%;
            text-align: left;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: rgba(255, 68, 68, 0.2);
            transform: translateY(-2px);
        }

        /* Botão Hambúrguer */
        .hamburger {
            display: none;
            font-size: 1.8rem;
            cursor: pointer;
            background: none;
            border: none;
            color: white;
            padding: 0.5rem;
            transition: transform 0.3s ease;
        }

        .hamburger:hover {
            transform: scale(1.1);
        }

        /* ========== CONTEÚDO PRINCIPAL ========== */
        .main-content {
            min-height: calc(100vh - 70px);
            padding: 2rem;
        }

        /* ========== ALERTS ========== */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            border-left: 4px solid;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        /* Preview de imagens */
        .image-preview {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .preview-item {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            background: #f5f5f5;
            border: 2px solid #e0e0e0;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-item small {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.6);
            color: white;
            font-size: 10px;
            text-align: center;
            padding: 2px;
        }

        /* ========== RESPONSIVIDADE ========== */
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
                animation: fadeIn 0.3s ease-out;
            }
            
            .nav-links.show {
                display: flex;
            }
            
            .nav-links li {
                width: 100%;
            }
            
            .nav-links li a,
            .logout-btn {
                padding: 0.8rem 1rem;
                text-align: center;
            }
            
            .nav-links li a::after {
                display: none;
            }
            
            .main-content {
                padding: 1rem;
            }
            
            .btn, button {
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

<!-- ========== NAVBAR TOPO COM HAMBÚRGUER ========== -->
<nav class="top-nav">
    <div class="logo">
        <h2>A+<span>Veículos</span> <small>Admin</small></h2>
    </div>
    <button class="hamburger" id="hamburgerBtn">☰</button>
    <ul class="nav-links" id="navLinks">
        <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a></li>
        <li><a href="{{ route('admin.veiculos.index') }}" class="{{ request()->routeIs('admin.veiculos.*') && !request()->routeIs('admin.veiculos.create') && !request()->routeIs('admin.veiculos.observacoes') ? 'active' : '' }}">
            <i class="fas fa-car me-2"></i> Veículos
        </a></li>
        <li><a href="{{ route('admin.veiculos.create') }}">
            <i class="fas fa-plus me-2"></i> Novo Veículo
        </a></li>
        <li><a href="{{ route('admin.veiculos.observacoes') }}" class="{{ request()->routeIs('admin.veiculos.observacoes') ? 'active' : '' }}">
            <i class="fas fa-lock me-2"></i> Obs. Internas
        </a></li>
        <li><a href="{{ route('admin.marcas.index') }}" class="{{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
            <i class="fas fa-trademark me-2"></i> Marcas
        </a></li>
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

<!-- ========== CONTEÚDO PRINCIPAL ========== -->
<main class="main-content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    
    @yield('content')
</main>

<!-- ========== SCRIPTS ========== -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ========== MENU HAMBÚRGUER ==========
    const hamburger = document.getElementById('hamburgerBtn');
    const navLinks = document.getElementById('navLinks');
    
    if (hamburger) {
        hamburger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            navLinks.classList.toggle('show');
        });
    }
    
    // Fechar menu ao clicar em um link
    const links = document.querySelectorAll('.nav-links li a, .logout-btn');
    links.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                setTimeout(() => {
                    navLinks.classList.remove('show');
                }, 100);
            }
        });
    });
    
    // Fechar menu ao clicar fora
    document.addEventListener('click', function(event) {
        if (window.innerWidth <= 768) {
            const isClickInsideNav = navLinks?.contains(event.target);
            const isClickOnHamburger = hamburger?.contains(event.target);
            
            if (!isClickInsideNav && !isClickOnHamburger && navLinks?.classList.contains('show')) {
                navLinks.classList.remove('show');
            }
        }
    });
    
    // Fechar menu ao redimensionar
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768 && navLinks) {
            navLinks.classList.remove('show');
        }
    });
    
    // Auto-fechar alerts
    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // ========== COMPRESSÃO DE IMAGENS ==========
    async function compressImage(file, maxWidth = 1200, quality = 0.85) {
        return new Promise((resolve) => {
            if (!file.type.startsWith('image/')) {
                resolve(file);
                return;
            }
            
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = (e) => {
                const img = new Image();
                img.src = e.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;
                    
                    if (width > maxWidth) {
                        height = (height * maxWidth) / width;
                        width = maxWidth;
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    canvas.toBlob((blob) => {
                        const compressedFile = new File([blob], file.name.replace(/\.[^/.]+$/, '.jpg'), {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    }, 'image/jpeg', quality);
                };
                img.onerror = () => resolve(file);
            };
            reader.onerror = () => resolve(file);
        });
    }
    
    // Preview de imagens
    document.addEventListener('DOMContentLoaded', function() {
        const fotoInput = document.getElementById('fotos_input');
        if (fotoInput) {
            fotoInput.addEventListener('change', async function(e) {
                const previewDiv = document.getElementById('preview_imagens');
                if (!previewDiv) return;
                
                previewDiv.innerHTML = '<div class="text-muted">📸 Processando imagens...</div>';
                
                const files = Array.from(this.files);
                if (files.length === 0) {
                    previewDiv.innerHTML = '';
                    return;
                }
                
                const dataTransfer = new DataTransfer();
                
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    let processedFile = file;
                    
                    if (file.type.startsWith('image/')) {
                        processedFile = await compressImage(file);
                    }
                    
                    dataTransfer.items.add(processedFile);
                }
                
                this.files = dataTransfer.files;
                
                previewDiv.innerHTML = '';
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `<img src="${e.target.result}" alt="preview"><small>${(file.size / 1024).toFixed(0)}KB</small>`;
                        previewDiv.appendChild(div);
                    };
                }
            });
        }
        
        const destaqueInput = document.getElementById('imagem_destaque');
        if (destaqueInput) {
            destaqueInput.addEventListener('change', function(e) {
                const previewDiv = document.getElementById('preview_destaque');
                if (!previewDiv) return;
                
                previewDiv.innerHTML = '';
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'preview-item';
                        div.innerHTML = `<img src="${e.target.result}" alt="preview">`;
                        previewDiv.appendChild(div);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // FUNÇÃO PARA TIPO DE VEÍCULO
        const tipoSelect = document.getElementById('tipo_veiculo');
        if (tipoSelect) {
            function toggleCamposPorTipo() {
                const tipo = tipoSelect.value;
                const campoKm = document.getElementById('campo_km');
                const campoHoras = document.getElementById('campo_horas');
                const campoPortas = document.getElementById('campo_portas');
                
                if (campoKm) campoKm.style.display = 'none';
                if (campoHoras) campoHoras.style.display = 'none';
                if (campoPortas) campoPortas.style.display = 'flex';
                
                if (tipo === 'carro') {
                    if (campoKm) campoKm.style.display = 'flex';
                    if (campoPortas) campoPortas.style.display = 'flex';
                } 
                else if (tipo === 'moto' || tipo === 'caminhao') {
                    if (campoKm) campoKm.style.display = 'flex';
                    if (campoPortas) campoPortas.style.display = 'none';
                }
                else if (tipo === 'jetski' || tipo === 'lancha') {
                    if (campoHoras) campoHoras.style.display = 'flex';
                    if (campoPortas) campoPortas.style.display = 'none';
                }
            }
            
            tipoSelect.addEventListener('change', toggleCamposPorTipo);
            toggleCamposPorTipo();
        }
    });
</script>

@stack('scripts')
</body>
</html>
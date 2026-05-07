<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+ Veículos Admin - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sidebar {
            background: #1e3c72;
            min-height: 100vh;
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: #dc3545;
            padding-left: 30px;
        }
        .sidebar .active {
            background: #dc3545;
        }
        .navbar-top {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: #1e3c72;
            border: none;
        }
        .btn-danger {
            background: #dc3545;
        }
        .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-collapse: collapse;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.075);
}

.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}

.table td, .table th {
    padding: 12px;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.text-end {
    text-align: right;
}

.text-center {
    text-align: center;
}

.align-middle {
    vertical-align: middle;
}

.badge {
    display: inline-block;
    padding: 0.35em 0.65em;
    font-size: 0.75em;
    font-weight: 700;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.375rem;
}

.bg-success {
    background-color: #198754;
    color: white;
}

.bg-danger {
    background-color: #dc3545;
    color: white;
}

.bg-info {
    background-color: #0dcaf0;
    color: #000;
}

.table-dark {
    --bs-table-bg: #1e3c72;
    color: white;
    border-color: #2a5298;
}
/* Garantir que a tabela fique enfileirada */
.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    width: 100%;
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
    border-collapse: collapse;
    display: table !important;
}

.table thead {
    display: table-header-group;
}

.table tbody {
    display: table-row-group;
}

.table tr {
    display: table-row !important;
}

.table td, .table th {
    display: table-cell !important;
    padding: 12px;
    vertical-align: middle;
    border-top: 1px solid #dee2e6;
}

.table-bordered {
    border: 1px solid #dee2e6;
}

.table-bordered td, 
.table-bordered th {
    border: 1px solid #dee2e6;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.075);
}

.table-dark {
    background-color: #1e3c72;
    color: white;
}

.table-dark th {
    background-color: #1e3c72;
    color: white;
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 p-0 sidebar">
                <div class="text-center py-4">
                    <h4>A+<span style="color:#dc3545">Veículos</span></h4>
                    <small>Administração</small>
                </div>
                <nav>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.veiculos.index') }}" class="{{ request()->routeIs('admin.veiculos.*') ? 'active' : '' }}">
                        <i class="fas fa-car me-2"></i> Veículos
                    </a>
                    <a href="{{ route('admin.veiculos.create') }}">
                        <i class="fas fa-plus me-2"></i> Novo Veículo
                    </a>
                    <a href="{{ route('admin.marcas.index') }}" class="{{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
                        <i class="fas fa-trademark me-2"></i> Marcas
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="mt-5">
                        @csrf
                        <button type="submit" class="btn btn-link text-white" style="text-decoration: none; width: 100%; text-align: left; padding: 12px 20px;">
                            <i class="fas fa-sign-out-alt me-2"></i> Sair
                        </button>
                    </form>
                </nav>
            </div>
            
            <div class="col-md-10 p-0">
                <div class="navbar-top p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">@yield('header')</h5>
                        <div>
                            <span class="me-3">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="p-4">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
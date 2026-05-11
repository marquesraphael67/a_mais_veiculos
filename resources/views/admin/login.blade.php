<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>A+ Veículos - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-logo h2 {
            color: #1e3c72;
            font-weight: 700;
            font-size: 28px;
        }
        
        .login-logo span {
            color: #dc3545;
        }
        
        .login-logo p {
            color: #6c757d;
            margin-top: 5px;
        }
        
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #ddd;
            font-size: 16px;
        }
        
        .form-control:focus {
            border-color: #1e3c72;
            box-shadow: 0 0 0 3px rgba(30,60,114,0.1);
            outline: none;
        }
        
        .btn-login {
            background: #1e3c72;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            width: 100%;
            font-size: 16px;
            color: white;
            cursor: pointer;
        }
        
        .btn-login:hover {
            background: #2a5298;
        }
        
        .btn-login:active {
            transform: scale(0.98);
        }
        
        .alert {
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 30px 20px;
            }
            
            .btn-login {
                padding: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <h2>A+<span>Veículos</span></h2>
            <p>Área Administrativa</p>
        </div>
        
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle me-2"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.auth') }}">
            @csrf
            
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt me-2"></i> Entrar
            </button>
        </form>
    </div>
</body>
</html>
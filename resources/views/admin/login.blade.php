<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A+ Veículos - Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
            color: #1e3c72;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-login {
            background: #dc3545;
            border: none;
            width: 100%;
            padding: 12px;
        }
        .btn-login:hover {
            background: #c82333;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo h1 {
            color: #1e3c72;
            font-weight: bold;
        }
        .logo span {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">
            <h1>A+<span>Veículos</span></h1>
            <p>Área Administrativa</p>
        </div>
        
        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="/admin/auth">
            @csrf
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login text-white">Entrar</button>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>A+ Veículos | Área Administrativa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;

            background:
            linear-gradient(rgba(15,23,42,.88),rgba(30,60,114,.88)),
            url('https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1600&q=80');

            background-size:cover;
            background-position:center;

            font-family:'Segoe UI',sans-serif;
        }

        .login-card{

            width:100%;
            max-width:430px;

            background:#FFF;

            border-radius:25px;

            padding:40px;

            box-shadow:0 25px 60px rgba(0,0,0,.30);

            animation:fade .5s;

        }

        @keyframes fade{

            from{

                opacity:0;
                transform:translateY(20px);

            }

            to{

                opacity:1;
                transform:translateY(0);

            }

        }

        .logo{

            text-align:center;

            margin-bottom:35px;

        }

        .logo img{

            max-height:70px;

            margin-bottom:15px;

        }

        .logo h2{

            font-weight:900;

            color:#1e3c72;

            margin-bottom:5px;

        }

        .logo span{

            color:#dc3545;

        }

        .logo p{

            color:#777;

            margin:0;

        }

        .form-label{

            font-weight:600;

        }

        .input-group-text{

            background:#FFF;

        }

        .form-control{

            height:52px;

            border-radius:12px;

            font-size:15px;

        }

        .form-control:focus{

            border-color:#1e3c72;

            box-shadow:0 0 0 .2rem rgba(30,60,114,.15);

        }

        .btn-login{

            width:100%;

            height:52px;

            border:none;

            border-radius:12px;

            background:#1e3c72;

            color:#FFF;

            font-weight:700;

            transition:.25s;

        }

        .btn-login:hover{

            background:#294f95;

            transform:translateY(-2px);

        }

        .btn-outline-secondary{

            border-radius:0 12px 12px 0;

        }

        .form-check-label{

            user-select:none;

        }

        .alert{

            border-radius:12px;

        }

        @media(max-width:480px){

            .login-card{

                margin:15px;

                padding:30px;

            }

        }

    </style>

</head>

<body>

<div class="login-card">

    <div class="logo">

        @if(file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}">
        @endif

        <h2>A+<span>Veículos</span></h2>

        <p>Painel Administrativo</p>

    </div>


    @if(session('error'))

        <div class="alert alert-danger">

            <i class="fas fa-circle-exclamation me-2"></i>

            {{ session('error') }}

        </div>

    @endif


    @if($errors->any())

        <div class="alert alert-danger">

            @foreach($errors->all() as $error)

                <div>

                    <i class="fas fa-circle-exclamation me-2"></i>

                    {{ $error }}

                </div>

            @endforeach

        </div>

    @endif


    <form method="POST" action="{{ route('admin.auth') }}">

        @csrf


        <div class="mb-3">

            <label class="form-label">

                E-mail

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fas fa-envelope"></i>

                </span>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Digite seu e-mail"
                    required
                    autofocus>

            </div>

        </div>



        <div class="mb-3">

            <label class="form-label">

                Senha

            </label>

            <div class="input-group">

                <span class="input-group-text">

                    <i class="fas fa-lock"></i>

                </span>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Digite sua senha"
                    required>

                <button
                    class="btn btn-outline-secondary"
                    type="button"
                    id="togglePassword">

                    <i class="fas fa-eye"></i>

                </button>

            </div>

        </div>


        <div class="mb-4 form-check">

            <input
                class="form-check-input"
                type="checkbox"
                name="remember"
                id="remember">

            <label
                class="form-check-label"
                for="remember">

                Manter conectado

            </label>

        </div>


        <button class="btn-login">

            <i class="fas fa-right-to-bracket me-2"></i>

            Entrar

        </button>

    </form>

</div>


<script>

const togglePassword=document.getElementById('togglePassword');

const password=document.getElementById('password');

togglePassword.addEventListener('click',()=>{

    const type=password.type==='password'
        ?'text'
        :'password';

    password.type=type;

    togglePassword.innerHTML=
        type==='password'
        ?'<i class="fas fa-eye"></i>'
        :'<i class="fas fa-eye-slash"></i>';

});

</script>

</body>
</html>
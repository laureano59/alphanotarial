<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alpha Notarial</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body{
            margin:0;
            font-family:'Poppins', sans-serif;
            height:100vh;
            overflow:hidden;
            background: linear-gradient(-45deg,#0f2027,#203a43,#2c5364,#1b2735);
            background-size:400% 400%;
            animation:gradientBG 15s ease infinite;
            color:white;
        }

        @keyframes gradientBG{
            0%{background-position:0% 50%}
            50%{background-position:100% 50%}
            100%{background-position:0% 50%}
        }

        .container{
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            flex-direction:column;
            text-align:center;
        }

        .glass-box{
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(15px);
            padding:50px;
            border-radius:25px;
            box-shadow:0 20px 50px rgba(0,0,0,0.4);
            max-width:600px;
            width:90%;
        }

        .logo{
            animation:float 4s ease-in-out infinite;
            margin-bottom:20px;
        }

        @keyframes float{
            0%{transform:translateY(0px)}
            50%{transform:translateY(-15px)}
            100%{transform:translateY(0px)}
        }

        .title{
            font-size:38px;
            font-weight:700;
            margin-bottom:10px;
        }

        .subtitle{
            font-size:15px;
            opacity:.8;
            margin-bottom:35px;
        }

        .btn{
            display:inline-block;
            padding:12px 30px;
            margin:10px;
            border-radius:40px;
            text-decoration:none;
            font-weight:600;
            transition:.3s;
        }

        .btn-primary{
            background:linear-gradient(45deg,#00c6ff,#0072ff);
            color:white;
            box-shadow:0 0 20px rgba(0,114,255,0.6);
        }

        .btn-primary:hover{
            transform:translateY(-4px);
            box-shadow:0 0 30px rgba(0,114,255,0.9);
        }

        .btn-outline{
            border:2px solid white;
            color:white;
        }

        .btn-outline:hover{
            background:white;
            color:#203a43;
            transform:translateY(-4px);
        }

        .top-links{
            position:absolute;
            top:25px;
            right:40px;
        }

        .top-links a{
            color:white;
            margin-left:20px;
            text-decoration:none;
            font-weight:500;
            transition:.3s;
        }

        .top-links a:hover{
            opacity:.7;
        }

        .footer{
            position:absolute;
            bottom:20px;
            font-size:12px;
            opacity:.6;
        }

        @media(max-width:768px){
            .glass-box{
                padding:30px;
            }
            .title{
                font-size:28px;
            }
        }
    </style>
</head>
<body>

@if (Route::has('login'))
<div class="top-links">
    @auth
        <a href="{{ url('/home') }}">Panel</a>
    @else
        <a href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
            <a href="{{ route('register') }}">Registro</a>
        @endif
    @endauth
</div>
@endif

<div class="container">
    <div class="glass-box">

        <img src="{{ asset('images/logo.png') }}" class="logo" width="260">

        <div class="title">
            ALPHA NOTARIAL
        </div>

        <div class="subtitle">
            Plataforma Integral de Gestión Notarial Inteligente<br>
            Seguridad • Precisión • Confianza
        </div>

        @auth
            <a href="{{ url('/home') }}" class="btn btn-primary">
                Entrar al Panel
            </a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">
                Iniciar Sesión
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn btn-outline">
                    Crear Cuenta
                </a>
            @endif
        @endauth

    </div>

    <div class="footer">
        © {{ date('Y') }} Alpha Notarial • Tecnología para notarías modernas
    </div>
</div>

</body>
</html>
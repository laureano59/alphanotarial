@extends('layouts.app')

@section('content')

<style>
body{
    background: linear-gradient(-45deg,#1e3c72,#2a5298,#16222A,#3A6073);
    background-size:400% 400%;
    animation:gradientBG 15s ease infinite;
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

@keyframes gradientBG{
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}

.reset-container{
    width:100%;
    max-width:500px;
}

.glass-card{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border-radius:25px;
    padding:40px;
    box-shadow:0 20px 50px rgba(0,0,0,0.4);
    color:white;
}

.brand-title{
    text-align:center;
    font-size:24px;
    font-weight:700;
    margin-bottom:5px;
}

.brand-sub{
    text-align:center;
    font-size:14px;
    opacity:.8;
    margin-bottom:25px;
}

.security-icon{
    text-align:center;
    font-size:50px;
    margin-bottom:15px;
    opacity:.8;
}

.form-control{
    background:rgba(255,255,255,0.15);
    border:none;
    border-radius:10px;
    color:white;
    height:45px;
}

.form-control:focus{
    background:rgba(255,255,255,0.25);
    box-shadow:none;
    color:white;
}

.btn-reset{
    background:linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    border-radius:30px;
    padding:12px;
    font-weight:600;
    transition:.3s;
    box-shadow:0 0 20px rgba(0,114,255,0.6);
}

.btn-reset:hover{
    transform:translateY(-3px);
    box-shadow:0 0 30px rgba(0,114,255,0.9);
}

.success-box{
    background:rgba(0,255,150,0.15);
    border-left:4px solid #00ff99;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    font-size:13px;
}

.small-text{
    font-size:12px;
    opacity:.7;
    margin-top:15px;
    text-align:center;
}

</style>

<div class="reset-container">
    <div class="glass-card">

        <div class="security-icon">
            <i class="fa fa-shield"></i>
        </div>

        <div class="brand-title">
            Centro de Seguridad
        </div>

        <div class="brand-sub">
            Recuperación de acceso • Alpha Notarial
        </div>

        @if (session('status'))
            <div class="success-box">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ old('email') }}"
                       required autofocus>

                @error('email')
                    <span class="text-danger small">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn btn-reset btn-block mt-3">
                Enviar Enlace de Recuperación
            </button>

        </form>

        <div class="small-text">
            Recibirás un enlace seguro para restablecer tu contraseña.
        </div>

    </div>
</div>

@endsection
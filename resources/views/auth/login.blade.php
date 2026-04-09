@extends('layouts.login')

@section('content')

<style>
body{
    background: linear-gradient(-45deg,#0f2027,#203a43,#2c5364,#1c1c1c);
    background-size:400% 400%;
    animation:gradientBG 12s ease infinite;
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
}

@keyframes gradientBG{
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}

.login-container{
    width:100%;
    max-width:420px;
}

.glass-card{
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(15px);
    border-radius:20px;
    padding:40px;
    box-shadow:0 15px 35px rgba(0,0,0,0.4);
    color:white;
}

.brand-title{
    text-align:center;
    font-size:28px;
    font-weight:700;
    margin-bottom:5px;
}

.brand-sub{
    text-align:center;
    font-size:14px;
    opacity:.8;
    margin-bottom:30px;
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

.input-group-text{
    background:rgba(255,255,255,0.15);
    border:none;
    color:white;
}

.btn-login{
    background:linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    border-radius:30px;
    padding:12px;
    font-weight:600;
    transition:.3s;
    box-shadow:0 0 15px rgba(0,114,255,0.6);
}

.btn-login:hover{
    transform:translateY(-3px);
    box-shadow:0 0 25px rgba(0,114,255,0.9);
}

.extra-links{
    text-align:center;
    margin-top:15px;
}

.extra-links a{
    color:#ccc;
    font-size:13px;
}

.footer-text{
    text-align:center;
    margin-top:25px;
    font-size:12px;
    opacity:.6;
}
</style>

<div class="login-container">
    <div class="glass-card">

        <div class="brand-title">
            ALPHA NOTARIAL
        </div>
        <div class="brand-sub">
            Plataforma Inteligente de Gestión Notarial
        </div>

        <form method="POST" action="{{ route('login') }}">
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

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-group">
                    <input id="password"
                           type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           required>
                    <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer;">
                            <i class="fa fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>

                @error('password')
                    <span class="text-danger small">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="form-group form-check mt-3">
                <input type="checkbox" name="remember" id="remember"
                       {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-login btn-block mt-3">
                Ingresar al Sistema
            </button>

            @if (Route::has('password.request'))
                <div class="extra-links">
                    <a href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            @endif
        </form>

        <div class="footer-text">
            © {{ date('Y') }} Alpha Notarial • Seguridad • Precisión • Confianza
        </div>

    </div>
</div>

<script>
function togglePassword(){
    let password = document.getElementById("password");
    let icon = document.getElementById("eyeIcon");

    if(password.type === "password"){
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }else{
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

@endsection
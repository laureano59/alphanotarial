@extends('layouts.app')

@section('content')

<style>
body{
    background: linear-gradient(-45deg,#141e30,#243b55,#1b2735,#0f2027);
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

.register-container{
    width:100%;
    max-width:750px;
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
    font-size:26px;
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

label{
    font-weight:500;
}

.btn-register{
    background:linear-gradient(45deg,#00c6ff,#0072ff);
    border:none;
    border-radius:30px;
    padding:12px;
    font-weight:600;
    transition:.3s;
    box-shadow:0 0 20px rgba(0,114,255,0.6);
}

.btn-register:hover{
    transform:translateY(-3px);
    box-shadow:0 0 30px rgba(0,114,255,0.9);
}

.password-strength{
    height:6px;
    border-radius:20px;
    margin-top:5px;
    background:rgba(255,255,255,0.2);
    overflow:hidden;
}

.password-strength-bar{
    height:100%;
    width:0%;
    transition:.3s;
}

.small-text{
    font-size:12px;
    opacity:.7;
}

</style>

<div class="register-container">
    <div class="glass-card">

        <div class="brand-title">
            ALPHA NOTARIAL
        </div>
        <div class="brand-sub">
            Registro de Nuevo Usuario • Plataforma Segura
        </div>

        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Nombre Completo</label>
                    <input id="name" type="text"
                           class="form-control @error('name') is-invalid @enderror"
                           name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>Correo Electrónico</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Contraseña</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" required onkeyup="checkStrength()">
                    <div class="password-strength">
                        <div id="strengthBar" class="password-strength-bar"></div>
                    </div>
                    <span id="strengthText" class="small-text"></span>

                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>Confirmar Contraseña</label>
                    <input id="password-confirm" type="password"
                           class="form-control"
                           name="password_confirmation" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label>Teléfono</label>
                    <input id="telefono" type="text"
                           class="form-control @error('telefono') is-invalid @enderror"
                           name="telefono" value="{{ old('telefono') }}">
                    @error('telefono')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label>Dirección</label>
                    <input id="direccion" type="text"
                           class="form-control @error('direccion') is-invalid @enderror"
                           name="direccion" value="{{ old('direccion') }}">
                    @error('direccion')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>Cargo</label>
                <input id="cargo" type="text"
                       class="form-control @error('cargo') is-invalid @enderror"
                       name="cargo" value="{{ old('cargo') }}">
                @error('cargo')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-register btn-block mt-3">
                Crear Cuenta
            </button>

        </form>
    </div>
</div>

<script>
function checkStrength(){
    let password = document.getElementById("password").value;
    let bar = document.getElementById("strengthBar");
    let text = document.getElementById("strengthText");

    let strength = 0;

    if(password.length > 5) strength += 1;
    if(password.match(/[A-Z]/)) strength += 1;
    if(password.match(/[0-9]/)) strength += 1;
    if(password.match(/[^A-Za-z0-9]/)) strength += 1;

    let width = strength * 25;
    bar.style.width = width + "%";

    if(strength <= 1){
        bar.style.background = "#ff4d4d";
        text.innerHTML = "Seguridad baja";
    }else if(strength == 2){
        bar.style.background = "#ffa500";
        text.innerHTML = "Seguridad media";
    }else if(strength == 3){
        bar.style.background = "#00c6ff";
        text.innerHTML = "Buena seguridad";
    }else{
        bar.style.background = "#00ff99";
        text.innerHTML = "Contraseña fuerte";
    }
}
</script>

@endsection
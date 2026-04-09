@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel Ejecutivo')
@section('content')

<style>
.dashboard-hero{
    background: linear-gradient(135deg,#1e3c72,#2a5298);
    color:white;
    padding:30px;
    border-radius:15px;
    margin-bottom:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}
.dashboard-hero h1{
    font-weight:700;
    margin:0;
}
.dashboard-cards{
    margin-top:20px;
}
.stat-card{
    background:white;
    border-radius:15px;
    padding:25px;
    box-shadow:0 8px 25px rgba(0,0,0,0.08);
    transition:all .3s ease;
    position:relative;
    overflow:hidden;
}
.stat-card:hover{
    transform:translateY(-8px);
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}
.stat-icon{
    font-size:40px;
    opacity:.15;
    position:absolute;
    right:20px;
    top:20px;
}
.stat-number{
    font-size:32px;
    font-weight:700;
}
.progress{
    height:8px;
    border-radius:20px;
}
.footer-info{
    margin-top:30px;
    text-align:center;
    color:#777;
}
.clock{
    font-size:18px;
    margin-top:10px;
    font-weight:500;
}
</style>

<div class="dashboard-hero text-center">
    <h1>ALPHA NOTARIAL</h1>
    <p>Plataforma Integral de Gestión Notarial</p>
    <div class="clock" id="clock"></div>
</div>

<div class="row dashboard-cards">

    <div class="col-md-3">
        <div class="stat-card">
            <i class="fa fa-folder-open stat-icon"></i>
            <div class="stat-number">{{$Id_radica}}</div>
            <div>Radicaciones Registradas</div>
            <div class="progress">
                <div class="progress-bar progress-bar-primary" style="width: {{ min($Id_radica,100) }}%"></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <i class="fa fa-file-text stat-icon"></i>
            <div class="stat-number">{{$Id_fact}}</div>
            <div>Facturas Generadas</div>
            <div class="progress">
                <div class="progress-bar progress-bar-success" style="width: {{ min($Id_fact,100) }}%"></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <i class="fa fa-book stat-icon"></i>
            <div class="stat-number">{{$Num_esc}}</div>
            <div>Escrituras Protocolizadas</div>
            <div class="progress">
                <div class="progress-bar progress-bar-danger" style="width: {{ min($Num_esc,100) }}%"></div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card">
            <i class="fa fa-calendar stat-icon"></i>
            <div class="stat-number">{{$AnioTrabajo->anio_trabajo}}</div>
            <div>Año Fiscal Activo</div>
            <div class="progress">
                <div class="progress-bar progress-bar-warning" style="width: 100%"></div>
            </div>
        </div>
    </div>

</div>

<div class="footer-info">
    Sistema desarrollado para gestión notarial avanzada • Seguridad • Control • Precisión
</div>

<div class="row" style="margin-top:40px;">
    <div class="col-md-12">
        <div style="
            background:#ffffff;
            border-radius:15px;
            padding:25px;
            box-shadow:0 8px 25px rgba(0,0,0,0.08);
        ">
            <h4 style="margin-bottom:20px; font-weight:600;">
                <i class="fa fa-external-link"></i> Centro de Accesos Rápidos
            </h4>

            <div class="row text-center">

                <div class="col-md-3 col-sm-6" style="margin-bottom:15px;">
                    <a href="https://www.dian.gov.co"
                       target="_blank"
                       rel="noopener"
                       class="btn btn-primary btn-block"
                       style="border-radius:10px;">
                        <i class="fa fa-bank"></i> DIAN
                    </a>
                </div>

                <div class="col-md-3 col-sm-6" style="margin-bottom:15px;">
                    <a href="https://www.rues.org.co"
                       target="_blank"
                       rel="noopener"
                       class="btn btn-success btn-block"
                       style="border-radius:10px;">
                        <i class="fa fa-building"></i> RUES
                    </a>
                </div>

                <div class="col-md-3 col-sm-6" style="margin-bottom:15px;">
                    <a href="https://www.supernotariado.gov.co"
                       target="_blank"
                       rel="noopener"
                       class="btn btn-warning btn-block"
                       style="border-radius:10px;">
                        <i class="fa fa-gavel"></i> SuperNotariado
                    </a>
                </div>

                <div class="col-md-3 col-sm-6" style="margin-bottom:15px;">
                    <a href="https://www.registraduria.gov.co"
                        target="_blank"
                        rel="noopener"
                        class="btn btn-danger btn-block"
                        style="border-radius:10px;">
                        <i class="fa fa-user"></i> Registraduría Nacional
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function actualizarReloj(){
    let ahora = new Date();
    let opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    let fecha = ahora.toLocaleDateString('es-ES', opciones);
    let hora = ahora.toLocaleTimeString();
    document.getElementById('clock').innerHTML = fecha + " | " + hora;
}
setInterval(actualizarReloj,1000);
actualizarReloj();
</script>

@endsection
@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control de Usuarios')
@section('content')

<div class="page-header">
    <h1>Administración de Usuarios y Roles</h1>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <label for="userSelect" class="font-weight-bold">Seleccionar Usuario:</label>
        <select class="form-control" id="id_usuario" name="id_proto" style="width: 250px;">
            <option value="" disabled selected>Elija Usuario</option>
            @foreach ($Usuarios as $User)
                <option value="{{$User->id}}">{{$User->name}}</option>
            @endforeach
        </select>
    </div>
    <form class="form-horizontal" role="form">
        @csrf
        <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
        <div class="col-md-6 d-flex align-items-end justify-content-center" id="botonguardarcambios" style="display:none">
        <button type="button" id="guardarcambios" class="btn btn-primary btn-lg" style="width: 250px;">Guardar Cambios</button>
    </div>
</div>

 <div class="alert alert-success" role="alert" id="msj-error1" style="display:none">
    <strong id="msj1"></strong>
</div>


<hr>


 <div class="row">       
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
            <h4 class="widget-title">Módulo de Reportes</h4>
                
                 <div class="widget-toolbar">                
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>

            </div>

            <div class="widget-body">
                <div class="widget-main">
                        <div class="row">
                            <!-- Primera columna -->
                            <div class="col-sm-3">
                                <h4 class="card-header bg-info text-white">Administrativos</h4>                                
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="14" name="reportes[]" value="14">
                                            <label class="form-check-label text-info" for="facturas1">Relación de Facturas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="15" name="reportes[]" value="15">
                                            <label class="form-check-label text-info" for="estadistico1">Estadístico Notarial</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="16" name="reportes[]" value="16">
                                            <label class="form-check-label text-info" for="notas1">Relación Notas Crédito</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="17" name="reportes[]" value="17">
                                            <label class="form-check-label text-info" for="conceptos1">Informe de Conceptos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="18" name="reportes[]" value="18">
                                            <label class="form-check-label text-info" for="recaudos1">Informe de Recaudos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="19" name="reportes[]" value="19">
                                            <label class="form-check-label text-info" for="escrituradores1">Ingresos por Escrituradores</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="20" name="reportes[]" value="20">
                                            <label class="form-check-label text-info" for="retefuentes1">Retefuentes Aplicadas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="21" name="reportes[]" value="21">
                                            <label class="form-check-label text-info" for="retefuente1">Informe de Retefuente</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="22" name="reportes[]" value="22">
                                            <label class="form-check-label text-info" for="timbre1">Informe de Timbre</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="23" name="reportes[]" value="23">
                                            <label class="form-check-label text-info" for="gastos1">Informe de Gastos</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="col-sm-3">
                                 <h4 class="card-header bg-info text-white">Escrituración</h4> 
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="26" name="reportes[]" value="26">
                                            <label class="form-check-label text-info" for="facturas2">Actos Jurídicos Notariales</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="27" name="reportes[]" value="27">
                                            <label class="form-check-label text-info" for="estadistico2">Enlaces</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="28" name="reportes[]" value="28">
                                            <label class="form-check-label text-info" for="notas2">Libro Índice de Escrituras</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="29" name="reportes[]" value="29">
                                            <label class="form-check-label text-info" for="conceptos2">Libro Relación de Escrituras</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="30" name="reportes[]" value="30">
                                            <label class="form-check-label text-info" for="recaudos2">Reporte de Operaciones Notariales (RON)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="31" name="reportes[]" value="31">
                                            <label class="form-check-label text-info" for="escrituradores2">Escrituras pendientes de Factura</label>
                                        </div>
                                         <h4 class="card-header bg-info text-white">Actas de Depósito</h4>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="40" name="reportes[]" value="40">
                                            <label class="form-check-label text-info" for="escrituradores2">Informe de Depósitos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="41" name="reportes[]" value="41">
                                            <label class="form-check-label text-info" for="escrituradores2">Informe de Egresos</label>
                                        </div>   
                                       
                                    </div>
                                </div>
                            </div>

                             <!-- Tercera columna -->
                            <div class="col-sm-3">
                                 <h4 class="card-header bg-info text-white">Cartera</h4> 
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="32" name="reportes[]" value="32">
                                            <label class="form-check-label text-info" for="facturas2">Relación de Cartera por Cliente</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="33" name="reportes[]" value="33">
                                            <label class="form-check-label text-info" for="estadistico2">Relación de Cartera por Fecha</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="34" name="reportes[]" value="34">
                                            <label class="form-check-label text-info" for="notas2">Relación de Cartera Facturas Activas</label>
                                        </div>
                                        <h4 class="card-header bg-info text-white">Bonos</h4> 
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="35" name="reportes[]" value="35">
                                            <label class="form-check-label text-info" for="conceptos2">Cuentas de Cobro Bonos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="36" name="reportes[]" value="36">
                                            <label class="form-check-label text-info" for="recaudos2">Trazabilidad X Cliente Bonos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="37" name="reportes[]" value="37">
                                            <label class="form-check-label text-info" for="escrituradores2">Trazabilidad X Fecha Bonos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="38" name="reportes[]" value="38">
                                            <label class="form-check-label text-info" for="escrituradores2">Informe de Cartera Bonos</label>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                             <!-- Cuarta columna -->
                            <div class="col-sm-3">
                                 <h4 class="card-header bg-info text-white">Otros Informes</h4> 
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="39" name="reportes[]" value="39">
                                            <label class="form-check-label text-info" for="facturas2">Certificado Retención en la Fuente</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="44" name="reportes[]" value="44">
                                            <label class="form-check-label text-info" for="facturas2">Consolidado de Caja</label>
                                        </div>
                                        
                                        <h4 class="card-header bg-info text-white">Informes DIAN</h4> 
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="42" name="reportes[]" value="42">
                                            <label class="form-check-label text-info" for="conceptos2">Informe de Ingresos X Cliente</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="43" name="reportes[]" value="43">
                                            <label class="form-check-label text-info" for="recaudos2">Informe de Enajenaciones</label>
                                        </div>                                      
                                       
                                    </div>
                                </div>
                            </div>




                        </div> <!-- End row -->
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">       
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
            <h4 class="widget-title">Módulo de Operación</h4>
                
                 <div class="widget-toolbar">                
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>

            </div>

            <div class="widget-body">
                <div class="widget-main">
                        <div class="row">
                            <!-- Primera columna -->
                            <div class="col-sm-3">
                                <h4 class="card-header bg-info text-white">Facturación</h4>                                
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="2" name="reportes[]" value="2">
                                            <label class="form-check-label text-info" for="facturas1">Facturar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="12" name="reportes[]" value="12">
                                            <label class="form-check-label text-info" for="estadistico1">Notas Crédito</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="11" name="reportes[]" value="11">
                                            <label class="form-check-label text-info" for="notas1">Copias de Factura</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="24" name="reportes[]" value="24">
                                            <label class="form-check-label text-info" for="conceptos1">Generar XML</label>
                                        </div>
                                        <h4 class="card-header bg-info text-white">Liquidación</h4>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="3" name="reportes[]" value="3">
                                            <label class="form-check-label text-info" for="conceptos1">Liquidar</label>
                                        </div>

                                        <h4 class="card-header bg-info text-white">Radicación</h4>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="1" name="reportes[]" value="1">
                                            <label class="form-check-label text-info" for="conceptos1">Radicar</label>
                                        </div>

                                        <h4 class="card-header bg-info text-white">Numeración</h4>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="25" name="reportes[]" value="25">
                                            <label class="form-check-label text-info" for="conceptos1">Numerar</label>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <!-- Segunda columna -->
                            <div class="col-sm-3">
                                 <h4 class="card-header bg-info text-white">Caja Rápida</h4> 
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="5" name="reportes[]" value="5">
                                            <label class="form-check-label text-info" for="facturas2">Mostrador</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="57" name="reportes[]" value="57">
                                            <label class="form-check-label text-info" for="facturas2">Facturar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="13" name="reportes[]" value="13">
                                            <label class="form-check-label text-info" for="estadistico2">Notas Crédito</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="6" name="reportes[]" value="6">
                                            <label class="form-check-label text-info" for="notas2">Reporte Diario</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="7" name="reportes[]" value="7">
                                            <label class="form-check-label text-info" for="conceptos2">Relación Nota Crédito</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="8" name="reportes[]" value="8">
                                            <label class="form-check-label text-info" for="recaudos2">Reporte por Grupo</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="9" name="reportes[]" value="9">
                                            <label class="form-check-label text-info" for="escrituradores2">Cartera</label>
                                        </div>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="10" name="reportes[]" value="10">
                                            <label class="form-check-label text-info" for="escrituradores2">Copias de Factura</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="58" name="reportes[]" value="58">
                                            <label class="form-check-label text-info" for="escrituradores2">Apertura Caja</label>
                                        </div>   
                                       
                                    </div>
                                </div>
                            </div>

                             <!-- Tercera columna -->
                            <div class="col-sm-3">
                                 <h4 class="card-header bg-info text-white">Generales</h4> 
                                <div class="card shadow-sm mb-4">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="45" name="reportes[]" value="45">
                                            <label class="form-check-label text-info" for="facturas2">Cartera</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="46" name="reportes[]" value="46">
                                            <label class="form-check-label text-info" for="estadistico2">Cuentas X Cobrar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="47" name="reportes[]" value="47">
                                            <label class="form-check-label text-info" for="notas2">Actas</label>
                                        </div>
                                         
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="48" name="reportes[]" value="48">
                                            <label class="form-check-label text-info" for="conceptos2">Certificados</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="49" name="reportes[]" value="49">
                                            <label class="form-check-label text-info" for="recaudos2">Protocolistas</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="54" name="reportes[]" value="54">
                                            <label class="form-check-label text-info" for="recaudos2">Gastos</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="55" name="reportes[]" value="55">
                                            <label class="form-check-label text-info" for="recaudos2">Registro</label>
                                        </div>                                       
                                    </div>
                                </div>
                            </div>

                              <!-- Cuarta columna -->
                            <div class="col-sm-3">
                                 <h4 class="card-header bg-info text-white">Mantenimiento</h4>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="50" name="reportes[]" value="50">
                                            <label class="form-check-label text-info" for="escrituradores2">Consultar</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="51" name="reportes[]" value="51">
                                            <label class="form-check-label text-info" for="escrituradores2">Mantenimiento</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="52" name="reportes[]" value="52">
                                            <label class="form-check-label text-info" for="escrituradores2">Configuración</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="53" name="reportes[]" value="53">
                                            <label class="form-check-label text-info" for="escrituradores2">Trazabilidad</label>
                                        </div>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="56" name="reportes[]" value="56">
                                            <label class="form-check-label text-info" for="escrituradores2">Auditoría</label>
                                        </div>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="59" name="reportes[]" value="59">
                                            <label class="form-check-label text-info" for="escrituradores2">Deshabilitar</label>
                                        </div>
                                         <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="4" name="reportes[]" value="4">
                                            <label class="form-check-label text-info" for="escrituradores2">Administrador</label>
                                        </div>
                                       
                                    </div>
                                </div>
                            </div>

                        </div> <!-- End row -->
                </div>
            </div>
        </div>
    </div>
</div>

</form>                            

@endsection

@section('scripts')
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/roles/script.js')}}"></script>
@endsection

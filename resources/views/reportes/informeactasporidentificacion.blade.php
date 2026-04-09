@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>
         {{ $nombre_reporte }}<span id="radi">
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Opciones: 
                        <label style="margin-right:15px; font-weight:normal; font-size:14px;"><input type="radio" name="estado_acta" value="todas" checked> Todas Actas</label>
                        <label style="margin-right:15px; font-weight:normal; font-size:14px;"><input type="radio" name="estado_acta" value="con_saldo"> Con Saldo</label>
                        <label style="margin-right:15px; font-weight:normal; font-size:14px;"><input type="radio" name="estado_acta" value="anuladas"> Anuladas</label>
                        <label style="font-weight:normal; font-size:14px;"><input type="radio" name="estado_acta" value="credito"> Actas a Crédito</label>
                    </h4>
                </div>
                <div class="widget-header">
                    <h4 class="widget-title">Identificación y Rango de Fecha</h4>
                    <span class="widget-toolbar">
                        <a href="#" id="imprimir_pdf_actas_identificacion">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Exportar PDF"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar">
                        <a href="#" id="exportar_excel_actas_identificacion">
                            <i><img src="{{ asset('images/icoexcel.png') }}" width="28 px" height="28 px" title="Exportar Excel"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="generarreporte_actasporidentificacion">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                    <span class="nav-search widget-toolbar">
                         <input type="text" placeholder="Identificación..." class="nav-search-input" id="identificacion_cli" autocomplete="off" />
                    </span>
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control" name="start" id="start" value="" autocomplete="off" placeholder="Desde" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" value="" autocomplete="off" placeholder="Hasta" />
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
      <div class="widget-body">
          <div class="widget-main">
                <h4 id="nombre_cliente_reporte" style="font-weight: bold; margin-bottom: 10px; font-size: 16px;"></h4>
                <table id="simple-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Radicación</th>
                            <th>Acta #</th>
                            <th># Escritura</th>
                            <th>Factura #</th>
                            <th id="th_cliente">Cliente</th>
                            <th>Vr Acta</th>
                            <th>Vr. Boleta</th>
                            <th>Vr. Registro</th>
                            <th>Vr. Escritura</th>
                            <th>Saldo</th>
                            <th>Estado Acta</th>
                            <th>Activa</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody id="datos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('js/__AJAX.js') }}"></script>
<script src="{{ asset('js/solonumeros.js') }}"></script>
<script src="{{ asset('js/formatonumero.js') }}"></script>
<script src="{{ asset('js/numberFormat154.js') }}"></script>
<script src="{{ asset('js/calendario.js') }}"></script>
<script src="{{ asset('js/reportes/grid.js') }}?v=13"></script>
<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/spinbox.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/autosize.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.inputlimiter.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
@endsection
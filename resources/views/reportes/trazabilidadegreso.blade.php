@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1><b>Trazabilidad de Egreso</b></h1>
</div>

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title" style="width:100%;">
                        <span style="font-weight:bold;">Fecha e Identificacion</span>
                        <label style="margin-left:16px; font-weight:normal; font-size:14px;">
                            <input type="radio" name="tipo_acta_egreso" value="todas" checked> Todas
                        </label>
                        <label style="margin-left:12px; font-weight:normal; font-size:14px;">
                            <input type="radio" name="tipo_acta_egreso" value="credito"> Actas a Credito
                        </label>
                        <label style="margin-left:12px; font-weight:normal; font-size:14px;">
                            <input type="radio" name="tipo_acta_egreso" value="normal"> Actas Normales
                        </label>
                    </h4>
                    <span class="widget-toolbar" style="float:right;">
                        <a href="#" id="exportar_excel_trazabilidadegreso">
                            <i><img src="{{ asset('images/icoexcel.png') }}" width="28 px" height="28 px" title="Exportar Excel"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar" style="float:right;">
                        <a target="_blank" href="#" id="imprimir_pdf_trazabilidadegreso">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Reporte PDF"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar" style="float:right;">
                        <a href="#" data-action="settings" id="generarreporte_trazabilidadegreso">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                    <span class="nav-search widget-toolbar" style="float:left; margin-right:10px;">
                        <div class="input-daterange input-group" style="display:inline-table; width:260px;">
                            <input type="text" class="input-sm form-control" name="start" id="start" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" />
                        </div>
                    </span>
                    <span class="nav-search widget-toolbar" style="float:left;">
                        <input type="text" id="identificacion_cli" placeholder="Identificacion" class="nav-search-input" style="width:190px;" />
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
                <table id="simple-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Trazabilidad por Acta</th>
                        </tr>
                    </thead>
                    <tbody id="data_trazabilidadegreso"></tbody>
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
<script src="{{ asset('js/calendario.js') }}"></script>
<script src="{{ asset('js/reportes/grid.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/spinbox.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/autosize.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.inputlimiter.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/solonumeros.js') }}"></script>
<script src="{{ asset('js/formatonumero.js') }}"></script>
<script src="{{ asset('js/numberFormat154.js') }}"></script>
@endsection
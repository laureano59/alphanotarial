@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>Modulo Para Cuentas de Cobro</h1>
</div><!-- /.page-header -->
<form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <input type="hidden" id="tipogrid" value="retiros">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <span class="nav-search widget-toolbar">
                        <input type="text" id="idfact" placeholder="Buscar por No.de Factura" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                        <a href="javascript://" id="buscarpornumfact">
                            <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por No.de Factura"></i>
                        </a>
                    </span>

                    <span class="nav-search widget-toolbar">
                        <input type="text" id="identif" placeholder="Buscar por No.de Identificación" class="nav-search-input" autocomplete="off" />
                        <a href="javascript://" id="buscarporidentif">
                            <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por Identificación"></i>
                        </a>
                    </span>

                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <table id="simple-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código bono</th>
                                    <th>No.Factura</th>
                                    <th>Fecha</th>
                                    <th>Nombre del Cliente</th>
                                    <th>
                                        $ Valor Bono
                                    </th>
                                    <th>
                                        $ Saldo
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="data"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="alert alert-success" role="alert" id="msj-error1" style="display:none">
            <strong id="msj1"></strong>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header">
                    <div class="widget-toolbar" style="display:none">
                        <a href="/imprimirabonos" target="_blank">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir abonos"></i>
                        </a>
                    </div>
                    <div class="widget-toolbar">
                        <a href="javascript://" id="GuardarAbono" data-action="reload">
                            <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Abono"></i>
                        </a>
                    </div>
                    
                    <center>
                        <h4 class="widget-title">Factura No.&nbsp;<font color="red"><span id="num_fact"></span></font>
                        </h4>
                    </center>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <form class="form-horizontal" role="form">
                          @csrf
                          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                          <input type="hidden" id="saldo_iden" value="0">
                          <input type="hidden" id="id_fact_iden" value="0">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1"> <b>Valor Abono</b></label>
                                <div class="col-sm-9">
                                    <input type="text" id="abono" placeholder="Valor" class="col-xs-10 col-sm-5" onKeyPress="return soloNumeros(event)"/>
                                </div>
                            </div>

                            <br>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->


       <div class="col-xs-12 col-sm-8">

        <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Cuentas de Cobro</h4>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="cargarbonos">
                            <i><img src="{{ asset('images/ojo.png') }}" width="28 px" height="28 px" title="Mostrar Bonos"></i>
                        </a>

                        <a href="#" data-action="settings" id="GenerarCuentaCobro">
                            <i><img src="{{ asset('images/printcc.png') }}" width="28 px" height="28 px" title="Generar Cuenta de Cobro"></i>
                        </a>
                    </span>
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control" name="start" id="start" placeholder="Fecha1" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" placeholder="Fecha2"/>
                        </div>
                    </span>
                </div>
            </div>
        </form>

        <table id="simple-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Bono</th>
                                    <th>Factura</th>
                                    <th>Escritura</th>
                                    <th>Radicación</th>
                                    <th>Fecha Escr</th>
                                    <th>Nombre del Cliente</th>
                                    <th>
                                        $ Valor Bono
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="data_bono"></tbody>
                        </table>

        
    </div>






    </div>

</form>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/bonos/script.js')}}"></script>
<script src="{{ asset('js/bonos/grid.js')}}"></script>

<script src="{{ asset('js/calendario.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.custom.min.js')}}"></script>
<script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
<script src="{{asset('assets/js/spinbox.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('assets/js/autosize.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
@endsection


  
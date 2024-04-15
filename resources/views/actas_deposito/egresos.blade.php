@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>Uso de los Depósitos del Cliente</h1>
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
                        <input type="text" id="idacta" placeholder="Buscar por No.de Acta" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                        <a href="javascript://" id="buscarpornumacta">
                            <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por No.de Acta"></i>
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
                                    <th>No.Acta</th>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Nombre del Proyecto</th>
                                    <th>Tipo Depósito</th>
                                    <th>
                                        $ Valor
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
        <div class="col-xs-12 col-sm-5">
            <div class="alert alert-success" role="alert" id="msj-error1" style="display:none">
                <strong id="msj1"></strong>
            </div>
            <div class="widget-box">
                <div class="widget-header">
                    <div class="widget-toolbar">
                        <a href="/Imprimircomprobante_Egreso" target="_blank">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir comprobante"></i>
                        </a>
                    </div>


                    <div class="widget-toolbar">
                        <a href="javascript://" id="GuardarEgreso" data-action="reload">
                            <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Egreso"></i>
                        </a>
                    </div>

                    
                    <center>
                        <h4 class="widget-title">Acta No.&nbsp;<font color="red"><span id="num_acta"></span></font>
                        </h4>
                    </center>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <form class="form-horizontal" role="form">
                          @csrf
                          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                          <input type="hidden" id="saldo_iden" value="0">
                          <input type="hidden" id="id_act_iden" value="0">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1"> <b>Valor Egreso</b></label>
                                <div class="col-sm-9">
                                    <input type="text" id="descuento" placeholder="Valor" class="col-xs-10 col-sm-5" onKeyPress="return soloNumeros(event)"/>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1"> <b>No.Radicaión</b></label>
                                <div class="col-sm-9">
                                    <input type="text" id="id_radica" placeholder="Radicación" class="col-xs-10 col-sm-5" onKeyPress="return soloNumeros(event)"/>
                                </div>
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1"> <b>No.Factura</b></label>
                               
                                <div class="col-sm-9">
                                     <input type="text" style="width: 60px;" id="prefijo" placeholder="prefijo" class="col-xs-10 col-sm-5"/>
                                    <input type="text" id="id_fact" placeholder="No.Fact" class="col-xs-10 col-sm-5" onKeyPress="return soloNumeros(event)"/>
                                </div>

                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1"> <b>Año Fiscal</b></label>
                                <div class="col-sm-9">
                                    <input type="text" id="anio_fiscal" placeholder="Año fiscal" class="col-xs-10 col-sm-5" onKeyPress="return soloNumeros(event)"/>
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <br>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1-1"> <b>Tipo Egreso</b> </label>

                                <div class="col-sm-9">
                                    <select id="id_con">
                                        <option value="" disabled selected>Tipo.Egreso</option>
                                        @foreach ($Concepto_egreso as $Con)
                                        <option value="{{$Con->id_con}}">{{$Con->concepto}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                	<br><br><br><br><br><br>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right orange" for="form-field-1-1"> <b>Observaciones</b> </label>

                                <div class="col-sm-9">
                                    <textarea class="form-control" id="observaciones" maxlength="250" placeholder="Default Text"></textarea>
                                </div>
                                    <br><br>
                            </div>

                            <br>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div>

</form>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/actas_deposito/script.js')}}"></script>
<script src="{{ asset('js/actas_deposito/grid_actas.js')}}"></script>
@endsection

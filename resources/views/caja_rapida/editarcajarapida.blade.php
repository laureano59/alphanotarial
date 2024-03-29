@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
@include('radicacion.modalcliente')
@include('radicacion.modalcliente-empresa')
@include('facturacion.modalfactelectronica')

  <div class="alert alert-danger" role="alert" id="msj-error" style="display:none">
    <strong id="msj"></strong>
  </div>
  <div class="page-header">

    <table>
      <tr>
        <td width="700">
          <h1>
            Editar Factura Caja Rápida
          </h1>
        </td>
        <form class="form-horizontal" role="form">
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
        <td align="right" width="500">
          <b>
            Escribir el No de Factura.&nbsp; <input type="text" id="numfactrapidavisual" onKeyPress="return soloNumeros(event)">
          </b>
          
          <input type="hidden" id="numfactrapida">
          <div class="widget-toolbar" id="botonvalidar">
              <a href="javascript://" id="validarfacturaparaeditar" data-action="reload">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Validar Factura"></i>
              </a>
        </div>
        </td>
      </tr>
    </table>

      
  </div><!-- /.page-header -->

  <div id="ocultar" style="display:none">

  <div class="row" id="clientesprincipales">
      <div id="dialog-confirm" class="hide">
        <div id="msg" class="alert alert-info bigger-110">

        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
        </p>
      </div><!-- #dialog-confirm -->

        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Datos del Ciente <span class="brown" id="Acto_Actual"></span></h4>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                      <div class="alert alert-warning" role="alert" id="msj-error4" style="display:none">
                        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                        <strong id="msj4"></strong>
                      </div>

                        
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Cliente</b></label>
                                <div class="col-sm-9">
                                    <select id="id_tipoident1" style="width: 70px;">
                                        <option value="" disabled selected>T.Doc</option>
                                        @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                                          <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" size="10" id="identificacion_cli1" name="identificacion_cli1" placeholder="Identificación" />
                                    <input type="text" readonly size="40" id="nombre_cli1" name="nombre_cli1" />
                                </div>
                            </div>
                            <br><br>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Forma_Pago</b></label>
                                <div class="col-sm-9">
                                    <select id="id_formapago" style="width: 150px;">
                                        <option value="" disabled selected>Seleccione</option>
                                          <option value="0">Contado</option>
                                          <option value="1">Crédito</option>
                                    </select>
                                </div>
                            </div>


                            <br><br>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Concepto</b></label>
                                <div class="col-sm-9">
                                    <select id="id_concepto" style="width: 350px;">
                                        <option value="" disabled selected>Codigo del Concepto</option>
                                        @foreach ($Conceptos as $Concept)
                                          <option value="{{$Concept->id_concep}}">{{$Concept->id_concep}} - {{$Concept->nombre_concep}} - ${{$Concept->valor}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" size="10" id="cantidad" name="cantidad" placeholder="Cantidad" onKeyPress="return soloNumeros(event)" />
                                    <a href="javascript://" id="agregaritem" data-action="collapse">
                                          <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Item"></i>
                                      </a>
                                </div>

                                <br><br>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->
      </div><!--- /row -->

     <div class="row" id="clientesprincipales">
      <div id="dialog-confirm" class="hide">
        <div id="msg" class="alert alert-info bigger-110">

        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
        </p>
      </div><!-- #dialog-confirm -->

          <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                  <h4 class="widget-title">Detalle de la Factura<span class="brown" id="Acto_Actual"></span></h4>
                  <div class="widget-toolbar" id="impresora"  style="display:none">
                        <a href="javascript://" id="imprimircajarapida" data-action="reload">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Factura"></i>
                        </a>
                  </div>

                  <div class="widget-toolbar" id="actualizar">
                        <a href="javascript://" id="actualizar_cambios" data-action="reload">
                            <i><img src="{{ asset('images/guardar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
                        </a>
                  </div>
                </div>



                <div class="widget-body">
                    <div class="widget-main">
                      <div class="alert alert-warning" role="alert" id="msj-error4" style="display:none">
                        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                        <strong id="msj4"></strong>
                      </div>


                      <table id="simple-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th>Valor/U</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="data"></tbody>
                        </table>
                       
                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div><!--- /row -->

  </div>


@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/caja_rapida/script.js')}}"></script>
<script src="{{ asset('js/limpiarclientes.js')}}"></script>
<script src="{{ asset('js/validarciudad.js')}}"></script>
<script src="{{ asset('js/crearclientes.js')}}"></script>
<script src="{{ asset('js/caja_rapida/script_electronica.js')}}"></script>

@endsection

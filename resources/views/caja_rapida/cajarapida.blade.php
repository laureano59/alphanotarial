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
          Facturación Caja Rápida
        </h1>
      </td>
      <td align="right" width="500">
        <b>
          Factura de venta No.&nbsp; <font color="Red" size="4"><span id="numfat"></span></font>
        </b>
      </td>
    </tr>
  </table>


</div><!-- /.page-header -->

<div class="row" id="clientesprincipales">
  <div id="dialog-confirm" class="hide">
    <div id="msg" class="alert alert-info bigger-110">

    </div>

    <div class="space-6"></div>

    <p class="bigger-110 bolder center grey">
    </p>
  </div><!-- #dialog-confirm -->

  <div class="col-xs-12 col-sm-6">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title">Datos del Ciente <span class="brown" id="Acto_Actual"></span></h4>
        <div class="widget-toolbar" id="botonnuevo">
          <a href="javascript://" id="nuevafactura" data-action="reload">
            <i><img src="{{ asset('images/nuevo7.png') }}" width="28 px" height="28 px" title="Nueva Factura"></i>
          </a>
        </div>
      </div>

      <div class="widget-body">
        <div class="widget-main">
          <div class="alert alert-warning" role="alert" id="msj-error4" style="display:none">
            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
            <strong id="msj4"></strong>
          </div>


          <form class="form-horizontal" role="form">
            @csrf
            <input type="hidden" id="numfactrapida">
            <input type="hidden" id="itemrapida" value=0>
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
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
                <input type="text" readonly size="28" id="nombre_cli1" name="nombre_cli1" />
              </div>

               <a href="javascript://" id="consumidorfinal" data-action="collapse" data-action="reload">
                  <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Consumidor Final"></i>
                </a>


            </div>

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

            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Concepto</b></label>
              <div class="col-sm-9">
                <select id="id_concepto" style="width: 310px;">
                  <option value="" disabled selected>Codigo del Concepto</option>
                  @foreach ($Conceptos as $Concept)
                  <option value="{{$Concept->id_concep}}">{{$Concept->id_concep}} - {{$Concept->nombre_concep}} - ${{$Concept->valor}}</option>
                  @endforeach
                </select>
                <input type="text" size="6" id="cantidad" name="cantidad" placeholder="Cantidad" onKeyPress="return soloNumeros(event)" />

                <a href="javascript://" id="agregaritem" data-action="collapse" data-action="reload">
                  <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Item"></i>
                </a>

              </div>
            </div>
            
            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Efectivo</b></label>
              <div class="col-sm-9">
                 <input type="text" value = '0' id="efectivo" name="efectivo" placeholder="Valor en efectivo" onKeyPress="return soloNumeros(event)" />
                 
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Transf_banc</b></label>
              <div class="col-sm-9">
                 <input type="text" value = '0' id="transferencia_bancaria" name="transferencia_bancaria" placeholder="Valor Transferencia" onKeyPress="return soloNumeros(event)"/>
                 
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">PSE</b></label>
              <div class="col-sm-9">
                 <input type="text" value = '0' id="pse" name="pse" placeholder="Valor pago PSE" onKeyPress="return soloNumeros(event)"/>
                 
              </div>
            </div>

             <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">T.Credito</b></label>
              <div class="col-sm-9">
                 <input type="text" value = '0' id="tarjeta_credito" name="tarjeta_credito" placeholder="Pago T.cred" onKeyPress="return soloNumeros(event)"/>
                 
              </div>
            </div>

             <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">T.Debito</b></label>
              <div class="col-sm-9">
                 <input type="text" value = '0' id="tarjeta_debito" name="tarjeta_debito" placeholder="Pago T.deb" onKeyPress="return soloNumeros(event)"/>
                 
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Cheque</b></label>
              <div class="col-sm-9">
                 <input type="text" value = '0' id="cheque" name="cheque" placeholder="Valor cheque" onKeyPress="return soloNumeros(event)"/>
                 
              </div>
            </div>


            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Banco</b></label>
              <div class="col-sm-9">
                <select id="id_banco" style="width: 150px;">
                  <option value="" disabled selected>Código Banco</option>
                  @foreach ($Banco as $Ban)
                  <option value="{{$Ban->codigo_ban}}">{{$Ban->codigo_ban}} >> {{$Ban->nombre_ban}}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div><!-- /.span -->


  <div class="col-xs-12 col-sm-6">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title">Detalle de la Factura<span class="brown" id="Acto_Actual"></span></h4>
        <div class="widget-toolbar" id="impresora"  style="display:none">
          <a href="javascript://" id="imprimir" data-action="reload">
            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Factura"></i>
          </a>
        </div>

        <div class="widget-toolbar" id="guardar_btn">
          <a href="javascript://" id="guardar" data-action="reload">
            <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Factura"></i>
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

@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Facturación')
@section('content')
@include('facturacion.modalanombrede')
@include('facturacion.modal_detalle_acargo_de')
@include('facturacion.modalegresosactasfact')
@include('radicacion.modalcliente')
@include('radicacion.modalcliente-empresa')
@include('facturacion.modalfactelectronica')

@if (session('key'))
@section('scripts2')
<script>
    window.onload = function() {
      document.getElementById('id_radica').value = {{ session('key') }};
      var id_radica = document.getElementById('id_radica').value;
      Factura(id_radica, {{ session('opcion') }});
  }
</script>
@endsection
@endif

<div class="alert alert-danger" role="alert" id="msj-error1" style="display:none">
  <strong id="msj1"></strong>
</div>
<div class="alert alert-warning" role="alert" id="msj-error2" style="display:none">
  <strong id="msj2"></strong>
</div>

<div class="row">
    <div class="col-md-9">
        <table class="table table-bordered table-striped">
            <tr>
                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">No.Radicación</b>
                </td>

                <td>
                    <span id="radicacion" class="pink" style="font-size:20px;"></span>
                    <input type="hidden" id="id_radica" value="0">
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">No.Factura</b>
                </td>

                <td>
                    <span id="num_factura" class="pink" style="font-size:20px;"></span>
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">No.Escritura</b>
                </td>

                <td>
                    <span id="num_escritura" class="pink" style="font-size:20px;"></span>
                </td>

            </tr>
            <tr>
                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Año</b>
                </td>

                <td>
                    <span id="anio_radica"></span>
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Fecha</b>
                </td>

                <td>
                    <span id="fecha_fact"></span>
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Imprimir</b>
                </td>

                <td>
                  <a href="javascript://" id="imprimirfactura">
                    <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Factura"></i>
                </a>
            </td>
        </tr>
        <tr>
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="blue">A Nombre de</b></td>
            <td><select id="id_tipoident1" style="width: 100%;">
              <option value="" disabled selected>Tipo Doc</option>
              @foreach ($TipoIdentificaciones as $TipoIdentificacion)
              <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
              @endforeach
          </select></td>
          <td><input type="text" size="10" id="identificacion_cli1" name="identificacion_cli1" placeholder="Identificación" /></td>
          <td><input type="text" readonly size="40" id="nombre_cli1" name="nombre_cli1" /></td>
          <td>
            <a href="javascript://" id="mostrarparticipantes">
              <span class="label label-warning label-white middle">Mostrar</span>
          </a>
      </td>
  </form>
</tr>
</table>

<hr style="border-top: 1px solid #E4E4E4; background: transparent;">

<table class="table table-bordered table-striped">
  <thead>
    <tr>
      <th class="white"  background="{{ asset('images/fondo_th.png')}}">Actos</th>
      <th class="white"  background="{{ asset('images/fondo_th.png')}}">Pago</th>
  </tr>
</thead>

<tbody id="actos">
</tbody>

<thead>
    <tr>
      <th class="white"  background="{{ asset('images/fondo_th.png')}}">Conceptos</th>
      <th class="white"  background="{{ asset('images/fondo_th.png')}}">Pago</th>
  </tr>
</thead>

<tbody id="conceptos">
    @foreach ($Conceptos as $con)
    <tr id="{{$con->atributo}}" style="display:none">
      <td>{{$con->nombre_concep}}</td>
      <td bgcolor="#ccffcc" align="right">
          <span id="total{{$con->atributo}}"></span>
      </td>
      @endforeach
  </tbody>
</table>
</div>

<!---Menu Totales--->
<div class="col-md-3">
  <form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div class="form-group">
        <div class="borde_title">
            <div class="box_title">
                <center><b clas="black" style="font-size:17px;">Forma de Pago</b></center>
            </div>
        </div>
        <div class="borde">
            <div class="box">
                <div class="radio">
                    <label>
                        <input name="formapago" id="contado" type="radio" value="contado" class="ace" />
                        <span class="lbl"> Contado</span>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input name="formapago" id="credito"  type="radio" value="credito" class="ace" />
                        <span class="lbl"> Crédito</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="space-4"></div>
        <div class="borde_total">
            <div class="box_total">
              <input type="hidden" id="totderechos" value="0">
              <input type="hidden" id="totconceptos" value="0">
              <input type="hidden" id="totiva" value="0">
              <input type="hidden" id="totrtf" value="0">
              <input type="hidden" id="totreteconsumo" value="0">
              <input type="hidden" id="totaporteespecial" value="0">
              <input type="hidden" id="totimpuestotimbre" value="0">
              <input type="hidden" id="totfondo" value="0">
              <input type="hidden" id="totsuper" value="0">
              <input type="hidden" id="reteivaide" value="0">
              <input type="hidden" id="retertfide" value="0">
              <input type="hidden" id="reteicaide" value="0">
              <input type="hidden" id="grantotal" value="0">
              <table style="width:100%" border=0>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">Subtotal:</span></td>
                    <td style="width:50%;"><span id="subtotal" style="font-size:16px;"></span></td>
                </tr>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">IVA:</span></td>
                    <td style="width:50%;"><span id="iva" style="font-size:16px;"></span></td>
                </tr>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">RTF:</span></td>
                    <td style="width:50%;"><span id="rtf" style="font-size:16px;"></span></td>
                </tr>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">Imp_consumo:</span></td>
                    <td style="width:50%;"><span id="reteconsumo" style="font-size:16px;"></span></td>
                </tr>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">Super:</span></td>
                    <td style="width:50%;"><span id="super" style="font-size:16px;"></span></td>
                </tr>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">Fondo:</span></td>
                    <td style="width:50%;"><span id="fondo" style="font-size:16px;"></span></td>
                </tr>
                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">Aporte_Especial:</span></td>
                    <td style="width:50%;"><span id="aporteespecial" style="font-size:16px;"></span></td>
                </tr>

                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">Impuesto_Timbre:</span></td>
                    <td style="width:50%;"><span id="impuestotimbre" style="font-size:16px;"></span></td>
                </tr>

                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">ReteIva:</span></td>
                    <td style="width:50%;"><span id="reteiva" class="red" style="font-size:16px;"></span></td>
                </tr>

                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">ReteRtf:</span></td>
                    <td style="width:50%;"><span id="retertf" class="red" style="font-size:16px;"></span></td>
                </tr>

                <tr>
                    <td style="width:20%;"><span style="font-size:16px;">ReteIca:</span></td>
                    <td style="width:50%;"><span id="reteica" class="red" style="font-size:16px;"></span></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="borde_titleRes">
        <div class="box_titleRes">
            <table style="width:100%" border=0>
                <tr>
                    <td style="width:20%;"><b style="font-size:16px;">Total:</b></td>
                    <td style="width:50%;"><b style="font-size:16px;"><span id="totalcompleto"></span></b></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="space-4"></div>
    <div class="borde_title_pago">
        <div class="box_title_pago">
            <center><b clas="black" style="font-size:17px;">Medios de Pago</b></center>
        </div>
    </div>
    <div class="borde_agregar_pago">
        <div class="box_agregar_pago">
            <div>
                <label>Efectivo</label></br>
                <input type="text" id="efectivo" value="0" placeholder="Valor en efectivo" />
                
            </div>
            <div>
                <label>Cheque</label></br>
                <input type="text" id="cheque" value="0" placeholder="Valor del cheque" />
            </div>

            <div>
                <label>Consig_Banc</label></br>
                <input type="text" id="consignacion_bancaria" value="0" placeholder="Valor consignación" />
            </div>

            <div>
                <label>Pse</label></br>
                <input type="text" id="pse" value="0" placeholder="Valor por PSE" />
            </div>

            <div>
                <label>Transf.Banc</label></br>
                <input type="text" id="transferencia_bancaria" value="0" placeholder="Valor Transferencia" />
            </div>

            <div>
                <label>Tar_Cred</label></br>
                <input type="text" id="tarjeta_credito" value="0" placeholder="Valor con tarj de credito" />
            </div>

            <div>
                <label>Tar_Deb</label></br>
                <input type="text" id="tarjeta_debito" value="0" placeholder="Valor con tarj debito" />
            </div>

            <div>
                <label>Bono</label></br>
                <input type="text" id="bono" value="0" placeholder="Valor bono" />
                <input type="text" size="5px" id="codigo_bono" placeholder="#Bono" maxlength="20"/>

                <select id="id_tipo_bono" style="width: 100%;">
                        <option value="" disabled selected>Tipo Bono</option>
                        @foreach ($TipoDeposito as $TipoDepo)
                        <option value="{{$TipoDepo->id_tip}}">{{$TipoDepo->descripcion_tip}}</option>
                        @endforeach
                        </select>
                          <input type="text" id="totalbono" placeholder="Total del bono" />
            </div>
            
            
            
            <div>
                <label>No.Cheque</label></br>
                <input type="text" id="numcheque" value="0" onKeyPress="return soloNumeros(event)" placeholder="Número de Cheque" />
            </div>
            <div>
                <label>Banco</label></br>
                <select id="id_banco" style="width: 100%;">
                    <option value="" disabled selected>Código Banco</option>
                    @foreach ($Banco as $Ban)
                    <option value="{{$Ban->codigo_ban}}">{{$Ban->codigo_ban}} >> {{$Ban->nombre_ban}}</option>
                    @endforeach
                </select>
            </div>
            <div>
            </br>
            <a href="#" id="guardarfacturaunica" class="btn btn-primary btn-lg">
              Guardar Pago
          </a>
      </div>
  </div>
</div>

</div>
</form>
</div>
</div>
<!--Row-->
<script src="{{ asset('assets/js/jquery-2.1.4.min.js')}}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{ asset('css/rect.css')}}" />
@endsection

@section('scripts')
<script src="{{ asset('js/facturacion/formatomoneda.js')}}"></script>
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/facturacion/grid.js')}}"></script>
<script src="{{ asset('js/facturacion/script.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/limpiarclientes.js')}}"></script>
<script src="{{ asset('js/crearclientes.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/validarciudad.js')}}"></script>
@endsection

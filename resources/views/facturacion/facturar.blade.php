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
@include('facturacion.modal_mediopago')
@include('facturacion.modal_errores')
@include('facturacion.modalavisos')
@include('facturacion.modal_error_general')
@include('facturacion.modal_numfact')
@include('facturacion.modalegresosactasfact')
@include('facturacion.modalconfirmaractas')

@if (session('key'))
@section('scripts2')
<script>  

   window.onload = function () {

    // 🔹 FORZAR SIEMPRE RADIO MANUAL
    var radios = document.getElementsByName('seleccion');
    for (var i = 0; i < radios.length; i++) {
        radios[i].checked = false;
    }
    document.getElementById('manual').checked = true;

    // 🔹 Cargar id_radica desde sesión
    document.getElementById('id_radica').value = {{ session('key') }};
    var id_radica = document.getElementById('id_radica').value;   

    // 🔹 Lógica principal
    Factura(id_radica, {{ session('opcion') }}, 0);
  };

</script>
@endsection
@endif

<input type="hidden" id="id_radica" value="0">
<div class="alert alert-danger" role="alert" id="msj-error1" style="display:none">
    <strong id="msj1"></strong>
</div>
<div class="alert alert-warning" role="alert" id="msj-error2" style="display:none">
    <strong id="msj2"></strong>
</div>


<div class="alert alert-danger" role="alert" id="msj-error" style="display:none">
  <strong id="msj"></strong>
</div>
<div class="page-header" style="margin-bottom:20px;">
    
    <div style="
        display:flex; 
        justify-content:space-between; 
        align-items:center; 
        background:linear-gradient(135deg,#f8f9fa,#eef2f7);
        padding:20px;
        border-radius:12px;
        box-shadow:0 4px 12px rgba(0,0,0,0.08);
        border-left:6px solid #ff9800;
    ">

        <!-- LADO IZQUIERDO -->
        <div>
            <h2 style="margin:0; font-weight:600; color:#2c3e50;">
                Facturación de Escrituras
            </h2>

            <div style="margin-top:8px; font-size:14px; color:#6c757d;">
                Fecha Factura: 
                <span id="fecha_escritura" style="font-weight:600; color:#34495e;"></span>
            </div>
        </div>

        <!-- LADO DERECHO -->
        <div style="text-align:right;">

            <div style="font-size:15px; margin-bottom:6px;">
                <strong>Radicación No:</strong>
                <span id="numfat" style="color:#e53935; font-size:18px; font-weight:bold;">
                    {{ $id_radica }}
                </span>
            </div>

            <div style="font-size:15px; margin-bottom:6px;">
                <strong>No. Escritura:</strong>
                <span id="num_escritura" style="color:#1e88e5; font-size:17px; font-weight:600;"></span>
            </div>

            <div style="font-size:15px;">
                <strong>No. Factura:</strong>
                <span id="num_factura" style="color:#43a047; font-size:17px; font-weight:600;"></span>
            </div>

        </div>

    </div>

</div>


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
            <input type="hidden" id="idregistrohiden">
            
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

               <a href="javascript://" id="mostrarparticipantes" data-action="collapse" data-action="reload">
                  <i><img src="{{ asset('images/usuario.png') }}" width="28 px" height="28 px" title="Consumidor Final"></i>
                </a>


            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">Forma_Pago</b></label>
              <div class="col-sm-9">
                <select id="id_formapago" name="forma_pago" style="width: 150px;">
                  <option value="" disabled selected>Seleccione</option>
                  <option value="0">Contado</option>
                  <option value="1">Crédito</option>
                </select>
              </div>
            </div>

             <div class="radio">
                <label>
                  <input name="seleccion" id="manual" value="manual" type="radio" class="ace input-lg" onclick="ValidacionManual();"  checked/>
                  <span class="lbl bigger-120"> Manual</span>
                </label>
                 <label>
                  <input name="seleccion" id="porcentaje" value="porcentaje" type="radio" class="ace input-lg" onclick="ValidacionManual();" />
                  <span class="lbl bigger-120"> Porcentaje</span>
                </label>
              </div>
              <br>              

            <table id="data1" class="table table-bordered table-striped">
            <thead>
              <tr>                
                <th>Descripción Acto</th>
                <th>Total Derechos</th>                
                <th>Valor a facturar</th>
                <th>Saldo restante</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data_derechos"></tbody>
          </table>
          <hr style="border-color: orange;">
          <table id="data2" class="table table-bordered table-striped">
            <thead>
              <tr>                
                <th>Descripción Concepto</th>
                <th>Total Concepto</th>                
                <th>Valor a facturar</th>
                <th>Saldo restante</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data_conceptos">
           
            </tbody>
          </table>

           <hr style="border-color: orange;">
           <table id="data2" class="table table-bordered table-striped">
            <thead>
              <tr>                
                <th>Descripción Recaudos</th>
                <th>Total Recaudos</th>                
                <th>Valor a facturar</th>
                <th>Saldo restante</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="data_recaudos">

            </tbody>
          </table>            
           


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

        <div class="widget-toolbar" id="autoretenciones">
           <button id="boton_autoretenciones" type="button" style="height:27px; line-height:20px; padding:0 6px; font-size:11px;">
              Autorretenciones
            </button>
          <a href="javascript://" id="guardar">
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
                <th>Descripción</th>
                <th>Valor</th>                
                <th></th>
              </tr>
            </thead>
            <tbody id="data_detalle"></tbody>
          </table>




        </div>
      </div>
    </div>
  </div><!-- /.span -->




</div><!--- /row -->



@endsection

@section('scripts')
<script src="{{ asset('js/facturacion/formatomoneda.js')}}"></script>
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/facturacion/grid_facturar.js')}}"></script>
<script src="{{ asset('js/facturacion/script_facturar.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/crearclientes.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/validarciudad.js')}}"></script>
@endsection
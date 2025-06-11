@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="alert alert-danger" role="alert" id="msj-error" style="display:none">
  <strong id="msj"></strong>
</div>
<div class="page-header">

  <table>
    <tr>
      <td width="700">
        <h1>
          Módulo de Registro
        </h1>
      </td>
      <td align="right" width="500">
        <b>
          Registro No.&nbsp; <font color="Red" size="4"><span id="numregistro"></span></font>
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
        <h4 class="widget-title">Agregar Concepto <span class="brown" id="Acto_Actual"></span></h4>
        <div class="widget-toolbar" id="botonnuevo">
          <a href="javascript://" id="nuevoregistro" data-action="reload">
            <i><img src="{{ asset('images/nuevo7.png') }}" width="28 px" height="28 px" title="Nuevo registro"></i>
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
          
            <input type="hidden" id="itemrapida" value=0>
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          

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
                <input type="text" size="12" id="serial" placeholder="serial" />

                <a href="javascript://" id="agregaritem" data-action="collapse" data-action="reload">
                  <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Item"></i>
                </a>

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
        <h4 class="widget-title">Detalle Registro<span class="brown" id="Acto_Actual"></span></h4>
        <div class="widget-toolbar" id="impresora"  style="display:none">
          <a href="javascript://" id="imprimir" data-action="reload">
            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir"></i>
          </a>
        </div>

        <div class="widget-toolbar" id="guardar_btn">
          <a href="javascript://" id="guardar" data-action="reload">
            <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar"></i>
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
                <th>Serial</th>
                <th>Cantidad</th>                
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
<script src="{{ asset('js/registro/script.js')}}"></script>
@endsection

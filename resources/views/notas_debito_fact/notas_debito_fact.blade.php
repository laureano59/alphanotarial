@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Nota Debito')
@section('content')
  <div class="alert alert-warning" role="alert" id="msj-error1" style="display:none">
    <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
    <strong id="msj1">
    </strong>
  </div>
  
  <div class="page-header">

      <h1>
          Seleccione el Número de Factura para Nota Debito

          <small>
              <span class="nav-search widget-toolbar ">
                  <form>
                      @csrf
                      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                      <input type="text" id="id_fact" onKeyPress="return soloNumeros(event)" placeholder="Buscar Factura" class="nav-search-input" autocomplete="off" />
                      <a href="javascript://" id="buscar_fact">
                          <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Encontrar Factura"></i>
                      </a>
                  </form>

              </span>
          </small>
      </h1>
  </div><!-- /.page-header -->

  <div align="right">

      <h4>
          <font color="Green"> Número Nota Debito : <span id="id_ndf"></span></font>
          <input type="hidden" id="id_notadebito">

          
      </h4>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-sm-7">
      <div class="widget-box">
        <div class="widget-header">
          <div class="widget-toolbar">
              <a href="#" id="crear_notadebito" data-action="reload">
                <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Crear Nota"></i>
              </a>
          </div>
          <h4 class="widget-title">Información de la Factura</h4>
        </div>
        <div class="widget-body">
          <table class="table table-bordered table-striped">
            <thead class="thin-border-bottom">
              <tr>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>No Fact
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Fech Fact
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>No Identif
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Nombre Cli
                </th>
                <th class="hidden-480">
                  <i class="ace-icon fa fa-caret-right blue"></i>Total Fact
                </th>
              </tr>
            </thead>
            <tbody id="data"></tbody>
          </table>
        </div>
      </div>
    </div>


    <div class="col-sm-5">
      <div class="widget-box">
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="widget-header">
              <div class="widget-toolbar">
                <a href="#" id="agregarconcepto">
                  <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Concepto"></i>
                </a>
              </div>
              <h4 class="widget-title">Conceptos</h4>
              <select  id="id_conc" data-placeholder="Seleccione un Concepto">
                  <option value="" disabled selected>Seleccione un Concepto</option>
                  @foreach ($Conceptos as $cp)
                   <option value="{{$cp->id_concep}}">{{$cp->nombre_concep}}</option>
                  @endforeach
              </select>
            </div>
            <div class="widget-body">
              <div class="form-horizontal">
                <br>
                <div class="form-group">
                  <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="red">Cantidad</b> </label>
                  <div class="col-sm-4">
                    <input type="text" id="cant" maxlength="3" onKeyPress="return soloNumeros(event)"  class="col-xs-10 col-sm-5" />
                  </div>
                </div>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
  </div><!--/.row -->
  <br>
   <div class="row">
    <div class="col-sm-12">
      <div class="widget-box">
        <div class="widget-header" align="center">
          <div class="widget-toolbar">
              <a href="#" id="enviar_nota_debito" data-action="reload">
                <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Enviar"></i>
              </a>
          </div>
          <h4 class="widget-title">Detalle Nota Debito</h4>
        </div>
        <div class="widget-body">
          <table class="table table-bordered table-striped">
            <thead class="thin-border-bottom">
              <tr>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Id
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Concepto
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Cantidad
                </th>
                <th>
                  <i class="ace-icon fa fa-caret-right blue"></i>Valor
                </th>
                <th class="hidden-480">
                  <i class="ace-icon fa fa-caret-right blue"></i>Sub Total
                </th>
                <th class="hidden-480">
                  <i class="ace-icon fa fa-caret-right blue"></i>Iva
                </th>
                <th class="hidden-480">
                  <i class="ace-icon fa fa-caret-right blue"></i>Total
                </th>
                <th class="hidden-480">
                  
                </th>
              </tr>
            </thead>
            <tbody id="detalle"></tbody>
          </table>
        </div>
      </div>
    </div>
   </div>

  

@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/notas_debito_fact/script.js')}}"></script>

@endsection

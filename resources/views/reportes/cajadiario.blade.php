@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        {{$nombre_reporte}}<span id="radi">

    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">


            <div class="control-group">
              <label class="control-label bolder blue">Seleccione Tipo de Informe</label>
              <div class="radio">
                <label>
                  <input name="seleccion" id="completo" value="completo" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120"> Informe Completo</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="contado" value="contado" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120"> Facturas de Contado</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="credito" value="credito" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120"> Facturas a Crédito</span>
                </label>
              </div>
            </div>
            







            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Ingresar Rango de Fecha</h4>
                    <span class="widget-toolbar">
                        <a target="_blank" href="/cajadiariopdf">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Reporte"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="generarreporte">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group">
                            <input type="text" class="input-sm form-control" name="start" id="start" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" />
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
                <table id="simple-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.Fac</th>
                            <th>Fecha</th>
                            <th>No.Esc</th>
                            <th>Derechos</th>
                            <th>Conceptos</th>
                            <th>Total Ingresos</th>
                            <th>I.V.A</th>
                            <th>Recaudos</th>
                            <th>Aport_Espe</th>
                            <th>Retención</th>
                            <th>ReteIva</th>
                            <th>ReteIca</th>
                            <th>Retefuente</th>
                            <th>Gran Total</th>
                            <th>Tipo Pago</th>
                            <th>Estado</th>
                            <th>No.Not</th>
                        </tr>
                    </thead>
                    <tbody id="datos"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Total Recibido</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">
                <table class="table table-bordered table-striped">
                    <thead class="thin-border-bottom">
                        <tr>
                            <th>
                                <i class="ace-icon fa fa-caret-right blue"></i>ITEM
                            </th>

                            <th>
                                <i class="ace-icon fa fa-caret-right blue"></i>VALOR
                            </th>
                        </tr>
                    </thead>
                    <tbody id="datos_totales"></tbody>
                </table>
            </div><!-- /.widget-main -->
        </div><!-- /.widget-body -->
      </div>
    </div>


    <div class="col-sm-5">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Cruces de Depósitos</h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">
              <table class="table table-bordered table-striped">
                  <thead class="thin-border-bottom">
                      <tr>
                          <th>
                              <i class="ace-icon fa fa-caret-right blue"></i>No.Factura
                          </th>

                          <th>
                              <i class="ace-icon fa fa-caret-right blue"></i>No.Acta
                          </th>

                          <th>
                              <i class="ace-icon fa fa-caret-right blue"></i>Fecha_Acta
                          </th>

                          <th>
                              <i class="ace-icon fa fa-caret-right blue"></i>Valor Cruce
                          </th>
                      </tr>
                  </thead>
                  <tbody id="data_cruce"></tbody>
              </table>
            </div>
          </div>
              </div>
        </div>


</div>


@endsection

@section('csslau')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}" />
@endsection

@section('scripts')
  <script src="{{ asset('js/__AJAX.js')}}"></script>
  <script src="{{ asset('js/calendario.js')}}"></script>
  <script src="{{asset('js/reportes/script.js')}}"></script>
  <script src="{{asset('js/reportes/grid.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.custom.min.js')}}"></script>
  <script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/spinbox.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('assets/js/autosize.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
  <script src="{{ asset('js/solonumeros.js')}}"></script>
  <script src="{{ asset('js/formatonumero.js')}}"></script>
  <script src="{{ asset('js/numberFormat154.js')}}"></script>
@endsection

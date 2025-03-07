@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
      <span id="reporte">
         {{$nombre_reporte}}
      </span>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-12">
        <form>
             @csrf
            <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="control-group">
              <label class="control-label bolder blue">Seleccione Tipo de Informe</label>
              <div class="radio">
                <label>
                  <input name="seleccion" id="maycero" value="maycero" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Informe con saldos mayor a Cero</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="completo" value="completo" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120">Informe completo</span>
                </label>
              </div>

              
            </div>  
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Ingresar Identificación del Cliente</h4>
                    <span class="widget-toolbar">
                        <a target="_blank" href="/printinformecarterabonos">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Reporte"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="generarreportecarterabonosactivas">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                     <span id="Botonexcel" class="widget-toolbar" style="display:none">
                        <a href="#" data-action="settings" id="excelcarteraclientebonosacti">
                            <i><img src="{{ asset('images/icoexcel.png') }}" width="28 px" height="28 px" title="Convertir a Excel"></i>
                        </a>
                    </span>

                     <span class="nav-search widget-toolbar">
                        <input type="text" id="identificacion_cli" placeholder="Escribir No.Identificación" class="nav-search-input" />
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
                            <th>Código.Bono</th>
                            <th>Factura</th>
                            <th>Fecha.Fact</th>
                            <th>Escritura</th>
                            <th>Identificación</th>
                            <th>Cliente</th>
                            <th>Valor Bono</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody id="carteradata">

                    </tbody>
                </table>
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
 
  <script src="{{ asset('js/calendario.js')}}"></script>
  <script src="{{ asset('js/__AJAX.js')}}"></script>
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

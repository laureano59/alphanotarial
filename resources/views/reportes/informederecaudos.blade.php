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
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Ingresar Rango de Fecha</h4>
                    <span class="widget-toolbar">
                        <a target="_blank" href="/informederecaudospdf">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Reporte"></i>
                        </a>
                    </span>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="generarinformederecaudos">
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
                            <th>Rango Cuantía</th>
                            <th>Cant.Escr</th>
                            <th>Valor Recaudo Super</th>
                            <th>Valor Recaudo Fonfo</th>
                            <th>Tarifa</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><b>Sin Cuantia</b></td>
                        <td><span id="sincescr"></span></td>
                        <td align="right">
                          <span id="sincsuper"></span> 
                        </td>
                        <td align="right">
                          <span id="sincfondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor1"></span> 
                        </td>
                        <td align="right">
                          <span id="sinctotal"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td><b>Excenta</b></td>
                        <td>
                          <span id="excescr"></span>
                        </td>
                        <td align="right">
                          <span id="excsuper"></span> 
                        </td>
                        <td align="right">
                          <span id="excfondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor1b"></span> 
                        </td>
                        <td align="right">
                          <span id="exctotal"></span> 
                        </td>
                      </tr>
                      <tr>
                        <td>$0 A $100,000,000</td>
                        <td>
                          <span id="ran1escr"></span> 
                        </td>
                        <td align="right">
                          <span id="ran1super"></span> 
                        </td>
                        <td align="right">
                          <span id="ran1fondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor2"></span> 
                        </td>
                        <td align="right">
                          <span id="ran1total"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td>$100,000,001 A $300,000,000</td>
                        <td>
                          <span id="ran2escr"></span> 
                        </td>
                        <td align="right">
                          <span id="ran2super"></span> 
                        </td>
                        <td align="right">
                          <span id="ran2fondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor3"></span> 
                        </td>
                        <td align="right">
                          <span id="ran2total"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td>$300,000,001 A $500,000,000</td>
                        <td>
                          <span id="ran3escr"></span> 
                        </td>
                        <td align="right">
                          <span id="ran3super"></span> 
                        </td>
                        <td align="right">
                          <span id="ran3fondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor4"></span> 
                        </td>
                        <td align="right">
                          <span id="ran3total"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td>$500,000,001 A $1,000,000,000</td>
                        <td>
                          <span id="ran4escr"></span> 
                        </td>
                        <td align="right">
                          <span id="ran4super"></span> 
                        </td>
                        <td align="right">
                          <span id="ran4fondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor5"></span> 
                        </td>
                        <td align="right">
                          <span id="ran4total"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td>$1,000,000,001 A $1,500,000,000</td>
                        <td>
                          <span id="ran5escr"></span> 
                        </td>
                        <td align="right">
                          <span id="ran5super"></span> 
                        </td>
                        <td align="right">
                          <span id="ran5fondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor6"></span> 
                        </td>
                        <td align="right">
                          <span id="ran5total"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td>DE $1,500,000,001 En adelante</td>
                        <td>
                          <span id="ran6escr"></span> 
                        </td>
                        <td align="right">
                          <span id="ran6super"></span> 
                        </td>
                        <td align="right">
                          <span id="ran6fondo"></span> 
                        </td>
                        <td align="right">
                          <span id="valor7"></span> 
                        </td>
                        <td align="right">
                          <span id="ran6total"></span> 
                        </td>
                      </tr>

                      <tr>
                        <td><b>Totales</b></td>
                        <td>
                          <b><span id="total_escrituras"></span></b>
                        </td>
                        <td align="right">
                          <b><span id="total_super"></span> </b>
                        </td>
                        <td align="right">
                          <b><span id="total_fondo"></span> </b>
                        </td>
                        <td><b>Total Recaudos</b></td>
                        <td align="right">
                          <b><span id="total_recaudos"></span></b>
                        </td>
                      </tr>

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
  <script src="{{ asset('js/reportes/script.js')}}"></script>
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

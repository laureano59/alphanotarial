@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">

    <h1>
        Informe de Enajenaciones para la DIAN<span id="radi">

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
                  <input name="seleccion" id="enajenacionesprincipales" value="enajenacionesprincipales" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120"> Enajenaciones vendedores y compradores principales</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="enajenacionesvendedoressecundarios" value="enajenacionesvendedoressecundarios" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120"> Enajenaciones Vendedores secundarios</span>
                </label>
              </div>

              <div class="radio">
                <label>
                  <input name="seleccion" id="enajenacionescompradoressecundarios" value="enajenacionescompradoressecundarios" type="radio" class="ace input-lg" />
                  <span class="lbl bigger-120"> Enajenaciones Compradores secundarios</span>
                </label>
              </div>

          </div>


            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Digite el Rango de Fecha</h4>
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" 
                        id="generar_informe_enajenaciones_dian">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Generar Informe"></i>
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
@endsection

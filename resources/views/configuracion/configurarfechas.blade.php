@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control Configuraciones')
@section('content')

  <div class="page-header">

      <h1>
          Configuración de Fechas Para Facturación, Numeración, Depósitos y Cruces<span id="radi">

      </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-sm-4">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Configurar Fecha</h4>

          <span class="widget-toolbar">
            <a href="javascript://" id="GuardarCambiosFecha" data-action="reload">
                <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
            </a>
          </span>
        </div>

        <div class="alert alert-success" role="alert" id="msj-error" style="display:none">
          <strong id="msj"></strong>
        </div>

        <div class="widget-body">
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          <div class="widget-main">
            <label for="id-date-picker-1"><p class="pink"> Fecha de Facturación</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">
                  <input class="form-control date-picker1" id="fecha_facturacion" type="text" value="{{$fecha_fact}}" data-date-format="dd-mm-yyyy" />
                  <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                  </span>
                </div>
              </div>
            </div>

            <div class="space space-8"></div>
            <label><p class="pink"> Fecha de Numeración</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">
                  <input class="form-control date-picker2" id="fecha_numeracion" type="text" value="{{$fecha_esc}}" data-date-format="dd-mm-yyyy" />
                  <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                  </span>
                </div>
              </div>
            </div>

            <hr />
            <label for="id-date-range-picker-1"><p class="pink"> Fecha de Facturación por el Sistema</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">

                  <label>
                    <input id="switch1" name="switch1" @if ($fecha_fact_automatica == true)checked @endif class="ace ace-switch ace-switch-6" type="checkbox" />
                    <span class="lbl"></span>
                  </label>

                </div>
              </div>
            </div>

            <hr />
            <label for="id-date-range-picker-1"><p class="pink"> Fecha de Numeración por el Sistema</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">

                  <label>
                    <input id="switch2" name="switch2" @if ($fecha_esc_automatica == true)checked @endif class="ace ace-switch ace-switch-6" type="checkbox" />
                    <span class="lbl"></span>
                  </label>

                </div>
              </div>
            </div>

            <hr />
          </div>
        </form>
        </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Configurar Fecha Depósitos y Cruces</h4>

          <span class="widget-toolbar">
            <a href="javascript://" id="GuardarCambiosFecha_Actas" data-action="reload">
                <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
            </a>
          </span>
        </div>

        <div class="alert alert-success" role="alert" id="msj-error1" style="display:none">
          <strong id="msj1"></strong>
        </div>

        <div class="widget-body">
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          <div class="widget-main">
            <label for="id-date-picker-1"><p class="pink">Fecha de Depósitos</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">
                  <input class="form-control date-picker1" id="fecha_acta" type="text" value="{{$fecha_acta}}" data-date-format="dd-mm-yyyy" />
                  <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                  </span>
                </div>
              </div>
            </div>

            <div class="space space-8"></div>
            <label><p class="pink"> Fecha de Cruces</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">
                  <input class="form-control date-picker2" id="fecha_egreso" type="text" value="{{$fecha_egreso}}" data-date-format="dd-mm-yyyy" />
                  <span class="input-group-addon">
                    <i class="fa fa-calendar bigger-110"></i>
                  </span>
                </div>
              </div>
            </div>

            <hr />
            <label for="id-date-range-picker-1"><p class="pink"> Fecha de Depósitos por el Sistema</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">

                  <label>
                    <input id="switch3" name="switch3" @if ($fecha_acta_automatica == true)checked @endif class="ace ace-switch ace-switch-6" type="checkbox" />
                    <span class="lbl"></span>
                  </label>

                </div>
              </div>
            </div>

            <hr />
            <label for="id-date-range-picker-1"><p class="pink"> Fecha de Cruces por el Sistema</p></label>

            <div class="row">
              <div class="col-xs-8 col-sm-11">
                <div class="input-group">

                  <label>
                    <input id="switch4" name="switch4" @if ($fecha_egreso_automatica == true)checked @endif class="ace ace-switch ace-switch-6" type="checkbox" />
                    <span class="lbl"></span>
                  </label>

                </div>
              </div>
            </div>

            <hr />
          </div>
        </form>
        </div>
      </div>
    </div>

  </div>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}" />
<link rel="stylesheet" href="{{asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}" />

@endsection

@section('scripts')
  <script src="{{ asset('js/__AJAX.js')}}"></script>
  <script src="{{asset('js/configuracion/script.js')}}"></script>
  <script src="{{asset('assets/js/jquery-ui.custom.min.js')}}"></script>
  <script src="{{asset('assets/js/chosen.jquery.min.js')}}"></script>
  <script src="{{asset('assets/js/spinbox.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('assets/js/autosize.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
  <script src="{{asset('assets/js/jquery.maskedinput.min.js')}}"></script>
@endsection

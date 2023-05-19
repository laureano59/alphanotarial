@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
@include('radicacion.modalactosradica')
@include('radicacion.modalcliente')
@include('radicacion.modalcliente-empresa')
<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse  ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {}
    </script>

</div>

    <!--  Top Menu  -->
    <div class="alert alert-danger" role="alert" id="msj-errorrad1" style="display:none">
      <strong id="msjrad1"></strong>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-6">
          <div class="alert alert-danger" role="alert" id="msj-error" style="display:none">
            <strong id="msj"></strong>
          </div>
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            @include('radicacion.form')
          </form>
        </div><!-- /.span -->



        <div class="col-xs-12 col-sm-6">
          <div class="alert alert-warning" role="alert" id="msj-error2" style="display:none">
            <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
            <strong id="msj2"></strong>
          </div>
          <form>
            @csrf
            <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
            @include('radicacion.form-actos')
          </form>
        </div><!-- /.span -->

    </div><!--/.row -->


    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <center>
                        <h4 class="widget-title">Actos Cuantia y Tradición</h4>
                    </center>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                      <div class="alert alert-warning" role="alert" id="msj-error3" style="display:none">
                        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                        <strong id="msj3"></strong>
                      </div>
                        <table id="simple-table" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Acto</th>
                                    <th>Cuantia</th>
                                    <th>
                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                        Tradición
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="datos"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div>


    <div class="row" id="clientesprincipales" style="display: none;">
      <div id="dialog-confirm" class="hide">
        <div id="msg" class="alert alert-info bigger-110">

        </div>

        <div class="space-6"></div>

        <p class="bigger-110 bolder center grey">
        </p>
      </div><!-- #dialog-confirm -->

        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Otorgantes y Comparecientes Principales <font color="orange">>></font> <span class="brown" id="Acto_Actual"></span></h4>
                    <div class="widget-toolbar">
                        <a href="#" id="ActualizarPrincipales" data-action="reload">
                            <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
                        </a>

                        <a href="javascript://" id="Adicionales">
                            <i><img src="{{ asset('images/lupa.png') }}" width="28 px" height="28 px" title="Vendedores y Compradores Adicionales"></i>
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
                          <input type="hidden" id="id_actoperrad">
                          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">1. En Calidad de</b></label>
                                <div class="col-sm-9">
                                    <select id="calidad1" style="width: 135px;">
                                        <option value="" disabled selected>Elija Calidad</option>
                                        @foreach ($calidad1 as $cal1)
                                          @if($cal1->id_cal1 != 24)
                                            <option value="{{$cal1->id_cal1}}">{{$cal1->nombre_cal1}}</option>
                                          @endif
                                        @endforeach
                                    </select>
                                    <select id="id_tipoident1" style="width: 70px;">
                                        <option value="" disabled selected>T.Doc</option>
                                        @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                                          <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" size="10" id="identificacion_cli1" name="identificacion_cli1" placeholder="Identificación" />
                                    <input type="text" readonly size="40" id="nombre_cli1" name="nombre_cli1" />
                                    <input type="text" size="6" id="porcentajecli1" name="porcentajecli1" placeholder="% Partc" />
                                    <span id ="adicionales1" style="display: none;">
                                      <a href="javascript://" id="guardaradicional1" data-action="collapse">
                                          <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Adicionales"></i>
                                      </a>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1-1"><b class="red">2. En Calidad de</b></label>
                                <div class="col-sm-9">
                                  <select id="calidad2" style="width: 135px;">
                                      <option value="" disabled selected>Elija Calidad</option>
                                      @foreach ($calidad2 as $cal2)
                                        @if($cal2->id_cal2 != 23)
                                          <option value="{{$cal2->id_cal2}}">{{$cal2->nombre_cal2}}</option>
                                        @endif
                                      @endforeach
                                  </select>
                                  <select id="id_tipoident2" style="width: 70px;">
                                      <option value="" disabled selected>T.Doc</option>
                                      @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                                        <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                                      @endforeach
                                  </select>
                                  <input type="text" size="10" id="identificacion_cli2" name="identificacion_cli2" placeholder="Identificación" />
                                  <input type="text" readonly size="40" id="nombre_cli2" name="nombre_cli2" />
                                  <input type="text" size="6" id="porcentajecli2" name="porcentajecli2" placeholder="% Partc" />
                                  <span id ="adicionales2" style="display: none;">
                                    <a href="javascript://" id="guardaradicional2" data-action="collapse">
                                        <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Adicionales"></i>
                                    </a>
                                  </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div><!--- /row -->


    <div class="row" id="adicionales" style="display: none;">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"><b class="green">Otorgantes y Comparecientes Adicionales</b></h4>
                    <div class="widget-toolbar">
                        <a href="javascript://" id="agregar" data-action="reload">
                            <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Adicionales"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                      <div class="alert alert-warning" role="alert" id="msj-error5" style="display:none">
                        <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                        <strong id="msj5"></strong>
                      </div>
                        <form class="form-horizontal" role="form">
                          @csrf
                          <input type="hidden" name="_token3" value="{{csrf_token()}}" id="token3">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"><b class="red">1. En Calidad de</b></label>
                                <div class="col-sm-9">
                                  <select id="calidad3" style="width: 135px;">
                                      <option value="" disabled selected>Elija Calidad</option>
                                      @foreach ($calidad1 as $cal1)
                                        <option value="{{$cal1->id_cal1}}">{{$cal1->nombre_cal1}}</option>
                                      @endforeach
                                  </select>
                                    <select id="id_tipoident3" style="width: 70px;">
                                        <option value="" disabled selected>T.Doc</option>
                                        @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                                          <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" size="10" id="identificacion_cli3" name="identificacion_cli3" placeholder="Identificación" />
                                    <input type="text" readonly size="40" id="nombre_cli3" name="nombre_cli3" />
                                    <input type="text" size="6" id="porcentajecli3" name="porcentajecli3" placeholder="% Partc" />
                                  </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div><!--- /row -->

    <div class="row" id="veradicionales" style="display: none;">
        <div class="col-xs-12 col-sm-6">
          <div class="alert alert-danger" role="alert" id="msj-error1" style="display:none">
            <strong id="msj1"></strong>
          </div>
          <div class="widget-box">
              <div class="widget-header">
                  <h4 class="widget-title">Otorgantes</h4>
                  <div class="widget-toolbar">
                    <!-- iconos  -->
                  </div>
              </div>

              <div class="widget-box widget-color-blue" id="widget-box-2">
                <div class="widget-header">
                  <h5 class="widget-title bigger lighter">
                    <i class="ace-icon fa fa-table"></i>
                    Otorgantes Adicionales
                  </h5>
                </div>
              <div class="widget-body">
                  <div class="widget-main">
                      <div class="form-horizontal">
                        <div class="widget-body">
                          <div class="widget-main no-padding">
                            <div class="alert alert-warning" role="alert" id="msj-error6" style="display:none">
                              <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                              <strong id="msj6"></strong>
                            </div>
                            <table class="table table-striped table-bordered table-hover">
                              <thead class="thin-border-bottom">
                                <tr>
                                  <th>
                                    Identificación
                                  </th>

                                  <th>
                                    <i class="ace-icon fa fa-user"></i>
                                    Nombre
                                  </th>
                                  <th >% Partc</th>
                                  <th ></th>
                                </tr>
                              </thead>
                              <tbody id="infotorgantes"></tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="space-10"></div>
                  </div>
              </div>
            </div>
          </div>
        </div><!-- /.span -->

        <div class="col-xs-12 col-sm-6">
          <div class="alert alert-danger" role="alert" id="msj-error1" style="display:none">
            <strong id="msj1"></strong>
          </div>
          <div class="widget-box">
              <div class="widget-header">
                  <h4 class="widget-title">Comparecientes</h4>
                  <div class="widget-toolbar">
                    <!-- iconos  -->
                  </div>
              </div>

              <div class="widget-box widget-color-blue" id="widget-box-2">
                <div class="widget-header">
                  <h5 class="widget-title bigger lighter">
                    <i class="ace-icon fa fa-table"></i>
                    Comparecientes Adicionales
                  </h5>
                </div>
              <div class="widget-body">
                  <div class="widget-main">
                      <div class="form-horizontal">
                        <div class="widget-body">
                          <div class="widget-main no-padding">
                            <div class="alert alert-warning" role="alert" id="msj-error7" style="display:none">
                              <span class="fa fa-exclamation-circle" aria-hidden="true"></span>
                              <strong id="msj7"></strong>
                            </div>
                            <table class="table table-striped table-bordered table-hover">
                              <thead class="thin-border-bottom">
                                <tr>
                                  <th>
                                    Identificación
                                  </th>

                                  <th>
                                    <i class="ace-icon fa fa-user"></i>
                                    Nombre
                                  </th>
                                  <th >% Partc</th>
                                  <th ></th>
                                </tr>
                              </thead>
                              <tbody id="infcomparecientes"></tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                      <div class="space-10"></div>
                  </div>
              </div>
            </div>
          </div>
        </div><!-- /.span -->

    </div><!--/.row -->

    <script src="{{ asset('assets/js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>

    <script>
        $("#cua").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
            }
        });

        $("#cu").on({
            "focus": function(event) {
                $(event.target).select();
            },
            "keyup": function(event) {
                $(event.target).val(function(index, value) {
                    return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
            }
        });
    </script>

    <script>
        jQuery(document).ready(function() {

            jQuery.getScript("//harvesthq.github.io/chosen/chosen.jquery.js")
                .done(function(script, textStatus) {
                    jQuery(".chosen1").chosen();
                    jQuery(".chosen2").chosen({
                        max_selected_options: 2
                    });
                    jQuery(".chosen2").bind("chosen:maxselected", function() {
                        alert("Máximo número de elementos seleccionado")
                    });
                    jQuery(".chosen3").chosen({
                        allow_single_deselect: true,
                        disable_search_threshold: 100
                    });
                })
                .fail(function(jqxhr, settings, exception) {
                    alert("Error");
                });
        });
    </script>

    @endsection

@section('csslau')
  <link rel="stylesheet" href="{{ asset('css/formatos.css')}}" />
	<link rel="stylesheet" href="{{ asset('css/lau.css')}}" />

  <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
  <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datepicker3.min.css')}}" />
@endsection



@section('scripts')
  <script src="{{ asset('js/radicacion/script.js')}}"></script>
  <script src="{{ asset('js/radicacion/scriptactosradica.js')}}"></script>
  <script src="{{ asset('js/radicacion/scriptbuscar.js')}}"></script>
  <script src="{{ asset('js/radicacion/scriptgrid.js')}}"></script>
  <script src="{{ asset('js/radicacion/scriptcliente.js')}}"></script>
  <script src="{{ asset('js/radicacion/dialogos.js')}}"></script>
  <script src="{{ asset('js/radicacion/scriptvalidaractos.js')}}"></script>
  <script src="{{ asset('js/solonumeros.js')}}"></script>
  <script src="{{ asset('js/__AJAX.js')}}"></script>
  <script src="{{ asset('js/validaradicacion.js')}}"></script>
  <script src="{{ asset('js/limpiarclientes.js')}}"></script>
  <script src="{{ asset('js/crearclientes.js')}}"></script>
  <script src="{{ asset('js/validarciudad.js')}}"></script>
  

  <script src="{{ asset('js/calendario.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap-datepicker.min.js')}}"></script>
    
 
@endsection

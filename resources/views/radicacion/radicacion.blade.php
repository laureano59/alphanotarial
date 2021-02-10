@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
<div id="sidebar" class="sidebar h-sidebar navbar-collapse collapse  ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {}
    </script>

    <!--  Top Menu  -->

    <div class="row">
        <div class="col-xs-12 col-sm-6">
          <form  method="POST" action="/radicacion">
            @csrf
            @include('radicacion.form')
        </div><!-- /.span -->
      </form>


        <div class="col-xs-12 col-sm-6">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Actos</h4>
                    <span class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Acto"></i>
                        </a>
                        <a href="#" data-action="reload">
                            <i><img src="{{ asset('images/guardar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
                        </a>
                    </span>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <div>
                            <form class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Actos </label>
                                    <div class="col-sm-9">
                                        <select class="chosen1" id="form-field-select-3" data-placeholder="Seleccione un Acto">
                                            <option value="" disabled selected>Seleccione un Acto</option>
                                            @foreach ($Actos as $Acto)
                                            <option value="{{$Acto->id_acto}}">{{$Acto->nombre_acto}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Cuantia </label>

                                    <div class="col-sm-9">
                                        <input type="text" id="cuantia" name="cuantia" class="col-xs-10 col-sm-5" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Tradición </label>

                                    <div class="col-sm-9">
                                        <input type="number" id="tradicion" name="tradicion" class="col-xs-10 col-sm-5" />
                                    </div>
                                </div>
                            </form>
                            <div class="space-10"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div><!--/.row -->


    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <center>
                        <h4 class="widget-title">Actos Radicados</h4>
                    </center>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <table id="simple-table" class="table  table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th>Acto</th>
                                    <th>Cuantia</th>
                                    <th>
                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                        Tradición
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td class="center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td><a href="#">Compra Venta</a></td>
                                    <td>$50.000.000</td>
                                    <td>2000</td>
                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">

                                            <button class="btn btn-xs btn-info" title="Editar">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>
                                            </button>

                                            <button class="btn btn-xs btn-danger" title="Eliminar">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" />
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    <td><a href="#">Dación en Pago</a></td>
                                    <td>$25000000</td>
                                    <td>2000</td>
                                    <td>
                                        <div class="hidden-sm hidden-xs btn-group">

                                            <button class="btn btn-xs btn-info" title="Editar">
                                                <i class="ace-icon fa fa-pencil bigger-120"></i>
                                            </button>

                                            <button class="btn btn-xs btn-danger" title="Eliminar">
                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div><!-- /.span -->
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Otorgantes y Comparecientes Principales</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="reload">
                            <i><img src="{{ asset('images/guardar.png') }}" width="28 px" height="28 px" title="Guardar Cambios"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Otorgante </label>
                                <div class="col-sm-9">
                                    <select id="id_cal" style="width: 150px;">
                                        <option value="" disabled selected>Elija Origen</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                    </select>
                                    <select id="id_tipoident" style="width: 150px;">
                                        <option value="" disabled selected>Tipo de Documento</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                    </select>
                                    <input type="text" size="30" id="identificacion_cli" name="identificacion_cli" placeholder="Número de Identificación" />
                                    <input type="text" size="6" id="porcentajecli1" name="porcentajecli1" placeholder="% Desc" />
                                    <a href="#" data-action="collapse">
                                        <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Adicionales"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="form-field-1-1"> Compareciente </label>
                                <div class="col-sm-9">
                                    <select id="id_cal" style="width: 150px;">
                                        <option value="" disabled selected>Elija Origen</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                    </select>
                                    <select id="id_tipoident" style="width: 150px;">
                                        <option value="" disabled selected>Tipo de Documento</option>
                                        <option value="AL">Alabama</option>
                                        <option value="AK">Alaska</option>
                                        <option value="AZ">Arizona</option>
                                    </select>

                                    <input type="text" size="30" id="identificacion_cli" name="identificacion_cli" placeholder="Número de Identificación" />
                                    <input type="text" size="6" id="porcentajecli1" name="porcentajecli1" placeholder="% Desc" />
                                    <a href="#" data-action="collapse">
                                        <i><img src="{{ asset('images/nuevo.png') }}" width="28 px" height="28 px" title="Agregar Adicionales"></i>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->

    </div>

    <script src="{{ asset('assets/js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>

    <script>
        $("#cuantia").on({
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

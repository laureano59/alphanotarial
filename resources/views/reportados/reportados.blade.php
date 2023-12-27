@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control de Personas Reportadas')
@section('content')

  <div class="page-header">

      <h1>
          Personas reportadas<span id="radi">

      </h1>
  </div><!-- /.page-header -->

 <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header">
                 <div class="widget-toolbar" id="boton_actualizar" style="display:none">
                      <a href="javascript://" id="ActualizarReportado" data-action="reload">
                          <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Actualizar"></i>
                      </a>
                  </div>
                  <div class="widget-toolbar" id="boton_guardar">
                      <a href="javascript://" id="GuardarReportado" data-action="reload">
                          <i><img src="{{ asset('images/agregar-usuario.png') }}" width="28 px" height="28 px" title="Guardar Reportado"></i>
                      </a>
                  </div>
                    <center>
                        <h4 class="widget-title">Agregar reportado</h4>
                    </center>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                      <form>
                      @csrf
                      <input type="hidden" id="id_reportado" value="0">
                      <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">

                        <table width="100%">
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Identificación</b></td>
                            <td>
                              <input type="text" id="identificacion"/>
                            </td>
                          </tr>
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Nombre</b></td>
                            <td>
                              <input type="text" id="nombre" size="30"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Tipo Reportado</b></td>
                            <td>
                              <select id="tipo" style="width: 100%;">
                                  <option value="" disabled selected>Tipo reporte</option>
                                  @foreach ($Tipo_reportados as $Tip)
                                  <option value="{{$Tip->id_tipo_rep}}">{{$Tip->descripcion_tipo_rep}}</option>
                                  @endforeach
                              </select>
                            </td>
                          </tr>
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Concepto</b></td>
                            <td>
                             <textarea id="concepto" name="textarea" rows="3" cols="30"></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Estado</b></td>
                            <td>
                              <select id="estado" style="width: 100%;">
                                <option value="" disabled selected>Estado</option>
                                <option value="true">Activo</option>
                                 <option value="false">Inactivo</option>
                              </select>
                            </td>
                          </tr>
                        </table>
                       </form> 
                    </div>
                </div>
            </div>
        </div><!-- /.span -->

        <div class="col-xs-12 col-sm-8">
          <div class="widget-box">
              <div class="widget-header">
                


              </div>

              <div class="widget-body">
                  <div class="widget-main">

                    <table id="simple-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Identificación</th>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Activo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="datos"></tbody>
                    </table>

                  </div>
              </div>
          </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/reportados/script.js')}}"></script>
<script src="{{ asset('js/reportados/grid.js')}}"></script>
@endsection
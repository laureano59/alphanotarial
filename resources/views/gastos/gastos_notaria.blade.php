@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>Gastos Varios


        <small>
            <span class="nav-search widget-toolbar ">
                Recibo No.&nbsp; <b>
                    <font size="5"><span class="red" id="id_gas"></span></font>
                </b>
            </span>
        </small>
    </h1>
</div><!-- /.page-header -->
<form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
     <input type="hidden" id="id_update">
          
    <div class="row">
        <div class="col-xs-12 col-sm-6">
            <div class="widget-box">
                <div class="widget-header">
                  <div class="widget-toolbar" id="btnimprimir" style="display:none">
                      <a href="/recibogastospdf" target="_blank">
                          <i><img src="{{ asset('images/imprimir.png') }}" width="28 px" height="28 px" title="Imprimir Recibo"></i>
                      </a>
                  </div>
                  <div class="widget-toolbar" id="btnguardar">
                      <a href="javascript://" id="guardargasto" data-action="reload">
                          <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar"></i>
                      </a>
                  </div>

                <div class="widget-toolbar" id="boton_actualizar" style="display:none">
                      <a href="javascript://" id="ActualizarGasto" data-action="reload">
                          <i><img src="{{ asset('images/guardarcambios.png') }}" width="28 px" height="28 px" title="Actualizar"></i>
                      </a>
                </div>

                  <div class="widget-toolbar" id="btnnuevo" style="display:none">
                      <a href="javascript://" id="nuevogasto" data-action="reload">
                          <i><img src="{{ asset('images/nuevo7.png') }}" width="28 px" height="28 px" title="Nuevo gasto"></i>
                      </a>
                  </div>
                    <center>
                        <h4 class="widget-title"></h4>
                    </center>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <table width="100%">
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Concepto</b></td>
                            <td>
                              <textarea id="concepto"  rows="2" cols="50"></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Valor</b></td>
                            <td>
                              <input type="text" id="valor_gasto" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Quién Autoriza</b></td>
                            <td>
                              <input type="text" id="autoriza" size="50" />
                            </td>
                          </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- /.span -->

        <div class="col-xs-12 col-sm-6">
          <div class="widget-box">
              <div class="widget-header">
                <span class="nav-search widget-toolbar">
                  <input type="text" id="id_gastos"  placeholder="Buscar por No.de Recibo" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                  <a href="javascript://" id="buscarpornumrecibo">
                      <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por No.de Recibo"></i>
                  </a>
                </span>
              </div>

              <div class="widget-body">
                  <div class="widget-main">

                    <table id="simple-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="10">No.Recibo</th>
                                <th>Fecha</th>
                                <th>Concepto</th>
                                <th>$ Valor</th>
                                <th>Autorizado por</th>
                            </tr>
                        </thead>
                        <tbody id="datos"></tbody>
                    </table>

                  </div>
              </div>
          </div>
        </div>
    </div>



</form>
@endsection

@section('scripts')
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/gastos/script.js')}}"></script>
<script src="{{ asset('js/gastos/grid_gastos.js')}}"></script>
@endsection

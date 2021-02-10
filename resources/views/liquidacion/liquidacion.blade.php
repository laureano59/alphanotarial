@extends('layouts.principal')
@section('title', 'Liquidación')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>
        Liquidación<span id="radi">
          @if (session('key'))

            @section('scripts2')
              <script>
                window.onload = function() {
                document.getElementById('radicacion').value = {{ session('key') }};
                var id_radica = document.getElementById('radicacion').value;
                $("#radicacion").val(id_radica);
                BuscarPorSession(id_radica);

                }

            </script>
            @endsection
          @endif
        </span>

        <span class="alert alert-danger" role="alert" id="msj-error" style="display:none">
            <strong id="msj"></strong>
        </span>
        <small>
            <span class="nav-search widget-toolbar ">
                <form>
                    @csrf
                    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                    <input type="text" id="radicacion" name="radicacion" placeholder="Buscar Radicación" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                    <a href="javascript://" id="buscar">
                        <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar Radicación"></i>
                    </a>
                </form>

            </span>
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-5">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-star orange"></i>
                    Derechos Notariales
                </h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main no-padding">
                    <table class="table table-bordered table-striped">
                        <thead class="thin-border-bottom">
                            <tr>
                                <th>
                                    <i class="ace-icon fa fa-caret-right blue"></i>Actos
                                </th>

                                <th>
                                    <i class="ace-icon fa fa-caret-right blue"></i>Cuantia
                                </th>

                                <th class="hidden-480">
                                    <i class="ace-icon fa fa-caret-right blue"></i>Derechos
                                </th>
                            </tr>
                        </thead>
                        <tbody id="datos"></tbody>
                    </table>
                </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
            <hr style="border-top: 1px solid #04CEFF; background: transparent;">
            <div class="widget-header widget-header-flat">
            <div class="widget-box widget-color-blue" id="widget-box-2">
              <div id="liqok" class="alert alert-success" role="alert" style="display:none">
                <span id="mensajeliq"></span>
              </div>
              <div class="alert alert-danger" role="alert" id="msj-errorrad1" style="display:none">
                <strong id="msjrad1"></strong>
              </div>

              <div class="widget-header">
                <h5 class="widget-title bigger lighter">
                  <i class="ace-icon fa fa-credit-card"></i>
                  Gran Total Liquidación
                </h5>
              </div>
              <div class="widget-toolbar">
                  <a href="javascript://" data-action="reload" id="guardarliq">
                      <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Liquidación"></i>
                  </a>
              </div>
              <div class="widget-toolbar">
                  <a href="javascript://" id="imprimirliquidacion">
                      <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Liquidación"></i>
                  </a>
              </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="form-horizontal">
                      <div class="widget-body">
                        <div class="widget-main no-padding">
                          <h1><b class="pink"><span id="grantotal"></span></b></h1>
                          <input type="hidden" id="grantot" value="0">
                        </div>
                      </div>
                    </div>
                    <div class="space-10"></div>
                </div>
            </div>
          </div>
        </div>

        </div><!-- /.widget-box -->
    </div><!-- /.col -->

    <div class="col-sm-7">
        <div class="widget-box transparent">
            <div class="widget-header widget-header-flat">
                <h4 class="widget-title lighter">
                    <i class="ace-icon fa fa-bar-chart-o"></i>
                    Conceptos Para: <b class="red"><span id="acto_concepto"></span></b>
                </h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>
                </div>

                <div class="widget-toolbar" id="botoncalcular" style="display:none">
                    <a href="#" id="CalcularConceptos" data-action="reload">
                        <i><img src="{{ asset('images/calcular.png') }}" width="28 px" height="28 px" title="Calcular Conceptos"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-4">
                    <div id="cargar_conceptos">
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="form-horizontal">
                                    <div class="widget-body">
                                        <div class="widget-main no-padding">
                                            <div class="wrap">
                                              <form id="formliq">
                                                @csrf
                                                <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                                                <table class="table table-striped table-bordered table-hover head" width="100%">
                                                    <tr>
                                                        <td width="50%"><b><i class="ace-icon fa fa-caret-right blue"></i> Concepto</b></td>
                                                        <td width="25%"><b><i class="ace-icon fa fa-caret-right blue"></i> Cant Hojas</b></td>
                                                        <td width="25%"><b><i class="ace-icon fa fa-caret-right blue"></i> Valor</b></td>
                                                    </tr>
                                                </table>
                                                <div class="inner_table">
                                                    <table class="table table-striped table-bordered table-hover">
                                                      @foreach ($Conceptos as $con)
                                                        <tr id="{{$con->atributo}}" style="display:none">
                                                            <td width="50%"><label class="col-sm-3 control-label no-padding-right" for="form-field-1"> <b class="blue">{{$con->nombre_concep}}</b> </label></td>
                                                            <td width="25%">
                                                                <input type="text" id="hojas{{$con->atributo}}" class="col-xs-10 col-sm-8" onblur="InputTexto(this.id, {{$con->id_concep}})" onKeyPress="return soloNumeros(event)" value="0"/>
                                                            </td>
                                                            <td width="25%" style="vertical-align:middle;">
                                                                <b class="pink"><span id="total{{$con->atributo}}"></span></b>
                                                                <input type="hidden" id="total{{$con->id_concep}}" value="0">
                                                            </td>
                                                        </tr>
                                                      @endforeach
                                                    </table>
                                                </div>

                                                <div class="space-10"></div>
                                                <hr style="border-top: 1px solid #04CEFF; background: transparent;">
                                                <table>
                                                    <tr>
                                                        <td><b class="brown">
                                                                <center>TOTAL CONCEPTOS</center>
                                                            </b></td>
                                                        <td><b class="brown">
                                                                <center>NOTARIALES</center>
                                                            </b></td>
                                                        <td><b class="brown">
                                                                <center>=</center>
                                                            </b></td>
                                                        <td>
                                                            <div>
                                                                <center><b class="brown"><span id="totalconceptos"></span></b></center>
                                                                <input type="hidden" id="totalconcept" value="0">
                                                            </div>
                                                        </td>

                                                    </tr>

                                                </table>

                                              </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-10"></div>

                                <hr style="border-top: 1px solid #04CEFF; background: transparent;">

                                <div class="widget-header widget-header-flat">
                                    <h4 class="widget-title lighter">
                                        <i class="ace-icon fa fa-asterisk"></i>
                                        Recaudo Para Terceros <b class="red"><span id="acto_concepto"></span></b>
                                    </h4>
                                </div>

                                <div class="widget-body">
                                  <div class="widget-main padding-4">
                                    <div id="recaudo_terceros">
                                      <table class="table table-bordered table-striped" id="recaudos" style="display:none">
                                          <thead class="thin-border-bottom">
                                              <tr>
                                                  <th>
                                                      <i class="ace-icon fa fa-caret-right blue"></i>Detalle
                                                  </th>

                                                  <th>
                                                      <i class="ace-icon fa fa-caret-right blue"></i>Valor
                                                  </th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                            <tr>
                                              <td><b class="orange">Recaudo Super</b></td>
                                              <td>
                                                <b class="green"><span id="totalrecsuper"></span></b>
                                                <input type="hidden" id="totrecsuper" value="0">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><b class="orange">Recaudo Fondo</b></td>
                                              <td>
                                                <b class="green"><span id="totalrecfondo"></span></b>
                                                <input type="hidden" id="totrecfondo" value="0">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><b class="blue">IVA</b></td>
                                              <td>
                                                <b class="green"><span id="totaliva"></span></b>
                                                <input type="hidden" id="totiva" value="0">
                                                <input type="hidden" id="totivacompleto" value="0">
                                              </td>
                                            </tr>
                                            <tr id="retefuente" style="display:none">
                                              <td><b class="blue">Retefuente</b></td>
                                              <td>
                                                <b class="green"><span id="totalrtf"></span></b>
                                                <input type="hidden" id="totrtf" value="0">
                                              </td>
                                            </tr>

                                            <tr id="aporteespecial" style="display:none">
                                              <td><b class="blue">Aporte Especial</b></td>
                                              <td>
                                              <b class="green"><span id="totalaporteespecial"></span></b>
                                              <input type="hidden" id="totaporteespecial" value="0">
                                              </td>
                                            </tr>
                                            
                                            <tr id="reteconsumo" style="display:none">
                                              <td><b class="blue">ReteConsumo</b></td>
                                              <td>
                                              <b class="green"><span id="totalreteconsumo"></span></b>
                                              <input type="hidden" id="totreteconsumo" value="0">
                                              </td>
                                            </tr>
                                            <tr>
                                              <td><b class="brown">TOTAL RECAUDOS</b></td>
                                              <td>
                                                <b class="brown"><span id="totalrecaudos"></span></b>
                                                <input type="hidden" id="totrecaudos" value="0">
                                              </td>
                                            </tr>
                                          </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>




                            </div>
                        </div>
                    </div>
                </div><!-- /.widget-main -->
            </div><!-- /.widget-body -->
        </div><!-- /.widget-box -->
    </div><!-- /.col -->
</div><!-- /.row -->

@endsection

@section('csslau')
<link rel="stylesheet" href="{{ asset('css/scrolltable.css')}}" />
@endsection

@section('scripts')
<script src="{{ asset('js/liquidacion/script.js')}}"></script>
<script src="{{ asset('js/liquidacion/scriptgrid.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/liquidacion/gridconceptos.js')}}"></script>
<script src="{{ asset('js/__AJAX.js')}}"></script>
<script src="{{ asset('js/liquidacion/limpiarconceptos.js')}}"></script>
<script src="{{ asset('js/liquidacion/guardarliq.js')}}"></script>
<script src="{{ asset('js/solonumeros.js')}}"></script>
@endsection

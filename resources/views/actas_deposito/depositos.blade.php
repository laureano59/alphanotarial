@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')
@include('radicacion.modalcliente')
@include('radicacion.modalcliente-empresa')

<div class="page-header">
    <h1>Depósito de Clientes


        <small>
            <span class="nav-search widget-toolbar ">
                Acta de Depósito No.&nbsp; <b>
                    <font size="5"><span class="red" id="id_act"></span></font>
                </b>
            </span>
        </small>
    </h1>
</div><!-- /.page-header -->
<form>
    @csrf
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <input type="hidden" id="tipogrid" value="depositos">
    <table width="100%" border="0">
        <tr>

            <td align="center"><i class="ace-icon fa fa-caret-right blue"></i><b class="blue">A Nombre de&nbsp;</b></td>
            <td align="center"><select id="id_tipoident1" style="width: 100%;">
                    <option value="" disabled selected>Tipo Doc</option>
                    @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                    <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                    @endforeach
                </select></td>
            <td align="center"><input type="text" size="17" id="identificacion_cli1" name="identificacion_cli1" placeholder="Identificación" /></td>
            <td align="center"><input type="text" readonly size="63" id="nombre_cli1" name="nombre_cli1" /></td>
            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Tipo de Depósito</b></td>
            <td align="center">
                <select id="id_tip" style="width: 100%;">
                    <option value="" disabled selected>Tipo de depósito</option>
                    @foreach ($TipoDeposito as $TipoDep)
                    <option value="{{$TipoDep->id_tip}}">{{$TipoDep->descripcion_tip}}</option>
                    @endforeach
                </select>
            </td>
        </tr>
    </table><br>
    <table width="100%" border="0">
      <tr>
      <td><i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Nombre del Proyecto</b></td>
        <td align="left">
          <input type="text" id="proyecto" size="70" onkeyup="mayus(this);"/>
        </td>
        <td>
          <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Valor a Depositar</b>
        </td>
        <td>
          <input type="text" id="deposito_act" onKeyPress="return soloNumeros(event)"/>
        </td>
      </tr>
    </table>
    <br>
    <table>
      <tr>
        <td>
          <i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Asignar No.Radicación &nbsp;</b>
        </td>
        <td>
          <input type="text" id="id_radica" placeholder="No.Radicación" onKeyPress="return soloNumeros(event)"/>
        </td>
        <td>
          <input type="text" id="anio_fiscal" placeholder="Año Fiscal" onKeyPress="return soloNumeros(event)"/>
        </td>
        <td>&nbsp;
          <a href="#">
              <i><img src="{{ asset('images/comprobar.png') }}" width="28 px" height="28 px" title="Asignar No.Radicación"></i>
          </a>
        </td>
      </tr>
    </table>
    <br>
    <table width="100%" border="0">
      <tr>
        <td valign="Top" width="150px">
          <i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Observaciones &nbsp;</b>
        </td>
        <td align="left">
          <textarea class="form-control" id="observaciones_act" maxlength="250" placeholder="Default Text"></textarea>
        </td>
      </tr>
    </table>
    <hr>
    <div class="row">
        <div class="col-xs-12 col-sm-4">
            <div class="widget-box">
                <div class="widget-header">
                  <div class="widget-toolbar">
                      <a href="/actasdepositopdf" target="_blank">
                          <i><img src="{{ asset('images/imprimir.png') }}" width="28 px" height="28 px" title="Imprimir Acta"></i>
                      </a>
                  </div>
                  <div class="widget-toolbar" id="btnguardar">
                      <a href="javascript://" id="GuardarActaDeposito" data-action="reload">
                          <i><img src="{{ asset('images/almacenar.png') }}" width="28 px" height="28 px" title="Guardar Acta"></i>
                      </a>
                  </div>

                  <div class="widget-toolbar" id="btnnuevo" style="display:none">
                      <a href="javascript://" id="nuevaacta" data-action="reload">
                          <i><img src="{{ asset('images/nuevo7.png') }}" width="28 px" height="28 px" title="Nuevo depósito"></i>
                      </a>
                  </div>

                   <div class="widget-toolbar">
                      <a href="#">
                          <i><img src="{{ asset('images/ayuda1.png') }}" width="28px" height="28px" title="Para imprimir copia de un comprobante anterior ingresa el No de acta en el campo que dice Buscar por No.de Acta y luego clic en el Ícono de la impresora"></i>
                      </a>
                  </div>
                    <center>
                        <h4 class="widget-title">Medios de Pago</h4>
                    </center>
                </div>

                <div class="widget-body">
                    <div class="widget-main">

                        <table width="100%">
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Efectivo</b></td>
                            <td>
                              <input type="text" id="efectivo" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Transferencia</b></td>
                            <td>
                              <input type="text" id="transferencia_bancaria" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                           <tr>
                            <td width="30%"><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">PSE</b></td>
                            <td>
                              <input type="text" id="pse" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">T.Crédito</b></td>
                            <td>
                              <input type="text" id="tarjeta_credito" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">T.Débito</b></td>
                            <td>
                              <input type="text" id="tarjeta_debito" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Cheque</b></td>
                            <td>
                              <input type="text" id="cheque" value="0" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">No.Cheque</b></td>
                            <td>
                              <input type="text" id="num_cheque" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">No.T.Crédito</b></td>
                            <td>
                              <input type="text" id="num_tarjetacredito" onKeyPress="return soloNumeros(event)"/>
                            </td>
                          </tr>
                          <tr>
                            <td><i class="ace-icon fa fa-caret-right blue"></i><b class="orange">Banco</b></td>
                            <td>
                              <select id="codigo_ban" style="width: 100%;">
                                  <option value="" disabled selected>Código Banco</option>
                                  @foreach ($Banco as $Ban)
                                  <option value="{{$Ban->codigo_ban}}">{{$Ban->codigo_ban}} >> {{$Ban->nombre_ban}}</option>
                                  @endforeach
                              </select>
                            </td>
                          </tr>
                        </table>

                    </div>
                </div>
            </div>
        </div><!-- /.span -->

        <div class="col-xs-12 col-sm-8">
          <div class="widget-box">
              <div class="widget-header">
                <span class="nav-search widget-toolbar">
                  <input type="text" id="idacta"  placeholder="Buscar por No.de Acta" class="nav-search-input" onKeyPress="return soloNumeros(event)" autocomplete="off" />
                  <a href="javascript://" id="buscarpornumacta">
                      <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por No.de Acta"></i>
                  </a>
                </span>

                <span class="nav-search widget-toolbar">
                  <input type="text" id="identif"  placeholder="Buscar por No.de Identificación" class="nav-search-input" autocomplete="off" />
                  <a href="javascript://" id="buscarporidentif">
                      <i><img src="{{ asset('images/investigacion.png') }}" width="28 px" height="28 px" title="Consultar por Identificación"></i>
                  </a>
                </span>

              </div>

              <div class="widget-body">
                  <div class="widget-main">

                    <table id="simple-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No.Acta</th>
                                <th>Fecha</th>
                                <th>Nombre del Proyecto</th>
                                <th>Tipo Depósito</th>
                                <th>
                                    $ Valor
                                </th>
                                <th>
                                    $ Saldo
                                </th>
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
<script src="{{ asset('js/limpiarclientes.js')}}"></script>
<script src="{{ asset('js/validarciudad.js')}}"></script>
<script src="{{ asset('js/crearclientes.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/actas_deposito/script.js')}}"></script>
<script src="{{ asset('js/actas_deposito/grid_actas.js')}}"></script>
@endsection

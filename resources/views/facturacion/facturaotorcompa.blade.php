@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Facturación')
@section('content')
@include('facturacion.modalanombrede')
@include('radicacion.modalcliente')
@include('radicacion.modalcliente-empresa')

  @if (session('key'))
    @section('scripts2')
      <script>
        window.onload = function() {
          document.getElementById('id_radica').value = {{ session('key') }};
          var id_radica = document.getElementById('id_radica').value;
          Factura(id_radica, {{ session('opcion') }});
        }
    </script>
    @endsection
  @endif

<div class="alert alert-danger" role="alert" id="msj-error1" style="display:none">
  <strong id="msj1"></strong>
</div>
<div class="alert alert-warning" role="alert" id="msj-error2" style="display:none">
  <strong id="msj2"></strong>
</div>

<div class="row">
    <div>
        <table class="table table-bordered table-striped">
            <tr>
                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">No.Radicación</b>
                </td>

                <td>
                    <span id="radicacion" class="pink" style="font-size:20px;"></span>
                    <input type="hidden" id="id_radica" value="0">
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">No.Factura</b>
                </td>

                <td>
                    <span id="num_factura" class="pink" style="font-size:20px;"></span>
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">No.Escritura</b>
                </td>

                <td>
                    <span id="num_escritura" class="pink" style="font-size:20px;"></span>
                </td>

            </tr>
            <tr>
                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Año</b>
                </td>

                <td>
                    <span id="anio_radica"></span>
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Fecha</b>
                </td>

                <td>
                    <span id="fecha_fact"></span>
                </td>

                <td>
                    <i class="ace-icon fa fa-caret-right blue"></i><b class="blue">Imprimir</b>
                </td>

                <td>
                  <a target="_blank" href="/factunicapdf">
                    <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Factura"></i>
                  </a>
                </td>
            </tr>
            <tr>
              <form id="form_pago">
                @csrf
                <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
              <td><i class="ace-icon fa fa-caret-right blue"></i><b class="blue">A Nombre de Vendedor</b></td>
              <td><select id="id_tipoident1" style="width: 100%;">
                  <option value="" disabled selected>Tipo Doc</option>
                  @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                    <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                  @endforeach
              </select></td>
              <td><input type="text" size="10" id="identificacion_cli1"  placeholder="Identificación" /></td>
              <td><input type="text" readonly size="40" id="nombre_cli1" /></td>
              <td>
                <a href="javascript://" id="mostrarparticipantesotor">
                  <span class="label label-warning label-white middle">Mostrar</span>
                </a>
              </td>
            </form>
            </tr>

            <tr>
              <td><i class="ace-icon fa fa-caret-right blue"></i><b class="blue">A Nombre de Comprador</b></td>
              <td><select id="id_tipoident2" style="width: 100%;">
                  <option value="" disabled selected>Tipo Doc</option>
                  @foreach ($TipoIdentificaciones as $TipoIdentificacion)
                    <option value="{{$TipoIdentificacion->id_tipoident}}">{{$TipoIdentificacion->abrev}}</option>
                  @endforeach
              </select></td>
              <td><input type="text" size="10" id="identificacion_cli2" placeholder="Identificación" /></td>
              <td><input type="text" readonly size="40" id="nombre_cli2" /></td>
              <td>
                <a href="javascript://" id="mostrarparticipantescompa">
                  <span class="label label-warning label-white middle">Mostrar</span>
                </a>
              </td>
            </form>
            </tr>
        </table>

        <hr style="border-top: 1px solid #E4E4E4; background: transparent;">

        <form>
          @csrf
          <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
          <input type="hidden" id="grantotalotorderechosiden" value="0" />
          <input type="hidden" id="grantotalcompaderechosiden" value="0" />
          <input type="hidden" id="grantotalotorconceptosiden" value="0" />
          <input type="hidden" id="grantotalcompaconceptosiden" value="0" />

        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th width="25%" class="white"  background="{{ asset('images/fondo_th.png')}}">Actos</th>
              <th width="17%" class="white"  background="{{ asset('images/fondo_th.png')}}">Derechos</th>
              <th width="12%" class="white"  background="{{ asset('images/fondo_th.png')}}">% Otor</th>
              <th width="17%" class="white"  background="{{ asset('images/fondo_th.png')}}">Pago Otor</th>
              <th width="12%" class="white"  background="{{ asset('images/fondo_th.png')}}">% Compa</th>
              <th width="17%" class="white"  background="{{ asset('images/fondo_th.png')}}">Pago Compa</th>
            </tr>
          </thead>

          <tbody id="actos">
          </tbody>

          <thead>
            <tr>
              <th width="25%" class="white"  background="{{ asset('images/fondo_th.png')}}">Conceptos</th>
              <th width="17%" class="white"  background="{{ asset('images/fondo_th.png')}}">Valor</th>
              <th width="12%" class="white"  background="{{ asset('images/fondo_th.png')}}">% Otor</th>
              <th width="17%" class="white"  background="{{ asset('images/fondo_th.png')}}">Pago Otor</th>
              <th width="12%" class="white"  background="{{ asset('images/fondo_th.png')}}">% Compa</th>
              <th width="17%" class="white"  background="{{ asset('images/fondo_th.png')}}">Pago Compa</th>
            </tr>
          </thead>

          <tbody id="conceptos">
            @foreach ($Conceptos as $con)
            <tr id="{{$con->atributo}}" style="display:none">
                <td>{{$con->nombre_concep}}</td>
                <td bgcolor="#ccffcc" align="right">
                    <span id="total{{$con->atributo}}"></span>
                    <input type="hidden" id="total{{$con->atributo}}iden" value="0" />
                </td>
                <td>
                  <input type="text" id="porcentaje{{$con->atributo}}otor" maxlength="3" class="col-xs-10 col-sm-8" onblur="Conceptos_FactDoble_Otor('total{{$con->atributo}}iden', 'porcentaje{{$con->atributo}}otor', 'total{{$con->atributo}}otor', 'total{{$con->atributo}}otoriden');" onKeyPress="return soloNumeros(event)"/>
                </td>
                <td bgcolor="#ccffcc" align="right">
                <span id="total{{$con->atributo}}otor"></span>
                <input type="hidden" id="total{{$con->atributo}}otoriden" value="0" />
                </td>
                <td>
                  <input type="text" id="porcentaje{{$con->atributo}}compa" maxlength="3" class="col-xs-10 col-sm-8" onblur="Conceptos_FactDoble_Compa('total{{$con->atributo}}iden', 'porcentaje{{$con->atributo}}compa', 'total{{$con->atributo}}compa', 'total{{$con->atributo}}compaiden');" onKeyPress="return soloNumeros(event)"/>
                </td>
                <td bgcolor="#ccffcc" align="right">
                <span id="total{{$con->atributo}}compa"></span>
                <input type="hidden" id="total{{$con->atributo}}compaiden" value="0" />
                </td>
            </tr>
              @endforeach
            <tr>
            <td>
            </td>
            <td>
            </td>
            <td bgcolor="#aef78c" align="right">
            <b>Total</b>
            </td>
            <td bgcolor="#aef78c" align="right">
            <b><span id="tototorganteconc"></span></b>
            </td>
            <td bgcolor="#aef78c" align="right">
            <b>Total</b>
            </td>
            <td bgcolor="#aef78c" align="right">
            <b><span id="totcomparecienteconc"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>Subtotal Otor</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="subtototorganteiden" value="0" />
            <b><span id="subtototorgante"></span></b>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>Subtotal Comp</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="subtotcomparecienteiden" value="0" />
            <b><span id="subtotcompareciente"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>IVA Otor</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="totalivaotoriden" value ="0" />
            <b><span id="totalivaotor"></span></b>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>IVA Comp</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="totalivacompaiden" value ="0" />
            <b><span id="totalivacompa"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>RTF Otor</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="rtfotoriden" />
            <b><span id="rtfotor"></span></b>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>RTF Comp</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="rtfcompaiden" />
            <b><span id="rtfcompa"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>Impcons Otor</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="impconsumootoriden" value="0" />
            <b><span id="impconsumootor"></span></b>
            </td>
            <td bgcolor="#22deff" align="right">
            <b>Impcons Comp</b>
            </td>
            <td bgcolor="#22deff" align="right">
              <input type="hidden" id="impconsumocompaiden" value="0" />
            <b><span id="impconsumocompa"></span></b>
            </td>
            </tr>

            <tr>
            <td>
                Recaudo Super
            </td>
            <td bgcolor="#ccffcc" align="right">
              <span id="racaudosuper"></span>
              <input type="hidden" id="racaudosuperiden" value="0" />
            </td>
            <td align="right">
              <input type="text" id="porcentajesuperotor" maxlength="3" class="col-xs-10 col-sm-8" onKeyPress="return soloNumeros(event)" onblur="porcentaje_super_otor()" />
            </td>
            <td bgcolor="#ccffcc" align="right">
              <input type="hidden" id="totalsuperotoriden" value="0" />
              <b><span id="totalsuperotor"></span></b>

            </td>
            <td align="right">
              <input type="text" id="porcentajesupercompa" maxlength="3" class="col-xs-10 col-sm-8" onKeyPress="return soloNumeros(event)" onblur="porcentaje_super_compa()" />
            </td>
            <td bgcolor="#ccffcc" align="right">
              <input type="hidden" id="totalsupercompaiden" value="0" />
              <b><span id="totalsupercompa"></span></b>
            </td>
            </tr>

            <tr>
            <td>
              Recaudo Fondo
            </td>
            <td bgcolor="#ccffcc" align="right">
                <span id="recaudofondo"></span>
                <input type="hidden" id="recaudofondoiden" value="0" />
            </td>
            <td align="right">
              <input type="text" id="porcentajefondootor" maxlength="3" class="col-xs-10 col-sm-8" onKeyPress="return soloNumeros(event)" onblur="porcentaje_fondo_otor()" />
            </td>
            <td bgcolor="#ccffcc" align="right">
              <input type="hidden" id="totalfondootoriden" value="0" />
              <b><span id="totalfondootor"></span></b>
            </td>
            <td align="right">
              <input type="text" id="porcentajefondocompa" maxlength="3" class="col-xs-10 col-sm-8" onKeyPress="return soloNumeros(event)" onblur="porcentaje_fondo_compa()" />
            </td>
            <td bgcolor="#ccffcc" align="right">
              <input type="hidden" id="totalfondocompaiden" value="0" />
              <b><span id="totalfondocompa"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
              Deducción
            </td>
            <td bgcolor="#FFEBEB" align="right">
            <b>ReteIva Otor</b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
              <input type="hidden" id="reteivaotoriden" value="0" />
            <b><span class="red" id="reteivaotor"></span></b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
            <b>ReteIva Comp</b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
              <input type="hidden" id="reteivacompiden" value="0" />
            <b><span class="red" id="reteivacomp"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
              Deducción
            </td>
            <td bgcolor="#FFEBEB" align="right">
            <b>ReteFuente Otor</b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
              <input type="hidden" id="retertfotoriden" value="0" />
            <b><span class="red" id="retertfotor"></span></b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
            <b>ReteFuente Comp</b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
              <input type="hidden" id="retertfcompiden" value="0" />
            <b><span class="red" id="retertfcomp"></span></b>
            </td>
            </tr>

            <tr>
            <td>
            </td>
            <td>
              Deducción
            </td>
            <td bgcolor="#FFEBEB" align="right">
            <b>ReteIca Otor</b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
              <input type="hidden" id="reteicaotoriden" value="0" />
            <b><span class="red" id="reteicaotor"></span></b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
            <b>ReteIva Comp</b>
            </td>
            <td bgcolor="#FFEBEB" align="right">
              <input type="hidden" id="reteicacompiden" value="0" />
            <b><span class="red" id="reteicacomp"></span></b>
            </td>
            </tr>

            <tr>
            <td bgcolor="#fff500">
              <b>Gran</b>
            </td>
            <td bgcolor="#fff500">
              <b>Total:</b>
            </td>
            <td bgcolor="#fff500" align="right">
            <b>Otorgante</b>
            </td>
            <td bgcolor="#fff500" align="right">
              <input type="hidden" id="grantotalotorganteiden" value="0" />
            <b><span id="grantotalotorgante"></span></b>
            </td>
            <td bgcolor="#fff500" align="right">
            <b>Compareciente</b>
            </td>
            <td bgcolor="#fff500" align="right">
              <input type="hidden" id="grantotalcomparecienteiden" value="0" />
            <b><span id="grantotalcompareciente"></span></b>
            </td>
            </tr>

            <tr>
            <td class="align-middle" bgcolor="#B3DCFF">
              <b>Forma de</b>
            </td>
            <td class="align-middle" bgcolor="#B3DCFF">
              <b>Pago</b>
            </td>
            <td class="align-middle" bgcolor="#B3DCFF">
            <b>Otorgante</b>
            </td>
            <td bgcolor="#B3DCFF">
              <div class="radio">
                  <label>
                      <input name="formapagootor" id="contado" type="radio" value="contado" class="ace" />
                      <span class="lbl"> Contado</span>
                  </label>
              </div>
              <div class="radio">
                  <label>
                      <input name="formapagootor" id="credito"  type="radio" value="credito" class="ace" />
                      <span class="lbl"> Crédito</span>
                  </label>
              </div>
            </td>
            <td class="align-middle" bgcolor="#B3DCFF">
            <b>Compareciente</b>
            </td>
            <td bgcolor="#B3DCFF">
              <div class="radio">
                  <label>
                      <input name="formapagocompa" id="contado" type="radio" value="contado" class="ace" />
                      <span class="lbl"> Contado</span>
                  </label>
              </div>
              <div class="radio">
                  <label>
                      <input name="formapagocompa" id="credito"  type="radio" value="credito" class="ace" />
                      <span class="lbl"> Crédito</span>
                  </label>
              </div>
            </td>
            </tr>
          </tbody>
        </table>
        <hr>
        <div class="center">
        <a href="#" id="guardarfacturadoble" class="btn btn-primary btn-lg">
          Guardar Pago
        </a>

        <a href="javascript://" id="racalcular" class="btn btn-success btn-lg">
          Recalcular Totales
        </a>
      </div>

        </form>
    </div>

</div>
<!--Row-->
<script src="{{ asset('assets/js/jquery-2.1.4.min.js')}}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{ asset('css/rect.css')}}" />
@endsection

@section('scripts')
<script src="{{ asset('js/facturacion/formatomoneda.js')}}"></script>
<script src="{{ asset('js/solonumeros.js')}}"></script>
<script src="{{ asset('js/facturacion/grid.js')}}"></script>
<script src="{{ asset('js/facturacion/script.js')}}"></script>
<script src="{{ asset('js/numberFormat154.js')}}"></script>
<script src="{{ asset('js/formatonumero.js')}}"></script>
<script src="{{ asset('js/limpiarclientes.js')}}"></script>
<script src="{{ asset('js/crearclientes.js')}}"></script>
@endsection

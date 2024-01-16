<!DOCTYPE html>
<html>

<head>
    <title>Caja Diario General</title>

</head>

<body>
    <table width="100%">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <font size="3"><b>{{$nombre_nota}}</b></font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="3">{{$nombre_notario}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="3">Nit. {{$nit}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="2">{{$direccion_nota}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>{{$nombre_reporte}}</td>
                    </tr>
                    <tr>
                      <td>
                        Fecha del Reporte : {{$fecha_reporte}}
                      </td>
                    </tr>
                    <tr>
                      <td>
                        Fecha de impresión : {{$fecha_impresion}}
                      </td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{ asset('images/logon13.png') }}" width="28 px" height="28 px"></br>
                <center>{{$email}}</center>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <thead>
            <tr>
                <th><font size="2">No.Fac</font></th>
                <th><font size="2">Fecha</font></th>
                <th><font size="2">No.Esc</font></th>
                <th><font size="2">Derechos</font></th>
                <th><font size="2">Conceptos</font></th>
                <th><font size="2">Total_Ingresos</font></th>
                <th><font size="2">I.V.A</font></th>
                <th><font size="2">Recaudos</font></th>
                <th><font size="2">Ap_Especial</font></th>
                <th><font size="2">Imp_Timbre</font></th>
                <th><font size="2">Retención</font></th>
                <th><font size="2">ReteIva</font></th>
                <th><font size="2">ReteIca</font></th>
                <th><font size="2">Retefuente</font></th>
                <th><font size="2">Gran Total</font></th>
                <th><font size="2">Tipo Pago</font></th>
                <th><font size="2">Estado</font></th>
                <th><font size="2">No.Not</font></th>
            </tr>
        </thead>
        <tbody id="datos">
          @for ($i = 0; $i < $contcajadiario; $i++)
            @if (array_key_exists($i, $cajadiario))
              <tr>
                <td>
                  <font size="2">{{ $cajadiario[$i]['numfact'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $cajadiario[$i]['fecha'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $cajadiario[$i]['num_esc'] }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format(round($cajadiario[$i]['derechos']), 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['conceptos'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format(round($cajadiario[$i]['total_gravado']), 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['iva'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['recaudo'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['aporteespecial'], 2) }}</font>
                </td>
                 <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['impuesto_timbre'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['retencion'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">(-{{ number_format($cajadiario[$i]['reteiva'], 2) }})</font>
                </td>
                <td align="right">
                  <font size="2">(-{{ number_format($cajadiario[$i]['reteica'], 2) }})</font>
                </td>
                <td align="right">
                  <font size="2">(-{{ number_format($cajadiario[$i]['retertf'], 2) }})</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['total'], 2) }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $cajadiario[$i]['tipo_pago'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $cajadiario[$i]['estado'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $cajadiario[$i]['id_ncf'] }}</font>
                </td>
                </tr>
                  @endif
                @endfor
                <tr>
                  <td> </td>
                  <td></td>
                  <td></td>
                  <td>
                    <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                      <hr>
                  </td>
                  <td>
                  </td>
                  <td></td>
                  </tr>

                  <tr>
                    <td>  <font size="2"><b>Total</b></font></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_derechos, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_conceptos, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format(round($total_gravado), 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_iva, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_recaudo, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_aporteespecial, 2) }}</b></font>
                    </td>
                     <td align="right">
                      <font size="2"><b>{{ number_format($impuesto_timbre, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_retencion, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>(-{{ number_format($total_reteiva, 2) }})</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>(-{{ number_format($total_reteica, 2) }})</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>(-{{ number_format($total_retertf, 2) }})</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total, 2) }}</b></font>
                    </td>
                    <td>
                    </td>
                    <td></td>
                    </tr>
            </tbody>
            </table>
            <hr><br><hr>

            <table width="100%">
              <tr>
                <td valign="top">
                  <table width="50%" border="1">
                      <thead>
                          <tr>
                              <th><font size="2">ITEM</font></th>
                              <th><font size="2">VALOR</font></th>
                              <th><font size="2">OTROS PERIODOS</font></th>
                              <th><font size="2">DIFERENCIA</font></th>
                              <th><font size="2">CONTADO</font></th>
                              <th><font size="2">CRÉDITO</font></th>
                          </tr>
                      </thead>
                      <tbody>

                        <tr>
                          <td>
                            <font size="3"><b>Total Derechos</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_derechos, 2) }}</font>
                          </td>
                           <td align="right">
                            <font size="3">{{ number_format($total_derechos_otros, 2) }}</font>
                          </td>
                           <td align="right">
                            <font size="3">{{ number_format($total_derechos_resta, 2) }}</font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($derechos_contado, 2) }}</font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($derechos_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total Conceptos</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_conceptos, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_conceptos_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_conceptos_resta, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($conceptos_contado, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($conceptos_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total Ingresos</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_ingresos, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_gravado_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_gravado_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($ingresos_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($ingresos_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total Iva</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_iva, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_iva_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_iva_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($iva_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($iva_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total Recaudos</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_recaudo, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_recaudo_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_recaudo_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($recaudos_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($recaudos_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total Aporte Especial</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_aporteespecial, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_aporteespecial_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_aporteespecial_resta, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($aporteespecial_contado, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($aporteespecial_credito, 2) }}</font>
                          </td>
                        </tr>

                         <tr>
                          <td>
                            <font size="3"><b>Total Impuesto Timbre</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($impuesto_timbre, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($impuesto_timbre_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($impuesto_timbre_resta, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($impuestotimbre_contado, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($impuestotimbre_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total Retención</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_retencion, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_retencion_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_retencion_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($rtf_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($rtf_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total ReteIva</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_reteiva, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_reteiva_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_reteiva_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($deduccion_reteiva_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($deduccion_reteiva_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total ReteIca</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_reteica, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_reteica_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_reteica_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($deduccion_reteica_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($deduccion_reteica_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Total ReteRtf</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total_retertf, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_retertf_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_retertf_resta, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($deduccion_retertf_contado, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($deduccion_retertf_credito, 2) }}</font>
                          </td>
                        </tr>

                        <tr>
                          <td>
                            <font size="3"><b>Gran Total</b></font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($total, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_otros, 2) }}</font>
                          </td>

                          <td align="right">
                            <font size="3">{{ number_format($total_resta, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($total_fact_contado, 2) }}</font>
                          </td>

                           <td align="right">
                            <font size="3">{{ number_format($total_fact_credito, 2) }}</font>
                          </td>
                        </tr>

                        </tbody>
                      </table>
                </td>
                <td>

                </td>
                <td valign="top">
                  <!--<table width="100%" border="1">
                      <thead>
                          <tr>
                              <th><font size="2">No.Factura</font></th>
                              <th><font size="2">No.Acta</font></th>
                              <th><font size="2">Fecha.Acta</font></th>
                              <th><font size="2">Valor Cruce</font></th>
                          </tr>
                      </thead>
                      <tbody>
                        @for ($i = 0; $i < $contcruces; $i++)
                          @if (array_key_exists($i, $cruces))
                        <tr>
                          <td>
                            <font size="3">{{ $cruces[$i]['num_fact'] }}</font>
                          </td>
                          <td>
                            <font size="3">{{ $cruces[$i]['num_act'] }}</font>
                          </td>
                          <td>
                            <font size="3">{{ $cruces[$i]['fecha_acta'] }}</font>
                          </td>
                          <td align="right">
                            <font size="3">{{ number_format($cruces[$i]['valor_egreso'], 2) }}</font>
                          </td>
                        </tr>
                      @endif
                    @endfor
                    <tr>
                      <td>
                      </td>
                      <td>

                      </td>
                      <td>

                      </td>
                      <td align="right">
                        ------------------------
                      </td>
                    </tr>
                    <tr>
                      <td>
                      <b><font size="2">Total Cruces</font></b>
                      </td>
                      <td>

                      </td>
                      <td>

                      </td>
                      <td align="right">
                        <b><font size="3">{{ number_format($total_egreso, 2) }}</font></b>
                      </td>
                    </tr>
                      </tbody>
                  </table>-->
                </td>
              </tr>
            </table>







</body>

</html>

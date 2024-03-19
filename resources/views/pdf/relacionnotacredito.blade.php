<!DOCTYPE html>
<html>

<head>
    <title>Relación de Notas Crédito</title>

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
                <img src="{{ asset('images/logon13.png') }}" width="85px" height="85px"></br>
                <center>{{$email}}</center>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <thead>
            <tr>
                <th><font size="2">No.Not</font></th>
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
                
               
            </tr>
        </thead>
        <tbody id="datos">
           {{-- Inicializar una variable para alternar colores --}}
            @php
                $colorAlternado = true;
            @endphp
          @for ($i = 0; $i < $contcajadiario; $i++)
            @if (array_key_exists($i, $cajadiario))
             {{-- Alternar colores de fondo --}}
            @php
            $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
            @endphp
              <tr style="background-color: {{ $colorFondo }}">
                <td align="center">
                  <font size="2">{{ $cajadiario[$i]['id_ncf'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $cajadiario[$i]['numfact'] }}</font>
                </td>
                <td>
                    <font size="2">{{ Carbon\Carbon::parse($cajadiario[$i]['fecha'])->format('d/m/Y') }}</font>
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
                </tr>
                 {{-- Alternar el valor de la variable para el próximo ciclo --}}
                @php
                $colorAlternado = !$colorAlternado;
                @endphp
                  @endif
                @endfor
                <tr>
                  <td> </td>
                  <td></td>
                  <td></td>
                  <td>
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
                     <hr>
                  </td>
                  <td> 
                    <hr>
                  </td>
                   <td> 
                    <hr>
                  </td>
                  </tr>

                  <tr>
                    <td>  <font size="2"><b>Total</b></font></td>
                    <td></td>
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
            <hr>

</body>

</html>

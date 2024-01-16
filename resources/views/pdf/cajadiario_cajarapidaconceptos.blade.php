<!DOCTYPE html>
<html>

<head>
    <title>Reporte Diario Caja Rápida</title>

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
                
                <th><font size="2">Id</font></th>
                <th><font size="2">Concepto</font></th>
                <th><font size="2">Cantidad</font></th>
                <th><font size="2">Subtotal</font></th>
                <th><font size="2">Iva</font></th>
                <th><font size="2">Total</font></th>
            </tr>
        </thead>
        <tbody id="datos">
          @for ($i = 0; $i < $contcajadiario; $i++)
            @if (array_key_exists($i, $cajadiario))
              <tr>
                <td align="center">
                  <font size="2">{{ $cajadiario[$i]['id_concep']}}</font>
                </td>
                <td>
                  <font size="2">{{ $cajadiario[$i]['nombre_concep'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $cajadiario[$i]['cantidad'] }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['subtotal'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['iva'], 2) }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($cajadiario[$i]['total'], 2) }}</font>
                </td>
                </tr>
                  @endif
                @endfor

                <tr>
                    <td>  <font size="2"><b>-------</b></font></td>
                    <td></td>
                     <td></td>
                    <td  align="right">
                        <font size="2"><b>------------</b></font>
                    </td>
                    <td  align="right">
                      <font size="2"><b>------------</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>------------</b></font>
                    </td>
                   
                </tr>

                 <tr>
                    <td>  <font size="2"><b>Total</b></font></td>
                    <td></td>
                    <td></td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($subtotal, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_iva, 2) }}</b></font>
                    </td>
                    <td align="right">
                      <font size="2"><b>{{ number_format($total_fact, 2) }}</b></font>
                    </td>
                </tr>
            </tbody>
            </table>
            <hr>

</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>Abonos de Cartera</title>

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
                        <td>Abonos a la Factura No. {{$id_fact}}</td>
                    </tr>
                    <tr>
                      <td>
                        Fecha del Reporte : {{$fecha_reporte}}
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
                <th><font size="2">Fecha Abono</font></th>
                <th><font size="2">Abono</font></th>
            </tr>
        </thead>
        <tbody id="datos">
          @for ($i = 0; $i < $contabonos; $i++)
            @if (array_key_exists($i, $abonos))
                <tr>
                    <td align="center">
                        <font size="2">{{ Carbon\Carbon::parse($abonos[$i]['created_at'])->format('d/m/Y') }}</font>
                    </td>
                    <td align="right">
                        <font size="2">${{ number_format($abonos[$i]['abono_car'], 2) }}</font>
                    </td>
                </tr>
                  @endif
                @endfor

                <tr>
                <td align="center">
                </td>
                
                <td align="right">
                  ------------------
                </td>
                
                </tr>

                <tr>
                <td>
                  <font size="2"><b>Totales</b></font>
                </td>
                
                <td align="right">
                  <font size="2"><b>{{ number_format($total_abono, 2) }}</b></font>
                </td>
                </tr>
                    
            </tbody>
            </table>
            <hr>

</body>

</html>

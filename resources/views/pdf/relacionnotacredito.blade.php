<!DOCTYPE html>
<html>

<head>
    <title>Relación Notas Crédito</title>

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
                <th><font size="2">No.nota</font></th>
                <th><font size="2">No.Fact</font></th>
                <th><font size="2">No.Radi</font></th>
                <th><font size="2">Total</font></th>
                <th><font size="2">Detalle</font></th>
            </tr>
        </thead>
        <tbody id="datos">
          @for ($i = 0; $i < $cont_rel_notas_credito; $i++)
            @if (array_key_exists($i, $rel_notas_credito))
              <tr>
                <td align="center">
                  <font size="2">{{ $rel_notas_credito[$i]['id_ncf'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $rel_notas_credito[$i]['id_fact'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $rel_notas_credito[$i]['id_radica'] }}</font>
                </td>
                <td align="right">
                  <font size="2">{{ number_format($rel_notas_credito[$i]['total_fact']),2 }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $rel_notas_credito[$i]['detalle'] }}</font>
                </td>
                
                </tr>
                  @endif
                @endfor
                    
            </tbody>
            </table>
            <hr>

</body>

</html>

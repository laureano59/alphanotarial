<!DOCTYPE html>
<html>

<head>
    <title>Informe de Cartera</title>

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
                <th><font size="2">No.Abono</font></th>
                <th><font size="2">No.Fact</font></th>
                <th><font size="2">Fecha.Fact</font></th>
                <th><font size="2">Fecha.Abono</font></th>
                <th><font size="2">No.Esc</font></th>
                <th><font size="2">Identificación</font></th>
                <th><font size="2">Cliente</font></th>
                <th><font size="2">Saldo General</font></th>
                <th><font size="2">Valor Abono</font></th>
                <th><font size="2">Saldo</font></th>
                <th><font size="2">Total Factura</font></th>
                
            </tr>
        </thead>
        <tbody id="datos">
          @for ($i = 0; $i < $continformecartera; $i++)
            @if (array_key_exists($i, $informecartera))
              <tr>
                <td align="center">
                  <font size="2">{{ $informecartera[$i]['id_car'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $informecartera[$i]['id_fact'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ Carbon\Carbon::parse($informecartera[$i]['fecha_fact'])->format('d/m/Y') }}</font>
                </td>
                 <td align="center">
                  <font size="2">{{ Carbon\Carbon::parse($informecartera[$i]['fecha_abono'])->format('d/m/Y') }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $informecartera[$i]['num_esc'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $informecartera[$i]['identificacion_cli'] }}</font>
                </td>
                <td align="center">
                  <font size="2">{{ $informecartera[$i]['cliente'] }}</font>
                </td>
                 <td>
                  <font size="2">{{ number_format($informecartera[$i]['saldogeneral'], 2) }}</font>
                </td>
                <td>
                  <font size="2">{{ number_format($informecartera[$i]['abono_car'], 2) }}</font>
                </td>
                 <td>
                  <font size="2">{{ number_format($informecartera[$i]['nuevo_saldo'], 2) }}</font>
                </td>
                <td>
                  <font size="2">{{ number_format($informecartera[$i]['total_fact'], 2) }}</font>
                </td>
               
                </tr>
                  @endif
                @endfor

                <tr>
                <td>
                  ------------------
                </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                  ------------------
                </td>
                 <td>
                </td>
                 <td>
                </td>
                </tr>

                <tr>
                <td>
                  <font size="2"><b>Totales</b></font>
                </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td> </td>
                <td>
                  <font size="2"><b>{{ number_format($total_saldo, 2) }}</b></font>
                </td>
                <td>
                </td>
                <td>
                </td>
                </tr>
                    
            </tbody>
            </table>
            <hr>

</body>

</html>

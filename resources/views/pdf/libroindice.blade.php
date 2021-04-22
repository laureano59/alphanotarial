<!DOCTYPE html>
<html>

<head>
    <title>Libro Indice</title>

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
                <th><font size="2">Fecha</font></th>
                <th><font size="2">No.Esc</font></th>
                <th><font size="2">Pmer.Contratante</font></th>
                <th><font size="2">Sgdo.Contratante</font></th>
                <th><font size="2">Acto</font></th>
            </tr>
        </thead>
        <tbody id="datos">
          @for ($i = 0; $i < $contlibroindice; $i++)
            @if (array_key_exists($i, $libroindice))
              <tr>
                <td>
                  <font size="2">{{ $libroindice[$i]['fecha'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $libroindice[$i]['num_esc'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $libroindice[$i]['otorgante'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $libroindice[$i]['compareciente'] }}</font>
                </td>
                <td>
                  <font size="2">{{ $libroindice[$i]['acto'] }}</font>
                </td>
                
                </tr>
                  @endif
                @endfor
                    
            </tbody>
            </table>
            <hr>

</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>Radicación</title>

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
                        <td>HOJA DE CONTROL DE RUTA DE ESCRITURAS</td>
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
        <tr>
          <td width="25%">
              <font size="3"><b>Radicación No.</b></font>
          </td>
          <td width="20%">
            <h2>{{$id_radica}}</h2>
          </td>
            <td width="25%">
              <font size="3"><b>Escritura No.</font>
            </td>
            <td width="15%">
                ___________________
            </td>
            <td width="15%">
              <font size="3"><b>Año.&nbsp;{{$anio_trabajo}}</font>
            </td>
        </tr>

        <tr>
          <td width="25%">
              <font size="3"><b>Amanuense:</b></font>
          </td>
          <td width="20%">
            {{$nombre_proto}}
          </td>
            <td width="25%">
              <font size="3"><b>Notario:</font>
            </td>
            <td width="15%">
                {{$notario_encargado}}
            </td>
            <td width="15%">
            </td>
        </tr>

        <tr>
          <td width="25%">
              <font size="3"><b>Fecha de recibido:</b></font>
          </td>
          <td width="20%">
            {{$fecha_recibido}}
          </td>
            <td width="25%">
              <font size="3"><b>Hora:</font>
            </td>
            <td width="15%">
                {{$hora_recibido}}
            </td>
            <td width="15%">
            </td>
        </tr>

        <tr>
          <td width="25%">
              <font size="3"><b>Solicitado por:</b></font>
          </td>
          <td width="20%">
            {{$nombre_cli}}
          </td>
            <td width="25%">
              <font size="3"><b>Teléfono / Cel:</font>
            </td>
            <td width="15%">
                {{$telefono_cli}}
            </td>
            <td width="15%">
            </td>
        </tr>

        <tr>
          <td width="25%">
              <font size="3"><b>Dirección:</b></font>
          </td>
          <td width="20%">
            {{$direccion_cli}}
          </td>
            <td width="25%">
            </td>
            <td width="15%">
                <font size="3"><b>Email:</b></font>
            </td>
            <td width="15%">
              {{$email_cli}}
            </td>
        </tr>

        <tr>
          <td width="25%">
              <font size="3"><b>Fecha de firma escritura:</b></font>
          </td>
          <td width="20%">
            ___________________________
          </td>
            <td width="25%">
            </td>
            <td width="15%">
                <font size="3"><b>Hora:</b></font>
            </td>
            <td width="15%">
              ______________
            </td>
        </tr>
    </table>
    <hr>


    <table width="100%">
        <tr>
            <td width="30%">
                <font size="3"><b>Otorgantes:</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%">
                <font size="3"><b>Comparecientes:</b></font>
            </td>
            <td width="25%"></td>
        </tr>

        @for ($i = 0; $i < $contprincipales; $i++)
          @if (array_key_exists($i, $principales))
        <tr>
            <td width="30%">
                <font size="3">{{ $principales[$i]['identificacion_cli1'] }}</font>
            </td>
            <td width="25%">
                <font size="2">{{ $principales[$i]['nombre_cli1'] }}</font>
            </td>
            <td width="20%" align="center">
                <font size="3">{{ $principales[$i]['identificacion_cli2'] }}</font>
            </td>
            <td width="25%">
                <font size="2">{{ $principales[$i]['nombre_cli2'] }}</font>
            </td>
        </tr>
        @else
        <tr>
            <td width="30%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
        </tr>
        @endif
        @endfor
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td width="30%">
                <font size="3"><b>Actos:</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="center">
                <font size="3"><b>Cuantias:</b></font>
            </td>
        </tr>
        @for ($i = 0; $i
        < $contactos; $i++) @if (array_key_exists($i, $actos))
        <tr>
            <td width="30%">
                <font size="3">{{ strtolower($actos[$i]['nombre_acto']) }}</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="3">$&nbsp;{{ number_format($actos[$i]['cuantia'], 2) }}</font>
            </td>
        </tr>
        @else
        <tr>
            <td width="30%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="25%">&nbsp;</td>
        </tr>
        @endif
        @endfor
    </table>
    <hr>

      <table width="100%">
    <tr>
      <td>
          Observaciones:<br>
          <hr><br>
          <hr><br>
          <hr><br>
          <hr><br>
          <hr><br>
          <hr><br>
          <hr><br>
      </td>
    </tr>
  </table>
</body>

</html>

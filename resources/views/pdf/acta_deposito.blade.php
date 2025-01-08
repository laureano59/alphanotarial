<!DOCTYPE html>
<html>

<head>
    <title>Acta de Depósito</title>

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
                        <td>Acta de Depósito No.&nbsp;<b>{{$id_act}}</b> </td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{ asset('images/logoposn13.png') }}" width="70px" height="70px"></br>
                <center>{{$email}}</center>
            </td>
        </tr>
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td>
                <b>A Nombre de:</b>
            </td>
            <td>
                {{$nombre}}
            </td>
            <td>
                <b>Identificación:</b>
            </td>
            <td>
                {{$identificacion_cli}}
            </td>
            <td>
                <b>Fecha</b>
            </td>
            <td>
                {{$fecha}}
            </td>
        </tr>
    </table>
    <table>
      <tr>
        <td>
          <b>Por Concepto de:</b>
        </td>
        <td>
          {{$descripcion_tip}}
        </td>
      </tr>
    </table>
    <table>
      <tr>
        <td>
          <b>Radicación No.</b>
        </td>
        <td>
        {{$id_radica}}
        </td>
        <td>
          <b>Escritura No.</b>
        </td>
        <td>
          {{$num_escritura}}
        </td>
        <td><b>Observaciones:</b></td><td><font size="3">{{$observaciones}}</font></td>
      </tr>
    </table>
    <hr>
    <br>
    <table width="100%" border="0">

      @foreach($mediosdepago as $item)
        <tr>
          <td width="18%">
            <b>{{ $item['medio'] }}</b>
          </td>
          <td width="18%">
            ${{ number_format($item['total'], 2) }}
          </td>
        </tr>
      @endforeach 
      </tr>
     
      <tr>
        <td>
        -------------------
        </td>
        <td>
        -------------------
        </td>
      </tr>

      <tr>
        <td>
        <b>Total Recibido:</b>
        </td>
        <td>
        ${{ number_format($total_recibido, 2) }}
        </td>
      </tr>
    </table>
    <hr>
<br><br>
    <table width="100%">
      <tr>
        <td align="center">
          _______________________
        </td>
        <td>
        </td>
        <td align="center">
          _______________________
        </td>
      </tr>
      <tr>
        <td align="center">
          Funcionario Responsable
        </td>
        <td>
        </td>
        <td align="center">
          Depositante
        </td>
      </tr>
    </table>
</body>

</html>

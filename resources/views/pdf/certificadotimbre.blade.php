<!DOCTYPE html>
<html>

<head>
    <title>{{$nombre_del_certificado}}</title>

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
        <tr>
          <td align="center">
              <font size="3"><b>{{$nombre_del_certificado}}  {{$id_cer}}</b></font>
          </td>
  </table>
  <table width="100%">
    <tr>
      <td>
        <font size="3">ESCRITURA No</font>.
      </td>
      <td>
        <font size="3">{{$num_escritura}}</font>
      </td>
      <td></td>
      <td>
        <font size="3">AÑO GRAVABLE :</font>
      </td>
      <td>
        <font size="3">{{$anio_gravable}}</font>
      </td>
    </tr>

    <tr>
      <td>
        <font size="3">FECHA:</font>
      </td>
      <td>
        <font size="3">{{$fecha_escritura}}</font>
      </td>
      <td></td>
      <td>
        <font size="3">CIUDAD :</font>
      </td>
      <td>
        <font size="3">{{$ciudad}}</font>
      </td>
    </tr>

    <tr>
      <td>
        <font size="3">CONTRIBUYENTE:</font>
      </td>
      <td>
        <font size="3">{{$nombre_contribuyente}}</font>
      </td>
      <td></td>
      <td>
        <font size="3">IDENTIFICACION:</font>
      </td>
      <td>
        <font size="3">{{$identificacion_contribuyente}}</font>
      </td>
    </tr>

    <tr>
      <td>
        <font size="3">FACTURA DE VENTA No.</font>
      </td>
      <td>
        <font size="3">{{$prefijo_fact}}&nbsp;-&nbsp;{{$num_factura}}</font>
      </td>
      <td></td>
      <td>
        <font size="3">FECHA:</font>
      </td>
      <td>
        <font size="3">{{$fecha_factura}}</font>
      </td>
    </tr>
  </table>
  <table width="100%">
    <tr>
      <td>
        <font size="3">VALOR VENTA</font>
      </td>
      <td>
        <font size="3">${{number_format($valor_venta, 2)}}</font>
      </td>
    </tr>

    <tr>
      <td>
        <font size="3">VALOR RETENIDO</font>
      </td>
      <td>
        <font size="3">${{number_format($total_retenido, 2)}}</font>
      </td>
    </tr>

    <tr>
      <td></td>
      <td>------------------</td>
    </tr>

    <tr>
      <td>
        <font size="3"><b>TOTAL RETENIDO</b></font>
      </td>
      <td>
        <font size="3"><b>${{number_format($total_retenido, 2)}}</b></font>
      </td>
    </tr>
  </table>
  <br><br>
  <font size="3">FECHA CERTIFICADO: {{$fecha_certificado}}</font>
  <br><br><br>
  <table width="100%">
    <tr>
      <td>
        ____________________
      </td>
      <td>
        ____________________
      </td>
    </tr>
    <tr>
      <td>
        <font size="2">Firma Contribuyente</font>
      </td>
      <td>
        <font size="2">Firma Funcionario</font>
      </td>
    </tr>
  </table>


</body>

</html>

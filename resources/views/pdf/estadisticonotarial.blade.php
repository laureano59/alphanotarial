<!DOCTYPE html>
<html>

<head>
    <title>Estadístico Notarial</title>

</head>

<body>
  <table width="100%">
      <tr>
          <td>
              <table>
                  <tr>
                      <td>
                          <font size="4"><b>{{$nombre_nota}}</b></font>
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
                          <font size="2">{{$direccion_nota}} / {{$telefono_nota}}</font>
                      </td>
                  </tr>

                  <tr>
                      <td>
                          <b>REPORTE ESTADÍSTICO NOTARIAL</b>
                      </td>
                  </tr>
                  <tr>
                      <td>
                          <b>Fecha : {{$fecha1}} / {{$fecha2}}</b>
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
          <th>ACTO</th>
          <th>CANTIDAD</th>
          <th>DERECHOS</th>
        </tr>
      </thead>
      <tbody id="datos">
        <tr>
          <td>
            VENTA
          </td>
          <td  align="center">
            {{$cantventa}}
          </td>
          <td align="right">
            {{ number_format($ingreventas, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            PERMUTA
          </td>
          <td align="center">
            {{$cantpermuta}}
          </td>
          <td align="right">
            {{ number_format($ingrepermuta, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            HIPOTECA
          </td>
          <td align="center">
            {{$canthipoteca}}
          </td>
          <td align="right">
            {{ number_format($ingrehipoteca, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            CANCELACIÓN HIPOTECA
          </td>
          <td align="center">
            {{$cantcancelhipo}}
          </td>
          <td align="right">
            {{ number_format($ingrecancelhipo, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            VENTA CON HIPOTECA
          </td>
          <td align="center">
            {{$cantventaconhipo}}
          </td>
          <td align="right">
            {{ number_format($ingreventaconhipo, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            CONSTITUCIÓN DE SOCIEDAD
          </td>
          <td align="center">
            {{$cantconstisocie}}
          </td>
          <td align="right">
            {{ number_format($ingreconstisocie, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            LIQUIDACIÓN SOCIEDAD
          </td>
          <td align="center">
            {{$cantliqsocie}}
          </td>
          <td align="right">
            {{ number_format($ingreliqsocie, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            REFORMA SOCIAL
          </td>
          <td align="center">
            {{$cantreforsocial}}
          </td>
          <td align="right">
            {{ number_format($ingrereforsocial, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            SUCESIONES
          </td>
          <td align="center">
            {{$cantsuce}}
          </td>
          <td align="right">
            {{ number_format($ingresuce, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            REGLAMENTO PROPIEDAD Y REFORMAS
          </td>
          <td align="center">
            {{$cantreglaproprefor}}
          </td>
          <td align="right">
            {{ number_format($ingrereglaprorefor, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            PROTOCOLIZACIONES
          </td>
          <td align="center">
            {{$cantproto}}
          </td>
          <td align="right">
            {{ number_format($ingreproto, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            MATRIMONIO CIVIL
          </td>
          <td align="center">
            {{$cantmatri}}
          </td>
          <td align="right">
            {{ number_format($ingrematri, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            CORRECCIÓN DE REGISTRO
          </td>
          <td align="center">
            {{$cantcorrecregis}}
          </td>
          <td align="right">
            {{ number_format($ingrecorrecregis, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            VIVIENDA DE INTERES SOCIAL (VIS)
          </td>
          <td align="center">
            {{$cantvis}}
          </td>
          <td align="right">
            {{ number_format($ingrevis, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            DIVORCIOS
          </td>
          <td align="center">
            {{$cantdivor}}
          </td>
          <td align="right">
            {{ number_format($ingredivor, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            SOCIEDAD PATRIMONIAL DE PERSONAS DEL MISMO SEXO
          </td>
          <td align="center">
            {{$cantmismosexo}}
          </td>
          <td align="right">
            {{ number_format($ingremismosexo, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            VIP
          </td>
          <td align="center">
            {{$cantvip}}
          </td>
          <td align="right">
            {{ number_format($ingrevip, 2) }}
          </td>
        </tr>

        <tr>
          <td>
            OTROS
          </td>
          <td align="center">
            {{$cantotros}}
          </td>
          <td align="right">
            {{ number_format($ingreotros, 2) }}
          </td>
        </tr>

        
        <tr>
          <td>
            <b>--------------------</b>
          </td>
          <td align="center">
            <b>--------------</b>
          </td>
          <td  align="right">
            <b>-------------------------------</b>
          </td>
        </tr>

        <tr>
          <td>
            <b>TOTAL</b>
          </td>
          <td align="center">
            <b>{{$totalcantidad}}</b>
          </td>
          <td  align="right">
            <b>{{ number_format($totalingresos, 2) }}</b>
          </td>
        </tr>
      </tbody>
    </table>

</body>

</html>

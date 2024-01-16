<!DOCTYPE html>
<html>

<head>
    <title>{{$nombre_reporte}}</title>

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
                        Fecha del reporte : {{$fecha_reporte}}
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
<table width="100%" border="1">
    <thead>
        <tr>
            <th><font size="2">Acta #</font></th>
            <th><font size="2">Fecha Egreso</font></th>
            <th><font size="2">Identificación</font></th>
            <th><font size="2">Nombre</font></th>
            <th><font size="2">Depósito</font></th>
            <th><font size="2">Egreso</font></th>
            <th><font size="2">Saldo</font></th>
            <th><font size="2">Observaciones</font></th>
            <th><font size="2">Rad</font></th>
        </tr>
    </thead>
    <tbody id="datos">
        @foreach($egresos as $item)
        <tr>
            <td>
                <font size="2">{{ $item['id_act'] }}</font>
            </td>
            <td align="center">
                <font size="2">{{ $item['fecha_egreso'] }}</font>
            </td>

            <td>
                <font size="2">{{ $item['identificacion_cli'] }}</font>
            </td>

            <td>
                <font size="2">{{ $item['nombre'] }}</font>
            </td>

            <td align="right">
                <font size="2">{{ number_format($item['deposito_act'], 2) }}</font>
            </td>

             <td align="right">
                <font size="2">{{ number_format($item['egreso_egr'], 2) }}</font>
            </td>

            <td align="right">
                <font size="2">{{ number_format($item['saldo'], 2) }}</font>
            </td>

             <td>
                <font size="2">{{ $item['observaciones_egr'] }}</font>
            </td>

              <td align="center">
                <font size="2">{{ $item['id_radica'] }}</font>
            </td>
        </tr>
        @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td>
            </td>
            <td>
                <b> Totales:</b>
            </td>
            <td align="right">
                <font size="2"><b>{{ number_format($totaldepositos, 2) }}</b></font>
            </td>
             <td align="right">
                <font size="2"><b>{{ number_format($totalegresos, 2) }}</b></font>
            </td>
             <td align="right">
                <font size="2"><b>{{ number_format($totalsaldo, 2) }}</b></font>
            </td>
            <td>
            </td>
             <td>
            </td>
            
        </tr>

    </tbody>
</table>

</body>

</html>

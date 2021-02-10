<!DOCTYPE html>
<html>

<head>
    <title>Comprobante Egreso</title>

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
                        <td>Acta No. {{$id_acta}}</td>
                    </tr>
                    <tr>
                      <td>
                        Fecha del Reporte : {{$fecha_reporte}}
                      </td>
                    </tr>
                    <
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
                <th><font size="2">Rec No.</font></th>
                <th><font size="2">Fecha</font></th>
                <th><font size="2">Identificación</font></th>
                <th><font sisze="2">Nombre</font></th>
                <th><font sisze="2">Valor</font></th>
            </tr>
        </thead>
        <tbody id="datos">
         
                <tr>
                    <td align="center">
                        <font size="2">{{ $id_egr }}</font>
                    </td>
                    <td align="center">
                        <font size="2">{{ Carbon\Carbon::parse($fecha_egreso)->format('d/m/Y') }}</font>
                    </td>
                    <td align="center">
                        <font size="2">{{ $identificacion }}</font>
                    </td>
                    <td align="center">
                        <font size="2">{{ $cliente }}</font>
                    </td>
                    <td align="right">
                        <font size="2">${{ number_format($valor_egreso, 2) }}</font>
                    </td>
                </tr>
                    
            </tbody>
            </table>

            <hr>
             Observaciones: {{ $observaciones }}

             <hr>
             <br><br><br>

             Recibe:_____________________ &nbsp; &nbsp; &nbsp; &nbsp;   Autoriza:__________________




</body>

</html>

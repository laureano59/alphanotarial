<!DOCTYPE html>
<html>

<head>
    <title>{{$titulo}}</title>

</head>

<body>

    <img src="{{ asset('images/logon13.png') }}" align="center" width="28 px" height="28 px">
    <br>
    <p align="center">
        <font size="1"><b>{{$nombre_nota}}</b></font><br>
        <font size="1">{{$nombre_notario}}</font><br>
        <font size="1">Nit. {{$nit}}</font><br>
        <font size="1">{{$direccion_nota}} / {{$telefono_nota}}</font><br>
        <font size="1">{{$email}}</font><br>
        <font size="1">{{$IVA}}</font>
    </p>

    <hr>

    <p align="center">
        <font size="1"><b>Cliente:&nbsp;</b>{{$identificacioncli1}}</font><br>
        <font size="1">{{$nombrecli1}}</font><br>
        <b><font size="1">Factura electrónica de Venta No:</font></b><br>
        <b>{{$prefijo_fact}}&nbsp;-&nbsp;{{$num_fact}}</b><br>
        <font size="1">Fecha:</font>&nbsp;
        <font size="1">{{ Carbon\Carbon::parse($fecha_fact)->format('d/m/Y') }} &nbsp; {{$hora_fact}}</font><br>
        <font size="1">Medios de pago: {{$formadepago}}</font><br>
    </p>
    <hr>
    <table width="100%">
        <thead>
            <tr>
                <th><font size="1">Código</font></th>
                <th><font size="1">Descripción</font></th>
                <th><font size="1">Valor/U</font></th>
                <th><font size="1">Cantidad</font></th>
                <th><font size="1">Subtotal</font></th>
             </tr>
        </thead>
        <tbody id="data">

        @for ($i = 0; $i < $contdetalle; $i++) 
        @if (array_key_exists($i, $detalle))
        <tr>
            <td width="10%" align="center">
                <font size="1">{{ $detalle[$i]['id_concep'] }}</font>
            </td>
            <td width="30%" align="center">
                <font size="1">{{ $detalle[$i]['nombre_concep'] }}</font>
            </td>
            <td width="20%" align="right">
                <font size="1">$&nbsp;{{ number_format($detalle[$i]['valor_unitario'], 2) }}</font>
            </td>
            <td width="10%" align="center">
                <font size="1">{{ $detalle[$i]['cantidad'] }}</font>
            </td>
            <td width="20%" align="right">
                <font size="1">$&nbsp;{{ number_format($detalle[$i]['subtotal'], 2) }}</font>
            </td>
        </tr>
        @else
        <tr>
            <td width="10%">&nbsp;</td>
            <td width="30%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="20%">&nbsp;</td>
        </tr>
        @endif
        @endfor

        </tbody>
    </table>
    <p align="right">
        <font size="1"><b>Total bruto:</b></font>
        <font size="1"><b>$&nbsp;{{ number_format($subtotal_all, 2) }}</b></font>
        <br>
        <font size="1"><b>Iva ({{$porcentaje_iva}}%):</b></font>
        <font size="1"><b>$&nbsp;{{ number_format($total_iva, 2) }}</b></font>
        <br>
        <font size="1"><b>Total neto:</b></font>
        <font size="1"><b>$&nbsp;{{ number_format($total_all, 2) }}</b></font>
    </p>
    <hr>
    <img width="40" height="40" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate($QRCode)) !!} "><br>
    
    <font size="1">Cufe:&nbsp;{{$cufe}} &nbsp; Hora:{{$hora_cufe}}</font>

    
</body>

</html>


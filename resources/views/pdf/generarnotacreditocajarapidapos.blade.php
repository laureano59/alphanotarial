<!DOCTYPE html>
<html>

<head>
    <title>{{$titulo}}</title>

</head>

<body>

      <div style="text-align: center;">
        <img src="{{ asset('images/logoposn13.png') }}">
    </div>
    <br>
    <p align="center">
        <font size="1"><b>{{$nombre_nota}}</b></font><br>
        <font size="3">{{$nombre_notario}}</font><br>
        <font size="3">Nit. {{$nit}}</font><br>
        <font size="2">{{$direccion_nota}} / {{$telefono_nota}}</font><br>
        <font size="3">{{$email}}</font><br>
        <font size="3">{{$IVA}}</font>
    </p>

    <hr>

    <p align="center">
        <font size="3"><b>Cliente:&nbsp;</b>{{$identificacioncli1}}</font><br>
        <font size="1"><b>{{$nombrecli1}}</font></b><br>
        <b><font size="3">Nota Crédito No:</font></b><br>
        <b>{{$prefijo_fact}}&nbsp;-&nbsp;{{$id_ncf}}</b> &nbsp; Fecha:{{ Carbon\Carbon::parse($fecha_ncf)->format('d/m/Y') }}<br>
        <b>(F.No: {{$num_fact}})</b><br>

        <font size="3">Fecha:</font>&nbsp;
        <font size="3">{{ Carbon\Carbon::parse($fecha_fact)->format('d/m/Y') }} &nbsp; {{$hora_fact}}</font><br>
    </p>
    
    <font size="2">Motivo NC:{{$detalle_ncf}}</font>
    <hr>

    <p align="center">
        <font size="4">Resolución:</font><br>
        <font size="3">{{$resolucion}}</font><br>
    </p>
    
    <hr>

    <table width="100%">
        <thead>
            <tr>
                <th><font size="6">COD</font></th>
                <th><font size="6">DESCRIP</font></th>
                <th><font size="6">VAL/U</font></th>
                <th><font size="6">CANT</font></th>
                <th><font size="6">SUBTOT</font></th>
             </tr>
        </thead>
        <tbody id="data">

        @for ($i = 0; $i < $contdetalle; $i++) 
        @if (array_key_exists($i, $detalle))
        <tr>
            <td  align="center">
                <h2>{{ $detalle[$i]['id_concep'] }}</h2>
            </td>
            <td  align="center">
                <h2>{{ $detalle[$i]['nombre_concep'] }}</h2>
            </td>
            <td  align="right">
                <h2>$&nbsp;{{ number_format($detalle[$i]['valor_unitario'], 2) }}</h2>
            </td>
            <td  align="center">
                <h2>{{ $detalle[$i]['cantidad'] }}</h2>
            </td>
            <td  align="right">
                <h2>$&nbsp;{{ number_format($detalle[$i]['subtotal'], 2) }}</h2>
            </td>
        </tr>
        @else
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        @endif
        @endfor

        </tbody>
    </table>
    <p align="right">
        <font size="4"><b>Total bruto:</b></font>
        <font size="4"><b>$&nbsp;{{ number_format($subtotal_all, 2) }}</b></font>
        <br>
        <font size="4"><b>Iva ({{$porcentaje_iva}}%):</b></font>
        <font size="4"><b>$&nbsp;{{ number_format($total_iva, 2) }}</b></font>
        <br>
        <font size="4"><b>Total neto:</b></font>
        <font size="4"><b>$&nbsp;{{ number_format($total_all, 2) }}</b></font>
    </p>
    <hr>
    <img width="40" height="40" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate($QRCode)) !!} "><br>
    
    <font size="1">Cufe:&nbsp;{{$cufe}} &nbsp; Hora:{{$hora_cufe}}</font>

</body>

</html>


<!DOCTYPE html>
<html>

<head>
    <title>{{$titulo}}</title>

</head>

<body>
    <table width="100%">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <font size="1"><b>{{$nombre_nota}}</b></font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="2">{{$nombre_notario}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="1">Nit. {{$nit}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="1">{{$direccion_nota}} / {{$telefono_nota}}</font>
                        </td>
                    </tr>
                   
                    
                </table>
            </td>
            <td>
                <img src="{{ asset('images/logon13.png') }}" width="28 px" height="28 px"></br>
                <center><font size="1">{{$email}}</font></center>
                <font size="1">{{$IVA}}</font>
            </td>
        </tr>
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td>
                <font size="1"><b>Cliente:&nbsp;</b>{{$identificacioncli1}}</font>
            </td>
            <td>
                <font size="1">{{$nombrecli1}}</font>
            </td>
            <td>
                <b>
                    <font size="1">Factura electrónica de Venta No:</font>
                    {{$prefijo_fact}}&nbsp;-&nbsp;{{$num_fact}}
                </b>
            </td>
        </tr>
        
        <tr>
            
            <td width="25%"></td>
            <td width="20%">
                <font size="1">Fecha:</font>&nbsp;
            </td>
            <td width="25%">
                <font size="1">{{ Carbon\Carbon::parse($fecha_fact)->format('d/m/Y') }}</font>
            </td>
        </tr>
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td align="center">
                <font size="1">Resolución:{{$resolucion}}</font>
            </td>
        </tr>
    </table>
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
    
    <table width="100%">
        <tr>
            <td align="right">
                <font size="1"><b>Total bruto:</b></font>
            </td>
            <td align="right">
                <font size="1"><b>$&nbsp;{{ number_format($subtotal_all, 2) }}</b></font>
            </td>

            <td align="right">
                <font size="1"><b>Iva:</b></font>
            </td>
            <td align="right">
                <font size="1"><b>$&nbsp;{{ number_format($total_iva, 2) }}</b></font>
            </td>

            <td width="10%" align="right">
                <font size="1"><b>Total neto:</b></font>
            </td>
            <td width="20%" align="right">
                <font size="1"><b>$&nbsp;{{ number_format($total_all, 2) }}</b></font>
            </td>

        </tr>
        
    </table>

    <hr>
    

    
    <font size="1" >Observaciones:_____________________________________________________________________________________________________________</font>
    <br>
    <table width="100%">
      <tr>
        <td>
            <img width="40" height="40" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate($QRCode)) !!} ">
        </td>
        <td><font size="1">Cufe:&nbsp;{{$cufe}}</font></td>
      </tr>
    </table>


</body>

</html>


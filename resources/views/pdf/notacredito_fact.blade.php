<!DOCTYPE html>
<html>

<head>
    <title>Nota Credito</title>

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
                            <font size="1">{{$nombre_notario}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="1">Nit. {{$nit}}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="1">{{$direccion_nota}}</font>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{ asset('images/logon13.png') }}" width="85px" height="85px"></br>
                <center>{{$email}}</center>
                <font size="1">{{$IVA}}</font>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
      <tr>
        <td align="center">
          <h6>Nota Crédito No. &nbsp; {{$prefijo_fact}} - {{$id_ncf}} </h6> &nbsp; 
           <font size="1">Fecha: {{ Carbon\Carbon::parse($fecha_ncf)->format('d/m/Y') }} Radicación: {{$id_radica}}&nbsp; Protocolista: {{$nameprotocolista}}</font>
        </td>
      </tr>
      <tr>
        <td bgcolor="#EAEAEA">
          <font size ="1"> Razón de la nota crédito:</font>
          <br>
        <font size="1">{{$detalle_ncf}}</font>
        </td>
      </tr>
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td width="30%">
                <font size="1"><b>Cliente:&nbsp;</b>{{$identificacioncli1}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%">
                <font size="2"><b>Factura de Venta No.</b></font>
            </td>
            <td width="25%"><font size="1"><b>{{$prefijo_fact}}&nbsp;-&nbsp;{{$num_fact}}</b></font></td>
        </tr>
        <tr>
            <td width="30%">
                <font size="1">{{$nombrecli1}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%">
                <font size="1"><b>Escritura No. </b></font>
            </td>
            <td width="25%">
                <font size="1"><b>{{$num_esc}}</b></font>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <font size="1">{{$direccioncli1}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%">
                <font size="1">Fecha:</font>&nbsp;
            </td>
            <td width="25%">
                <font size="1">{{ Carbon\Carbon::parse($fecha_fact)->format('d/m/Y') }} &nbsp; {{$hora_fact}}</font>
            </td>
        </tr>
    </table>
    <hr>


    <table width="100%">
        <tr>
            <td width="30%">
                <font size="1"><b>Otorgantes:</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%">
                <font size="1"><b>Comparecientes:</b></font>
            </td>
            <td width="25%"></td>
        </tr>

        @for ($i = 0; $i
        < $contprincipales; $i++) @if (array_key_exists($i, $principales))
        <tr>
            <td width="30%">
                <font size="1">{{ $principales[$i]['identificacion_cli1'] }}</font>
            </td>
            <td width="25%">
                <font size="1">{{ $principales[$i]['nombre_cli1'] }}</font>
            </td>
            <td width="20%" align="center">
                <font size="1">{{ $principales[$i]['identificacion_cli2'] }}</font>
            </td>
            <td width="25%">
                <font size="1">{{ $principales[$i]['nombre_cli2'] }}</font>
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
                <font size="1"><b>Actos:</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="center">
                <font size="1"><b>Cuantias:</b></font>
            </td>
        </tr>
        @for ($i = 0; $i
        < $contactos; $i++) @if (array_key_exists($i, $actos))
        <tr>
            <td width="30%">
                <font size="1">{{ strtolower($actos[$i]['nombre_acto']) }}</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="2">$&nbsp;{{ number_format($actos[$i]['cuantia'], 2) }}</font>
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
            <td align="center">
                <font size="1">{{$resolucion}}</font>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="30%" bgcolor="#ededed">
                <font size="1"><b>Ingresos Notariales</b></font>
            </td>
            <td width="25%" bgcolor="#ededed"></td>
            <td width="20%" bgcolor="#ededed">
                <font size="2"><b>Cantidad</b></font>
            </td>
            <td width="25%" bgcolor="#ededed" align="center">
                <font size="1"><b>Valor</b></font>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <font size="1">Derechos</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="2">$&nbsp;{{ number_format($derechos, 2) }}</font>
            </td>
        </tr>
        @for ($i = 1; $i
        <= $contdataconcept; $i++) @if (array_key_exists($i, $dataconcept))
        <tr>
            <td width="30%">
                <font size="1">{{$dataconcept[$i]['concepto']}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%" align="center">
                <font size="1">{{$dataconcept[$i]['cantidad']}}</font>
            </td>
            <td width="25%" align="right">
                <font size="1">$&nbsp;{{ number_format($dataconcept[$i]['total'], 2) }}</font>
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
        <tr>
            <td width="30%"></td>
            <td width="25%"></td>
            <td width="20%">
                <font size="1"><b>Total Ingresos:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="1"><b>$&nbsp;{{ number_format($subtotal1, 2) }}</b></font>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <tr>
            <td width="30%">
                <font size="1"><b>Recaudos y Retenciones</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="center">
                <font size="1"><b>Valor</b></font>
            </td>
        </tr>
        @for ($i = 1; $i
        <= $contterceros; $i++) @if (array_key_exists($i, $terceros))
        <tr>
            <td width="30%">
                <font size="1">{{$terceros[$i]['concepto']}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="1">$&nbsp;{{ number_format($terceros[$i]['total'], 2) }}</font>
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
        <tr>
            <td width="30%"></td>
            <td width="25%"></td>
            <td width="20%">
                <font size="2"><b>Total Recaudos:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="1"><b>$&nbsp;{{ number_format($totalterceros, 2) }}</b></font>
            </td>
        </tr>
    </table>
    <hr>


@if (isset($contdeducciones))
    <table width="100%">
        <tr>
            <td width="30%">
                <font size="1"><b>Deducciones</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="center">
                <font size="1"><b>Valor</b></font>
            </td>
        </tr>
        @for ($i = 1; $i <= $contdeducciones; $i++)
          @if (array_key_exists($i, $deducciones))
        <tr>
            <td width="30%">
                <font size="1">{{$deducciones[$i]['concepto']}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="1">$&nbsp;{{ number_format($deducciones[$i]['total'], 2) }}</font>
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
        <tr>
            <td width="30%"></td>
            <td width="25%"></td>
            <td width="20%">
                <font size="1"><b>Total Deducciones:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="1"><b>$&nbsp;{{ number_format($totaldeducciones, 2) }}</b></font>
            </td>
        </tr>
    </table>

  @endif
    <hr>

    <table width="100%">
        <tr>
            <td width="30%"></td>
            <td width="25%"></td>
            <td width="20%">
                <font size="1"><b>Total a Pagar:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="1"><b>$&nbsp;{{ number_format($total_fact, 2) }}</b></font>
            </td>
        </tr>
    </table>

    <br>
    <table width="100%">
      <tr>
        <td>
            <img width="40" height="40" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->generate($QRCode)) !!} ">
        </td>
        <td><font size="1">Cufe:&nbsp;{{$cufe}} &nbsp; Hora:{{$hora_cufe}}</font></td>
      </tr>
    </table>

  </body>

</html>

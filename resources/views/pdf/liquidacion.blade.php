<!DOCTYPE html>
<html>

<head>
    <title>Liquidación</title>

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
                            <font size="2">Fecha de impresión. {{$fecha_impresion}}</font>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <img src="{{ asset('images/logon13.png') }}" width="28 px" height="28 px">
                </br>
                <center>{{$email}}</center>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
      <tr>
        <td align="center">
          {{$titulo_liq}}
        </td>
      </tr>
    </table>
  <br><br>

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
            <td align="center">
                <font size="1">{{$resolucion}}</font>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="30%" bgcolor="#ededed">
                <font size="3"><b>Ingresos Notariales</b></font>
            </td>
            <td width="25%" bgcolor="#ededed"></td>
            <td width="20%" bgcolor="#ededed">
                <font size="3"><b>Cantidad</b></font>
            </td>
            <td width="25%" bgcolor="#ededed" align="center">
                <font size="3"><b>Valor</b></font>
            </td>
        </tr>
        <tr>
            <td width="30%">
                <font size="3">Derechos</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="3">$&nbsp;{{ number_format($derechos, 2) }}</font>
            </td>
        </tr>
        @for ($i = 1; $i
        <= $contdataconcept; $i++) @if (array_key_exists($i, $dataconcept))
        <tr>
            <td width="30%">
                <font size="3">{{$dataconcept[$i]['concepto']}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%" align="center">
                <font size="3">{{$dataconcept[$i]['cantidad']}}</font>
            </td>
            <td width="25%" align="right">
                <font size="3">$&nbsp;{{ number_format($dataconcept[$i]['total'], 2) }}</font>
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
                <font size="3"><b>Total Ingresos:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="3"><b>$&nbsp;{{ number_format($subtotal1, 2) }}</b></font>
            </td>
        </tr>
    </table>
    <hr>
    <table width="100%">
        <tr>
            <td width="30%">
                <font size="3"><b>Recaudos y Retenciones</b></font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="center">
                <font size="3"><b>Valor</b></font>
            </td>
        </tr>
        @for ($i = 1; $i
        <= $contterceros; $i++) @if (array_key_exists($i, $terceros))
        <tr>
            <td width="30%">
                <font size="3">{{$terceros[$i]['concepto']}}</font>
            </td>
            <td width="25%"></td>
            <td width="20%"></td>
            <td width="25%" align="right">
                <font size="3">$&nbsp;{{ number_format($terceros[$i]['total'], 2) }}</font>
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
                <font size="3"><b>Total Recaudos:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="3"><b>$&nbsp;{{ number_format($totalterceros, 2) }}</b></font>
            </td>
        </tr>
    </table>
    <hr>

    <table width="100%">
        <tr>
            <td width="30%"></td>
            <td width="25%"></td>
            <td width="20%">
                <font size="4"><b>Total a Pagar:</b></font>
            </td>
            <td width="25%" align="right">
                <font size="4"><b>$&nbsp;{{ number_format($total_fact, 2) }}</b></font>
            </td>
        </tr>
    </table>

</body>

</html>

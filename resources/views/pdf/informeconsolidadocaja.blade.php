<!DOCTYPE html>
<html>

<head>
    <title>Informe Consolidado</title>
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
                        Fecha del Reporte : {{$fecha_reporte}}
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
            <img src="{{ asset('images/logon13.png') }}" width="85px" height="85px"></br>
            <center>{{$email}}</center>
        </td>
    </tr>
</table>
<hr>
<table width="100%">
    <thead>
        <tr>
            <th></th>
            <th><font size="2">Escrituración</font></th>
            <th><font size="2">Caja Rápida</font></th>
            <th><font size="2">Total</font></th>
        </tr>
    </thead>
    <tbody id="datos">
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Contado</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($escri_contado, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($cajarapida_contado, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_contado, 2)}}</font>
            </td>
        </tr>
         <tr>
            <td>
                <font size="2"><b>Crédito</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($escri_credito, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($cajarapida_credito, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_credito, 2)}}</font>
            </td>
        </tr>
         <tr style="background-color: #f2f2f2;">
            <td>
            </td>
            <td align="right">
                <font size="2"><b>{{number_format($total_escrituras, 2)}}</b></font>
            </td>
            <td align="right">
                <font size="2"><b>{{number_format($total_cajarapida, 2)}}</b></font>
            </td>
             <td align="right">
                <font size="2"><b>{{number_format($total, 2)}}</b></font>
            </td>
        </tr>
       
    </tbody>
</table>
<br>
<hr>
<table width="100%">
    <thead>
        <tr>
            <th></th>
            <th><font size="2">Actas de deposito</font></th>
            <th><font size="2">Escrituración</font></th>
            <th><font size="2">Caja Rápida</font></th>
            <th><font size="2">Total</font></th>
        </tr>
    </thead>
    <tbody id="datos">
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Base</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($actas_base, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($escrituras_base, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($cajarapida_base, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_base, 2)}}</font>
            </td>
        </tr>
         <tr style="background-color: #ffffff;">
            <td>
                <font size="2"><b>Efectivo</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($efectivo_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($efectivo_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($efectivo_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_efectivo, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Transf.Bancaria</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($transferencia_bancaria_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($transferencia_bancaria_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($transferencia_bancaria_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_transbanc, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td>
                <font size="2"><b>Consig.Bancaria</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($consignacion_bancaria_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($consignacion_bancaria_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($consignacion_bancaria_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_consgbanc, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>PSE</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($pse_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($pse_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($pse_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_pse, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td>
                <font size="2"><b>T.Crédito</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($tarjeta_credito_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($tarjeta_credito_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($tarjeta_credito_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_tcredito, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>T.Débito</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($tarjeta_debito_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($tarjeta_debito_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($tarjeta_debito_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_tdebito, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #ffffff;">
            <td>
                <font size="2"><b>Cheque</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($cheque_act, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">{{number_format($cheque_es, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($cheque_cr, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format($total_cheque, 2)}}</font>
            </td>
        </tr>
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Bonos</b></font>
            </td>
            <td align="right">
                <font size="2">({{number_format($bono_act, 2)}})</font>
            </td>
            <td align="right">
                <font size="2">({{number_format($bonos_es, 2)}})</font>
            </td>
             <td align="right">
                <font size="2">{{number_format(0, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format(0, 2)}}</font>
            </td>
        </tr>
         <tr style="background-color: #ffffff;">
            <td>
            </td>
            <td align="right">
                <font size="2"><b>{{number_format($total_mediosactas, 2)}}</b></font>
            </td>
            <td align="right">
                <font size="2"><b>{{number_format($total_mediosescrituras, 2)}}</b></font>
            </td>
            <td align="right">
                <font size="2"><b>{{number_format($total_medioscajarapida, 2)}}</b></font>
            </td>
             <td align="right">
                <font size="2"><b>{{number_format($totalmediosdepago, 2)}}</b></font>
            </td>
        </tr>

        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Cruces de Actas Escr</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format(0, 2)}}</font>
            </td>
            <td align="right">
                <font size="2">({{number_format($total_cruces_escr, 2)}})</font>
            </td>
             <td align="right">
                <font size="2">{{number_format(0, 2)}}</font>
            </td>
             <td align="right">
                <font size="2">{{number_format(0, 2)}}</font>
            </td>
        </tr>
       
    </tbody>
</table>
<hr>

<table>
        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Abonos a cartera:</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($abonos_cartera_fact, 2)}}</font>
            </td>
        </tr>

         <tr style="background-color: #ffffff;">
            <td>
                <font size="2"><b>Abonos a cuentas de cobro:</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($abonobonos, 2)}}</font>
            </td>
        </tr>

        <tr style="background-color: #f2f2f2;">
            <td>
                <font size="2"><b>Gastos:</b></font>
            </td>
            <td align="right">
                <font size="2">{{number_format($gastos, 2)}}</font>
            </td>
        </tr>
    </table>

</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <title>Informe de Recaudos</title>

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
                <th><font size="4">Rango Cuantía</font></th>
                <th><font size="4">Cant.Escr</font></th>
                <th><font size="4">Valor Super</font></th>
                <th><font size="4">Valor Fondo</font></th>
                <th><font size="4">Tarifa</font></th>
                <th><font size="4">Total</font></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Sin Cuantia</td>
                <td align="center">{{$sincescr}}</td>
                <td align="right">
                    {{number_format($sincsuper, 2)}} 
                </td>
                <td align="right">
                    {{number_format($sincfondo, 2)}}
                </td>
                <td align="right">
                    {{number_format($valor1, 2)}} 
                </td>
                <td align="right">
                    {{number_format($sinctotal, 2)}}
                </td>
            </tr>

            <tr>
                <td>Excenta</td>
                <td align="center">
                    {{$excescr}}
                </td>
                <td align="right">
                    {{number_format($excsuper, 2)}} 
                </td>
                <td align="right">
                    {{number_format($excfondo, 2)}} 
                </td>
                <td align="right">
                    {{number_format($valor1, 2)}} 
                </td>
                <td align="right">
                    {{number_format($exctotal, 2)}} 
                </td>
            </tr>
            <tr>
                <td>$0 A $100,000,000</td>
                <td align="center">
                    {{$ran1escr}} 
                </td>
                <td align="right">
                    {{number_format($ran1super, 2)}} 
                </td>
                <td align="right">
                    {{number_format($ran1fondo, 2)}} 
                </td>
                <td align="right">
                    {{number_format($valor2, 2)}} 
                </td>
                <td align="right">
                    {{number_format($ran1total, 2)}} 
                </td>
            </tr>

            <tr>
                <td>$100,000,001 A $300,000,000</td>
                <td align="center">
                    {{$ran2escr}} 
                </td>
                <td align="right">
                    {{number_format($ran2super, 2)}} 
                </td>
                <td align="right">
                    {{number_format($ran2fondo, 2)}}
                </td>
                <td align="right">
                    {{number_format($valor3, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran2total, 2)}}
                </td>
            </tr>

            <tr>
                <td>$300,000,001 A $500,000,000</td>
                <td align="center">
                    {{$ran3escr}}
                </td>
                <td align="right">
                    {{number_format($ran3super, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran3fondo, 2)}}
                </td>
                <td align="right">
                    {{number_format($valor4, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran3total, 2)}}
                </td>
            </tr>

            <tr>
                <td>$500,000,001 A $1,000,000,000</td>
                <td align="center">
                    {{$ran4escr}}
                </td>
                <td align="right">
                    {{number_format($ran4super, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran4fondo, 2)}}
                </td>
                <td align="right">
                    {{number_format($valor5, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran4total, 2)}}
                </td>
            </tr>

            <tr>
                <td>$1,000,000,001 A $1,500,000,000</td>
                <td align="center">
                    {{$ran5escr}}
                </td>
                <td align="right">
                    {{number_format($ran5super, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran5fondo, 2)}}
                </td>
                <td align="right">
                    {{number_format($valor6, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran5total, 2)}}
                </td>
            </tr>

            <tr>
                <td>DE $1,500,000,001 En adelante</td>
                <td align="center">
                    {{$ran6escr}}
                </td>
                <td align="right">
                    {{number_format($ran6super, 2)}}
                </td>
                <td align="right">
                    {{number_format($ran6fondo)}}
                </td>
                <td align="right">
                    {{number_format($valor7)}}
                </td>
                <td align="right">
                    {{number_format($ran6total, 2)}}
                </td>
            </tr>

            <tr>
                <td>--------------------------------------------</td>
                <td align="center">
                    ----------------------------
                </td>
                <td align="center">
                    ----------------------------
                </td>
                <td align="center">
                    -----------------------------
                </td>
                <td>-----------------------------</td>
                <td align="center">
                    -----------------------------
                </td>
            </tr>


            <tr>
                <td><b>Totales</b></td>
                <td align="center">
                    <b>{{$total_escrituras}}</b>
                </td>
                <td align="right">
                    <b>{{number_format($total_super, 2)}}</b>
                </td>
                <td align="right">
                    <b>{{number_format($total_fondo, 2)}}</b>
                </td>
                <td align="right"><b>Total Recaudos:</b></td>
                <td align="right">
                    <b>{{number_format($total_recaudos, 2)}}</b>
                </td>
            </tr>


         
        </tbody>
    </table>
            
    <hr>
    

</body>

</html>

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
                <th><font size="4">Rango Cuantía</font></th>
                <th><font size="4">Cant.Escr</font></th>
                <th><font size="4">Valor Super</font></th>
                <th><font size="4">Valor Fondo</font></th>
                <th><font size="4">Tarifa</font></th>
                <th><font size="4">Total</font></th>
            </tr>
        </thead>
        <tbody>

            <tbody>
                @foreach($recaudos as $item)
                    @if($item->rango !== 'TOTALES')
                        <tr>
                            <td>{{ $item->rango }}</td>
                            <td style="text-align: center;">{{ $item->cant_escr }}</td>
                            <td style="text-align: right;">{{ number_format((float)$item->total_super, 2) }}</td>
                            <td style="text-align: right;">{{ number_format((float)$item->total_fondo, 2) }}</td>
                            <td style="text-align: right;">
                            {{ $item->tarifa !== null ? number_format((float)$item->tarifa, 2) : '' }}
                            </td>
                            <td style="text-align: right;">{{ number_format((float)$item->total, 2) }}</td>
                        </tr>
                    @endif
                @endforeach

                {{-- FILA DE TOTALES --}}
                @php
                $totales = collect($recaudos)->firstWhere('rango', 'TOTALES');
                @endphp

                @if($totales)
                    <tr style="font-weight: bold; background-color: #f2f2f2;">
                        <td>{{ $totales->rango }}</td>
                        <td style="text-align: center;">{{ $totales->cant_escr }}</td>
                        <td style="text-align: right;">{{ number_format((float)$totales->total_super, 2) }}</td>
                        <td style="text-align: right;">{{ number_format((float)$totales->total_fondo, 2) }}</td>
                        <td></td>
                        <td style="text-align: right;">{{ number_format((float)$totales->total, 2) }}</td>
                    </tr>
                @endif
            </tbody>         
        </tbody>
    </table>
            
    <hr>
    

</body>

</html>

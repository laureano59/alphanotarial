<!DOCTYPE html>
<html>

<head>
    <title>Relación de Facturas Diarias por Conceptos</title>

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
            <img src="{{ asset('images/logon13.png') }}" width="28 px" height="28 px"></br>
            <center>{{$email}}</center>
        </td>
    </tr>
</table>
<hr>
<table width="100%">
    <thead>
        <tr>
            <th><font size="2">Concepto</font></th>
            <th><font size="2">Cantidad</font></th>
            <th><font size="2">Valor</font></th>
        </tr>
    </thead>
    <tbody id="datos">
         {{-- Inicializar una variable para alternar colores --}}
            @php
                $colorAlternado = true;
            @endphp
        @foreach($relconceptos as $item)
         {{-- Alternar colores de fondo --}}
            @php
            $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
            @endphp
        <tr style="background-color: {{ $colorFondo }}">
            <td>
                <font size="2">{{ $item['concepto'] }}</font>
            </td>
            <td align="center">
                <font size="2">{{ $item['escrituras'] }}</font>
            </td>
            <td align="right">
                <font size="2">{{ number_format($item['total'], 2) }}</font>
            </td>
        </tr>
        {{-- Alternar el valor de la variable para el próximo ciclo --}}
                @php
                $colorAlternado = !$colorAlternado;
                @endphp
        @endforeach
        <tr>
            <td>
            </td>
            <td>
            </td>
            <td align="right">
                ---------------------
            </td>
        </tr>

        <tr>
            <td>
            </td>
            <td align="right">
                <b>Total:</b>
            </td>
            <td align="right">
                <b>{{number_format($total, 2)}}</b>
            </td>
        </tr>

    </tbody>
</table>
<hr>

</body>

</html>

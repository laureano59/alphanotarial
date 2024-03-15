<!DOCTYPE html>
<html>

<head>
    <title>{{$nombre_reporte}}</title>

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
                        Fecha del reporte : {{$fecha_reporte}}
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
            <th><font size="2">Concepto</font></th>
            <th><font size="2">Fecha</font></th>
            <th><font size="2">Valor</font></th>
            <th><font size="2">Autoriza</font></th>
        </tr>
    </thead>
    <tbody>
       {{-- Inicializar una variable para alternar colores --}}
       @php
       $colorAlternado = true;
       @endphp
       @foreach($informedegastos as $item)
       {{-- Alternar colores de fondo --}}
       @php
       $colorFondo = $colorAlternado ? '#f2f2f2' : '#ffffff';
       @endphp
       <tr style="background-color: {{ $colorFondo }}">
        <td align="center">
            <font size="2">{{ $item['concepto_gas'] }}</font>
        </td>
        <td>
            <font size="2">{{ Carbon\Carbon::parse($item['fecha_fact'])->format('d/m/Y') }}</font> 
        </td>
        <td align="right">
            <font size="2">{{ number_format($item['valor_gas'], 2) }}</font>
        </td>
        <td>
            <font size="2">{{ $item['autorizado_por'] }}</font>
        </td>
    </tr>
    {{-- Alternar el valor de la variable para el próximo ciclo --}}
    @php
    $colorAlternado = !$colorAlternado;
    @endphp
    @endforeach

    <tr>
        <td></td>
        <td></td>
        <td align="right">-----------------------</td>
        <td></td>
    </tr>
     <tr>
        <td></td>
        <td></td>
        <td align="right"><b>{{ number_format($total_gastos, 2) }}</b></td>
        <td></td>
    </tr>

</tbody>
</table>
</body>

</html>

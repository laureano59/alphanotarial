<!DOCTYPE html>
<html>

<head>
    <title>Ingresos por escrituradores</title>

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
            <th><font size="2">Escriturador</font></th>
            <th><font size="2">Fecha_Fact</font></th>
            <th><font size="2">Escritura</font></th>
            <th><font size="2">Derechos</font></th>
            <th><font size="2">Conceptos</font></th>
            <th><font size="2">Ingresos</font></th>
            <th><font size="2">Radicación</font></th>
        </tr>
    </thead>
    <tbody id="datos">
         {{-- Inicializar una variable para alternar colores --}}
            @php
                $colorAlternado = true;
            @endphp
        @foreach($relingescr as $item)
         {{-- Alternar colores de fondo --}}
            @php
            $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
            @endphp
        <tr style="background-color: {{ $colorFondo }}">
            <td width="200">
                <font size="2">{{ $item['nombre_proto'] }}</font>
            </td>
            <td align="center">
                <font size="2">{{ $item['fecha_fact'] }}</font>
            </td>
            <td align="center">
                <font size="2">{{ $item['num_esc'] }}</font>
            </td>
            <td align="right">
                <font size="2">{{ number_format($item['total_derechos'], 2) }}</font>
            </td>
            <td align="right">
                <font size="2">{{ number_format($item['total_conceptos'], 2) }}</font>
            </td>
             <td align="right">
                <font size="2">{{ number_format($item['ingresos'], 2) }}</font>
            </td>
             <td align="center">
                <font size="2">{{ $item['id_radica'] }}</font>
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
            <td>
                <b> Totales:</b>
            </td>
                     
             <td align="right">
                <font size="2"><b>{{ number_format($totalderechos, 2) }}</b></font>
            </td>
              <td align="right">
                <font size="2"><b>{{ number_format($totalconceptos, 2) }}</b></font>
            </td>
             <td align="right">
                <font size="2"><b>{{ number_format($totalingresos, 2) }}</b></font>
            </td>
            <td>
            </td>
                        
        </tr>
       
    </tbody>
</table>
<hr>

</body>

</html>

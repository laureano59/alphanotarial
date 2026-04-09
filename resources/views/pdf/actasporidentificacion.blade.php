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
                    <tr><td><font size="3"><b>{{$nombre_nota}}</b></font></td></tr>
                    <tr><td><font size="3">{{$nombre_notario}}</font></td></tr>
                    <tr><td><font size="3">Nit. {{$nit}}</font></td></tr>
                    <tr><td><font size="2">{{$direccion_nota}}</font></td></tr>
                    <tr><td>{{$nombre_reporte}}</td></tr>
                    <tr><td>Fecha del reporte : {{$fecha_reporte}}</td></tr>
                    <tr><td>Fecha de impresión : {{$fecha_impresion}}</td></tr>
                    @if(!empty($identificacion_filtro) && count($informe) > 0)
                    <tr><td><font size="3"><b>Cliente: {{$informe[0]->identificacion_cli}} {{$informe[0]->nombre}}</b></font></td></tr>
                    @endif
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
        <tr style="background-color: #f2f2f2;">
            <th><font size="2">Fecha</font></th>
            <th><font size="2">Radicación</font></th>
            <th><font size="2">Acta #</font></th>
            <th><font size="2">Escritura</font></th>
            <th><font size="2">Factura #</font></th>
            @if(empty($identificacion_filtro))
            <th><font size="2">Cliente</font></th>
            @endif
            <th><font size="2">Vr Acta</font></th>
            <th><font size="2">Vr. Boleta</font></th>
            <th><font size="2">Vr. Registro</font></th>
            <th><font size="2">Vr. Escritura</font></th>
            <th><font size="2">Saldo</font></th>
            <th><font size="2">Estado</font></th>
            <th><font size="2">Activa</font></th>
            <th><font size="2">Observaciones</font></th>
        </tr>
    </thead>
    <tbody>
        @php $colorAlternado = true; @endphp
        @foreach($informe as $item)
        @php $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2'; @endphp
        <tr style="background-color: {{ $colorFondo }}">
            <td align="center"><font size="2">{{ $item->fecha }}</font></td>
            <td align="center"><font size="2">{{ $item->id_radica }}</font></td>
            <td align="center"><font size="2">{{ $item->id_act }}</font></td>
            <td align="center"><font size="2">{{ $item->num_esc }}</font></td>
            <td align="center"><font size="2">{{ $item->id_fact ?? '' }}</font></td>
            @if(empty($identificacion_filtro))
            <td><font size="2">{{ $item->identificacion_cli }} {{ $item->nombre }}</font></td>
            @endif
            <td align="right"><font size="2">{{ number_format($item->deposito_act, 2) }}</font></td>
            <td align="right"><font size="2">{{ number_format($item->deposito_boleta, 2) }}</font></td>
            <td align="right"><font size="2">{{ number_format($item->deposito_registro, 2) }}</font></td>
            <td align="right"><font size="2">{{ number_format($item->deposito_escrituras, 2) }}</font></td>
            <td align="right"><font size="2">{{ number_format($item->saldo, 2) }}</font></td>
            <td align="center"><font size="2">{{ $item->credito_act == 1 ? "Crédito" : "Normal" }}</font></td>
            <td align="center"><font size="2">{{ ($item->anulada == 1 || $item->anulada == true) ? "Anulada" : "Activa" }}</font></td>
            <td><font size="2">{{ $item->observaciones_act }}</font></td>
        </tr>
        @php $colorAlternado = !$colorAlternado; @endphp
        @endforeach
        <tr style="background-color: #f2f2f2; font-weight: bold;">
            <td colspan="{{ empty($identificacion_filtro) ? 6 : 5 }}" align="right"><b>TOTALES:</b></td>
            <td align="right"><font size="2"><b>{{ number_format($total_deposito, 2) }}</b></font></td>
            <td align="right"><font size="2"><b>{{ number_format($total_boleta, 2) }}</b></font></td>
            <td align="right"><font size="2"><b>{{ number_format($total_registro, 2) }}</b></font></td>
            <td align="right"><font size="2"><b>{{ number_format($total_escritura, 2) }}</b></font></td>
            <td align="right"><font size="2"><b>{{ number_format($total_saldo, 2) }}</b></font></td>
            <td colspan="3"></td>
        </tr>
    </tbody>
</table>
</body>
</html>

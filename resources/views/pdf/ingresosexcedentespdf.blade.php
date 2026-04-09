<!DOCTYPE html>
<html>

<head>
    <title>{{ $nombre_reporte }}</title>
</head>

<body>
    <table width="100%">
        <tr>
            <td>
                <table>
                    <tr>
                        <td>
                            <font size="3"><b>{{ $nombre_nota }}</b></font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="3">{{ $nombre_notario }}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="3">Nit. {{ $nit }}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <font size="2">{{ $direccion_nota }}</font>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ $nombre_reporte }}</td>
                    </tr>
                    <tr>
                        <td>
                            Fecha del reporte : {{ $fecha_reporte }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Fecha de impresión : {{ $fecha_impresion }}
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                @if (!empty($logoSrc))
                    <img src="{{ $logoSrc }}" width="85" height="85" alt=""><br>
                @endif
                <center>{{ $email }}</center>
            </td>
        </tr>
    </table>
    <hr>

    @php
        $sumDerechos = 0;
        $sumConceptos = 0;
        $sumIva = 0;
        $sumRtf = 0;
        $sumFondo = 0;
        $sumSuper = 0;
        $sumTotal = 0;
        $colorAlternado = true;
    @endphp

    <table width="100%">
        <thead>
            <tr>
                <th><font size="2">No. Fac</font></th>
                <th><font size="2">Radicado</font></th>
                <th><font size="2">Año</font></th>
                <th><font size="2">Fecha Fac</font></th>
                <th><font size="2">No. Esc</font></th>
                <th><font size="2">Fecha Esc</font></th>
                <th><font size="2">Derechos</font></th>
                <th><font size="2">Conceptos</font></th>
                <th><font size="2">IVA</font></th>
                <th><font size="2">RTF</font></th>
                <th><font size="2">Fondo</font></th>
                <th><font size="2">Super</font></th>
                <th><font size="2">Total Fac.</font></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reporte as $item)
                @php
                    $sumDerechos += (float) ($item->total_derechos ?? 0);
                    $sumConceptos += (float) ($item->total_conceptos ?? 0);
                    $sumIva += (float) ($item->total_iva ?? 0);
                    $sumRtf += (float) ($item->total_rtf ?? 0);
                    $sumFondo += (float) ($item->total_fondo ?? 0);
                    $sumSuper += (float) ($item->total_super ?? 0);
                    $sumTotal += (float) ($item->total_fac ?? 0);
                    $colorFondo = $colorAlternado ? '#ffffff' : '#f2f2f2';
                @endphp
                <tr style="background-color: {{ $colorFondo }}">
                    <td align="center"><font size="2">{{ $item->id_fact }}</font></td>
                    <td align="center"><font size="2">{{ $item->id_radica }}</font></td>
                    <td align="center"><font size="2">{{ $item->anio_radica }}</font></td>
                    <td align="center"><font size="2">{{ $item->fecha_fact_fmt ?? '' }}</font></td>
                    <td align="center"><font size="2">{{ $item->num_esc }}</font></td>
                    <td align="center"><font size="2">{{ $item->fecha_esc_fmt ?? '' }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_derechos ?? 0, 2) }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_conceptos ?? 0, 2) }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_iva ?? 0, 2) }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_rtf ?? 0, 2) }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_fondo ?? 0, 2) }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_super ?? 0, 2) }}</font></td>
                    <td align="right"><font size="2">{{ number_format($item->total_fac ?? 0, 2) }}</font></td>
                </tr>
                @php
                    $colorAlternado = ! $colorAlternado;
                @endphp
            @endforeach

            <tr>
                <td colspan="6" align="right"><b><font size="2">Totales</font></b></td>
                <td align="right"><font size="2"><b>{{ number_format($sumDerechos, 2) }}</b></font></td>
                <td align="right"><font size="2"><b>{{ number_format($sumConceptos, 2) }}</b></font></td>
                <td align="right"><font size="2"><b>{{ number_format($sumIva, 2) }}</b></font></td>
                <td align="right"><font size="2"><b>{{ number_format($sumRtf, 2) }}</b></font></td>
                <td align="right"><font size="2"><b>{{ number_format($sumFondo, 2) }}</b></font></td>
                <td align="right"><font size="2"><b>{{ number_format($sumSuper, 2) }}</b></font></td>
                <td align="right"><font size="2"><b>{{ number_format($sumTotal, 2) }}</b></font></td>
            </tr>
        </tbody>
    </table>
</body>

</html>

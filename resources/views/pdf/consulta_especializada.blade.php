<!DOCTYPE html>
<html>
<head>
    <title>Consulta Especializada</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #4472C4; color: white; text-align: center; padding: 5px; font-size: 10px; border: 1px solid #000; }
        td { padding: 4px; font-size: 10px; border: 1px solid #000; }
        .fila-par  { background-color: #f2f2f2; }
        .fila-impar{ background-color: #ffffff; }
        .fila-total{ background-color: #dce6f1; font-weight: bold; border-top: 2px solid #4472C4; }
        .derecha { text-align: right; }
        .centro  { text-align: center; }
        .encabezado td { font-size: 11px; border: none !important; }
        hr { border: 1px solid #4472C4; margin: 10px 0; }
        .section-title { font-size: 13px; font-weight: bold; margin-top: 15px; margin-bottom: 5px; color: #4472C4; border-bottom: 2px solid #4472C4; }
        .highlight { border: 2px solid #000; background-color: #e9ecef; color: #004085; font-size: 18px; font-weight: bold; padding: 10px; display: inline-block; }
    </style>
</head>
<body>

<table class="encabezado" style="margin-bottom:0;">
    <tr>
        <td style="width:75%; text-align: left; vertical-align: top;">
            <table>
                <tr><td><b style="font-size:14px;">{{ $nombre_nota }}</b></td></tr>
                <tr><td>{{ $nombre_notario }}</td></tr>
                <tr><td>Nit. {{ $nit }}</td></tr>
                <tr><td>{{ $direccion_nota }}</td></tr>
                <tr><td><b>CONSULTA ESPECIALIZADA - TRAZABILIDAD</b></td></tr>
                <tr><td>{{ $query }}</td></tr>
                <tr><td>Fecha Impresión: {{ $fecha_impresion }}</td></tr>
            </table>
        </td>
        <td style="width:25%; text-align:center; vertical-align:top;">
             <img src="{{ public_path('images/logon13.png') }}" width="80px" height="80px"><br>
             <small>{{ $email }}</small>
        </td>
    </tr>
</table>
<hr>


@if(isset($escritura_destacada) && $escritura_destacada != '')
<div style="text-align: center; margin: 15px 0;">
    <div class="highlight">
        {!! $escritura_destacada !!}
    </div>
</div>
@endif

@if(count($facturas) > 0)
<div class="section-title">FACTURAS</div>
<table>
    <thead>
        <tr>
            <th>Escritura</th>
            <th>No. Factura (Radicación)</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Saldo</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($facturas as $f)
        @php
            $saldo = 0;
            if (!empty($f->cartera)) {
                foreach($f->cartera as $cart) {
                    $saldo = $cart->saldo;
                }
            }
        @endphp
        <tr>
            <td class="centro">{{ $f->num_esc }} - {{ $f->anio_esc }}</td>
            <td class="centro"><b>{{ $f->id_fact }}</b><br><small>(Rad: {{ $f->id_radica }}-{{ $f->anio_radica }})</small></td>
            <td class="centro">{{ $f->fecha_fact }}</td>
            <td>{{ $f->a_nombre_de }} {{ isset($f->cliente_nombre) ? '- ' . $f->cliente_nombre : '' }}</td>
            <td class="derecha">{{ number_format($f->total_fact, 0) }}</td>
            <td class="derecha">{{ number_format($saldo, 0) }}</td>
            <td class="centro">{{ $f->nota_credito ? 'ANULADA' : 'ACTIVA' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

@if(count($actas) > 0)
<div class="section-title">ACTAS DE DEPÓSITO</div>
<table>
    <thead>
        <tr>
            <th>Escritura</th>
            <th>No. Acta (Radicación / Fecha)</th>
            <th>Valor</th>
            <th>Saldo</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($actas as $a)
        <tr>
            <td class="centro">{{ $a->num_esc }} - {{ $a->anio_esc }}</td>
            <td class="centro">
                <b>{{ $a->id_act }}</b><br>
                <small>(Rad: {{ $a->id_radica }}-{{ $a->anio_radica }})</small><br>
                <small>Fecha: {{ $a->fecha }}</small><br>
                <small><b>{{ $a->credito_act ? 'CRÉDITO' : 'CONTADO' }}</b></small>
            </td>
            <td class="derecha">{{ number_format($a->deposito_act, 0) }}</td>
            <td class="derecha">{{ number_format($a->saldo, 0) }}</td>
            <td class="centro">{{ $a->anulada ? 'ANULADA' : 'ACTIVA' }}</td>
        </tr>
        @if(!empty($a->cruces))
        <tr>
            <td colspan="5">
                <table style="width:100%; margin-top:5px; border:1px solid #ccc; font-size: 8px;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th style="padding: 2px;">No. Egreso</th>
                            <th style="padding: 2px;">Fecha</th>
                            <th style="padding: 2px;">Valor</th>
                            <th style="padding: 2px;">Saldo</th>
                            <th style="padding: 2px;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($a->cruces as $cr)
                        <tr>
                            <td class="centro" style="padding: 2px;">{{ $cr->id_egr }}</td>
                            <td class="centro" style="padding: 2px;">{{ $cr->fecha_egreso }}</td>
                            <td class="derecha" style="padding: 2px;">{{ number_format($cr->egreso_egr, 0) }}</td>
                            <td class="derecha" style="padding: 2px;">{{ number_format($cr->saldo, 0) }}</td>
                            <td style="padding: 2px;">{{ $cr->observaciones_egr }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
@endif

@if(count($bonos) > 0)
<div class="section-title">BONOS</div>
<table>
    <thead>
        <tr>
            <th>No. Bono</th>
            <th>Radicación / Fecha</th>
            <th>Código</th>
            <th>Valor Bono</th>
            <th>Saldo Bono</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bonos as $b)
        <tr>
            <td class="centro">{{ $b->id_bon }}</td>
            <td class="centro">
                <small>Rad: {{ $b->id_radica }}-{{ $b->anio_radicacion }}</small><br>
                <small>Fecha: {{ $b->fecha_radica }}</small>
            </td>
            <td class="centro">{{ $b->codigo_bono }}</td>
            <td class="derecha">{{ number_format($b->valor_bono, 0) }}</td>
            <td class="derecha">{{ number_format($b->saldo_bono, 0) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif

<div style="position: fixed; bottom: 0; width: 100%; text-align: right; font-size: 8px;">
    Exportado por: {{ $usuario }} - Fecha: {{ $fecha_impresion }}
</div>

</body>
</html>
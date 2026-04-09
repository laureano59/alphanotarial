@extends('layouts.principal')
@section('title', 'Alpha-Notarial')
@section('titulo_link', 'Panel de Control')
@section('content')

<div class="page-header">
    <h1>{{ $nombre_reporte }}</h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Rango de Fechas de Facturación</h4>
                    
                    <span class="widget-toolbar">
                        <a href="javascript://" id="exportar_excel_excedentes">
                            <i><img src="{{ asset('images/icoexcel.png') }}" width="28 px" height="28 px" title="Exportar a Excel"></i>
                        </a>
                    </span>
                    
                    <span class="widget-toolbar">
                        <a target="_blank" href="#" id="imprimir_pdf_excedentes">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Reporte PDF"></i>
                        </a>
                    </span>
                    
                    <span class="widget-toolbar">
                        <a href="#" data-action="settings" id="generarreporte_excedentes">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                    
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group" style="display:inline-table; width:250px;">
                            <input type="text" class="input-sm form-control" name="start" id="start" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" />
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="widget-body">
            <div class="widget-main">
                <table id="simple-table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No. Fac</th>
                            <th>Radicación</th>
                            <th>Año</th>
                            <th>Fecha Fact.</th>
                            <th>No. Esc.</th>
                            <th>Fecha Esc.</th>
                            <th>Derechos</th>
                            <th>Conceptos</th>
                            <th>IVA</th>
                            <th>RTF</th>
                            <th>Fondo</th>
                            <th>Super</th>
                            <th>Total Fac.</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('csslau')
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('js/reportes/script.js') }}"></script>
<script src="{{ asset('js/calendario.js') }}"></script>
<script src="{{ asset('js/reportes/grid.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/spinbox.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/autosize.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.inputlimiter.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('js/solonumeros.js') }}"></script>
<script src="{{ asset('js/formatonumero.js') }}"></script>
<script src="{{ asset('js/numberFormat154.js') }}"></script>

<script>
// ===========================================================================
// Carga el informe de excedentes al hacer clic en "Generar Reporte"
// ===========================================================================
$(document).ready(function(){

    $("#generarreporte_excedentes").off('click').on('click', function(e){
        e.preventDefault();
        var fecha1 = $("#start").val();
        var fecha2  = $("#end").val();
        if (fecha1 == '' || fecha2 == '') {
            alert("Todos los campos son necesarios");
            return;
        }
        var route = "/ingresos_excedentes_otros_periodos";
        var token = $("#token").val() || $('meta[name="csrf-token"]').attr('content');
        var datos = { "fecha1": fecha1, "fecha2": fecha2 };
        $.ajax({
            url: route,
            headers: { 'X-CSRF-TOKEN': token },
            type: 'GET',
            dataType: 'json',
            data: datos,
            success: function(info){
                CargarTablaExcedentes(info.reporte);
            },
            error: function(xhr){
                alert("Error al obtener el reporte.");
            }
        });
    });

    // Exportar a Excel
    $("#exportar_excel_excedentes").off('click').on('click', function(){
        var fecha1 = $("#start").val();
        var fecha2  = $("#end").val();
        if (fecha1 == '' || fecha2 == '') {
            alert('Seleccione un rango de fecha.');
            return;
        }
        window.location.href = "/ingresos_excedentes_excel?fecha1=" + encodeURIComponent(fecha1) + "&fecha2=" + encodeURIComponent(fecha2);
    });

    // Imprimir PDF
    $("#imprimir_pdf_excedentes").off('click').on('click', function(e){
        e.preventDefault();
        var fecha1 = $("#start").val();
        var fecha2  = $("#end").val();
        if (fecha1 == '' || fecha2 == '') {
            alert('Seleccione un rango de fecha.');
            return;
        }
        window.open("/ingresos_excedentes_pdf?fecha1=" + encodeURIComponent(fecha1) + "&fecha2=" + encodeURIComponent(fecha2), "_blank");
    });

});

function CargarTablaExcedentes(datos) {
    var tbody = $("#data");
    tbody.empty();

    if (!datos || datos.length === 0) {
        tbody.append('<tr><td colspan="13" style="text-align:center;">Sin datos para el rango seleccionado.</td></tr>');
        return;
    }

    $.each(datos, function(i, item) {
        var esTotal = (item.id_fact == 'TOTAL');
        var fila = '';
        if (esTotal) {
            fila = '<tr style="font-weight: bold; background-color: #e8f4fd; border-top: 2px solid #999;">';
        } else {
            fila = '<tr>';
        }
        fila += '<td>' + (item.id_fact    || '') + '</td>';
        fila += '<td>' + (item.id_radica  || '') + '</td>';
        fila += '<td>' + (item.anio_radica|| '') + '</td>';
        fila += '<td>' + (item.fecha_fact || '') + '</td>';
        fila += '<td>' + (item.num_esc    || '') + '</td>';
        fila += '<td>' + (item.fecha_esc  || '') + '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_derechos) + '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_conceptos)+ '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_iva)      + '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_rtf)      + '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_fondo)    + '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_super)    + '</td>';
        fila += '<td style="text-align:right;">' + fmtNum(item.total_fac)      + '</td>';
        fila += '</tr>';
        tbody.append(fila);
    });
}

function fmtNum(num) {
    if (num === null || num === undefined || num === '') return '';
    return '$' + parseFloat(num).toLocaleString('es-CO', {minimumFractionDigits: 2, maximumFractionDigits: 2});
}
</script>
@endsection
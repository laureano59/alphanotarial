@extends('layouts.principal')
@section('title', 'Informe de Escrituras por Acto')

@section('content')
<div class="page-header">
    <h1>
        Escrituras por Acto Notarial
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Consulta por fechas de escrituración
        </small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-12">
        <form>
            @csrf
            <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Rango de Fecha de Escrituración</h4>
                    
                    <span class="widget-toolbar">
                        <a href="javascript://" id="btn_exportar_excel_acto">
                            <i><img src="{{ asset('images/excel.png') }}" width="28 px" height="28 px" title="Exportar a Excel"></i>
                        </a>
                    </span>
                    
                    <span class="widget-toolbar">
                        <a href="javascript://" id="btn_imprimir_pdf_acto">
                            <i><img src="{{ asset('images/impresora.png') }}" width="28 px" height="28 px" title="Imprimir Reporte PDF"></i>
                        </a>
                    </span>
                    
                    <span class="widget-toolbar">
                        <a href="javascript://" id="btn_buscar_escrituras_acto">
                            <i><img src="{{ asset('images/buscar.png') }}" width="28 px" height="28 px" title="Generar Reporte"></i>
                        </a>
                    </span>
                    
                    <span class="nav-search widget-toolbar">
                        <div class="input-daterange input-group" style="display:inline-table; width:250px;">
                            <input type="text" class="input-sm form-control" name="start" id="start" placeholder="Inicio" autocomplete="off" />
                            <span class="input-group-addon">
                                <i class="fa fa-exchange"></i>
                            </span>
                            <input type="text" class="input-sm form-control" name="end" id="end" placeholder="Fin" autocomplete="off" />
                        </div>
                    </span>
                </div>

                <div class="widget-body">
                    <div class="widget-main" style="padding: 20px;">
                        <div class="row">
                            <div class="col-xs-12">
                                <label class="control-label bolder blue">Seleccione uno o varios Actos Notariales</label>
                                <select multiple="" class="chosen-select form-control" id="form-field-select-4" data-placeholder="Haga clic aquí para seleccionar los actos..." style="width: 100%;">
                                    <option value="TODOS">--- TODOS LOS ACTOS (REPORTE GENERAL) ---</option>
                                    @foreach($actos as $acto)
                                        <option value="{{ $acto->id_acto }}">{{ $acto->nombre_acto }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="space-12"></div>

<div class="row">
    <div class="col-xs-12">
        <div class="table-header">
            Resultados de la Búsqueda
        </div>

        <div class="table-responsive">
            <table id="dynamic-table-acto" class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Escritura</th>
                        <th>Fecha</th>
                        <th>Radicación</th>
                        <th>Año</th>
                        <th>Factura</th>
                        <th>Valor</th>
                        <th>ID Acto</th>
                        <th>Acto</th>
                        <th>Otorgante</th>
                        <th>Compareciente</th>
                    </tr>
                </thead>
                <tbody id="tbody_reporte_acto">
                    <!-- Se carga via AJAX -->
                </tbody>
            </table>
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
<script src="{{ asset('assets/js/jquery-ui.custom.min.js') }}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">
    jQuery(function($) {
        $('.chosen-select').chosen({allow_single_deselect:true}); 
        
        // El calendario ya se inicializa en js/calendario.js para la clase .input-daterange

        $("#btn_buscar_escrituras_acto").click(function(e){
            e.preventDefault();
            var f1 = $("#start").val();
            var f2 = $("#end").val();
            var actos = $("#form-field-select-4").val();

            if(!f1 || !f2){
                alert("Por favor seleccione un rango de fechas.");
                return;
            }

            if(!actos){
                alert("Por favor seleccione al menos un acto o 'TODOS'.");
                return;
            }

            $.ajax({
                url: '/getescrituras_por_acto_ajax',
                type: 'GET',
                data: {
                    fecha1: f1,
                    fecha2: f2,
                    actos: actos
                },
                success: function(response){
                    var html = '';
                    $.each(response.reporte, function(i, item){
                        html += '<tr>' +
                            '<td>' + (item.escritura || '-') + '</td>' +
                            '<td>' + (item.fecha_esc || '-') + '</td>' +
                            '<td>' + item.id_radica + '</td>' +
                            '<td>' + (item.anio_radica || '-') + '</td>' +
                            '<td>' + (item.id_fact || '-') + '</td>' +
                            '<td>' + (item.total_fact ? '$' + parseFloat(item.total_fact).toLocaleString() : '-') + '</td>' +
                            '<td>' + item.id_acto + '</td>' +
                            '<td>' + item.nombre_acto + '</td>' +
                            '<td>' + item.otorgante + '</td>' +
                            '<td>' + item.compareciente + '</td>' +
                            '</tr>';
                    });
                    $("#tbody_reporte_acto").html(html);
                },
                error: function(){
                    alert("Error al recuperar datos.");
                }
            });
        });

        $("#btn_imprimir_pdf_acto").click(function(e){
             e.preventDefault();
             var f1 = $("#start").val();
             var f2 = $("#end").val();
             var actos = $("#form-field-select-4").val();
             if(!f1 || !f2){ alert("Seleccione fechas"); return; }
             if(!actos){ alert("Seleccione actos"); return; }
             
             var url = '/pdf_escrituras_por_acto?fecha1='+f1.replace(/\//g,'-')+'&fecha2='+f2.replace(/\//g,'-')+'&actos='+actos.join(',');
             window.open(url, '_blank');
        });

        $("#btn_exportar_excel_acto").click(function(e){
             e.preventDefault();
             var f1 = $("#start").val();
             var f2 = $("#end").val();
             var actos = $("#form-field-select-4").val();
             if(!f1 || !f2){ alert("Seleccione fechas"); return; }
             if(!actos){ alert("Seleccione actos"); return; }
             
             var url = '/excel_escrituras_por_acto?fecha1='+f1+'&fecha2='+f2+'&actos='+actos.join(',');
             window.open(url, '_blank');
        });
    });
</script>
@endsection

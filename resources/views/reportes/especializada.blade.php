@extends('layouts.principal')
@section('title', 'Consulta Especializada')
@section('content')

<div id="consulta_especializada">
    <div class="page-header">
        <h1>
            🔍 MÓDULO CONSULTA ESPECIALIZADA
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Búsqueda Trazabilidad Completa
            </small>
        </h1>
    </div>

    <!-- Buscador -->
    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box widget-color-blue2">
                <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                        <i class="ace-icon fa fa-search"></i>
                        Criterios de Búsqueda (Puede llenar uno o varios campos)
                    </h5>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main padding-16">
                        <div id="form_busqueda">
                            <div class="row" style="margin-left: 5px; margin-right: 5px;">
                                <div style="float: left; width: 100px; padding: 2px;">
                                    <label for="f_acta" style="font-size: 11px;"><b>No. Acta:</b></label>
                                    <input type="text" id="f_acta" class="form-control input-sm" placeholder="Acta">
                                </div>
                                <div style="float: left; width: 100px; padding: 2px;">
                                    <label for="f_radica" style="font-size: 11px;"><b>Radicación:</b></label>
                                    <input type="text" id="f_radica" class="form-control input-sm" placeholder="Radica">
                                </div>
                                <div style="float: left; width: 100px; padding: 2px;">
                                    <label for="f_escritura" style="font-size: 11px;"><b>Escritura:</b></label>
                                    <input type="text" id="f_escritura" class="form-control input-sm" placeholder="Número">
                                </div>
                                <div style="float: left; width: 75px; padding: 2px;">
                                    <label for="f_anio_escritura" style="font-size: 11px;"><b>Año:</b></label>
                                    <input type="text" id="f_anio_escritura" class="form-control input-sm" placeholder="Año">
                                </div>
                                <div style="float: left; width: 100px; padding: 2px;">
                                    <label for="f_factura" style="font-size: 11px;"><b>Factura:</b></label>
                                    <input type="text" id="f_factura" class="form-control input-sm" placeholder="Factura">
                                </div>
                                <div style="float: left; width: 170px; padding: 2px; margin-top: 21px;">
                                    <button type="button" id="btn_buscar" class="btn btn-primary btn-sm btn-block">
                                        <i class="ace-icon fa fa-search"></i> BUSCAR EXPEDIENTE
                                    </button>
                                </div>
                                <div style="float: left; width: 100px; padding: 2px; margin-top: 21px;">
                                    <button type="button" id="btn_limpiar" class="btn btn-default btn-sm btn-block" title="Limpiar">
                                        <i class="fa fa-refresh"></i> LIMPIAR
                                    </button>
                                </div>
                                <div style="float: left; width: 100px; padding: 2px; margin-top: 21px;">
                                    <button type="button" id="btn_stop" class="btn btn-warning btn-xs btn-block" style="display:none;">
                                        <i class="ace-icon fa fa-stop"></i> DETENER
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr style="margin: 10px 0;">
                            <div class="col-md-12 text-right">
                                <button type="button" id="btn_pdf" class="btn btn-danger btn-sm" disabled>
                                    <i class="ace-icon fa fa-file-pdf-o"></i> 📄 PDF Consulta
                                </button>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Resultados -->
    <div id="contenedor_resultados" style="display:none;">
        <div id="info_escritura_destacada" style="margin-bottom: 20px;"></div>
        
        <!-- Facturas -->
        <h3 class="header smaller bolder blue"><b>📜 Facturas Relacionadas</b></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered table-striped" id="tabla_facturas">
                    <thead class="thin-border-bottom">
                        <tr class="info">
                            <th>Escritura</th>
                            <th>No. Factura (Radicación)</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Tipo</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Notas Crédito -->
        <h3 class="header smaller bolder red"><b>📄 Notas Crédito</b></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered table-striped" id="tabla_nc">
                    <thead class="thin-border-bottom">
                        <tr class="danger">
                            <th>No. NC</th>
                            <th>Factura Ref.</th>
                            <th>Fecha</th>
                            <th>Valor</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Actas -->
        <h3 class="header smaller bolder orange"><b>📋 Actas de Depósito</b></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered table-striped" id="tabla_actas">
                    <thead class="thin-border-bottom">
                        <tr class="info">
                            <th>Escritura</th>
                            <th>No. Acta (Radicación)</th>
                            <th>Valor Depósito</th>
                            <th>Estado</th>
                            <th>Saldo</th>
                            <th>Relación de Egresos / Cruces</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Bonos -->
        <h3 class="header smaller bolder green"><b>🎟️ Bonos</b></h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-bordered table-striped" id="tabla_bonos">
                    <thead class="thin-border-bottom">
                        <tr class="success">
                            <th>Escritura</th>
                            <th>No. Bono (Radicación)</th>
                            <th>Código</th>
                            <th>Valor Bono</th>
                            <th>Saldo Bono</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Mensaje No Resultados -->
    <div id="sin_resultados" class="alert alert-warning center" style="display:none; border-radius:15px; margin-top:50px;">
        <h2 class="lighter bigger">
            <i class="ace-icon fa fa-info-circle"></i>
            Excelente registro, pero NO se encontraron resultados para la búsqueda actual.
        </h2>
        <p class="bigger-110">Por favor verifique la información ingresada.</p>
    </div>

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#btn_limpiar").click(function() {
            $("#f_acta").val('');
            $("#f_radica").val('');
            $("#f_escritura").val('');
            $("#f_anio_escritura").val('');
            $("#f_factura").val('');
            $("#f_identificacion").val('');
            $("#f_fecha1").val('');
            $("#f_fecha2").val('');
            
            $("#contenedor_resultados").hide();
            $("#sin_resultados").hide();
            $("#btn_pdf").prop('disabled', true);
            
            $("#f_acta").focus();
        });

        var currentRequest = null;

        $("#btn_stop").click(function() {
            if(currentRequest) {
                currentRequest.abort();
                $("#btn_stop").hide();
                $("#btn_buscar").show().html('<span class="ace-icon fa fa-search icon-on-right bigger-110"></span> BUSCAR');
            }
        });

        $("#btn_buscar").click(function() {
            var act = $.trim($("#f_acta").val());
            var rad = $.trim($("#f_radica").val());
            var esc = $.trim($("#f_escritura").val());
            var anio_esc = $.trim($("#f_anio_escritura").val());
            var fac = $.trim($("#f_factura").val());

            if (act == '' && rad == '' && esc == '' && fac == '') {
                alert("Debe ingresar un parámetro de búsqueda.");
                return;
            }
            if (esc != '' && anio_esc == '') {
                alert("Para buscar por número de escritura, debe indicar el año (Año Esc.).");
                return;
            }

            $("#btn_buscar").hide();
            $("#btn_stop").show();
            
            if(currentRequest) { currentRequest.abort(); }

            currentRequest = $.ajax({
                url: '/consulta_especializada/buscar',
                type: 'GET',
                timeout: 120000,
                data: { 
                    acta: act, 
                    radica: rad, 
                    escritura: esc,
                    anio_escritura: anio_esc,
                    factura: fac
                },
                success: function(response) {
                    $("#btn_stop").hide();
                    $("#btn_buscar").show().html('<span class="ace-icon fa fa-search icon-on-right bigger-110"></span> BUSCAR');
                    if(response.status == 'success') {
                        // Limpiar y cargar tablas
                        $("#tabla_facturas tbody").empty();
                        $("#tabla_nc tbody").empty();
                        $("#tabla_actas tbody").empty();
                        $("#tabla_bonos tbody").empty();
                        $("#info_escritura_destacada").empty();
                        
                        if (response.escritura_info && response.escritura_info != '') {
                            $("#info_escritura_destacada").html('<div class="alert alert-info center" style="border-radius:15px; border:2px solid #2e89bb;"><h1 class="blue lighter bigger"><i class="ace-icon fa fa-certificate"></i> ' + response.escritura_info + '</h1></div>');
                        }
                        
                        var hay_datos = false;
                        
                        if(response.data.facturas.length > 0) {
                            hay_datos = true;
                            response.data.facturas.forEach(function(f) {
                                var tipo_pago = f.credito_fact ? '<span class="label label-danger">CRÉDITO</span>' : '<span class="label label-success">CONTADO</span>';
                                var cartera_html = '';
                                if(f.credito_fact && f.cartera) {
                                    f.cartera.forEach(function(c) {
                                        cartera_html += 'Abono: ' + number_format(c.abono, 0) + ' | Saldo: ' + number_format(c.saldo, 0) + '<br>';
                                    });
                                }
                                var nombreCli = f.a_nombre_de;
                                if (f.cliente_nombre) {
                                    nombreCli += ' - ' + f.cliente_nombre;
                                }
                                 $("#tabla_facturas tbody").append('<tr>' +
                                    '<td>'+(f.num_esc || 'N/A')+' - '+(f.anio_esc || '')+'</td>' +
                                    '<td><b>'+f.id_fact+'</b> <br><small class="text-primary">(Rad: '+f.id_radica+'-'+f.anio_radica+')</small></td>' +
                                    '<td>'+f.fecha_fact+'</td>' +
                                    '<td>'+nombreCli+'</td>' +
                                    '<td>'+tipo_pago+'</td>' +
                                    '<td>$'+number_format(f.total_fact, 0)+'</td>' +
                                    '<td>'+(f.nota_credito ? '<span class="label label-danger">Anulada</span>' : '<span class="label label-success">Activa</span>')+'</td>' +
                                    '<td>'+cartera_html+'</td>' +
                                    '</tr>');
                            });
                        }
                        
                        if(response.data.notas_credito.length > 0) {
                            hay_datos = true;
                            response.data.notas_credito.forEach(function(nc) {
                                $("#tabla_nc tbody").append('<tr><td>'+nc.id_ncf+'</td><td>'+nc.id_fact+'</td><td>'+nc.created_at+'</td><td>$'+number_format(nc.total_iva, 2)+'</td></tr>');
                            });
                        }
                        
                        // Modificar cómo pintamos actas según el JSON actualizado
                        if(response.data.actas.length > 0) {
                            hay_datos = true;
                            response.data.actas.forEach(function(a) {
                                 var cruces_html = '<table class="table table-condensed table-bordered" style="font-size:10px;">';
                                cruces_html += '<tr class="info"><td>No. Egreso</td><td>Valor</td><td>Saldo</td><td>Fecha</td><td>Observación</td></tr>';
                                if(a.cruces && a.cruces.length > 0) {
                                    a.cruces.forEach(function(cr) {
                                        cruces_html += '<tr><td>'+cr.id_egr+'</td><td>$'+number_format(cr.egreso_egr, 0)+'</td><td>$'+number_format(cr.saldo, 0)+'</td><td>'+(cr.fecha_egreso || '')+'</td><td>'+(cr.observaciones_egr || '')+'</td></tr>';
                                    });
                                } else {
                                    cruces_html += '<tr><td colspan="5" class="center">Sin egresos asociados</td></tr>';
                                }
                                cruces_html += '</table>';
                                 var tipo_acta = a.credito_act ? '<span class="label label-danger">CRÉDITO</span>' : '<span class="label label-success">CONTADO</span>';
                                
                                $("#tabla_actas tbody").append('<tr '+(a.saldo > 1 ? 'class="warning"' : '')+'>' +
                                    '<td>'+(a.num_esc || 'N/A')+' - '+(a.anio_esc || '')+'</td>' +
                                    '<td><b>'+a.id_act+'</b> <br><small class="text-primary">(Rad: '+a.id_radica+'-'+a.anio_radica+')</small><br><small>Fecha: '+(a.fecha || '')+'</small><br>'+tipo_acta+'</td>' +
                                    '<td>$'+number_format(a.deposito_act, 0)+'</td>' +
                                    '<td>'+(a.anulada ? '<span class="label label-danger">ANULADA</span>' : '<span class="label label-success">ACTIVA</span>')+'</td>' +
                                    '<td>$'+number_format(a.saldo, 0)+'</td>' +
                                    '<td>'+cruces_html+'</td>' +
                                    '</tr>');
                            });
                        }
                        
                        if(response.data.bonos.length > 0) {
                            hay_datos = true;
                            response.data.bonos.forEach(function(b) {
                                var num_esc_str = (b.num_esc || 'N/A') + (b.anio_esc ? ' - ' + b.anio_esc : '');
                                var rad_info = '<b>'+b.id_bon+'</b><br><small class="text-primary">(Rad: ' + (b.id_radica || '') + '-' + (b.anio_radicacion || '') + ')</small><br><small>Fecha: ' + (b.fecha_radica || '') + '</small>';
                                
                                $("#tabla_bonos tbody").append('<tr '+(b.saldo_bono < b.valor_bono ? 'class="warning"' : '')+'>' +
                                    '<td>' + num_esc_str + '</td>' +
                                    '<td>' + rad_info + '</td>' +
                                    '<td>' + b.codigo_bono + '</td>' +
                                    '<td>$' + number_format(b.valor_bono, 0) + '</td>' +
                                    '<td>$' + number_format(b.saldo_bono, 0) + '</td>' +
                                    '</tr>');
                            });
                        }
                        
                        if(hay_datos) {
                            $("#contenedor_resultados").fadeIn();
                            $("#sin_resultados").hide();
                            $("#btn_pdf").prop('disabled', false);
                        } else {
                            $("#contenedor_resultados").hide();
                            $("#sin_resultados").fadeIn();
                            $("#btn_pdf").prop('disabled', true);
                        }
                    }
                },
                error: function(xhr, status, error) {
                    if (status !== 'abort') {
                        $("#btn_stop").hide();
                        $("#btn_buscar").show().html('<span class="ace-icon fa fa-search icon-on-right bigger-110"></span> BUSCAR');
                        
                        var msg = 'Error genérico al realizar la búsqueda.';
                        if (status === 'timeout') {
                            msg = 'La búsqueda tardó demasiado. Intente con un valor más específico.';
                        } else if (xhr.responseText) {
                            try {
                                var responseJson = JSON.parse(xhr.responseText);
                                if (responseJson.mensaje) {
                                    msg = responseJson.mensaje;
                                }
                            } catch (e) {
                                console.error('Respuesta cruda del servidor:', xhr.responseText);
                            }
                        }
                        alert(msg);
                    }
                }
            });
        });



        $("#btn_pdf").click(function() {
            var url = '/consulta_especializada/pdf?' + $.param({
                acta: $.trim($("#f_acta").val()),
                radica: $.trim($("#f_radica").val()),
                escritura: $.trim($("#f_escritura").val()),
                anio_escritura: $.trim($("#f_anio_escritura").val()),
                factura: $.trim($("#f_factura").val()),
                identificacion: $.trim($("#f_identificacion").val()),
                fecha1: $("#f_fecha1").val(),
                fecha2: $("#f_fecha2").val()
            });
            window.open(url, '_blank');
        });

        function number_format(amount, decimals) {
            amount += '';
            amount = parseFloat(amount.replace(/[^0-9\.]/g, ''));
            decimals = decimals || 0;
            if (isNaN(amount) || amount === 0) return parseFloat(0).toFixed(decimals);
            amount = '' + amount.toFixed(decimals);
            var amount_parts = amount.split('.'),
                regexp = /(\d+)(\d{3})/;
            while (regexp.test(amount_parts[0]))
                amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');
            return amount_parts.join('.');
        }
    });
</script>
@endsection

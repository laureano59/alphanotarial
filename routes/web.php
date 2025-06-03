<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Ruta de bienvenida
Route::get('/', function () { return view('welcome'); });


// Gestión de Radicación y Liquidación
Route::resource('radicacion', 'RadicacionController');
Route::resource('liquidacion', 'LiqderechoController');
Route::resource('liqderechos', 'LiqderechoController');
Route::resource('liqconceptos', 'LiqconceptosController');
Route::resource('liqrecaudos', 'LiqrecaudosController');

// Gestión de Facturación
Route::resource('facturacion', 'FacturacionController');
Route::resource('factura_acargo_de', 'EditaracargodeController');
Route::resource('facturaelectronica', 'FacturaelectronicaController');
Route::resource('tipofactura', 'OpcionesdefacturaController');
Route::resource('notascreditofact', 'NotascreditofacturaController');
Route::resource('notasdebitofact', 'NotasdebitoController');
Route::resource('detallenotadebito', 'DetallenotadebitoController');
Route::resource('facturacajarapida', 'FacturascajarapidaController');
Route::resource('detallefacturacajarapida', 'DetallefacturascajarapidaController');
Route::resource('registro', 'RegistroController');


// Gestión de Clientes y Otorgantes
Route::resource('clientes', 'ClienteController');
Route::resource('otorgante', 'OtorganteController');
Route::resource('compareciente', 'ComparecienteController');

// Gestión de Actas de Depósito y Egresos
Route::resource('actas_deposito', 'ActasdepositoController');
Route::resource('depositos', 'ActasdepositoController');
Route::resource('egresos', 'EgresoactasdepositoController');
Route::resource('actasdeposito', 'OpcionesdeactasController');
Route::resource('egreso', 'EgresoactasdepositoController');

// Gestión de Reportes y Consultas
Route::resource('reportes', 'ReportesController');
Route::resource('consultas', 'ConsultasController');
Route::resource('cartera', 'CarteraController');
Route::resource('bonos', 'BonosController');
Route::resource('cuentadecobro', 'BonosController'); // Parece ser un recurso de bonos también
Route::resource('seguimientoescrituras', 'SeguimientoController');
Route::resource('consulta_cajarapida', 'ConsultacajarapidaController');

// Gestión de Caja Rápida
Route::resource('cajarapida', 'CajarapidaController');
Route::resource('cpanelcajarapida', 'Panel_cajarapidaController');
Route::resource('notacreditocajarapida', 'NotacreditocajarapidaController');
Route::resource('carteracacajarapida', 'CarteracajarapidaController');
Route::resource('guardarbasecajarapida', 'BasecajarapidaController');

// Gestión de Certificados
Route::resource('cpanelcertificados', 'CertificadosController');
Route::resource('guardarcertificadortf', 'Certificado_rtfController');

// Gestión de Escrituración y Protocolistas
Route::resource('escrituracion', 'EscrituraController');
Route::resource('actosradica', 'ActosclienteradicaController');
Route::resource('panel_protocolistas', 'ProtocolistasController');

// Gestión de Mantenimiento y Configuración
Route::resource('mantenimiento', 'MantenimientoController');
Route::resource('configuracion', 'ConfiguracionController');
Route::resource('configurarfechas', 'ConfigurarfechasController');
Route::resource('notaria', 'NotariaController');
Route::resource('abono_bonos', 'Abono_bonosController');
Route::resource('gastos_notaria', 'Gastos_notariaController');
Route::resource('reportados', 'ReportadosController');
Route::resource('ayuda', 'ayudaController');


// Rutas Get

// Rutas de Búsqueda y Validación
Route::get('buscarencajarapida', 'ConsultacajarapidaController@Consulta_CajaRapida');
Route::get('retefuenteporvendedor', 'validacionesController@Porcentaje_Rtf_Vendedores');
Route::get('liberarradicacion', 'RadicacionController@Liberar_Radicacion');
Route::get('validar_idcce', 'ValidacionesController@Validar_Num_Cuenta_Cobro_pdf');
Route::get('validarradicacion', 'ValidacionesController@ValidarRadicacion');
Route::get('validartotalfactliq', 'ValidacionesController@TotalFact_TotalLiq');
Route::get('validarfacturacion', 'ValidacionesController@ValidarRadicacionFact');
Route::get('validaractadeposito', 'ValidacionesController@Validar_Actas_Factura');
Route::get('validarrtfmaycero', 'ValidacionesController@ValidarRtfMayCero');
Route::get('existefactura', 'ValidacionesController@ExisteFactura');
Route::get('existefacturacajarapida', 'ValidacionesController@ExisteFacturaCajaRapida');
Route::get('validareditarfacturacajarapida', 'ValidacionesController@ValidarparaEditarFacturaCajaRapida');
Route::get('validarexixtefact', 'ValidacionesController@ValidarRadFacturada');
Route::get('validarciudad', 'ValidacionesController@ValidarCiudadCliente');
Route::get('validaractos', 'ValidaractosController@Validar');
Route::get('validartimbrec', 'ValidaractosController@ValidarTimbreC');
Route::get('buscaracta', 'ActasdepositoController@BuscarActa');
Route::get('buscarcartera', 'CarteraController@BuscarCartera');
Route::get('buscarbono', 'BonosController@BuscarBono');
Route::get('buscarcartera_cajarapida', 'CarteracajarapidaController@BuscarCartera');
Route::get('rastrearradicacion', 'ConsultasController@Rastrear_Radicacion');
Route::get('consultar_gasto', 'Gastos_notariaController@validar_existencia');
Route::get('validar_liquidacion_provisional', 'ValidacionesController@Validar_liquidacion_provisional');
Route::get('validar_tarifa', 'ValidacionesController@Validar_Tarifa');
Route::get('validarreportados', 'ValidacionesController@ExisteReportado');


// Rutas de Edición y Actualización
Route::get('editar_acargo_de_factura', 'FacturacionController@A_cargo_De');
Route::get('editar_acargo_de', 'FacturacionController@Update_a_cargo_de_Editar');
Route::get('anularacta', 'ActasdepositoController@Anular');
Route::get('anombrede', 'FacturacionController@AnombreDe');

// Rutas de Carga de Datos
Route::get('factderechos', 'FacturacionController@DerechosLiquidados');
Route::get('almacena', 'ValidacionesController@ValidarCalidadDestino');
Route::get('agregaritemcajarapida', 'AgregaritemcajarapidaController@AgregarItemCajaRapida');
Route::get('mostrarliq', 'LiqderechoController@Cargar_Derechos');
Route::get('mostrarconcep', 'LiqconceptosController@Cargar_Conceptos');
Route::get('mostrarrecaud', 'LiqrecaudosController@Cargar_Recaudos');
Route::get('conceptos', 'ConceptosController@ConceptoActo');
Route::get('traeconceptosporid', 'ConceptosController@TraeConceptoPorId');
Route::get('traeconceptos', 'ConceptosController@Conceptos_All');
Route::get('valorconceptos', 'ConceptosController@ValorConceptos');
Route::get('verprincipales', 'PrincipalesController@listingprincipales');
Route::get('detalleradica', 'ActosclienteradicaController@listing');
Route::get('principales', 'PrincipalesController@existecliente');
Route::get('derechos', 'LiqderechoController@derechos');
Route::get('recaudos', 'RecaudosController@Recaudos');
Route::get('tarifas', 'TarifasController@Tarifas');
Route::get('ciudad', 'CiudadController@ciudad');
Route::get('cargarbonos', 'BonosController@CargarBonos');
Route::get('cargarfacturanotadebito', 'NotasdebitoController@CargarFactura');
Route::get('cargarfacturaelectronica', 'FacturaelectronicaController@CargarFacturas');
Route::get('cargarfacturasnodian', 'FacturaelectronicacajarapidaController@CargarFacturas_cajarapida');
Route::get('cargartiporeporte', 'ReportesController@CargarTipoReporte');
Route::get('cargarfechas', 'ReportesController@FechaReporte');
Route::get('cargaridentificacion', 'SesionesController@Sessiones_Identificacion');

// Rutas de Sesiones
Route::get('sessiones', 'SesionesController@Sessiones');
Route::get('sessiones_protocolista', 'SesionesController@Sessiones_protocolistas');
Route::get('sessiones_certificados', 'SesionesController@Sessiones_certificados');
Route::get('sessionescajarapida', 'SesionesController@Sessiones_cajarapida');
Route::get('sessionabonos', 'CarteraController@SessionFact');
Route::get('sessionabonos_bon', 'BonosController@SessionBon');

// Rutas de Reportes (HTML/Datos)
Route::get('cajadiario', 'ReportesController@Caja_Diario');
Route::get('libroindice', 'ReportesController@Libro_Indice');
Route::get('relacionnotacredito', 'ReportesController@Relacion_Nota_Credito');
Route::get('ingresoporconceptos', 'ReportesController@Ingreso_Conceptos');
Route::get('escripendtfact', 'ReportesController@Escrituras_Sin_Factura');
Route::get('informecartera', 'ReportesController@Informe_Cartera');
Route::get('informerecaudos', 'ReportesController@Informe_Recaudos');
Route::get('generarreportecajadiario', 'ReportesController@Informe_cajadiario_rapida');
Route::get('informecarterabonos', 'ReportesController@Informe_Cartera_Bonos');
Route::get('reporte_depositos', 'ReportesController@Relaciondepositosdiarios');
Route::get('reporte_egresos', 'ReportesController@Relacionegresosdiarios');
Route::get('cuentas_cobro_generadas', 'ReportesController@Cuentas_Cobro_Generadas');
Route::get('generarreportecajadiarioporconceptos', 'ReportesController@Informe_cajadiario_rapida_conceptos');
Route::get('informe_ron', 'ReportesController@Ron');
Route::get('generar_informe_ingresos_dian', 'ReportesController@Reporte_ingresos_Dian');
Route::get('informe_enejenaciones_dian', 'ReportesController@Reporte_enejenaciones_Dian');

// Rutas de Exportación a Excel
Route::get('excelcarteraclientebonos', 'ReportesController@ExcelcarteraClienteBonos');
Route::get('excelcarterafechabonos', 'ReportesController@ExcelCarteraFechaBonos');
Route::get('excelcarteraclientebonosacti', 'ReportesController@ExcelCarteraClienteBonosActi');

// Rutas de Envío de Correos y XML
Route::get('enviarcorreo', 'EnviaremailController@enviarfactura');
Route::get('enviarfactura', 'EinvoiceController@index');
Route::get('enviarfacturacajarapida', 'EnvoicecajarapidaController@index');
Route::get('enviarnotadebito', 'EinvoicenotadebitoController@index');
Route::get('enviarfacturas','JobenviaremailController@Enviarfactura');
Route::get('generarxml', 'GenerarxmlController@GenerarXml');

// Rutas de Generación de PDF
Route::get('certificado_impuesto_timbre', 'PdfController@Certificado_impuesto_timbre');
Route::get('recibogastospdf', 'PdfController@ReciboGastosNotaria');
Route::get('informedegastos', 'PdfController@Informedegastos');
Route::get('escripendtfactpdf', 'PdfController@Escrituras_Sin_Factura');
Route::get('relacionnotacreditocajarapida', 'PdfController@RelacionNotaCreditoCajaRapidaPdf');
Route::get('relaciondepositosdiariospdf','PdfController@DepositosDiarios');
Route::get('relaciondeegresosdiariospdf','PdfController@EgresosDiarios');
Route::get('imprimirconsolidadocajapdf','PdfController@ConsolidadoCaja');
Route::get('certificadortf','PdfController@PdfCertificadoRetecncionenlaFuente');
Route::get('copiacertificadortf','PdfController@PdfCopiaCertificadoRetecncionenlaFuente');
Route::get('reporteradicacion', 'PdfController@PdfRadicacion');
Route::get('notacreditopdf', 'PdfController@PdfNotaCreditoFact');
Route::get('imprimirabonos', 'PdfController@PdfAbonosCartera');
Route::get('imprimirabonoscajarapida', 'PdfController@PdfAbonosCarteraCajaRapida');
Route::get('copianotacreditopdf', 'PdfController@PdfNotaCreditoFactCopia');
Route::get('copianotacreditocajarapidapdf', 'PdfController@PdfNotaCreditoFacturaCajaRapida');
Route::get('copiafactura', 'PdfController@PdfCopiaFactura');
Route::get('copiafacturacajarapida', 'PdfController@PdfCopiaFacturaCajaRapida');
Route::get('copiafacturacajarapidapos', 'PdfController@PdfCopiaFacturaCajaRapidaPOS');
Route::get('factunicapdf', 'PdfController@pdf');
Route::get('facturacajarapidapdf', 'PdfController@FacturaCajaRapida');
Route::get('actasdepositopdf', 'PdfController@PdfActaDeposito');
Route::get('cajadiariopdf', 'PdfController@PdfCajaDiarioGeneral');
Route::get('facturacajarapidaPost', 'PdfController@FacturaCajaRapidaPost');
Route::get('cajadiariocajarapidapdf', 'PdfController@CajaDiarioCajaRapidaPdf');
Route::get('cajadiariocajarapidaconceptos', 'PdfController@Cajadiariocajarapidaconceptospdf');
Route::get('cuentadecobropdf', 'PdfController@Cuenta_de_Cobro');
Route::get('liquidacionpdf', 'PdfController@PdfLiquidacion');
Route::get('estadisticonotarialpdf', 'PdfController@PdfEstadisticoNotarial');
Route::get('ingresosporescrituradorpdf', 'PdfController@IngresosporEscriturador');
Route::get('retefuentesaplicadaspdf', 'PdfController@Retefuentesaplicadaspdf');
Route::get('informeretefuentespdf', 'PdfController@Retencionenlafuente_pdf');
Route::get('informetimbre', 'PdfController@InformeTimbre');
Route::get('enlacespdf', 'PdfController@PdfEnlaces');
Route::get('libroindicepdf', 'PdfController@PdfLibroIndiceNotarial');
Route::get('relnotacreditopdf', 'PdfController@PdfRelacionNotaCredito');
Route::get('printinformecartera', 'PdfController@PdfInformeCartera');
Route::get('relacionporconceptospdf', 'PdfController@PdfRelaciondeFacturasPorConceptos');
Route::get('printinformecarterabonos', 'PdfController@PdfInformeCartera_Bonos');
Route::get('informederecaudospdf', 'PdfController@PdfInformeRecaudos');
Route::get('Imprimircomprobante_Egreso', 'PdfController@PdfComprobante_Egreso');

// Rutas de Seguimiento
Route::get('seguimiento', 'ConsultasController@Consultar');
Route::get('seguimiento_secun', 'ConsultasController@Consultar_secun');
Route::get('seguimiento_escr', 'SeguimientoController@Seguimiento_escrituras');

// Rutas de Autenticación (mantener al final como en el original)
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
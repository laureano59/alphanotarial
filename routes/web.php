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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('radicacion', 'RadicacionController');
Route::resource('liquidacion', 'LiqderechoController');
Route::resource('facturacion', 'FacturacionController');
Route::resource('factura_acargo_de', 'EditaracargodeController');
Route::resource('ayuda', 'ayudaController');


Route::resource('facturaelectronica', 'FacturaelectronicaController');
Route::resource('panel_protocolistas', 'ProtocolistasController');
Route::resource('cpanelcertificados', 'CertificadosController');

Route::resource('reportados', 'ReportadosController');


Route::resource('actas_deposito', 'ActasdepositoController');
Route::resource('guardarcertificadortf', 'Certificado_rtfController');
Route::resource('escrituracion', 'EscrituraController');
Route::resource('actosradica', 'ActosclienteradicaController');
Route::resource('clientes', 'ClienteController');
Route::resource('otorgante', 'OtorganteController');
Route::resource('notaria', 'NotariaController');
Route::resource('compareciente', 'ComparecienteController');
Route::resource('liqderechos', 'LiqderechoController');
Route::resource('liqconceptos', 'LiqconceptosController');
Route::resource('liqrecaudos', 'LiqrecaudosController');
Route::resource('tipofactura', 'OpcionesdefacturaController');
Route::resource('mantenimiento', 'MantenimientoController');
Route::resource('depositos', 'ActasdepositoController');
Route::resource('egresos', 'EgresoactasdepositoController');
Route::resource('actasdeposito', 'OpcionesdeactasController');
Route::resource('egreso', 'EgresoactasdepositoController');

Route::resource('abono_bonos', 'Abono_bonosController');

Route::resource('gastos_notaria', 'Gastos_notariaController');

Route::resource('notascreditofact', 'NotascreditofacturaController');
Route::resource('notacreditocajarapida', 'NotacreditocajarapidaController');
Route::resource('carteracacajarapida', 'CarteracajarapidaController');
Route::resource('notasdebitofact', 'NotasdebitoController');
Route::resource('detallenotadebito', 'DetallenotadebitoController');
//Route::resource('cpanelreportes', 'PanelreporteController');
Route::resource('configuracion', 'ConfiguracionController');
Route::resource('configurarfechas', 'ConfigurarfechasController');
Route::resource('consultas', 'ConsultasController');
//Route::resource('Einvoice', 'EinvoiceController');
Route::resource('reportes', 'ReportesController');
Route::resource('cartera', 'CarteraController');
Route::resource('bonos', 'BonosController');
Route::resource('cajarapida', 'CajarapidaController');
Route::resource('cpanelcajarapida', 'Panel_cajarapidaController');
Route::resource('facturacajarapida', 'FacturascajarapidaController');
Route::resource('detallefacturacajarapida', 'DetallefacturascajarapidaController');

Route::resource('seguimientoescrituras', 'SeguimientoController');
Route::resource('consulta_cajarapida', 'ConsultacajarapidaController');

Route::resource('guardarbasecajarapida', 'BasecajarapidaController');

Route::get('buscarencajarapida', 'ConsultacajarapidaController@Consulta_CajaRapida');


Route::get('retefuenteporvendedor', 'validacionesController@Porcentaje_Rtf_Vendedores');

Route::get('liberarradicacion', 'RadicacionController@Liberar_Radicacion');

Route::get('editar_acargo_de_factura', 'FacturacionController@A_cargo_De');

Route::get('editar_acargo_de', 'FacturacionController@Update_a_cargo_de_Editar');

Route::get('factderechos', 'FacturacionController@DerechosLiquidados');
Route::get('almacena', 'ValidacionesController@ValidarCalidadDestino');

Route::get('validar_idcce', 'ValidacionesController@Validar_Num_Cuenta_Cobro_pdf');

Route::get('agregaritemcajarapida', 'AgregaritemcajarapidaController@AgregarItemCajaRapida');


Route::get('anularacta', 'ActasdepositoController@Anular');



Route::get('anombrede', 'FacturacionController@AnombreDe');
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
Route::get('mostrarliq', 'LiqderechoController@Cargar_Derechos');
Route::get('mostrarconcep', 'LiqconceptosController@Cargar_Conceptos');
Route::get('mostrarrecaud', 'LiqrecaudosController@Cargar_Recaudos');
Route::get('sessiones', 'SesionesController@Sessiones');
Route::get('sessiones_protocolista', 'SesionesController@Sessiones_protocolistas');
Route::get('certificado_impuesto_timbre', 'PdfController@Certificado_impuesto_timbre');
Route::get('sessiones_certificados', 'SesionesController@Sessiones_certificados');
Route::get('sessionescajarapida', 'SesionesController@Sessiones_cajarapida');
Route::get('conceptos', 'ConceptosController@ConceptoActo');
Route::get('traeconceptosporid', 'ConceptosController@TraeConceptoPorId');
Route::get('traeconceptos', 'ConceptosController@Conceptos_All');
Route::get('valorconceptos', 'ConceptosController@ValorConceptos');
Route::get('verprincipales', 'PrincipalesController@listingprincipales');
Route::get('detalleradica', 'ActosclienteradicaController@listing');
Route::get('principales', 'PrincipalesController@existecliente');
Route::get('derechos', 'LiqderechoController@derechos');
Route::get('validaractos', 'ValidaractosController@Validar');
Route::get('recaudos', 'RecaudosController@Recaudos');
Route::get('tarifas', 'TarifasController@Tarifas');
Route::get('ciudad', 'CiudadController@ciudad');
Route::get('buscaracta', 'ActasdepositoController@BuscarActa');
Route::get('buscarcartera', 'CarteraController@BuscarCartera');
Route::get('buscarbono', 'BonosController@BuscarBono');
Route::get('cargarbonos', 'BonosController@CargarBonos');
Route::get('cuentadecobro', 'BonosController@GuardarCuentaCobro');
Route::get('buscarcartera_cajarapida', 'CarteracajarapidaController@BuscarCartera');
Route::get('rastrearradicacion', 'ConsultasController@Rastrear_Radicacion');
Route::get('enviarcorreo', 'EnviaremailController@enviarfactura');
Route::get('cargarfacturanotadebito', 'NotasdebitoController@CargarFactura');
Route::get('cargarfacturaelectronica', 'FacturaelectronicaController@CargarFacturas');
Route::get('cargarfacturasnodian', 'FacturaelectronicacajarapidaController@CargarFacturas_cajarapida');
Route::get('enviarfactura', 'EinvoiceController@index');
Route::get('enviarfacturacajarapida', 'EnvoicecajarapidaController@index');
Route::get('enviarnotadebito', 'EinvoicenotadebitoController@index');


Route::get('cargartiporeporte', 'ReportesController@CargarTipoReporte');
Route::get('cargarfechas', 'ReportesController@FechaReporte');
Route::get('cargaridentificacion', 'SesionesController@Sessiones_Identificacion');
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

Route::get('consultar_gasto', 'Gastos_notariaController@validar_existencia');


Route::get('recibogastospdf', 'PdfController@ReciboGastosNotaria');
Route::get('informedegastos', 'PdfController@Informedegastos');
Route::get('escripendtfactpdf', 'PdfController@Escrituras_Sin_Factura');

Route::get('relacionnotacreditocajarapida', 'PdfController@RelacionNotaCreditoCajaRapidaPdf');




Route::get('relaciondepositosdiariospdf','PdfController@DepositosDiarios');
Route::get('relaciondeegresosdiariospdf','PdfController@EgresosDiarios');

Route::get('generarreportecajadiarioporconceptos', 'ReportesController@Informe_cajadiario_rapida_conceptos');



Route::get('imprimirconsolidadocajapdf','PdfController@ConsolidadoCaja');



Route::get('sessionabonos', 'CarteraController@SessionFact');
Route::get('sessionabonos_bon', 'BonosController@SessionBon');


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


Route::get('validar_liquidacion_provisional', 'ValidacionesController@Validar_liquidacion_provisional');

Route::get('validarreportados', 'ValidacionesController@ExisteReportado');


Route::get('liquidacionpdf', 'PdfController@PdfLiquidacion');
Route::get('estadisticonotarialpdf', 'PdfController@PdfEstadisticoNotarial');
Route::get('informe_ron', 'ReportesController@Ron');
Route::get('generar_informe_ingresos_dian', 'ReportesController@Reporte_ingresos_Dian');
Route::get('informe_enejenaciones_dian', 'ReportesController@Reporte_enejenaciones_Dian');

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

Route::get('seguimiento', 'ConsultasController@Consultar');
Route::get('seguimiento_secun', 'ConsultasController@Consultar_secun');

Route::get('seguimiento_escr', 'SeguimientoController@Seguimiento_escrituras');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

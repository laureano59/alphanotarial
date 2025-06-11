<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Notaria;
use App\Actosclienteradica;
use App\Otorgante;
use App\Actoscuantia;
use App\derechos_view;
use App\Cliente;
use App\Radicacion;
use App\Protocolista;
use App\Principales_radica;
use App\Notario;
use App\Principalesfact_view;
use App\Factura;
use App\Escritura;
use App\Detalle_factura;
use App\Liq_derecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Detalle_liqderecho;
use App\Certificado_rtf;
use App\Actas_deposito_view;
use App\Concepto;
use App\Notas_credito_factura;
use App\Detalle_notas_debito;
use App\Notas_debito_factura;
use App\Cajadiariogeneral_view;
use App\Cruces_actas_deposito_view;
use App\Estadisticonotarial_view;
use App\Estadisticonotarial_unicas_view;
use App\Estadisticonotarial_repetidas_view;
use App\Estadisticonotarial_repetidas_solo_radi_view;
use App\Info_cliente_factura_electronica_view;
use App\Pago;
use App\Medios_pago;
use App\Tarifa;
use App\Credenciales_api;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\mail\FacturaElectronica;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Mail;
use App\Services\PdfService;
//use DOMDocument;

class EinvoiceController extends Controller
{
  public function index(Request $request){

    $notaria = Notaria::find(1);
    $IdSoftware = $notaria->SoftwareId;
    $pinfactDian = $notaria->pin;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $IndustryClasificationCode = $notaria->codigo_actividad;
    $nombre_comercial = $notaria->nombre_comercial;
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $NumAutorizacionDian = $notaria->InvoiceAuthorization;
    $prefijo_fact = trim($notaria->prefijo_fact);
    $resolucion = $notaria->resolucion;
    $StarFecha = $notaria->fecha_iniciofact;
    $EndFecha = $notaria->fecha_finfact;
    $NumDesde = trim($notaria->numiniciofact);
    $NumHasta = trim($notaria->numfinfact);
    $piepagina_fact = $notaria->piepagina_fact;
    $iva = "Somos Responsables de IVA";
    $NitDian = $notaria->nitdian;
    $ciudad = $notaria->ciudad;
    $codigo_ciudad = $notaria->codigo_ciudad;
    $departamento = $notaria->departamento;
    $codigo_departamento = $notaria->codigo_departamento;
    $codigo_actividad = $notaria->codigo_actividad;
    $responsabilidad_fiscal = $notaria->responsabilidad_fiscal;
    //$anio_trabajo = Notaria::find(1)->anio_trabajo;

    # -----------  Numero de factura obtenida en una session  -----------

    
    $numfact = $request->num_fact;


    $opcion1 = $request->opcion;
    $retransmitir = $request->retransmitir;

    if (is_null($retransmitir) || $retransmitir === '') {
      $retransmitir = '0';    
    }elseif($retransmitir == '1'){
      $retransmitir = '1';
    }

    if($opcion1 == 'F1'){

     $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$numfact)->get();


     foreach ($facturas as $factura) {
      $fecha_fact           = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
      $fecha_fact_completa  = $factura->fecha_fact;
      $hora_fact          = Carbon::parse($factura->fecha_fact)->format('h-i-s');
      $StarPeriodo        =  Carbon::parse($fecha_fact)->firstOfMonth();
      $StarPeriodo        = Carbon::parse($StarPeriodo)->format('Y-m-d');
      $EndPeriodo         =  Carbon::parse($fecha_fact)->endOfMonth();
      $EndPeriodo         = Carbon::parse($EndPeriodo)->format('Y-m-d');
      $identificacioncli  = $factura->a_nombre_de;
      $TipodePago         = $factura->credito_fact;
      $TotalFactura       = $factura->total_fact;
      $TotalDerechos      = $factura->total_derechos;
      $TotalConceptos     = $factura->total_conceptos;
      $TotalIva           = $factura->total_iva;
      $TotalRtf           = $factura->total_rtf;
      $TotalReteIva       = $factura->deduccion_reteiva;
      $TotalReteIca       = $factura->deduccion_reteica;
      $TotalReteRtf       = $factura->deduccion_retertf;
      $TotalFondo         = $factura->total_fondo;
      $TotalSuper         = $factura->total_super;
      $AporteEspecial     = $factura->total_aporteespecial;
      $ImpuestoTimbre     = $factura->total_impuesto_timbre;
      $total_timbrec      = $factura->total_timbrec;
      $id_radica          = $factura->id_radica;
      $comentarios_fact   = $factura->comentarios_fact;
      $diascredito_fact   = $factura->dias_credito;
      $nota_credito       = $factura->nota_credito;
      $anio_trabajo       = $factura->anio_radica;
    }


    $TotalAntesdeIva = $TotalDerechos + $TotalConceptos;
   

  }else if($opcion1 == 'NC'){
    
    $Notas_credito_factura_anulada =  Notas_credito_factura::where("prefijo_ncf","=",$prefijo_fact)->where("id_ncf","=",$numfact)->get();

     if ($Notas_credito_factura_anulada->isEmpty()) {
          $num_fact_anulada = $numfact;
          $Notas_credito_factura_anulada =  Notas_credito_factura::where("prefijo_ncf","=",$prefijo_fact)->where("id_fact","=",$numfact)->get();
      } else {
            foreach ($Notas_credito_factura_anulada as $ncf) {
              $num_fact_anulada = $ncf['id_fact'];
            }
        }

    $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact_anulada)->get();

   
    foreach ($facturas as $factura) {
      $fecha_fact           = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
      $fecha_fact_completa  = $factura->fecha_fact;
      $hora_fact            = Carbon::parse($factura->fecha_fact)->format('h-i-s');
      $StarPeriodo          =  Carbon::parse($fecha_fact)->firstOfMonth();
      $StarPeriodo          = Carbon::parse($StarPeriodo)->format('Y-m-d');
      $EndPeriodo           =  Carbon::parse($fecha_fact)->endOfMonth();
      $EndPeriodo           = Carbon::parse($EndPeriodo)->format('Y-m-d');
      $identificacioncli    = $factura->a_nombre_de;
      $TipodePago           = $factura->credito_fact;
      $TotalFactura         = $factura->total_fact;
      $TotalDerechos        = $factura->total_derechos;
      $TotalConceptos       = $factura->total_conceptos;
      $TotalIva             = $factura->total_iva;
      $TotalRtf             = $factura->total_rtf;
      $TotalReteIva         = $factura->deduccion_reteiva;
      $TotalReteIca         = $factura->deduccion_reteica;
      $TotalReteRtf         = $factura->deduccion_retertf;
      $TotalFondo           = $factura->total_fondo;
      $TotalSuper           = $factura->total_super;
      $AporteEspecial       = $factura->total_aporteespecial;
      $ImpuestoTimbre       = $factura->total_impuesto_timbre;
      $total_timbrec        = $factura->total_timbrec;
      $id_radica            = $factura->id_radica;
      $comentarios_fact     = $factura->comentarios_fact;
      $diascredito_fact     = $factura->dias_credito;
      $nota_credito         = $factura->nota_credito;
      $anio_trabajo         = $factura->anio_radica;
    }

    $TotalAntesdeIva = $TotalDerechos + $TotalConceptos;

  }


    # ============================================
    # =      Item Conceptos de Factura           =
    # ============================================

  if($opcion1 == 'F1'){

    $SoloConceptos = array();
    /********Valida Si la factura es doble o unica*********/
    if (Detalle_factura::where('id_fact', $numfact)->where('prefijo', $prefijo_fact)->exists()){

      $conceptos_mul = Detalle_factura::where('id_fact', $numfact)->get()->toArray();
      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;
      $dataconcept_mul = array();
      foreach ($conceptos_mul as $key => $conc1) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc1[$totalatributo] > 0){
            $dataconcept_mul[$i]['concepto'] = $atributo;
            $dataconcept_mul[$i]['total'] = $conc1[$totalatributo];
            $i = $i + 1;
          }
        }
      }

      $contdataconcept = count($dataconcept_mul, 0);
      $SoloConceptos = $dataconcept_mul;

    }else{
      $conceptos_unica = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;
      $dataconcept_unica = array();
      foreach ($conceptos_unica as $key => $conc) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $dataconcept_unica[$i]['concepto'] = $atributo;
            $dataconcept_unica[$i]['total'] = $conc[$totalatributo];
            $i = $i + 1;
          }
        }
      }

      $contdataconcept = count ($dataconcept_unica, 0);
      $SoloConceptos = $dataconcept_unica;
    }


  }else if($opcion1 == 'NC'){

    $SoloConceptos = array();
    /********Valida Si la factura es doble o unica*********/
    if (Detalle_factura::where('id_fact', $num_fact_anulada)->where('prefijo', $prefijo_fact)->exists()){

      $conceptos_mul = Detalle_factura::where('id_fact', $num_fact_anulada)->get()->toArray();
      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;
      $dataconcept_mul = array();
      foreach ($conceptos_mul as $key => $conc1) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc1[$totalatributo] > 0){
            $dataconcept_mul[$i]['concepto'] = $atributo;
            $dataconcept_mul[$i]['total'] = $conc1[$totalatributo];
            $i = $i + 1;
          }
        }
      }

      $contdataconcept = count($dataconcept_mul, 0);
      $SoloConceptos = $dataconcept_mul;

    }else{
      $conceptos_unica = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;
      $dataconcept_unica = array();
      foreach ($conceptos_unica as $key => $conc) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $dataconcept_unica[$i]['concepto'] = $atributo;
            $dataconcept_unica[$i]['total'] = $conc[$totalatributo];
            $i = $i + 1;
          }
        }
      }

      $contdataconcept = count ($dataconcept_unica, 0);
      $SoloConceptos = $dataconcept_unica;
    }


  }



  if($TotalDerechos > 0){
    $SoloConceptos[0]['concepto']= 'Derechos';
    $SoloConceptos[0]['total']= $TotalDerechos;
  }

  ksort($SoloConceptos);
  $contSoloConceptos = count ($SoloConceptos, 0);
  $contSoloConceptos = $contSoloConceptos - 1;


    # =============================================
    # =           % Tarifas: Iva, Ica, Rtf        =
    # =============================================

  $IVA = Tarifa::find(9);
  $PorcentajeIva = round($IVA->valor1, 2);

  $ReteIca = Tarifa::find(27);
  $PorcentajeReteIca = round($ReteIca->valor1, 2);

  $ReteIva = Tarifa::find(26);
  $PorcentajeReteIva = $ReteIva->valor1 * 100;

  $ReteRtf = Tarifa::find(28);
  $PorcentajeReteRtf = $ReteRtf->valor1 * 100;

    #===============================================
    #            Información del Cliente           =
    #===============================================

  $Info_cliente = Info_cliente_factura_electronica_view::where("identificacion_cli","=",$identificacioncli)->get();

   
  foreach ($Info_cliente as $infocliente) {
    $nombre_cliente = $infocliente->nombre_cli;
    $pmer_nombre = $infocliente->pmer_nombrecli;
    $sgdo_nombre = $infocliente->sgndo_nombrecli;
    $pmer_apellido = $infocliente->pmer_apellidocli;
    $sgdo_apellido = $infocliente->sgndo_apellidocli;
    $telefono_cliente = $infocliente->telefono_cli;
    $direccion_cliente = $infocliente->direccion_cli;
    $email_cliente = $infocliente->email_cli;
    $CodPostalCiud_cliente = $infocliente->id_ciud;
    $CodPostalDepartamento_cliente = $infocliente->id_depa;
    $CodPostalPais_cliente = $infocliente->id_pais;
    $NombreCiud_cliente = $infocliente->nombre_ciud;
    $NombreDepartamento_cliente = $infocliente->nombre_depa;
    $NombrePais_cliente = $infocliente->nombre_pais;
    $Tipo_identificacion = $infocliente->id_tipoident;
    $digito_verif = $infocliente->digito_verif;
  }

  
    #=============================================
    #               Medio de Pago                =
    #=============================================

  //$Medios_de_pago = Pago::where("id_fact","=",$numfact)->get();
  //foreach ($Medios_de_pago as $med) {
    //$MediodePago = $med->codigo_med;
  //}

  $Medio_pago = //Medios_pago::find($MediodePago);
  $paymentmethod = 10; //$Medio_pago->codigo_med;

  $InvoiceAuthorization = $NumAutorizacionDian;
  $StartDate = $StarPeriodo;
  $EndDate = $EndPeriodo;
  $From = $NumDesde;
  $To = $NumHasta;
  $Prefix = $prefijo_fact;
  $Nitempresa = $nit;
  $SoftwareID = $IdSoftware;
  $pin = $pinfactDian;
  $SoftwareSecurityCode = hash('sha384', $IdSoftware, $pin);
    $AuthorizationProviderID = $NitDian; //Que es?

    $CustomizationID = '10';
		$ProfileExecutionID = '2'; //Pruebas, cambia a 1 si es producción
		$ID = $prefijo_fact.$numfact; //Numero de la factura
    $IssueDate = $fecha_fact;

    /*----------  Formato de hora y zona horaria Colombia ----------*/

    $ZonaHoraria_Colombia = '-05:00';
    $HoraMasZonaHoraria = $hora_fact.$ZonaHoraria_Colombia;
		$HoraMasZonaHoraria = str_replace(" ", "", $HoraMasZonaHoraria);//Elimina espacios si los hay
		$IssueTime =   $HoraMasZonaHoraria;//Formato: 09:15:23-05:00
		$InvoiceTypeCode = '01';//Significa Factura Venta
		$Note = ''; //Opcional

		if($TotalDerechos > 0){
			$LineCountNumeric = $contdataconcept + 1; //Número de productos de la factura: Conceptos y derechos
		}else{
			$LineCountNumeric = $contdataconcept; //Número de productos de la factura: Conceptos y derechos
		}
		

		/*--Periodo en el que se está facturando Fecha de inicio y Fecha Final--*/

    $InvoiceStartDate = $StartDate;
    $InvoiceEndDate = $EndDate;


	  #===============================================
    #            Información de la Notaria         =
    #===============================================

		$AdditionalAccountID = '2'; // 1. Persona Juridica 2. Persona Natural
		$Name = $nombre_nota;
		$IndustryClasificatioxnCode = $codigo_actividad;
		$CodigoPostalCity = $codigo_ciudad;
		$CityName = $ciudad;
		$DeptoName = $departamento;
		$CodigoPostalDpto = $codigo_departamento;
		$Direccion_empresa = $direccion_nota;
		$RegistrationName = $nombre_comercial;
		$TaxLevelCode = $responsabilidad_fiscal;
		$TaxSchemeId = '01';
		$TaxSchemeName = 'IVA';


		#===============================================
    #=            Información del Cliente          =
    #===============================================

    $ClienteName = $nombre_cliente;
    $CodigoPostalCiud_cliente = $CodPostalCiud_cliente;
    $CiudadNameCliente = $NombreCiud_cliente;
    $DeptoNameCliente = $NombreDepartamento_cliente;
    $CodigoPostalDptoCliente = $CodPostalDepartamento_cliente;
    $DireccionCliente = $direccion_cliente;
		$IdentificacionCliente = $identificacioncli; //Línea 75

		# -----------  Persona natural o juridica  -----------
		
    if($Tipo_identificacion != 31){//Si es Diferente a Nit
			$AdditionalAccountID = '2';//Persona natural
      $Name_empresa = '';
    }else{
			$AdditionalAccountID = '1';//Persona Juridica
      $Name_empresa = $ClienteName;
    }

		$CodIdentificacionFiscal = $Tipo_identificacion; //Tipo de Identificación

		/*---------- Tipo de de Pago Contado Credito ----------*/

		if($TipodePago == true){
			$TipoPago = '2';
		}else if($TipodePago == false){
			$TipoPago = '1';
		}

		/*----------  Medios de Pago  ----------*/
		
		$PaymentMeansCode = 10;//$MediodePago;


		# =============================================
		# =           Totales de la factura           =
		# =============================================


		$TaxableAmount = $TotalAntesdeIva; //Derechos + Conceptos

		# =======================================
		# =           Pago a Terceros           =
		# =======================================

		$TaxAmountIva = $TotalIva;

    # =============================================
    # =           Deducciones           =
    # =============================================

    $TaxAmountReteIva = $TotalReteIva; // Sobre ingresos
    $TaxAmountReteIca = $TotalReteIca; // Sobre ingresos
    $TaxAmountReteRtf = $TotalReteRtf; // 

    # =================================
    # =           % Tarifas           =
    # =================================

    $PorcentIva = $PorcentajeIva;
    $PorcentReteIca = floatval($PorcentajeReteIca / 1000) * 100;
    $PorcentReteIva = $PorcentajeReteIva;
    $PorcentReteRtf = $PorcentajeReteRtf;

    $iva = floatval($PorcentIva / 100);

   	# ======================================
   	# =           Total Ingresos           =
   	# ======================================

   	$LineExtensionAmount = $TotalAntesdeIva; //Total antes de tributos
   	$AllowanceTotalAmount = 0;
    $TaxExclusiveAmount = $TaxableAmount;// Duda con esta variable
    $TaxInclusiveAmount = $TotalFactura;
    $PayableAmount = $TotalFactura; //El Valor a Pagar de Factura es igual a la Suma de Valor Bruto más tributos - Valor del Descuento Total + Valor del Cargo Total - Valor del Anticipo Total

		$codImp1 = '01'; //IVA
		$valImp1 = $TaxAmountIva;
		$codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
		$valImp2 = 0.00;
		$codImp3 = '03'; //ICA
		$valImp3 = $TaxAmountReteIca;
		$valTot  = $TotalFactura;
		$NitOfe  = $nit;//Nit Notaría
		$NumAdq  = $IdentificacionCliente;
		$TipoAmbiente = $ProfileExecutionID; //1=AmbienteProduccion , 2: AmbientePruebas

		

    # ================================================
    # =           NOTA CREDITO, NOTA DEBITO          =
    # ================================================

    $opcion = $request->opcion;
    $tipo_operacion = $opcion;


    if($opcion == 'F1'){
      $typenote = '';
      $num_fact_aplica = '';
      $fecha_fact_aplica = '';
      $prefijo_fact_aplica = '';
    }else if($opcion == 'NC'){


      if($nota_credito == true){


        foreach ($Notas_credito_factura_anulada as $nc) {
          $num_fact_aplica = $num_fact_anulada;
          $fecha_fact_aplica = $fecha_fact_completa;
          $prefijo_fact_aplica = $Prefix;
          $numfact = $nc->id_ncf;
          $fecha_fact = Carbon::parse($nc->created_at)->format('Y-m-d');
          $fecha_fact_completa = $nc->created_at;
          $hora_fact = Carbon::parse($nc->created_at)->format('h-i-s');
          $typenote = '20';
        }
      }
    }



    # =============================================
    # =           JSON PARA ENVIAR API            =
    # =============================================

    $encabezado = array(
      'number'              =>  $numfact,
      'id_n'                =>  $IdentificacionCliente, 
      'tipoadq'             =>  $Tipo_identificacion,
      'tipocontr'           =>  $AdditionalAccountID, 
      'company'             =>  $Name_empresa,
      'name'                =>  $pmer_nombre,
      'second_name'         =>  $sgdo_nombre,
      'surname'             =>  $pmer_apellido,
      'second_surname'      =>  $sgdo_apellido,
      'cv'                  =>  $digito_verif,
      'subtotal'            =>  $TaxableAmount,
      'total'               =>  $TaxInclusiveAmount,
      'tipo'                =>  $tipo_operacion,
      'ponumber'            =>  $telefono_cliente,
      'fecha_fac'           =>  $fecha_fact_completa,
      'comments'            =>  $comentarios_fact,
      'typenote'            =>  $typenote,//20 si es NC 30 si es ND y vacio si es factura
      'prefix'              =>  $Prefix,
      'currency'            =>  'COP',
      'linescount'          =>  $LineCountNumeric,
      'emailfe'             =>  $email_cliente,
      'cod_municipio'       =>  $CodigoPostalCiud_cliente,
      'city'                =>  $CiudadNameCliente,
      'departamento'        =>  $DeptoNameCliente,
      'cod_dpto'            =>  $CodigoPostalDptoCliente,
      'addr1'               =>  $DireccionCliente,
      'typepurchase'        =>  $TipoPago,
      'paymentmethod'       =>  $paymentmethod,
      'paymentperiod'       =>  $diascredito_fact,
      'resolution'          =>  $resolucion,
      'text1'               =>  '',
      'text2'               =>  '',
      'text3'               =>  '',
      'text4'               =>  '',
      'text5'               =>  '',
      'text6'               =>  '',
      'text7'               =>  '',
      'text8'               =>  '',
      'text9'               =>  '',
      'text10'              =>  '',
      'text11'              =>  '',
      'text12'              =>  '',
      'number_dian'         =>  $num_fact_aplica,//número de factura a la que aplica la NC
      'dev_number_date'     =>  $fecha_fact_aplica,//'fecha de la factura
      'prefix_application'  =>  $prefijo_fact_aplica,//'prefijo de la fatura a la que aplica la nota ( en caso de notas)',
    );


    $ingresos = $SoloConceptos;
    $item = 1;
    $i=1;
    foreach ($ingresos as $key => $value) {
      if (!isset($detalle)) {
        $detalle = [];
      }
      $detalle[$i]['conteo'] = $item;
      $detalle[$i]['item_id'] = $item;
      $detalle[$i]['descripcion'] = $value['concepto'];
      $detalle[$i]["qtyship"] = 1;
      $detalle[$i]['price'] = $value['total'];
      $item += 1;
      $i += 1;
    }

    $det = [];

    if (!empty($detalle)) {
      foreach ($detalle as $key => $value) {
        $det[] = $value;
      }
    }    
   

   $det = array(
    "detalle_factura_set"=>$det,
  );

   
   $impuestos = array();
   $item = 1;
   $i=1;
  
   foreach ($ingresos as $key => $value) {
    $impuestos[$i]['id'] = $item;
    $impuestos[$i]['item'] = $item;
    $impuestos[$i]['codigo'] = "01";
    if ($value['concepto'] != 'Registro_Civil'){
      $impuestos[$i]['rate'] = $PorcentIva;
      $impuestos[$i]['name'] = "IVA";
      $impuestos[$i]['amount'] = $value['total'];
      $impuestos[$i]['base'] = $value['total'] * $iva;

    }else{
      $impuestos[$i]['rate'] = 0.00;
      $impuestos[$i]['name'] = "IVA";
      $impuestos[$i]['amount'] = $value['total'];
      $impuestos[$i]['base'] = 0.00;

    }
    
    $item += 1;
    $i += 1;
  } 

  $imp = [];
  foreach ($impuestos as $key => $value) {
   $imp[] = $value;
 }

 $imp = array(
  "salestax"=>$imp,
);


 $otroscargos = array();

 $otroscargos[1]["name"] = "Retencion en la Fuente";
 $otroscargos[1]["base"] = $TotalRtf;
 $otroscargos[1]["amount"] = $TotalRtf;
 $otroscargos[1]["factor"] = "99.99";
 $otroscargos[1]["indicator"] = "true";

 $otroscargos[2]["name"] = "Super";
 $otroscargos[2]["base"] = $TotalSuper;
 $otroscargos[2]["amount"] = $TotalSuper;
 $otroscargos[2]["factor"] = "99.99";
 $otroscargos[2]["indicator"] = "true";

 $otroscargos[3]["name"] = "Fondo";
 $otroscargos[3]["base"] = $TotalFondo;
 $otroscargos[3]["amount"] = $TotalFondo;
 $otroscargos[3]["factor"] = "99.99";
 $otroscargos[3]["indicator"] = "true";

 $otroscargos[4]["name"] = "Aporte especial";
 $otroscargos[4]["base"] = $AporteEspecial;
 $otroscargos[4]["amount"] = $AporteEspecial;
 $otroscargos[4]["factor"] = "99.99";
 $otroscargos[4]["indicator"] = "true";

 $otroscargos[5]["name"] = "Impuesto timbre";
 $otroscargos[5]["base"] = $ImpuestoTimbre;
 $otroscargos[5]["amount"] = $ImpuestoTimbre;
 $otroscargos[5]["factor"] = "99.99";
 $otroscargos[5]["indicator"] = "true";

 $otroscargos[6]["name"] = "Timbre Decreto 175";
 $otroscargos[6]["base"] = $total_timbrec;
 $otroscargos[6]["amount"] = $total_timbrec;
 $otroscargos[6]["factor"] = "99.99";
 $otroscargos[6]["indicator"] = "true";


 foreach ($otroscargos as $key => $value) {
   $otr[] = $value;
 }

 $otr = array(
  "AllowanceCharge"=>$otr,
);


 $deducciones = array();
 $deducciones[1]["name"] = "Rete Iva";
 $deducciones[1]["tax"] = $TaxAmountReteIva;
 $deducciones[1]["base"] = $TaxAmountIva;
 $deducciones[1]["rate"] = $PorcentReteIva;
 $deducciones[1]["id"] = "05";

 $deducciones[2]["name"] = "Rete Ica";
 $deducciones[2]["tax"] = $TaxAmountReteIca;
 $deducciones[2]["base"] = $TaxableAmount;
 $deducciones[2]["rate"] = $PorcentReteIca;
 $deducciones[2]["id"] = "07";

 $deducciones[3]["name"] = "Rete Fuente";
 $deducciones[3]["tax"] = $TaxAmountReteRtf;
 $deducciones[3]["base"] = $TaxableAmount;
 $deducciones[3]["rate"] = $PorcentReteRtf;
 $deducciones[3]["id"] = "06";


 foreach ($deducciones as $key => $value) {
   $dedu[] = $value;
 }

 $dedu = array(
  "WithholdingTaxTotal"=>$dedu,
);



 $todo = array_merge($encabezado, $det, $imp, $otr, $dedu);

    # ========================================================
    # =       Almacena JSON antes de enviar a la API         =
    # ========================================================
    $carpeta_destino_dian = "dian/";
    if(file_exists($carpeta_destino_dian)){
      $enviar_todo = json_encode($todo);
      $fh = fopen($carpeta_destino_dian.$numfact.'_'.$opcion."_JSON.json", 'w') or die("Se produjo un error al crear el archivo");
      $texto = preg_replace("/[\r\n|\n|\r]+/", " ", $enviar_todo);
      fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
      fclose($fh);

    }else{
      echo "No existe el directorio dian";
    }
    
    

    # =======================================
    # =           Enviar a la API           =
    # =======================================

    

    $res = $this->Enviar_Json($todo);

      

    # =====================================================
    # =           Recoge lo que devuelve la API           =
    # =====================================================

    foreach ($res as $key => $value) {
      $cuf = $value['cufe'];
      $status = $value['status'];
      $status_description = $value['status_description'];
      $email_cliente = $value['emailfe'];
      $AttachedDocument = $value['fexml'];
      $numerofactura = $value['number'];
    }
    
    

    # =========================================================
    # =           Valida Status que devuelve la API           =
    # =========================================================

    if($status == true){
      $recibo_factura = "Factura de Venta No.";
      $mensaje = "Muy bien! documentos enviados correctamente";
      $cf = $cuf;
      $estado = 1;
      $email_cliente = $email_cliente;
      $request->session()->put('CUFE_SESION', $cf);
      $request->session()->put('recibo_factura', $recibo_factura);

      # ============================================
      # =           Guarda CUFE y Status           =
      # ============================================

      if($opcion == 'F1'){
        $factura = Factura::where("prefijo","=",$Prefix)->find($numerofactura);
        $factura->cufe = $cf;
        $factura->status_factelectronica = '1';
        $factura->save();

        if($retransmitir == '1'){
            # ===========================================
            # =       Almacena AttachedDocument         =
            # ===========================================        
            $titulo        = "FACTURA No.";
            $directorio = $this->Generar_XML($cf, $numerofactura, $opcion);
            $pdfService = new PdfService();
            $pdf = $pdfService->generarCopiaFactura($anio_trabajo, $numfact, $directorio);
            $archivo = $this->Comprimir_Zip($directorio, $numfact, $opcion);
            $nombre_fact =  $numfact.'_'.$opcion;
            $this->Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente);
            $factura->status_envio_email = '1';
            $factura->save();
        }
      }else if($opcion == 'NC'){
        $nota_c = Notas_credito_factura::where("prefijo_ncf","=",$Prefix)->find($numerofactura);
        $nota_c->cufe = $cf;
        $nota_c->status_factelectronica = '1';
        $nota_c->save();

        if($retransmitir == '1'){
            # ===========================================
            # =       Almacena AttachedDocument         =
            # ===========================================
            $titulo        = "FACTURA No.";
            $directorio = $this->Generar_XML($cf, $numerofactura, $opcion);
            $pdfService = new PdfService();
            $pdf = $pdfService->GenerarCopiaNotaCredito($numfact, $directorio);
            $archivo = $this->Comprimir_Zip($directorio, $numfact, $opcion);
            $nombre_fact =  $numfact.'_'.$opcion;
            $this->Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente);               
        }
      }
      
    }else{
      $recibo_factura = "Comprobante de pago No.";
      $mensaje = $status_description;
      $cf = "";
      $estado = 0;
      $email_cliente = "";
      $request->session()->put('CUFE_SESION', $cf);
      $request->session()->put('recibo_factura', $recibo_factura);
    }
    

    return response()->json([
      "status"=>$estado,
      "mensaje"=>$mensaje,
      "cufe"=>$cf,
      "email_cliente"=>$email_cliente,
      "opcion"=>$opcion
    ]);

  }


  private function Enviar_Json($data_todo){

    $datosCodificados = json_encode($data_todo);

    $Credenciales = Credenciales_api::find(1);
    $url = $Credenciales->url_fa_electr;
    // $url = 'http://notaria13cali.binario.shop/factura/api-sync-invoice/';
    
    $ch = curl_init($url);
    curl_setopt_array($ch, array(
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $datosCodificados,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datosCodificados),
      ),
      # indicar que regrese los datos, no que los imprima directamente
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_PORT => 80
    ));


    # Hora de hacer la petición
    $resultado = curl_exec($ch);

    # Vemos si el código es 200, es decir, HTTP_OK
    $codigoRespuesta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $res = json_decode($resultado, true);

    
    curl_close($ch);

    
    return $res;

  }

  private function Generar_XML($cufe, $numerofactura, $opcion){
          $Credenciales = Credenciales_api::find(1);
          $url       = $Credenciales->url_cufe_escr;
          $url_login = $Credenciales->url_cufe_login;
          $usuario   = $Credenciales->user_cufe_escr;
          $password  = $Credenciales->pwd_cufe_escr;
          $url_login = rtrim($url_login, '/') . '/';
          $url       = rtrim($url, '/') . '/';
          $downloadUrl = $url . $cufe;
         
          try {
              $client = new Client([
                 'cookies' => true,
                 'verify' => public_path('cacert.pem'),
                 'headers' => [
                    'User-Agent' => 'Mozilla/5.0',
                    ]
               ]);

        // 1. Obtener CSRF token              
              $loginPage = $client->get($url_login);
              $html = (string) $loginPage->getBody();
              $crawler = new Crawler($html);
              $csrfToken = $crawler->filter('input[name="csrfmiddlewaretoken"]')->attr('value');

        // 2. Login con token
              $loginResponse = $client->post($url_login, [
                 'form_params' => [
                    'username' => $usuario,
                    'password' => $password,
                    'csrfmiddlewaretoken' => $csrfToken,
                    'next' => '/factura/list/',
                    ],
                    'headers' => [
                    'Referer' => $url_login,
                    ]
               ]);

        // 3. Descargar XML autenticado
              $xmlResponse = $client->get($downloadUrl);
              $contenido = $xmlResponse->getBody()->getContents();
              $AttachedDocument = $contenido;

              $carpeta_destino_cliente = public_path("cliente/");
              $nombre_directorio = $numerofactura . '_' . $opcion;

              if(file_exists($carpeta_destino_cliente)) {

                    // Crea el subdirectorio si no existe
                    $ruta_subdirectorio = $carpeta_destino_cliente . $nombre_directorio;
                    if (!file_exists($ruta_subdirectorio)) {
                         mkdir($ruta_subdirectorio, 0777, true); // Crea la carpeta con permisos
                    }

                    // Guarda el archivo XML en el subdirectorio
                    $fh = fopen($ruta_subdirectorio . '/' . $numerofactura . '_' . $opcion . "_AttachedDocument.xml", 'w') 
                         or die("Se produjo un error al crear el archivo");
                    $texto = preg_replace("/[\r\n|\n|\r]+/", " ", $AttachedDocument);
                    fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    // 4️⃣ Retorna la ruta del subdirectorio
                    return $nombre_directorio;

               } else {
                         echo "No existe el directorio cliente";
                    }

          } catch (\Exception $e) {
              
          }
     }

      private function Comprimir_Zip($directorio, $numfact, $opcion){
          // 1. Nombre del archivo ZIP final
          $nombreZip = "FACTURA_{$numfact}_{$opcion}.zip";
          //$rutaZip = $directorio . '/' . $nombreZip;
          $rutaZip = public_path("cliente/{$directorio}/{$nombreZip}");
         

          // 2. Instanciar el objeto ZipArchive
          $zip = new ZipArchive();

          if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true){

               // 3. Buscar los archivos PDF y XML en el directorio
               /*$archivos = glob(public_path('cliente/'.$directorio).'/*.{pdf,xml}', GLOB_BRACE); */

               $archivos = glob(public_path("cliente/{$directorio}/*.{pdf,xml}"), GLOB_BRACE); 

               foreach ($archivos as $archivo) {
                   
                    // Obtener el nombre del archivo sin la ruta
                    $nombreArchivo = basename($archivo);

                    // Agregar el archivo al ZIP
                    $zip->addFile($archivo, $nombreArchivo);
               }

               // 4. Cerrar el ZIP
               $zip->close();

               // 5. Eliminar los archivos sueltos (PDF y XML)
               foreach ($archivos as $archivo) {
                    unlink($archivo);
               }

               // 6. Guardar el ZIP en una variable para luego enviarlo por correo
               $rutaPublica = "cliente/{$directorio}/{$nombreZip}";
               return $rutaPublica;

               //echo "Archivo ZIP creado y archivos originales eliminados exitosamente: " . $archivo;

          } else {
               //echo "No se pudo crear el archivo ZIP.";
               }
     }

      private function Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente){
         
          $Enviar = array();
          $Enviar = [
               'num_fact' => $nombre_fact,
               'titulo' => $titulo,
               'archivo' => $archivo
          ];

          Mail::to($email_cliente)->queue(new FacturaElectronica($Enviar));

     }
}
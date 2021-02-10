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

class EinvoicenotadebitoController extends Controller
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
    $anio_trabajo = Notaria::find(1)->anio_trabajo;

    # -----------  Numero de factura obtenida en una session  -----------

    $numfact = $request->session()->get('numfact');
        
    $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$numfact)->get();
    foreach ($facturas as $factura) {
      $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
      $fecha_fact_completa = $factura->fecha_fact;
      $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
      $StarPeriodo =  Carbon::parse($fecha_fact)->firstOfMonth();
      $StarPeriodo = Carbon::parse($StarPeriodo)->format('Y-m-d');
      $EndPeriodo =  Carbon::parse($fecha_fact)->endOfMonth();
      $EndPeriodo = Carbon::parse($EndPeriodo)->format('Y-m-d');
      $identificacioncli = $factura->a_nombre_de;
      $TipodePago = $factura->credito_fact;
      $TotalFactura = $factura->total_fact;
      $TotalDerechos = $factura->total_derechos;
      $TotalConceptos = $factura->total_conceptos;
      $TotalIva = $factura->total_iva;
      $TotalRtf = $factura->total_rtf;
      $TotalReteIva = $factura->deduccion_reteiva;
      $TotalReteIca = $factura->deduccion_reteica;
      $TotalReteRtf = $factura->deduccion_retertf;
      $TotalFondo = $factura->total_fondo;
      $TotalSuper = $factura->total_super;
      $AporteEspecial = $factura->total_aporteespecial;
      $id_radica = $factura->id_radica;
      $comentarios_fact = $factura->comentarios_fact;
      $diascredito_fact = $factura->dias_credito;
      $nota_credito = $factura->nota_credito;
    }

    $TotalAntesdeIva = $TotalDerechos + $TotalConceptos;


    # ============================================
    # =      Item Conceptos de Factura           =
    # ============================================
    $id_ndf = $request->session()->get('id_ndf');
    $nota_debito = Notas_debito_factura::where("prefijo_ndf","=",$prefijo_fact)->where("id_ndf","=",$id_ndf)->get();
      foreach ($nota_debito as $nd) {
        $num_fact_aplica = $numfact;
        $fecha_fact_aplica = $fecha_fact_completa;
        $numfact = $id_ndf;
        $fecha_fact = Carbon::parse($nd->created_at)->format('Y-m-d');
        $fecha_fact_completa = $nd->created_at;
        $hora_fact = Carbon::parse($nd->created_at)->format('h-i-s');
      }
      
      $Detalle_ND = Detalle_notas_debito::where("id_ndf","=",$id_ndf)->get()->toArray();
      $i = 1;
      $detalle = array();
      $total_notadebito = 0;
      $subtotal_notadebito = 0;
      $total_iva = 0;
      foreach ($Detalle_ND as $key => $value) {
      	$total_notadebito += $value['total_concepto'];
      	$subtotal_notadebito += $value['subtotal'];
      	$total_iva += $value['iva'];
        $detalle[$i]['descripcion'] = $value['concepto'];
        $detalle[$i]['subtotal'] = $value['subtotal'];
        $detalle[$i]['iva'] = $value['iva'];
        $detalle[$i]['total_concepto'] = $value['total_concepto'];
        $i++;
      }
    
    $contdetalle = count($detalle, 0);

           

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

    $MediodePago = '10';
        
    $paymentmethod = $MediodePago;
         	 
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
	
	$LineCountNumeric = $contdetalle; //Número de productos de la factura: Conceptos y derechos
	
		

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
		
	$PaymentMeansCode = $MediodePago;


	# =============================================
	# =           Totales de la factura           =
	# =============================================


	$TaxableAmount = $subtotal_notadebito; //Derechos + Conceptos

	# =======================================
	# =           Pago a Terceros           =
	# =======================================

	$TaxAmountIva = $total_iva;
    
    # =============================================
    # =           Deducciones           =
    # =============================================

    $TaxAmountReteIva = $TotalReteIva; // Sobre ingresos
    $TaxAmountReteIca = $TotalReteIca; // Sobre ingresos
    $TaxAmountReteRtf = $TotalReteRtf; // 
      	
    # =================================
    # =           % Tarifas           =
    # =================================

    $PercentIva = $PorcentajeIva;
   	$PercentReteIca = $PorcentajeReteIca;
   	$PercentReteIva = $PorcentajeReteIva;
   	$PercentReteRtf = $PorcentajeReteRtf;

    $iva = floatval($PercentIva / 100);

   	# ======================================
   	# =           Total Ingresos           =
   	# ======================================

   	$LineExtensionAmount = $subtotal_notadebito; //Total antes de tributos
   	$AllowanceTotalAmount = 0;
    $TaxExclusiveAmount = $TaxableAmount;// Duda con esta variable
    $TaxInclusiveAmount = $total_notadebito;
    $PayableAmount = $total_notadebito; //El Valor a Pagar de Factura es igual a la Suma de Valor Bruto más tributos - Valor del Descuento Total + Valor del Cargo Total - Valor del Anticipo Total
      	
	$codImp1 = '01'; //IVA
	$valImp1 = $TaxAmountIva;
	$codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
	$valImp2 = 0.00;
	$codImp3 = '03'; //ICA
	$valImp3 = $TaxAmountReteIca;
	$valTot  = $total_notadebito;
	$NitOfe  = $nit;//Nit Notaría
	$NumAdq  = $IdentificacionCliente;
	//$ClTec 	 = '8e31038a-a994-4f62-92ec-728ff30b7f74'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
	$TipoAmbiente = $ProfileExecutionID; //1=AmbienteProduccion , 2: AmbientePruebas

	/*$cufe = $ID.$IssueDate.$IssueTime.$LineExtensionAmount.$codImp1.$valImp1.
    $codImp2.$valImp2.$codImp3.$valImp3.$valTot.$NitOfe.
    $NumAdq.$TipoAmbiente;*/

	//$UUID = hash('sha384', $cufe);

	//$QRCode =trim("NroFactura = $ID NitFacturador = $NitOfe NitAdquiriente = $NumAdq FechaFactura= $IssueDate ValorTotalFactura= $valTot CUFE=$UUID URL=https://catalogo-vpfe-hab.dian.gov.co/document/searchqr?documentKey=$UUID");

    $prefijo_fact_aplica = $Prefix;
	$typenote = '30';
	$opcion = $request->opcion;
    $tipo_operacion = $opcion;
    

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
  

    $ingresos = $detalle;
    $item = 1;
    $i=1;

   
    foreach ($ingresos as $key => $value) {
      $detalle[$i]['conteo'] = $item;
      $detalle[$i]['item_id'] = $item;
      $detalle[$i]['descripcion'] = $value['descripcion'];
      $detalle[$i]["qtyship"] = 1;
      $detalle[$i]['price'] = $value['subtotal'];
      $item += 1;
      $i += 1;
    }
    
    foreach ($detalle as $key => $value) {
     $det[] = $value;
    }
      
    $det = array(
      "detalle_factura_set"=>$det,
    );
          
   
    $impuestos = array();
    $item = 1;
    $i=1;
    foreach ($ingresos as $key => $value) {
      $impuestos[$i]['conteo'] = $item;
      $impuestos[$i]['item'] = $item;
      $impuestos[$i]['codigo'] = "01";
      $impuestos[$i]['tarifa'] = $PercentIva;
      $impuestos[$i]['nombre'] = "IVA";
      $impuestos[$i]['base'] = $value['subtotal'];
      $impuestos[$i]['valor'] = $value['iva'];
      $item += 1;
      $i += 1;
    }

    foreach ($impuestos as $key => $value) {
     $imp[] = $value;
    }

    $imp = array(
      "impuestos"=>$imp,
    );
    
   

    $todo = array_merge($encabezado, $det, $imp);

    # ========================================================
    # =       Almacena JSON antes de enviar a la API         =
    # ========================================================
     $carpeta_destino_dian = "dian/";
    if(file_exists($carpeta_destino_dian)){
    	$enviar_todo = json_encode($todo);
    	$fh = fopen($carpeta_destino_dian.$numfact.'_ND_'.$opcion."JSON.json", 'w') or die("Se produjo un error al crear el archivo");
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

    # ===========================================
    # =       Almacena AttachedDocument         =
    # ===========================================
    $carpeta_destino_cliente = "cliente/";
    if(file_exists($carpeta_destino_cliente)){
    	$fh = fopen($carpeta_destino_cliente.$numerofactura.'_'.'ND_'."AttachedDocument.xml", 'w') or die("Se produjo un error al crear el archivo");
    	$texto = preg_replace("/[\r\n|\n|\r]+/", " ", $AttachedDocument);
    	fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
    	fclose($fh);
    }else{
    	echo "No existe el directorio cliente";
    }


    


    # =========================================================
    # =           Valida Status que devuelve la API           =
    # =========================================================

    if($status == true){
      $recibo_factura = "Nota debito No.";
      $mensaje = "Muy bien! documentos enviados correctamente";
      $cf = $cuf;
      $estado = 1;
      $email_cliente = $email_cliente;
      $request->session()->put('CUFE_SESION', $cf);
      $request->session()->put('recibo_factura', $recibo_factura);

      $nota_d = Notas_debito_factura::where("prefijo_ndf","=",$Prefix)->find($numerofactura);
      $nota_d->cufe = $cf;
      $nota_d->status_factelectronica = '1';
      $nota_d->save();


    }else{
      $recibo_factura = "";
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
      "email_cliente"=>$email_cliente
    ]);
   

  }


  private function Enviar_Json($data_todo){

    $datosCodificados = json_encode($data_todo);

    $url = "http://notaria13.binario.shop/factura/api-sync-invoice.json";
    $ch = curl_init($url);

    curl_setopt_array($ch, array(
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $datosCodificados,
      //Encabezados
      //CURLOPT_HEADER => true,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datosCodificados),
      ),
      # indicar que regrese los datos, no que los imprima directamente
      CURLOPT_RETURNTRANSFER => true,
    ));
  
    # Hora de hacer la petición
    $resultado = curl_exec($ch);
    # Vemos si el código es 200, es decir, HTTP_OK
    $codigoRespuesta = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $res = json_decode($resultado, true);
    curl_close($ch);
   
    return $res;
 
  }
}

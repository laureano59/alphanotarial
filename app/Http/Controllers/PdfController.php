<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Mpdf\Mpdf;
use App\Notaria;
use App\Actosclienteradica;
use App\Otorgante;
use App\Actoscuantia;
use App\Cliente;
use App\Radicacion;
use App\Protocolista;
use App\Protocolistas_view;
use App\Principales_radica;
use App\Notario;
use App\Principalesfact_view;
use App\Factura;
use App\Cajadiario_cajarapida_view;
use App\Cajadiario_conceptos_rapida_view;
use App\Escritura;
use App\Detalle_factura;
use App\Liq_derecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Detalle_liqderecho;
use App\Certificado_rtf;
use App\Actas_deposito_view;
use App\Actas_deposito;
use App\Concepto;
use App\Notas_credito_factura;
use App\Cajadiariogeneral_view;
use App\Cajadiariogeneral_notas_otros_periodos_view;
use App\Cruces_actas_deposito_view;
use App\Egreso_acta_deposito;
use App\Actas_deposito_egreso_view;
use App\Estadisticonotarial_view;
use App\Estadisticonotarial_unicas_view;
use App\Estadisticonotarial_repetidas_view;
use App\Estadisticonotarial_repetidas_solo_radi_view;
use App\Libroindice_view;
use App\Actos_notariales_escritura_view;
use App\Relacion_notas_credito_view;
use App\Informe_cartera_view;
use App\Recaudos_view;
use App\Recaudos_sincuantia_view;
use App\Recaudos_excenta_view;
use App\Tarifa;
use App\Recaudos_sincuantia_excenta_view;
use App\Recaudos_concuantia_view;
use App\Cartera_fact;
use App\Cartera_fact_caja_rapida;
use App\Detalle_cajarapidafacturas;
use App\Facturascajarapida;
use App\Notas_credito_cajarapida;
use App\Protocolistas_copias_view;
use App\Consecutivo;
use App\Ciudad;
use App\Mediosdepago;
use App\Mediodepagocajarapida_view;
use App\Ingresosporescrituradores_view;
use App\Retencionesaplicadas_view;
use App\Retencionenlafuente_view;
use App\Gastos_notaria;
use App\Base_cajarapida;
use App\Relacion_nota_credito_print_view;
use App\Relacion_nota_credito_caja_rapida_view;
//use App\Http\Controllers\LiqderechoController;


class PdfController extends Controller
{

  public function pdf(Request $request){
    $opcion = $request->session()->get('opcion');//TODO:Session para tipo de factura
    $prefijo_fact = $request->session()->get('prefijo_fact');
    $num_fact = $request->session()->get('numfactura');//TODO:Obtiene el número de factura por session
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $id_radica = $request->session()->get('key');//Obtiene el número de radicación por session
    
    //TARIFA DEL IVA
    $porcentaje_iva = round((Tarifa::find(9)->valor1));

    $Escri = Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get();
    foreach ($Escri as $value) {
      $num_esc = $value['num_esc'];
    }

    $protocolista = Protocolistas_view::where('num_esc', $num_esc)
    ->where('anio_esc', $anio_trabajo)
    ->get();
    foreach ($protocolista as $value) {
      $nameprotocolista = $value['nombre_proto'];
    }

    
    if($opcion == 1){//TODO:Factura Unica
      $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = $factura->total_rtf;
        $total_reteconsumo = $factura->total_reteconsumo;
        $total_aporteespecial = $factura->total_aporteespecial;
        $total_impuesto_timbre = $factura->total_impuesto_timbre;
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $ingresos = $factura->total_derechos + $factura->total_conceptos;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
      }

      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Efectivo";
      }

       /*Medios de Pago*/


      $mediodepago = '';
      
      $Medpago = Mediosdepago::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }


      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }


      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }

      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(2)->get()->toArray();
      $contprincipales = count ($principales, 0);


      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }


      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(30)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;

      foreach ($conceptos as $key => $conc) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $dataconcept[$i]['concepto'] = $atributo;
            $dataconcept[$i]['cantidad'] = $conc[$hojasatributo];
            $dataconcept[$i]['total'] = $conc[$totalatributo];
            $i = $i + 1;
          }

        }
      }
      $contdataconcept = count ($dataconcept, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$num_fact;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica;
      $valTot  = $total_fact;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1;
      $TipoAmbiente = '1'; //1=AmbienteProduccion , 2: AmbientePruebas

      $cufe = $request->session()->get('CUFE_SESION');
      if (empty($cufe)) {
        $cufe = '0';
      } 
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto
      $QRCode = $cufe;

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura o comprobante

      $fecha_impresion = date("d/m/Y");
      
      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['num_esc'] = $num_esc;
      $data['id_radica'] = $id_radica;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['fecha_impresion'] = $fecha_impresion;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['principales'] = $principales;
      $data['contprincipales'] = $contprincipales;
      $data['actos'] = $actos;
      $data['contactos'] = $contactos;
      $data['derechos'] = $derechos;
      $data['dataconcept'] = $dataconcept;
      $data['contdataconcept'] = $contdataconcept;
      $data['subtotal1'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;
      $data['titulo'] = $FactComprobante;
      $data['protocolista'] = $nameprotocolista;
      $data['formadepago'] = $formadepago;
      $data['a_cargo_de'] = $a_cargo_de;
      $data['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data['detalle_acargo_de'] = $detalle_acargo_de;
      $data['porcentaje_iva'] = $porcentaje_iva;
      $data['mediodepago'] = $mediodepago;


      $j = 0;
      if($total_super > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super;
      }
      if($total_fondo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo;
      }
      if($total_rtf > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf;
      }
      if($total_reteconsumo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo;
      }
      if($total_aporteespecial > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_impuesto_timbre;
      }
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $k = 0;
      if($reteiva > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIva 15%";
        $deducciones[$k]['total'] = $reteiva;
      }
      if($retertf > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteFuente 11%";
        $deducciones[$k]['total'] = $retertf;
      }
      if($reteica > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones[$k]['total'] = $reteica;
      }

      if (isset($deducciones)){ //Si está definida la variable
        $contdeducciones = count ($deducciones, 0);
        $data['deducciones'] = $deducciones;
        $data['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva + $retertf + $reteica;
        $data['totaldeducciones'] = round($totaldeducciones);
      }


      if ($cufe == '0'){
        $piepagina_fact = '';
        $html = view('pdf.generar_recibo',$data)->render();
      }else{
        $html = view('pdf.generar',$data)->render();
      }
      

      $namefile = $num_fact.'_F1'.'.pdf';
      //$namefile = 'facturan13'.$num_fact.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);



    }else if($opcion == 2){//TODO:FacturaDoble
      //Ya no se usa

    }else if($opcion == 3){//TODO:Factura Multiple
            
      $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();

      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = $factura->total_rtf;
        $total_reteconsumo = $factura->total_reteconsumo;
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_aporteespecial = $factura->total_aporteespecial;
        $total_impuesto_timbre = $factura->total_impuesto_timbre;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $ingresos = $factura->total_derechos + $factura->total_conceptos;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
      }

       /*Medios de Pago*/


      $mediodepago = '';
      
      $Medpago = Mediosdepago::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }


      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }



      if($forma_pago == true){
        $formadepago = "Credito";
      }else if($forma_pago == false){
        $formadepago = "Efectivo";
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }


      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }


      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(2)->get()->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(30)->get()->toArray();
      $contactos = count ($actos, 0);
      //$conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $conceptos = Detalle_factura::where('id_fact', $num_fact)->get()->toArray();
      $cantidades = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

      $i = 1;
      $dataconcept = array();
      foreach ($conceptos as $key => $conc) {
        foreach ($cantidades as $key => $cnt) {
          # code...

          foreach ($atributos as $key => $atri) {
            $atributo = $atri['nombre_concep'];
            $totalatributo = 'total'.$atri['atributo'];
            $hojasatributo = 'hojas'.$atri['atributo'];
            if($conc[$totalatributo] > 0){
              $dataconcept[$i]['concepto'] = $atributo;
              $dataconcept[$i]['cantidad'] = $cnt[$hojasatributo];
              $dataconcept[$i]['total'] = $conc[$totalatributo];
              $i = $i + 1;
            }
          }
        }
      }

      $contdataconcept = count ($dataconcept, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$num_fact;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica;
      $valTot  = $total_fact;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1;
      $ClTec   = 'XXXXX'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '1'; //1=AmbienteProduccion , 2: AmbientePruebas
      
      $cufe = $request->session()->get('CUFE_SESION');
      if (empty($cufe)) {
        $cufe = '0';
      } 
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto
      $QRCode = $cufe;

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura o comprobante

      $fecha_impresion = date("d/m/Y");

      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['num_esc'] = $num_esc;
      $data['id_radica'] = $id_radica;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['principales'] = $principales;
      $data['contprincipales'] = $contprincipales;
      $data['actos'] = $actos;
      $data['contactos'] = $contactos;
      $data['derechos'] = $derechos;
      $data['dataconcept'] = $dataconcept;
      $data['contdataconcept'] = $contdataconcept;
      $data['subtotal1'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;
      $data['titulo'] = $FactComprobante;
      $data['protocolista'] = $nameprotocolista;
      $data['formadepago'] = $formadepago;
      $data['a_cargo_de'] = $a_cargo_de;
      $data['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data['detalle_acargo_de'] = $detalle_acargo_de;
      $data['mediodepago'] = $mediodepago;
      $data['fecha_impresion'] = $fecha_impresion;
      

      $j = 0;
      if($total_super > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super;
      }
      if($total_fondo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo;
      }
      if($total_aporteespecial > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto Timbre";
        $terceros[$j]['total'] = $total_impuesto_timbre;
      }
      if($total_rtf > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf;
      }
      if($total_reteconsumo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo;
      }
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super + $total_aporteespecial +$total_impuesto_timbre;
      $data['totalterceros'] = round($totalterceros);

      $k = 0;
      if($reteiva > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIva 15%";
        $deducciones[$k]['total'] = $reteiva;
      }
      if($retertf > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteFuente 11%";
        $deducciones[$k]['total'] = $retertf;
      }
      if($reteica > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones[$k]['total'] = $reteica;
      }

      if (isset($deducciones)){ //Si está definida la variable
        $contdeducciones = count ($deducciones, 0);
        $data['deducciones'] = $deducciones;
        $data['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva + $retertf + $reteica;
        $data['totaldeducciones'] = round($totaldeducciones);
      }

      if ($cufe == '0'){
        $piepagina_fact = '';
        $html = view('pdf.generar_recibo',$data)->render();
      }else{
        $html = view('pdf.generar',$data)->render();
      }
     
      //$namefile = 'facturan13'.$num_fact.'.pdf';
      $namefile = $num_fact.'_F1'.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta

    }
  }

  public function PdfRadicacion(Request $request){
    $id_radica = $request->session()->get('key');//TODO:Obtiene el número de radicación por session
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $raw = \DB::raw("id_proto, created_at");
    $radica = Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw)->get();
    foreach ($radica as $rad) {
      $id_proto = $rad->id_proto;
      $fecha_radica = $rad->created_at;
    }

    $rawproto = \DB::raw("nombre_proto");
    $protocolista = Protocolista::where('id_proto', $id_proto)->select($rawproto)->get();
    foreach ($protocolista as $pro) {
      $nombre_proto = $pro->nombre_proto;
    }

    $identificacion_not = $notaria->identificacion_not;

    $rawnotario_encargado = \DB::raw("CONCAT(nombre_not, ' ', apellido_not)as fullname");
    $not_encargado = Notario::where('identificacion_not', $identificacion_not)->select($rawnotario_encargado)->get();
    foreach ($not_encargado as $not) {
      $notario_encargado = $not->fullname;
    }

    $fecha_recibido = $fecha_radica->format('d/m/Y');
    $hora_recibido = $fecha_radica->format("g:i a");

    $rawsolicitado = \DB::raw("MIN(id_actoperrad) as id_actoperrad, MIN(CONCAT(pmer_nombrecli1, ' ', sgndo_nombrecli1, ' ', pmer_apellidocli1, ' ', sgndo_apellidocli1, empresa1)) as fullname, MIN(telefono_cli1) as telefono_cli1, MIN(direccion_cli1) as direccion_cli1, MIN(email_cli1) as email_cli1");
    $solicitado = Principales_radica::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($rawsolicitado)->get();
    foreach ($solicitado as $sol) {
      $solicitado_nombre = $sol->fullname;
      $solicitado_tel = $sol->telefono_cli1;
      $solicitado_dir = $sol->direccion_cli1;
      $solicitado_email = $sol->email_cli1;
    }

    $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
      identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
    $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->get()->toArray();
    $contprincipales = count ($principales, 0);

    $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
    $contactos = count ($actos, 0);


    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['id_radica'] = $id_radica;
    $data['anio_trabajo'] = $anio_trabajo;
    $data['nombre_proto'] = $nombre_proto;
    $data['notario_encargado'] = $notario_encargado;
    $data['fecha_recibido'] = $fecha_recibido;
    $data['hora_recibido'] = $hora_recibido;
    $data['nombre_cli'] = $solicitado_nombre;
    $data['telefono_cli'] = $solicitado_tel;
    $data['direccion_cli'] = $solicitado_dir;
    $data['email_cli'] = $solicitado_email;
    $data['principales'] = $principales;
    $data['contprincipales'] = $contprincipales;
    $data['actos'] = $actos;
    $data['contactos'] = $contactos;

    $html = view('pdf.radicacion',$data)->render();

    $namefile = 'controlruta_'.$id_radica.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        // "format" => "Letter en mm",
      "format" => 'Letter',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");
  }



  public function PdfCertificadoRetecncionenlaFuente(Request $request){
  //$id_cer = $request->session()->get('id_cer');
    $id_radica = $request->session()->get('key');
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nombre_nota = $notaria->nombre_nota;
    $nombre_notario = $notaria->nombre_notario;
    $nit = $notaria->nit;
    $direccion_nota = $notaria->direccion_nota;
    $email = $notaria->email;
    $num_escritura = $request->session()->get('num_esc');
    $anio_gravable = $anio_trabajo;
    $fecha_certificado = date("Y/m/d");

    $certificado_rtf = Certificado_rtf::where("id_radica","=",$id_radica)->where("anio_gravable","=",$anio_gravable)->get();
    $i = 0;
    $html = [];
    foreach ($certificado_rtf as $cer) {
      $fecha_escritura = $cer->fecha_escritura;
      $ciudad = $cer->ciudad;
      $nombre_contribuyente = $cer->nombre_contribuyente;
      $identificacion_contribuyente = $cer->identificacion_contribuyente;
      $prefijo_fact = $cer->prefijo;
      $num_factura = $cer->num_factura;
      $fecha_factura = $cer->fecha_factura;
      $valor_venta = $cer->valor_venta;
      $total_retenido = $cer->total_retenido;


      $data['id_cer'] = $cer->id_cer;
      $data['nombre_nota'] = $nombre_nota;
      $data['nombre_notario'] = $nombre_notario;
      $data['nit'] = $nit;
      $data['direccion_nota'] = $direccion_nota;
      $data['email'] = $email;
      $data['num_escritura'] = $num_escritura;
      $data['anio_gravable'] = $anio_gravable;
      $data['fecha_escritura'] = $fecha_escritura;
      $data['ciudad'] = $ciudad;
      $data['nombre_contribuyente'] = $nombre_contribuyente;
      $data['identificacion_contribuyente'] = $identificacion_contribuyente;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_factura'] = $num_factura;
      $data['fecha_factura'] = $fecha_factura;
      $data['valor_venta'] = $valor_venta;
      $data['total_retenido'] = $total_retenido;
      $data['fecha_certificado'] = $fecha_certificado;
      $html[$i] = view('pdf.certificadortf',$data)->render();
      $i++;
    }


    $namefile = 'certifirtf_'.$fecha_certificado.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
      // "format" => "Letter en mm",
      "format" => [216, 140],//Media Carta
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');

    $contador = count ($html, 0);
    $contador = $contador - 1;
    foreach ($html as $key => $value) {
      $mpdf->WriteHTML($value);
      if($contador > 0){
        $mpdf->AddPage();
      }
      $contador--;
    }

    $mpdf->Output($namefile,"I");



  }


  public function PdfCopiaCertificadoRetecncionenlaFuente(Request $request){
  //$id_cer = $request->session()->get('id_cer');

    $notaria = Notaria::find(1);
    //$anio_trabajo = $notaria->anio_trabajo;
    $nombre_nota = $notaria->nombre_nota;
    $nombre_notario = $notaria->nombre_notario;
    $nit = $notaria->nit;
    $direccion_nota = $notaria->direccion_nota;
    $email = $notaria->email;
    //$anio_gravable = $anio_trabajo;
    $fecha_certificado = date("Y/m/d");
    //$identificacion = $request->identificacion;
    $identificacion = $request->session()->get('identificacion');


    //$certificado_rtf = Certificado_rtf::where("id_radica","=",$id_radica)->where("anio_gravable","=",$anio_gravable)->where("identificacion_contribuyente","=",$identificacion)->get();
    $certificado_rtf = Certificado_rtf::where("identificacion_contribuyente","=",$identificacion)->get();

    
    $i = 0;

    foreach ($certificado_rtf as $cer) {
      $fecha_escritura = $cer->fecha_escritura;
      $ciudad = $cer->ciudad;
      $nombre_contribuyente = $cer->nombre_contribuyente;
      $identificacion_contribuyente = $cer->identificacion_contribuyente;
      $prefijo_fact = $cer->prefijo;
      $num_factura = $cer->num_factura;
      $fecha_factura = $cer->fecha_factura;
      $valor_venta = $cer->valor_venta;
      $total_retenido = $cer->total_retencion;
      $num_escritura = $cer->num_escritura;
      $anio_gravable = $cer->anio_gravable;
      $data['id_cer'] = $cer->id_cer;
      $data['nombre_nota'] = $nombre_nota;
      $data['nombre_notario'] = $nombre_notario;
      $data['nit'] = $nit;
      $data['direccion_nota'] = $direccion_nota;
      $data['email'] = $email;
      $data['num_escritura'] = $num_escritura;
      $data['anio_gravable'] = $anio_gravable;
      $data['fecha_escritura'] = $fecha_escritura;
      $data['ciudad'] = $ciudad;
      $data['nombre_contribuyente'] = $nombre_contribuyente;
      $data['identificacion_contribuyente'] = $identificacion_contribuyente;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_factura'] = $num_factura;
      $data['fecha_factura'] = $fecha_factura;
      $data['valor_venta'] = $valor_venta;
      $data['total_retenido'] = $total_retenido;
      $data['fecha_certificado'] = $fecha_certificado;
      $html[$i] = view('pdf.certificadortf',$data)->render();
      $i++;
    }

    
    $namefile = 'certifirtf_'.$fecha_certificado.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
      // "format" => "Letter en mm",
      "format" => [216, 140],//TODO: Media Carta
      'margin_bottom' => 1,
    ]);

    $mpdf->defaultfooterfontsize=1;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');

    $contador = count ($html, 0);
    $contador = $contador - 1;
    foreach ($html as $key => $value) {
      $mpdf->WriteHTML($value);
      if($contador > 0){
        $mpdf->AddPage();
      }
      $contador--;
    }

    $mpdf->Output($namefile,"I");

  }


  /***************NOTA CREDITO FACTURA*******************/
  public function PdfNotaCreditoFact(Request $request){
    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_fact;
    //$anio_trabajo = $notaria->anio_trabajo;
    $num_fact = $request->session()->get('numfact');//TODO:Obtiene el número de factura por session
    
    //TARIFA DEL IVA
    $porcentaje_iva = round((Tarifa::find(9)->valor1));
    $id_ncf = $request->session()->get('id_ncf');
    $notacreditofact = Notas_credito_factura::where("id_ncf","=",$id_ncf)->where("prefijo_ncf","=",$prefijo_fact)->get();
    

    foreach ($notacreditofact as $ncf) {
      $detalle_ncf = $ncf->detalle_ncf;
      $fecha_ncf = Carbon::parse($ncf->created_at)->format('Y-m-d');
      $fecha_ncf_completa = $ncf->created_at;
      $hora_ncf = Carbon::parse($ncf->created_at)->format('h-i-s');
    }

    /********Valida Si la factura es doble o unica*********/
    if (Detalle_factura::where('id_fact', $num_fact)->where('prefijo', $prefijo_fact)->exists()){
      $factura_oto = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($factura_oto as $factura_otor) {
        $total_iva_otor = $factura_otor->total_iva;
        $total_rtf_otor = $factura_otor->total_rtf;
        $total_reteconsumo_otor = $factura_otor->total_reteconsumo;
        $total_fondo_otor = $factura_otor->total_fondo;
        $total_super_otor = $factura_otor->total_super;
        $total_aporteespecial_otor = $factura_otor->total_aporteespecial;
        $total_impuesto_timbre_otor = $factura_otor->total_impuesto_timbre;
        $total_fact_otor = $factura_otor->total_fact;
        $reteiva_otor = $factura_otor->deduccion_reteiva;
        $retertf_otor = $factura_otor->deduccion_retertf;
        $reteica_otor = $factura_otor->deduccion_reteica;
        $subtotal1_otor = $factura_otor->total_derechos + $factura_otor->total_conceptos;
        $fecha_fact = Carbon::parse($factura_otor->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura_otor->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura_otor->updated_at)->format('h:i:s');
        $derechos_otor = $factura_otor->total_derechos;
        $identificacioncli1_otor = $factura_otor->a_nombre_de;
        $id_radica =  $factura_otor->id_radica;
        $anio_trabajo = $factura_otor->anio_radica;
        $a_cargo_de = $factura_otor->a_cargo_de;
        $detalle_acargo_de = $factura_otor->detalle_acargo_de;
      }

      $escrituras = Escritura::where("id_radica","=",$id_radica)->where("anio_esc","=",$anio_trabajo)->get();
      foreach ($escrituras as $esc) {
        $num_esc = $esc->num_esc;
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente_otor = Cliente::where('identificacion_cli', $identificacioncli1_otor)->select($raw)->get();
      foreach ($cliente_otor as $key => $cli_otor) {
        $nombrecli1_otor = $cli_otor['fullname'];
        $direccioncli1_otor = $cli_otor['direccion_cli'];
      }

      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }

      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(3)->get()->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(3)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos_otor = Detalle_factura::where('id_fact', $num_fact)->get()->toArray();

      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');

      $i = 1;
      $dataconcept_otor = array();
      foreach ($conceptos_otor as $key => $conc1) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc1[$totalatributo] > 0){
            $dataconcept_otor[$i]['concepto'] = $atributo;
            $dataconcept_otor[$i]['cantidad'] = "";
            $dataconcept_otor[$i]['total'] = $conc1[$totalatributo];
            $i = $i + 1;
          }

        }
      }

      $contdataconcept_otor = count($dataconcept_otor, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;



      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$id_ncf;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva_otor;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica_otor;
      $valTot  = $total_fact_otor;
      $ingresos = $subtotal1_otor;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1_otor;
      //$ClTec   = 'XXXXX'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura 

      $cufe = $request->session()->get('CUFE_SESION');
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      $QRCode = $cufe;

      $iva = "Somos Responsables de IVA";
      $data_otor['id_ncf'] = $id_ncf;
      $data_otor['detalle_ncf'] = $detalle_ncf;
      $data_otor['nit'] = $nit;
      $data_otor['nombre_nota'] = $nombre_nota;
      $data_otor['direccion_nota'] = $direccion_nota;
      $data_otor['telefono_nota'] = $telefono_nota;
      $data_otor['email'] = $email;
      $data_otor['nombre_notario'] = $nombre_notario;
      $data_otor['resolucion'] = $resolucion;
      $data_otor['piepagina_fact'] = $piepagina_fact;
      $data_otor['IVA'] = $iva;
      $data_otor['prefijo_fact'] = $prefijo_fact;
      $data_otor['num_fact'] = $num_fact;
      $data_otor['num_esc'] = $num_esc;
      $data_otor['identificacioncli1'] = $identificacioncli1_otor;
      $data_otor['nombrecli1'] = $nombrecli1_otor;
      $data_otor['direccioncli1'] = $direccioncli1_otor;
      $data_otor['fecha_fact'] = $fecha_fact;
      $data_otor['hora_fact'] = $hora_fact;
      $data_otor['hora_cufe'] = $hora_cufe;
      $data_otor['principales'] = $principales;
      $data_otor['contprincipales'] = $contprincipales;
      $data_otor['actos'] = $actos;
      $data_otor['contactos'] = $contactos;//contador actos
      $data_otor['derechos'] = $derechos_otor;
      $data_otor['dataconcept'] = $dataconcept_otor;
      $data_otor['contdataconcept'] = $contdataconcept_otor;
      $data_otor['subtotal1'] = $subtotal1_otor;
      $data_otor['total_fact'] = $total_fact_otor;
      $data_otor['QRCode'] = $QRCode;
      $data_otor['cufe'] = $cufe;
      $data_otor['a_cargo_de'] = $a_cargo_de;
      $data_otor['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data_otor['detalle_acargo_de'] = $detalle_acargo_de;

      $j = 0;
      if($total_super_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super_otor;
      }
      if($total_fondo_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo_otor;
      }
      if($total_aporteespecial_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial_otor;
      }
      if($total_impuesto_timbre_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto Timbre";
        $terceros[$j]['total'] = $total_impuesto_timbre_otor;
      }
      if($total_rtf_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf_otor;
      }
      if($total_reteconsumo_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo_otor;
      }
      if($total_iva_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = $total_iva_otor;
      }

      $contterceros = count ($terceros, 0);
      $data_otor['terceros'] = $terceros;
      $data_otor['contterceros'] = $contterceros;

      $totalterceros = $total_iva_otor + $total_rtf_otor + $total_reteconsumo_otor + $total_fondo_otor + $total_super_otor;
      $data_otor['totalterceros'] = $totalterceros;

      $k = 0;
      if($reteiva_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteIva 15%";
        $deducciones_otor[$k]['total'] = $reteiva_otor;
      }
      if($retertf_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteFuente 11%";
        $deducciones_otor[$k]['total'] = $retertf_otor;
      }
      if($reteica_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones_otor[$k]['total'] = $reteica_otor;
      }

      if (isset($deducciones_otor)){
        $contdeducciones = count ($deducciones_otor, 0);
        $data_otor['deducciones'] = $deducciones_otor;
        $data_otor['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva_otor + $retertf_otor + $reteica_otor;
        $data_otor['totaldeducciones'] = round($totaldeducciones);
      }

      $html_otor = view('pdf.notacredito_fact',$data_otor)->render();

      //$namefile = 'notacredito_n13_'.$id_ncf.'.pdf';

      $namefile = $id_ncf.'_NC'.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHeader('Factura '.'{PAGENO} de {nbpg}');

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html_otor);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta

    }else{//Nota Credito Para radicación con una sola factura
      $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();

      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = $factura->total_rtf;
        $total_reteconsumo = $factura->total_reteconsumo;
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_aporteespecial = $factura->total_aporteespecial;
        $total_impuesto_timbre = $factura->total_impuesto_timbre;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $ingresos = $factura->total_derechos + $factura->total_conceptos;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $id_radica = $factura->id_radica;
        $anio_trabajo = $factura->anio_radica;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
      }

      $escrituras = Escritura::where("id_radica","=",$id_radica)->where("anio_esc","=",$anio_trabajo)->get();
      foreach ($escrituras as $esc) {
        $num_esc = $esc->num_esc;
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }


      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }

      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->get()->take(3)->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(3)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;

      foreach ($conceptos as $key => $conc) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $dataconcept[$i]['concepto'] = $atributo;
            $dataconcept[$i]['cantidad'] = $conc[$hojasatributo];
            $dataconcept[$i]['total'] = $conc[$totalatributo];
            $i = $i + 1;
          }

        }
      }
      $contdataconcept = count ($dataconcept, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$num_fact;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica;
      $valTot  = $total_fact;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1;
      $ClTec   = 'XXXXX'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

      $cufe = $request->session()->get('CUFE_SESION');
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      $QRCode = $cufe;

      $iva = "Somos Responsables de IVA";
      $data['id_ncf'] = $id_ncf;
      $data['detalle_ncf'] = $detalle_ncf;
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['num_esc'] = $num_esc;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['principales'] = $principales;
      $data['contprincipales'] = $contprincipales;
      $data['actos'] = $actos;
      $data['contactos'] = $contactos;
      $data['derechos'] = $derechos;
      $data['dataconcept'] = $dataconcept;
      $data['contdataconcept'] = $contdataconcept;
      $data['subtotal1'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $UUID;
      $data['a_cargo_de'] = $a_cargo_de;
      $data['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data['detalle_acargo_de'] = $detalle_acargo_de;

      $j = 0;
      if($total_super > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super;
      }
      if($total_fondo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo;
      }
      if($total_aporteespecial > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto Timbre";
        $terceros[$j]['total'] = $total_impuesto_timbre;
      }
      if($total_rtf > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf;
      }
      if($total_reteconsumo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo;
      }
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $k = 0;
      if($reteiva > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIva 15%";
        $deducciones[$k]['total'] = $reteiva;
      }
      if($retertf > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteFuente 11%";
        $deducciones[$k]['total'] = $retertf;
      }
      if($reteica > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones[$k]['total'] = $reteica;
      }

      if (isset($deducciones)){ //Si está definida la variable
        $contdeducciones = count ($deducciones, 0);
        $data['deducciones'] = $deducciones;
        $data['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva + $retertf + $reteica;
        $data['totaldeducciones'] = round($totaldeducciones);
      }

      $html = view('pdf.notacredito_fact',$data)->render();

      //$namefile = 'notacredito_n13_'.$id_ncf.'.pdf';
      $namefile = $id_ncf.'_NC'.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      
    }
  }

  /***************COPIA NOTA CREDITO FACTURA*******************/
  public function PdfNotaCreditoFactCopia(Request $request){
    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_fact;
    //$anio_trabajo = $notaria->anio_trabajo;
    $num_fact = $request->session()->get('numfact');//TODO:Obtiene el número de factura por session
    
    //TARIFA DEL IVA
    $porcentaje_iva = round((Tarifa::find(9)->valor1));

    $Notacredito = Notas_credito_factura::where("id_fact","=",$num_fact)->where("prefijo","=",$prefijo_fact)->get();
    foreach ($Notacredito as $nc) {
      $id_ncf = $nc->id_ncf;
      $cuf = $nc->cufe;
    }

    
    $notacreditofact = Notas_credito_factura::where("id_ncf","=",$id_ncf)->where("prefijo_ncf","=",$prefijo_fact)->get();
    foreach ($notacreditofact as $ncf) {
      $detalle_ncf = $ncf->detalle_ncf;
      $fecha_ncf = Carbon::parse($ncf->created_at)->format('Y-m-d');
      $fecha_ncf_completa = $ncf->created_at;
      $hora_ncf = Carbon::parse($ncf->created_at)->format('h:i:s');
    }

    /********Valida Si la factura es doble o unica*********/
    if (Detalle_factura::where('id_fact', $num_fact)->where('prefijo', $prefijo_fact)->exists()){

      $factura_oto = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($factura_oto as $factura_otor) {
        $total_iva_otor = $factura_otor->total_iva;
        $total_rtf_otor = $factura_otor->total_rtf;
        $total_reteconsumo_otor = $factura_otor->total_reteconsumo;
        $total_fondo_otor = $factura_otor->total_fondo;
        $total_super_otor = $factura_otor->total_super;
        $total_aporteespecial_otor = $factura_otor->total_aporteespecial;
        $total_fact_otor = $factura_otor->total_fact;
        $reteiva_otor = $factura_otor->deduccion_reteiva;
        $retertf_otor = $factura_otor->deduccion_retertf;
        $reteica_otor = $factura_otor->deduccion_reteica;
        $subtotal1_otor = $factura_otor->total_derechos + $factura_otor->total_conceptos;
        $fecha_fact = Carbon::parse($factura_otor->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura_otor->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura_otor->updated_at)->format('h:i:s');
        $derechos_otor = $factura_otor->total_derechos;
        $identificacioncli1_otor = $factura_otor->a_nombre_de;
        $id_radica =  $factura_otor->id_radica;
        $anio_trabajo =  $factura_otor->anio_radica;
        $a_cargo_de = $factura_otor->a_cargo_de;
        $detalle_acargo_de = $factura_otor->detalle_acargo_de;
      }

      $escrituras = Escritura::where("id_radica","=",$id_radica)->where("anio_esc","=",$anio_trabajo)->get();
      foreach ($escrituras as $esc) {
        $num_esc = $esc->num_esc;
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente_otor = Cliente::where('identificacion_cli', $identificacioncli1_otor)->select($raw)->get();
      foreach ($cliente_otor as $key => $cli_otor) {
        $nombrecli1_otor = $cli_otor['fullname'];
        $direccioncli1_otor = $cli_otor['direccion_cli'];
      }

      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }

      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(3)->get()->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(3)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos_otor = Detalle_factura::where('id_fact', $num_fact)->get()->toArray();

      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');

      $i = 1;
      $dataconcept_otor = array();
      foreach ($conceptos_otor as $key => $conc1) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc1[$totalatributo] > 0){
            $dataconcept_otor[$i]['concepto'] = $atributo;
            $dataconcept_otor[$i]['cantidad'] = "";
            $dataconcept_otor[$i]['total'] = $conc1[$totalatributo];
            $i = $i + 1;
          }

        }
      }

      $contdataconcept_otor = count($dataconcept_otor, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;



      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$id_ncf;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva_otor;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica_otor;
      $valTot  = $total_fact_otor;
      $ingresos = $subtotal1_otor;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1_otor;
      //$ClTec   = 'XXXXX'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura 

      $cufe = $cuf;
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      $QRCode = $cufe;

      $iva = "Somos Responsables de IVA";
      $data_otor['id_ncf'] = $id_ncf;
      $data_otor['detalle_ncf'] = $detalle_ncf;
      $data_otor['nit'] = $nit;
      $data_otor['nombre_nota'] = $nombre_nota;
      $data_otor['direccion_nota'] = $direccion_nota;
      $data_otor['telefono_nota'] = $telefono_nota;
      $data_otor['email'] = $email;
      $data_otor['nombre_notario'] = $nombre_notario;
      $data_otor['resolucion'] = $resolucion;
      $data_otor['piepagina_fact'] = $piepagina_fact;
      $data_otor['IVA'] = $iva;
      $data_otor['prefijo_fact'] = $prefijo_fact;
      $data_otor['num_fact'] = $num_fact;
      $data_otor['num_esc'] = $num_esc;
      $data_otor['identificacioncli1'] = $identificacioncli1_otor;
      $data_otor['nombrecli1'] = $nombrecli1_otor;
      $data_otor['direccioncli1'] = $direccioncli1_otor;
      $data_otor['fecha_fact'] = $fecha_fact;
      $data_otor['hora_fact'] = $hora_fact;
      $data_otor['hora_cufe'] = $hora_cufe;
      $data_otor['principales'] = $principales;
      $data_otor['contprincipales'] = $contprincipales;
      $data_otor['actos'] = $actos;
      $data_otor['contactos'] = $contactos;//contador actos
      $data_otor['derechos'] = $derechos_otor;
      $data_otor['dataconcept'] = $dataconcept_otor;
      $data_otor['contdataconcept'] = $contdataconcept_otor;
      $data_otor['subtotal1'] = $subtotal1_otor;
      $data_otor['total_fact'] = $total_fact_otor;
      $data_otor['QRCode'] = $QRCode;
      $data_otor['cufe'] = $cufe;
      $data_otor['a_cargo_de'] = $a_cargo_de;
      $data_otor['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data_otor['detalle_acargo_de'] = $detalle_acargo_de;

      $j = 0;
      if($total_super_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super_otor;
      }
      if($total_fondo_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo_otor;
      }
      if($total_aporteespecial_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial_otor;
      }
      if($total_rtf_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf_otor;
      }
      if($total_reteconsumo_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo_otor;
      }
      if($total_iva_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = $total_iva_otor;
      }

      $contterceros = count ($terceros, 0);
      $data_otor['terceros'] = $terceros;
      $data_otor['contterceros'] = $contterceros;

      $totalterceros = $total_iva_otor + $total_rtf_otor + $total_reteconsumo_otor + $total_fondo_otor + $total_super_otor;
      $data_otor['totalterceros'] = $totalterceros;

      $k = 0;
      if($reteiva_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteIva 15%";
        $deducciones_otor[$k]['total'] = $reteiva_otor;
      }
      if($retertf_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteFuente 11%";
        $deducciones_otor[$k]['total'] = $retertf_otor;
      }
      if($reteica_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones_otor[$k]['total'] = $reteica_otor;
      }

      if (isset($deducciones_otor)){
        $contdeducciones = count ($deducciones_otor, 0);
        $data_otor['deducciones'] = $deducciones_otor;
        $data_otor['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva_otor + $retertf_otor + $reteica_otor;
        $data_otor['totaldeducciones'] = round($totaldeducciones);
      }

      $html_otor = view('pdf.notacredito_fact',$data_otor)->render();

      //$namefile = 'notacredito_n13_'.$id_ncf.'.pdf';

      $namefile = $id_ncf.'_NC'.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHeader('Factura '.'{PAGENO} de {nbpg}');

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html_otor);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta

    }else{//Nota Credito Para radicación con una sola factura
      $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();

      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = $factura->total_rtf;
        $total_reteconsumo = $factura->total_reteconsumo;
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_aporteespecial = $factura->total_aporteespecial;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $ingresos = $factura->total_derechos + $factura->total_conceptos;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $id_radica = $factura->id_radica;
        $anio_trabajo =  $factura->anio_radica;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
      }

      $escrituras = Escritura::where("id_radica","=",$id_radica)->where("anio_esc","=",$anio_trabajo)->get();
      foreach ($escrituras as $esc) {
        $num_esc = $esc->num_esc;
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }

      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }

      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->get()->take(3)->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(3)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      
      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;

      foreach ($conceptos as $key => $conc) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $dataconcept[$i]['concepto'] = $atributo;
            $dataconcept[$i]['cantidad'] = $conc[$hojasatributo];
            $dataconcept[$i]['total'] = $conc[$totalatributo];
            $i = $i + 1;
          }

        }
      }
      $contdataconcept = count ($dataconcept, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$num_fact;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica;
      $valTot  = $total_fact;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1;
      $ClTec   = 'XXXXX'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

      $cufe = $cuf;
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      $QRCode = $cufe;

      $iva = "Somos Responsables de IVA";
      $data['id_ncf'] = $id_ncf;
      $data['detalle_ncf'] = $detalle_ncf;
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['num_esc'] = $num_esc;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['principales'] = $principales;
      $data['contprincipales'] = $contprincipales;
      $data['actos'] = $actos;
      $data['contactos'] = $contactos;
      $data['derechos'] = $derechos;
      $data['dataconcept'] = $dataconcept;
      $data['contdataconcept'] = $contdataconcept;
      $data['subtotal1'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;
      $data['a_cargo_de'] = $a_cargo_de;
      $data['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data['detalle_acargo_de'] = $detalle_acargo_de;

      $j = 0;
      if($total_super > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super;
      }
      if($total_fondo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo;
      }
      if($total_aporteespecial > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial;
      }
      if($total_rtf > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf;
      }
      if($total_reteconsumo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo;
      }
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $k = 0;
      if($reteiva > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIva 15%";
        $deducciones[$k]['total'] = $reteiva;
      }
      if($retertf > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteFuente 11%";
        $deducciones[$k]['total'] = $retertf;
      }
      if($reteica > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones[$k]['total'] = $reteica;
      }

      if (isset($deducciones)){ //Si está definida la variable
        $contdeducciones = count ($deducciones, 0);
        $data['deducciones'] = $deducciones;
        $data['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva + $retertf + $reteica;
        $data['totaldeducciones'] = round($totaldeducciones);
      }

      $html = view('pdf.notacredito_fact',$data)->render();

      //$namefile = 'notacredito_n13_'.$id_ncf.'.pdf';
      $namefile = $id_ncf.'_NC'.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      
    }
  }


  public function PdfActaDeposito(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $id_act = $request->session()->get('id_acta');

    $Actas_deposito = Actas_deposito_view::find($id_act);
    $id_radica = $Actas_deposito->id_radica;
    
    $escritura = Escritura::where('id_radica', $id_radica)
    ->where('anio_esc', $anio_trabajo)
    ->get()
    ->toArray();

    if($escritura){
      foreach ($escritura as $key => $escr) {
        $num_escritura = $escr['num_esc'];
      }
    }else{
      $num_escritura = '';
    }

    $id_act = $Actas_deposito->id_act;
    $nombre = $Actas_deposito->nombre;
    $identificacion_cli = $Actas_deposito->identificacion_cli;
    $fecha = $Actas_deposito->fecha;
    $descripcion_tip = $Actas_deposito->descripcion_tip;
    $efectivo = $Actas_deposito->efectivo;
    $transferencia = $Actas_deposito->transferencia_bancaria;
    $cheque = $Actas_deposito->cheque;
    $tarjeta_credito = $Actas_deposito->tarjeta_credito;
    $tarjeta_debito = $Actas_deposito->tarjeta_debito;
    $pse = $Actas_deposito->pse;
    $num_cheque = $Actas_deposito->num_cheque;
    $num_tarjetacredito = $Actas_deposito->num_tarjetacredito;
    $nombre_ban = $Actas_deposito->nombre_ban;
    $total_recibido = round($Actas_deposito->deposito_act);
    $total_en_letras = strtoupper($this->convertir($total_recibido)).' '.'PESOS M/CTE';

     $j = 0;
      if($efectivo > 0){
        $j = $j + 1;
        $mediosdepago[$j]['medio'] = "Efectivo";
        $mediosdepago[$j]['total'] = $efectivo;
      }
      if($transferencia > 0){
        $j = $j + 1;
        $mediosdepago[$j]['medio'] = "Transferencia";
        $mediosdepago[$j]['total'] = $transferencia;
      }
      if($cheque > 0){
        $j = $j + 1;
        $mediosdepago[$j]['medio'] = "Cheque";
        $mediosdepago[$j]['total'] = $cheque;
      }
      if($tarjeta_credito > 0){
        $j = $j + 1;
        $mediosdepago[$j]['medio'] = "T.crédito";
        $mediosdepago[$j]['total'] = $tarjeta_credito;
      }
      if($tarjeta_debito > 0){
        $j = $j + 1;
        $mediosdepago[$j]['medio'] = "T.débito";
        $mediosdepago[$j]['total'] = $tarjeta_debito;
      }
      if($pse > 0){
        $j = $j + 1;
        $mediosdepago[$j]['medio'] = "Pse";
        $mediosdepago[$j]['total'] = $pse;
      }


    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['id_act'] = $id_act;
    $data['nombre'] = $nombre;
    $data['identificacion_cli'] = $identificacion_cli;
    $data['fecha'] = $fecha;
    $data['descripcion_tip'] = $descripcion_tip;
    $data['num_escritura'] = $num_escritura;
    $data['id_radica'] = $id_radica;
    $data['mediosdepago'] = $mediosdepago;
    //$data['efectivo'] = $efectivo;
   // $data['transferencia'] = $transferencia;
   // $data['cheque'] = $cheque;
    //$data['tarjeta_credito'] = $tarjeta_credito;
    $data['num_cheque'] = $num_cheque;
    $data['num_tarjetacredito'] = $num_tarjetacredito;
    $data['nombre_ban'] = $nombre_ban;
    $data['total_recibido'] = $total_recibido;
    $data['total_en_letras'] = $total_en_letras;


    $html = view('pdf.acta_deposito',$data)->render();

    $namefile = 'actadeposito_'.$id_act.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        "format" => [216, 140],//TODO: Media Carta
        //"format" => 'Letter',
        'margin_bottom' => 1,
      ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");
  }


   public function ReciboGastosNotaria(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $id_gas = $request->session()->get('numrecibo');
    $fecha_impresion = date("d/m/Y");

    $Gastos_notaria = Gastos_notaria::find($id_gas);
    
    $autorizado_por = $Gastos_notaria->autorizado_por;
    $reembolsado_a = $Gastos_notaria->reembolsado_a;
    $fecha_gas = $Gastos_notaria->fecha_gas;

    $concepto_gas = $Gastos_notaria->concepto_gas;
    $valor_gas = $Gastos_notaria->valor_gas;
    $valor_letras = $this->convertir($valor_gas);
    $valor_letras = mb_strtoupper($valor_letras);
    
    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['id_gas'] = $id_gas;
    $data['autorizado_por'] = $autorizado_por;
    $data['reembolsado_a'] = $reembolsado_a;
    $data['fecha_impresion'] = $fecha_impresion;
    $data['fecha_gas'] = $fecha_gas;
    $data['concepto_gas'] = $concepto_gas;
    $data['valor_letras'] = $valor_letras;
   
    $data['valor_gas'] = $valor_gas;
   
    $html = view('pdf.recibo_gasto',$data)->render();

    $namefile = 'recibo_'.$id_gas.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        "format" => [216, 140],//TODO: Media Carta
        //"format" => 'Letter',
        'margin_bottom' => 1,
      ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");
  }

  public function Informedegastos(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $nombre_reporte = $request->session()->get('nombre_reporte');
  
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');

    $fecha_reporte =  $fecha1." A ". $fecha2;
    $fecha_impresion = date("d/m/Y");

  
    $total_gastos = 0;
    $informedegastos = Gastos_notaria::whereDate('fecha_gas', '>=', $fecha1)
      ->whereDate('fecha_gas', '<=', $fecha2)
      ->get();

     
    foreach ($informedegastos as $key => $ig) {
      $total_gastos += $ig->valor_gas;
    }
     
    
    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['informedegastos'] = $informedegastos;
    $data['fecha_impresion'] = $fecha_impresion;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['total_gastos'] = $total_gastos;
    $data['nombre_reporte'] = $nombre_reporte;
   
    $html = view('pdf.informedegastos',$data)->render();

    $namefile = 'informedegastos'.$fecha_impresion.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter',
        'margin_bottom' => 1,
      ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");
  }

  
  public function PdfEstadisticoNotarial(Request $request){
    $notaria = Notaria::find(1);
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    //$anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $anio_trabajo = date("Y", strtotime($fecha1));
    $fecha_impresion = date("d/m/Y");

    $nombre_reporte = $request->session()->get('nombre_reporte');

    
    /*----------  Consulta Radicaciones con un solo acto  ----------*/


    $raw1 = \DB::raw("id_radica");
    $subquery = Estadisticonotarial_view::whereBetween('fecha', [$fecha1, $fecha2])
    ->groupBy('id_radica')
    ->havingRaw('count(*) = 1')
    ->select($raw1)
    ->get()
    ->toArray();


    $estadistico = [];
    foreach ($subquery as $key => $sub) {
      $id_radica = $sub['id_radica'];
      $consulta = Estadisticonotarial_view::whereBetween('fecha', [$fecha1, $fecha2])
      ->where('id_radica', [$id_radica])->get()->toArray();


      foreach ($consulta as $key2 => $con) {
        $estadistico[$key]['id_actoperrad'] = $con['id_actoperrad'];
        $estadistico[$key]['id_radica'] = $con['id_radica'];
        $estadistico[$key]['fecha'] = $con['fecha'];
        $estadistico[$key]['id_codigoagru'] = $con['id_codigoagru'];
        $estadistico[$key]['id_gru'] = $con['id_gru'];
        $estadistico[$key]['derechos'] = $con['derechos'];
      }

    }



    /*----------  Consulta Radicaciones con varios actos  ----------*/


    $raw2 = \DB::raw("id_radica");
    $subquery2 = Estadisticonotarial_view::whereBetween('fecha', [$fecha1, $fecha2])
    ->groupBy('id_radica')
    ->havingRaw('count(*) > 1')
    ->select($raw2)
    ->get()
    ->toArray();



    $estadistico_repe = [];
    foreach ($subquery2 as $key => $sub2) {
      $id_radica = $sub2['id_radica'];
      $consulta2 = Estadisticonotarial_view::whereBetween('fecha', [$fecha1, $fecha2])
      ->where('id_radica', [$id_radica])->get()->toArray();

      foreach ($consulta2 as $key2 => $con2) {
        $estadistico_repe[$key]['id_actoperrad'] = $con2['id_actoperrad'];
        $estadistico_repe[$key]['id_radica'] = $con2['id_radica'];
        $estadistico_repe[$key]['fecha'] = $con2['fecha'];
        $estadistico_repe[$key]['id_codigoagru'] = $con2['id_codigoagru'];
        $estadistico_repe[$key]['id_gru'] = $con2['id_gru'];
        $estadistico_repe[$key]['derechos'] = $con2['derechos'];
      }

    }


    $cantventa = 0;
    $ingreventas = 0;
    $cantpermuta = 0;
    $ingrepermuta = 0;
    $canthipoteca = 0;
    $ingrehipoteca = 0;
    $cantcancelhipo = 0;
    $ingrecancelhipo = 0;
    $cantventaconhipo = 0;
    $ingreventaconhipo = 0;
    $cantconstisocie = 0;
    $ingreconstisocie = 0;
    $cantliqsocie = 0;
    $ingreliqsocie = 0;
    $cantreforsocial = 0;
    $ingrereforsocial = 0;
    $cantsuce = 0;
    $ingresuce = 0;
    $cantreglaproprefor = 0;
    $ingrereglaprorefor = 0;
    $cantproto = 0;
    $ingreproto = 0;
    $cantmatri = 0;
    $ingrematri = 0;
    $cantcorrecregis = 0;
    $ingrecorrecregis = 0;
    $cantvis = 0;
    $ingrevis = 0;
    $cantdivor = 0;
    $ingredivor = 0;
    $cantmismosexo = 0;
    $ingremismosexo = 0;
    $cantotros = 0;
    $ingreotros = 0;
    $cantvip = 0;
    $ingrevip = 0;


    foreach ($estadistico as $key => $est) {
      $id_radica = $est['id_radica'];
      $id_codigoagru = $est['id_codigoagru'];
      $ingresos = round($est['derechos']);

      if($id_codigoagru == 1){
        $cantventa += 1;
        $ingreventas += $ingresos;
      }else if($id_codigoagru == 2){
        $cantpermuta++;
        $ingrepermuta += $ingresos;
      }else if($id_codigoagru == 3){
        $canthipoteca++;
        $ingrehipoteca += $ingresos;
      }else if($id_codigoagru == 4){
        $cantcancelhipo++;
        $ingrecancelhipo += $ingresos;
      }else if($id_codigoagru == 5){
        $cantventaconhipo++;
        $ingreventaconhipo += $ingresos;
      }else if($id_codigoagru == 6){
        $cantconstisocie++;
        $ingreconstisocie += $ingresos;
      }else if($id_codigoagru == 7){
        $cantliqsocie++;
        $ingreliqsocie += $ingresos;
      }else if($id_codigoagru == 8){
        $cantreforsocial++;
        $ingrereforsocial += $ingresos;
      }else if($id_codigoagru == 9){
        $cantsuce++;
        $ingresuce += $ingresos;
      }else if($id_codigoagru == 10){
        $cantreglaproprefor++;
        $ingrereglaprorefor += $ingresos;
      }else if($id_codigoagru == 11){
        $cantproto++;
        $ingreproto += $ingresos;
      }else if($id_codigoagru == 12){
        $cantmatri++;
        $ingrematri += $ingresos;
      }else if($id_codigoagru == 13){
        $cantcorrecregis++;
        $ingrecorrecregis += $ingresos;
      }else if($id_codigoagru == 14){
        $cantvis++;
        $ingrevis += $ingresos;
      }else if($id_codigoagru == 15){
        $cantdivor++;
        $ingredivor += $ingresos;
      }else if($id_codigoagru == 16){
        $cantmismosexo++;
        $ingremismosexo += $ingresos;
      }else if($id_codigoagru == 17){
        $cantotros++;
        $ingreotros += $ingresos;
      }else if($id_codigoagru == 18){
        $cantvip++;
        $ingrevip += $ingresos;
      }
    }//Fin del for estadisticonotarial
    


    foreach ($estadistico_repe as $key => $esr) {
      $id_radica = $esr['id_radica'];
      $ingresos = round($esr['derechos']);
      $estadistico_rad = Estadisticonotarial_view::whereBetween('fecha', [$fecha1, $fecha2])
      ->where('id_radica', [$id_radica])
      ->get()
      ->toArray();



      $i = 0;
      unset($arr_codigo);
      $arr_codigo = array();
      
      foreach ($estadistico_rad as $key => $num) {
        $arr_codigo[$i] = $num['id_codigoagru'];
        $i++;
      }


      

      if (in_array("1", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo)) {

        $cantventa++;
        $ingreventas += $ingresos;

      }

      if (in_array("2", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("6", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("8", $arr_codigo) && !in_array("10", $arr_codigo) && !in_array("11", $arr_codigo) && !in_array("12", $arr_codigo) && !in_array("13", $arr_codigo) && !in_array("15", $arr_codigo) && !in_array("16", $arr_codigo) ) {

        $cantpermuta++;
        $ingrepermuta += $ingresos;

      }

      if (in_array("3", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {

        $canthipoteca++;
        $ingrehipoteca += $ingresos;

      }

      if (in_array("4", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("1", $arr_codigo)) {

        $cantcancelhipo++;
        $ingrecancelhipo += $ingresos;

      }

      if (in_array("1", $arr_codigo) && !in_array("18", $arr_codigo) && in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("14", $arr_codigo)) {

        $cantventaconhipo++;
        $ingreventaconhipo += $ingresos;

      }

      if (in_array("6", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

        $cantconstisocie++;
        $ingreconstisocie += $ingresos;

      }


      if (in_array("7", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo ) && !in_array("1", $arr_codigo) ) {

        $cantliqsocie++;
        $ingreliqsocie += $ingresos;
      }

      if (in_array("8", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("1", $arr_codigo) ) {

        $cantreforsocial++;
        $ingrereforsocial += $ingresos;

      }

      if (in_array("9", $arr_codigo) ) {

        $cantsuce++;
        $ingresuce += $ingresos;

      }


      if (in_array("10", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("1", $arr_codigo)) {

        $cantreglaproprefor++;
        $ingrereglaprorefor += $ingresos;

      }

      if (in_array("11", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("1", $arr_codigo)) {

        $cantproto++;
        $ingreproto += $ingresos;

      }

      if (in_array("12", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo)  && !in_array("1", $arr_codigo)) {

        $cantmatri++;
        $ingrematri += $ingresos;


      }

      if (in_array("13", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

        $cantcorrecregis++;
        $ingrecorrecregis += $ingresos;

      }

      if (in_array("14", $arr_codigo)  && !in_array("9", $arr_codigo) ) {

        $cantvis++;
        $ingrevis += $ingresos;

      }


      if (in_array("15", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

        $cantdivor++;
        $ingredivor += $ingresos;

      }

      if (in_array("16", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

        $cantmismosexo++;
        $ingremismosexo += $ingresos;

      }


      if (in_array("17", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("1", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("6", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("8", $arr_codigo) && !in_array("10", $arr_codigo) && !in_array("11", $arr_codigo) && !in_array("12", $arr_codigo) && !in_array("13", $arr_codigo) && !in_array("15", $arr_codigo) && !in_array("16", $arr_codigo)) {

        $cantotros++;
        $ingreotros += $ingresos;


      }


      if (in_array("18", $arr_codigo)  && !in_array("9", $arr_codigo) ) {
        $cantvip++;
        $ingrevip += $ingresos;

      }

    }


    $totalcantidad = $cantventa + $cantpermuta + $canthipoteca +
    $cantcancelhipo + $cantventaconhipo + $cantconstisocie +
    $cantliqsocie + $cantreforsocial + $cantsuce + $cantreglaproprefor +
    $cantproto + $cantmatri + $cantcorrecregis + $cantvis + $cantdivor +
    $cantmismosexo + $cantotros + $cantvip;
    

    $totalingresos = $ingreventas + $ingrepermuta + $ingrehipoteca +
    $ingrecancelhipo + $ingreventaconhipo + $ingreconstisocie +
    $ingreliqsocie + $ingrereforsocial + $ingresuce + $ingrereglaprorefor +
    $ingreproto + $ingrematri + $ingrecorrecregis + $ingrevis + $ingredivor +
    $ingremismosexo + $ingreotros + $ingrevip;
    //$totalingresos = $totalingresos;

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha1'] = $fecha1;
    $data['fecha2'] = $fecha2;
    $data['fecha_impresion'] = $fecha_impresion;
    $data['nombre_reporte'] = $nombre_reporte;
    $data['cantventa'] = $cantventa;
    $data['ingreventas'] = $ingreventas;
    $data['cantpermuta'] = $cantpermuta;
    $data['ingrepermuta'] = $ingrepermuta;
    $data['canthipoteca'] = $canthipoteca;
    $data['ingrehipoteca'] = $ingrehipoteca;
    $data['cantcancelhipo'] = $cantcancelhipo;
    $data['ingrecancelhipo'] = $ingrecancelhipo;
    $data['cantventaconhipo'] = $cantventaconhipo;
    $data['ingreventaconhipo'] = $ingreventaconhipo;
    $data['cantconstisocie'] = $cantconstisocie;
    $data['ingreconstisocie'] = $ingreconstisocie;
    $data['cantliqsocie'] = $cantliqsocie;
    $data['ingreliqsocie'] = $ingreliqsocie;
    $data['cantreforsocial'] = $cantreforsocial;
    $data['ingrereforsocial'] = $ingrereforsocial;
    $data['cantsuce'] = $cantsuce;
    $data['ingresuce'] = $ingresuce;
    $data['cantreglaproprefor'] = $cantreglaproprefor;
    $data['ingrereglaprorefor'] = $ingrereglaprorefor;
    $data['cantproto'] = $cantproto;
    $data['ingreproto'] = $ingreproto;
    $data['cantmatri'] = $cantmatri;
    $data['ingrematri'] = $ingrematri;
    $data['cantcorrecregis'] = $cantcorrecregis;
    $data['ingrecorrecregis'] = $ingrecorrecregis;
    $data['cantvis'] = $cantvis;
    $data['ingrevis'] = $ingrevis;
    $data['cantdivor'] = $cantdivor;
    $data['ingredivor'] = $ingredivor;
    $data['cantmismosexo'] = $cantmismosexo;
    $data['ingremismosexo'] = $ingremismosexo;
    $data['cantotros'] = $cantotros;
    $data['ingreotros'] = $ingreotros;
    $data['cantvip'] = $cantvip;
    $data['ingrevip'] = $ingrevip;

    $data['totalingresos'] = $totalingresos;
    $data['totalcantidad'] = $totalcantidad;



    $html = view('pdf.estadisticonotarial',$data)->render();

    $fecha_reporte = date("Y/m/d");
    $namefile = 'estadistico_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
      "format" => 'Letter-L',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

  }

  public function PdfLibroIndiceNotarial(Request $request){
    $notaria = Notaria::find(1);
    //$anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
   
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fecha_impresion = date("d/m/Y");
    $anio_trabajo = date("Y", strtotime($fecha1));

    $fecha = $fecha1.' A '.$fecha2;
     $parapdf = '';
    $resultadoFinal = [];

    $ordenar = $request->session()->get('ordenar');
    if($ordenar == 'porescritura'){ //Ordena por escritura
       $parapdf = '1';
      $raw1 = \DB::raw("MIN(id_radica) AS id_radica, MIN(id_actperrad) AS id_actperrad, MIN(fecha) AS fecha, MIN(num_esc) AS num_esc, MIN(identificacion_otor) AS identificacion_otor, MIN(otorgante) AS otorgante, MIN(identificacion_comp) AS identificacion_comp, MIN(compareciente) AS compareciente, MIN(acto) AS acto");
      $libroindice = Libroindice_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->groupBy('num_esc')
      ->orderBy('num_esc')
      ->select($raw1)
      ->get()
      ->toArray();

      $resultadoFinal = $libroindice;


    }elseif($ordenar == 'pornombre'){//Ordena por nombre

          $alfabeto = range('A', 'Z');
          $parapdf = '2';

          foreach ($alfabeto as $letra) {
            $libroindice = Libroindice_view::
            whereDate('fecha', '>=', $fecha1)
            ->whereDate('fecha', '<=', $fecha2)
            ->where('otorgante', 'like', $letra . '%')
            ->selectRaw('MIN(otorgante) AS otorgante, MIN(fecha) AS fecha, MIN(num_esc) AS num_esc, MIN(compareciente) AS compareciente,  SUBSTRING(MIN(acto), 1, 30) AS acto')
            ->groupBy('num_esc')
            ->orderBy('num_esc')
            //->orderBy('otorgante')
            ->orderBy('fecha')
            ->get()->toArray();
            $resultadoFinal[$letra] = $libroindice;
          }

          $resultadoFinal = array_merge(...array_values($resultadoFinal));
    }else if($ordenar == 'pornumescritura'){ //Ordena por escritura
      $parapdf = '3';
      $raw1 = \DB::raw("(id_radica) AS id_radica, (id_actperrad) AS id_actperrad, (fecha) AS fecha, (num_esc) AS num_esc, (identificacion_otor) AS identificacion_otor, (otorgante) AS otorgante, (identificacion_comp) AS identificacion_comp, (compareciente) AS compareciente, (acto) AS acto");
      $libroindice = Actos_notariales_escritura_view::
      whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->orderBy('num_esc')
      ->select($raw1)
      ->get()
      ->toArray();
      $resultadoFinal = $libroindice;
      }
  
   $nombre_reporte = $request->session()->get('nombre_reporte');

   $data['nit'] = $nit;
   $data['nombre_nota'] = $nombre_nota;
   $data['direccion_nota'] = $direccion_nota;
   $data['telefono_nota'] = $telefono_nota;
   $data['email'] = $email;
   $data['nombre_notario'] = $nombre_notario;
   $data['fecha_reporte'] = $fecha;
   $data['fecha_impresion'] = $fecha_impresion;
   $data['libroindice'] = $resultadoFinal;
   $data['nombre_reporte'] = $nombre_reporte;

  
  if($parapdf == '2'){
    ini_set('pcre.backtrack_limit', 10000000);
    $html = view('pdf.libroindice',$data)->render();
    $namefile = 'libroindice_'.$fecha_impresion.'.pdf';
  }else if($parapdf == '1'){
    ini_set('pcre.backtrack_limit', 10000000);
     $html = view('pdf.librorelacion',$data)->render();
    $namefile = 'librorelacion_'.$fecha_impresion.'.pdf';
  }else if($parapdf == '3'){
    ini_set('pcre.backtrack_limit', 10000000);
     $html = view('pdf.librorelacion',$data)->render();
    $namefile = 'librorelacion_'.$fecha_impresion.'.pdf';     
   }

   $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
   $fontDirs = $defaultConfig['fontDir'];

   $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
   $fontData = $defaultFontConfig['fontdata'];
   $mpdf = new Mpdf([
    'fontDir' => array_merge($fontDirs, [
      public_path() . '/fonts',
    ]),
    'fontdata' => $fontData + [
      'arial' => [
        'R' => 'arial.ttf',
        'B' => 'arialbd.ttf',
      ],
    ],
    'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
    "format" => 'Letter-L',
    'margin_bottom' => 10,//espacio inferior en mm
  ]);



    // Configurar estilos y alineación del encabezado
        $header ='
            <table width="100%">
            <tr>
            <td align="center" colspan="2" style="padding: 0;">
            <p><h2>'.$nombre_nota.'</h2>
            
            <b>'.$nombre_reporte.' -  '.$anio_trabajo.'</b></p>
            </td>
            <td colspan="2" style="padding: 0;">
            <table width="100%">
            <tr>
            <td align="right" colspan="2" style="padding: 0;">
            <img src="' . asset('images/logon13.png') . '" alt="Logo" style="float: right; margin-right: 10px;">
            </td>
            </tr>
            </table>
            </td>
            </tr>
            </table>
            <hr>
            ';


        // Configurar encabezado en el PDF
        $mpdf->SetHTMLHeader($header);
       
        $mpdf->SetTopMargin(42);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($namefile,"I");

 }

 public function PdfRelacionNotaCredito(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
     
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');

             
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

      $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY

      
      $cajadiario = Relacion_nota_credito_print_view::whereDate('fecha_nc', '>=', $fecha1)
      ->whereDate('fecha_nc', '<=', $fecha2)
      ->where('anio_esc', '=', $anio_trabajo)
       ->where('nota_credito', true)
        ->orderBy('id_ncf')
      ->get()
      ->toArray();
   

    $contcajadiario = count ($cajadiario, 0);
    $total_derechos = 0;
    $total_conceptos = 0;
    $total_recaudo = 0;
    $total_aporteespecial = 0;
    $impuesto_timbre = 0;
    $total_retencion = 0;
    $total_iva = 0;
    $total = 0;
    $total_gravado = 0;
    $total_reteiva = 0;
    $total_reteica = 0;
    $total_retertf = 0;

    foreach ($cajadiario as $key => $value) {
      $total_derechos = $value['derechos'] + $total_derechos;
      $total_conceptos =$value['conceptos'] + $total_conceptos;
      $total_recaudo = $value['recaudo'] + $total_recaudo;
      $total_aporteespecial = $value['aporteespecial'] + $total_aporteespecial;
      $impuesto_timbre = $value['impuesto_timbre'] + $impuesto_timbre;
      $total_retencion = $value['retencion'] + $total_retencion;
      $total_iva =$value['iva'] + $total_iva;
      $total = $value['total'] + $total;
      $total_gravado = $value['total_gravado'] + $total_gravado;
      $total_reteiva =$value['reteiva'] + $total_reteiva;
      $total_reteica = $value['reteica'] + $total_reteica;
      $total_retertf = $value['retertf'] + $total_retertf;
    }
  
   
    $nombre_reporte = $request->session()->get('nombre_reporte');

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['cajadiario'] = $cajadiario;
    $data['contcajadiario'] = $contcajadiario;
    $data['total_derechos'] = round($total_derechos);
    $data['total_conceptos'] = $total_conceptos;
    $data['total_ingresos'] = round($total_derechos + $total_conceptos);
    $data['total_recaudo'] = $total_recaudo;
    $data['total_aporteespecial'] = $total_aporteespecial;
    $data['impuesto_timbre'] = $impuesto_timbre;
    $data['total_retencion'] = $total_retencion;
    $data['total_iva'] = round($total_iva);
    $data['total'] = $total;
    $data['total_gravado'] = $total_gravado;
    $data['total_reteiva'] = $total_reteiva;
    $data['total_reteica'] = $total_reteica;
    $data['total_retertf'] = $total_retertf;
   
    $data['fecha_reporte'] = $fecha_reporte;
    $data['fecha_impresion'] = $fecha_impresion;
   
    $data['nombre_reporte'] = $nombre_reporte;
 

    $html = view('pdf.relacionnotacredito',$data)->render();

    $namefile = 'relacion_nota_credito_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        //"format" => [216, 140],//Media Carta
      "format" => 'Letter-L',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

}

public function PdfInformeCartera(Request $request){
  $notaria = Notaria::find(1);
  $anio_trabajo = $notaria->anio_trabajo;
  $nit = $notaria->nit;
  $nombre_nota = strtoupper($notaria->nombre_nota);
  $direccion_nota = $notaria->direccion_nota;
  $telefono_nota = $notaria->telefono_nota;
  $email = $notaria->email;
  $nombre_notario = $notaria->nombre_notario;
  $identificacion_not = $notaria->identificacion_not;
  
  $fecha1 = $request->session()->get('fecha1');
  $fecha2 = $request->session()->get('fecha2');
  $opcionreporte = $request->session()->get('opcionreporte');
  

  $fecha_reporte =  $fecha1." A ". $fecha2;
  $fecha_impresion = date("d/m/Y");

  $identificacion_cli = $request->session()->get('identificacion_cli');
  $ordenar = $request->session()->get('ordenar');
    if($ordenar == 'porfecha'){ //por fecha

      if($opcionreporte == 'maycero'){
         $informecartera = Informe_cartera_view::whereDate('fecha_abono', '>=', $fecha1)
          ->whereDate('fecha_abono', '<=', $fecha2)
          ->where('nota_credito', false)
          ->where('saldo_fact', '>=', 1)
          ->orderBy('id_fact')
          ->get()
          ->toArray();
      }else if($opcionreporte == 'completo'){
         $informecartera = Informe_cartera_view::whereDate('fecha_abono', '>=', $fecha1)
          ->whereDate('fecha_abono', '<=', $fecha2)
          ->where('nota_credito', false)
          ->orderBy('id_fact')
          ->get()
          ->toArray();
      }
    }elseif($ordenar == 'porcliente'){//por cliente
      if($opcionreporte == 'maycero'){
        $informecartera = Informe_cartera_view::where('identificacion_cli', $identificacion_cli)
          ->where('nota_credito', false)
          ->where('saldo_fact', '>=', 1)
          ->orderBy('id_fact')->get()->toArray();
      }else if($opcionreporte == 'completo'){
        $informecartera = Informe_cartera_view::where('identificacion_cli', $identificacion_cli)
          ->where('nota_credito', false)
          ->orderBy('id_fact')->get()->toArray();
      }
      
    }else if($ordenar == 'facturasactivas'){
       $informecartera = Informe_cartera_view::
      where('nota_credito', false)
      ->where('saldo_fact', '>=', 1)
      ->orderBy('id_fact')->get()
      ->toArray();
    }

    $total_pago = 0;
    $total_saldo = 0;
    foreach ($informecartera as $key => $inf) {
      $total_saldo = $inf['abono_car'] + $total_saldo;
    }

    $continformecartera = count ($informecartera, 0);

    $nombre_reporte = $request->session()->get('nombre_reporte');

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['fecha_impresion'] = $fecha_impresion;
    $data['informecartera'] = $informecartera;
    $data['continformecartera'] = $continformecartera;
    $data['nombre_reporte'] = $nombre_reporte;
    $data['total_pago'] = $total_pago;
    $data['total_saldo'] = $total_saldo;

    if($ordenar == 'facturasactivas'){
      $total_saldo = 0;
      $total_factura = 0;
      foreach ($informecartera as $key => $inf) {
      $total_saldo = $inf['saldo_fact'] + $total_saldo;
      $total_factura = $inf['total_fact'] + $total_factura;
       $data['total_saldo'] = $total_saldo;
      $data['total_factura'] = $total_factura;
    }
      $html = view('pdf.informecarterafacturasactivas',$data)->render();

    }else{
      $html = view('pdf.informecartera',$data)->render();
    }

    

    $namefile = 'informecartera_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
      "format" => 'Letter-L',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

  }

  public function PdfAbonosCartera(Request $request){
    $notaria = Notaria::find(1);
    $nit = $notaria->nit;
    $prefijo = $notaria->prefijo_fact;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $fecha_reporte = date("d/m/Y");
    $id_fact = $request->session()->get('abonos_fact');

    $abonos = Cartera_fact::where('id_fact', $id_fact)
    ->where('prefijo', $prefijo)
    ->orderBy('created_at')
    ->get()
    ->toArray();
    
    $total_abono = 0;
    foreach ($abonos as $key => $abn) {
      $total_abono = $abn['abono_car'] + $total_abono;
    }

    $contabonos = count ($abonos, 0);

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['abonos'] = $abonos;
    $data['contabonos'] = $contabonos;
    $data['total_abono'] = $total_abono;
    $data['id_fact'] = $id_fact;
    $data['id_cliente'] = $request->session()->get('ident');
    $data['cliente'] = $request->session()->get('cli');
    $html = view('pdf.abonoscartera',$data)->render();

    $namefile = 'abonoscartera_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
      "format" => 'Letter',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

  }

  public function PdfAbonosCarteraCajaRapida(Request $request){
    $notaria = Notaria::find(1);
    $nit = $notaria->nit;
    $prefijo = $notaria->prefijo_facturarapida;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $fecha_reporte = date("Y/m/d");
    $id_fact = $request->session()->get('abonos_fact');

    $abonos = Cartera_fact_caja_rapida::where('id_fact', $id_fact)
    ->where('prefijo', $prefijo)
    ->orderBy('created_at')
    ->get()
    ->toArray();
    
    $total_abono = 0;
    foreach ($abonos as $key => $abn) {
      $total_abono = $abn['abono_car'] + $total_abono;
    }

    $contabonos = count ($abonos, 0);

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['abonos'] = $abonos;
    $data['contabonos'] = $contabonos;
    $data['total_abono'] = $total_abono;
    $data['id_fact'] = $id_fact;
    $data['id_cliente'] = $request->session()->get('ident');
    $data['cliente'] = $request->session()->get('cli');
    $html = view('pdf.abonoscartera',$data)->render();

    $namefile = 'abonoscartera_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
      "format" => 'Letter',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

  }

  public function PdfComprobante_Egreso(Request $request){
    $notaria = Notaria::find(1);
    $nit = $notaria->nit;
    $prefijo = $notaria->prefijo_fact;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $fecha_reporte = date("Y/m/d");
    $id_egr = $request->session()->get('id_egr');
    $Egreso = Egreso_acta_deposito::where('id_egr', $id_egr)
    ->get()
    ->toArray();

    foreach ($Egreso as $key => $eg) {
      $id_egreso = $eg['id_egr'];
      $id_acta = $eg['id_act'];
      $valor_egreso = $eg['egreso_egr'];
      $fecha_egreso = $eg['fecha_egreso'];
      $observaciones = $eg['observaciones_egr'];
    }

    $Acta_deposito = Actas_deposito_view::where('id_act', $id_acta)
    ->get()
    ->toArray();

    foreach ($Acta_deposito as $key => $ad) {
      $cliente = $ad['nombre'];
      $identificacion = $ad['identificacion_cli'];
    }


    
    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['id_egr'] = $id_egreso;
    $data['id_acta'] = $id_acta;
    $data['valor_egreso'] = $valor_egreso;
    $data['fecha_egreso'] = $fecha_egreso;
    $data['observaciones'] = $observaciones;
    $data['cliente'] = $cliente;
    $data['identificacion'] = $identificacion;

    $html = view('pdf.ComprobanteEgreso',$data)->render();

    $namefile = 'ComprobanteEgreso_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        "format" => [216, 140],//Media Carta
        'margin_bottom' => 10,
      ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

  }

  private function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
    foreach($array as $val) {
      if (!in_array($val[$key], $key_array)) {
        $key_array[$i] = $val[$key];
        $temp_array[$i] = $val;
      }
      $i++;
    }
    return $temp_array;
  }

  
  public function PdfInformeRecaudos(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
   
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');

    $fecha_reporte =  $fecha1." A ". $fecha2;
    $fecha_impresion = date("d/m/Y");

    $fecha = $fecha1.' A '.$fecha2;

    $raw1 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
    $rango1 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->where('cuantia','>=', 0)
    ->where('cuantia','<=', 100000000)
    ->groupBy('escr')
    ->select($raw1)->get()->toArray();

    
    $raw2 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
    $rango2 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->where('cuantia','>=', 100000001)
    ->where('cuantia','<=', 300000000)
    ->groupBy('escr')
    ->select($raw2)->get()->toArray();



    $raw3 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
    $rango3 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->where('cuantia','>=', 300000001)
    ->where('cuantia','<=', 500000000)
    ->groupBy('escr')
    ->select($raw3)->get()->toArray();


    
    $raw4 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
    $rango4 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->where('cuantia','>=', 500000001)
    ->where('cuantia','<=', 1000000000)
    ->groupBy('escr')
    ->select($raw4)->get()->toArray();

    

    $raw5 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
    $rango5 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->where('cuantia','>=', 1000000001)
    ->where('cuantia','<=', 1500000000)
    ->groupBy('escr')
    ->select($raw5)->get()->toArray();
    

    $raw6 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
    $rango6 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->where('cuantia','>', 1500000000)
    ->groupBy('escr')
    ->select($raw6)->get()->toArray();

    

    $raw7 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(super + fondo) AS total");
    $sincuantia = Recaudos_sincuantia_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->groupBy('escr')
    ->select($raw7)->get()->toArray();

    
    $raw8 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(super + fondo) AS total");
    $excenta = Recaudos_excenta_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->groupBy('escr')
    ->select($raw8)->get()->toArray();

    $raw9 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(super + fondo) AS total");
    $sincuantiaexcenta = Recaudos_sincuantia_excenta_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<', $fecha2)
    ->where('nota_periodo', '<>', 0)
    ->groupBy('escr')
    ->select($raw9)->get()->toArray();

    /*----------  Elimina repetidas entre sincuantia y excentas  ----------*/
    
    foreach ($sincuantia as $i => $sinc) {
      foreach ($excenta as $j => $exc) {
        if($sinc['escr'] == $exc['escr']){
          unset($sincuantia[$i]);
        }
      }
    }
    
    /*----------  Concatena excenta con sncuantiaexcenta  ----------*/
    
    $excenta = array_merge($excenta, $sincuantiaexcenta);

    foreach ($excenta as $key => $value) {
      if($value['escr'] == 0){
        unset($excenta[$key]);
      }
    }

       # ====================================================================
      # =           Identifica excentas que van para con cuantia           =
      # ====================================================================
    

      $tarifa = Tarifa::find(8);//:Tarifa de Recaudo Super y Fondo
      $valor2 = $tarifa['valor2'] / 2;
      $valor3 = $tarifa['valor3'] / 2;
      $valor4 = $tarifa['valor4'] / 2;
      $valor5 = $tarifa['valor5'] / 2;
      $valor6 = $tarifa['valor6'] / 2;
      $valor7 = $tarifa['valor7'] / 2;


      $array_rango1 = array();
      $array_rango2 = array();
      $array_rango3 = array();
      $array_rango4 = array();
      $array_rango5 = array();
      $array_rango6 = array();
      $array_rango7 = array();
      foreach ($excenta as $key => $value) {
        if($value['super'] == $valor2){
          $array_rango1[$key]['escr'] = $value['escr'];
          $array_rango1[$key]['super'] = $value['super'];
          $array_rango1[$key]['fondo'] = $value['fondo'];
          $array_rango1[$key]['total'] = $value['super'] + $value['fondo'];
          unset($excenta[$key]);
        }

        if($value['super'] == $valor3){
          $array_rango2[$key]['escr'] = $value['escr'];
          $array_rango2[$key]['super'] = $value['super'];
          $array_rango2[$key]['fondo'] = $value['fondo'];
          $array_rango2[$key]['total'] = $value['super'] + $value['fondo'];
          unset($excenta[$key]);
        }

        if($value['super'] == $valor4){
          $array_rango3[$key]['escr'] = $value['escr'];
          $array_rango3[$key]['super'] = $value['super'];
          $array_rango3[$key]['fondo'] = $value['fondo'];
          $array_rango3[$key]['total'] = $value['super'] + $value['fondo'];
          unset($excenta[$key]);
        }

        if($value['super'] == $valor5){
          $array_rango4[$key]['escr'] = $value['escr'];
          $array_rango4[$key]['super'] = $value['super'];
          $array_rango4[$key]['fondo'] = $value['fondo'];
          $array_rango4[$key]['total'] = $value['super'] + $value['fondo'];
          unset($excenta[$key]);
        }

        if($value['super'] == $valor6){
          $array_rango5[$key]['escr'] = $value['escr'];
          $array_rango5[$key]['super'] = $value['super'];
          $array_rango5[$key]['fondo'] = $value['fondo'];
          $array_rango5[$key]['total'] = $value['super'] + $value['fondo'];
          unset($excenta[$key]);
        }

        if($value['super'] == $valor7){
          $array_rango6[$key]['escr'] = $value['escr'];
          $array_rango6[$key]['super'] = $value['super'];
          $array_rango6[$key]['fondo'] = $value['fondo'];
          $array_rango6[$key]['total'] = $value['super'] + $value['fondo'];
          unset($excenta[$key]);
        }
      }

      

      $rango1 = array_merge($rango1, $array_rango1);
      $rango2 = array_merge($rango2, $array_rango2);
      $rango3 = array_merge($rango3, $array_rango3);
      $rango4 = array_merge($rango4, $array_rango4);
      $rango5 = array_merge($rango5, $array_rango5);
      $rango6 = array_merge($rango6, $array_rango6);

      $rango1 = $this->unique_multidim_array($rango1,'escr');
      $rango2 = $this->unique_multidim_array($rango2,'escr');
      $rango3 = $this->unique_multidim_array($rango3,'escr');
      $rango4 = $this->unique_multidim_array($rango4,'escr');
      $rango5 = $this->unique_multidim_array($rango5,'escr');
      $rango6 = $this->unique_multidim_array($rango6,'escr');

      
      # ==============================================================================
      # =           Elimna repetidas en rangos entre excentas y sincuantia           =
      # ==============================================================================
      
      /*----------  Rango1  ----------*/

      foreach ($excenta as $i => $exc) {
        foreach ($rango1 as $j => $rn1) {
          if($exc['escr'] == $rn1['escr']){
            unset($excenta[$i]);
          }
        }
      }

      foreach ($sincuantia as $i => $sinc) {
        foreach ($rango1 as $j => $rn1) {
          if($sinc['escr'] == $rn1['escr']){
            unset($sincuantia[$i]);
          }
        }
      }

      unset($array_rango1);
      unset($array_rango2);
      unset($array_rango3);
      unset($array_rango4);
      unset($array_rango5);
      unset($array_rango6);

      $array_rango1 = [];
      $array_rango2 = [];
      $array_rango3 = [];
      $array_rango4 = [];
      $array_rango5 = [];
      $array_rango6 = [];
      
      foreach ($sincuantia as $key => $value) {
        if($value['super'] == $valor2){
          $array_rango1[$key]['escr'] = $value['escr'];
          $array_rango1[$key]['super'] = $value['super'];
          $array_rango1[$key]['fondo'] = $value['fondo'];
          $array_rango1[$key]['total'] = $value['super'] + $value['fondo'];
          unset($sincuantia[$key]);
        }

        if($value['super'] == $valor3){
          $array_rango2[$key]['escr'] = $value['escr'];
          $array_rango2[$key]['super'] = $value['super'];
          $array_rango2[$key]['fondo'] = $value['fondo'];
          $array_rango2[$key]['total'] = $value['super'] + $value['fondo'];
          unset($sincuantia[$key]);
        }

        if($value['super'] == $valor4){
          $array_rango3[$key]['escr'] = $value['escr'];
          $array_rango3[$key]['super'] = $value['super'];
          $array_rango3[$key]['fondo'] = $value['fondo'];
          $array_rango3[$key]['total'] = $value['super'] + $value['fondo'];
          unset($sincuantia[$key]);
        }

        if($value['super'] == $valor5){
          $array_rango4[$key]['escr'] = $value['escr'];
          $array_rango4[$key]['super'] = $value['super'];
          $array_rango4[$key]['fondo'] = $value['fondo'];
          $array_rango4[$key]['total'] = $value['super'] + $value['fondo'];
          unset($sincuantia[$key]);
        }

        if($value['super'] == $valor6){
          $array_rango5[$key]['escr'] = $value['escr'];
          $array_rango5[$key]['super'] = $value['super'];
          $array_rango5[$key]['fondo'] = $value['fondo'];
          $array_rango5[$key]['total'] = $value['super'] + $value['fondo'];
          unset($sincuantia[$key]);
        }

        if($value['super'] == $valor7){
          $array_rango6[$key]['escr'] = $value['escr'];
          $array_rango6[$key]['super'] = $value['super'];
          $array_rango6[$key]['fondo'] = $value['fondo'];
          $array_rango6[$key]['total'] = $value['super'] + $value['fondo'];
          unset($sincuantia[$key]);
        }
      }



      /*----------  Elimina repetidas entre rango1 y array_rango1  ----------*/


      foreach ($rango1 as $i => $ran) {
        foreach ($array_rango1 as $j => $arran) {
          if($ran['escr'] == $arran['escr']){
            unset($rango1[$i]);
          }
        }
      }

      $rango1 = array_merge($rango1, $array_rango1);
      $rango2 = array_merge($rango2, $array_rango2);
      $rango3 = array_merge($rango3, $array_rango3);
      $rango4 = array_merge($rango4, $array_rango4);
      $rango5 = array_merge($rango5, $array_rango5);
      $rango6 = array_merge($rango6, $array_rango6);

      $rango1 = $this->unique_multidim_array($rango1,'escr');
      $rango2 = $this->unique_multidim_array($rango2,'escr');
      $rango3 = $this->unique_multidim_array($rango3,'escr');
      $rango4 = $this->unique_multidim_array($rango4,'escr');
      $rango5 = $this->unique_multidim_array($rango5,'escr');
      $rango6 = $this->unique_multidim_array($rango6,'escr');


      if($rango1){
        $ran1escr = 0;
        $ran1super =  0;
        $ran1fondo = 0;
        $ran1total = 0;
        foreach ($rango1 as $key => $rn1) {
          $ran1escr += 1;
          $ran1super +=  $rn1['super'];
          $ran1fondo += $rn1['fondo'];
          $ran1total += $rn1['total'];
        }
      }else{
        $ran1escr = 0;
        $ran1super =  0;
        $ran1fondo = 0;
        $ran1total = 0;
      }
      
      /*----------  Rango2  ----------*/

      foreach ($excenta as $i => $exc) {
        foreach ($rango2 as $j => $rn2) {
          if($exc['escr'] == $rn2['escr']){
            unset($excenta[$i]);
          }
        }
      }

      foreach ($sincuantia as $i => $sinc) {
        foreach ($rango2 as $j => $rn2) {
          if($sinc['escr'] == $rn2['escr']){
            unset($sincuantia[$i]);
          }
        }
      }

      if($rango2){
        $ran2escr = 0;
        $ran2super = 0;
        $ran2fondo = 0;
        $ran2total = 0;
        foreach ($rango2 as $key => $rn2) {
          $ran2escr += 1;
          $ran2super +=  $rn2['super'];
          $ran2fondo += $rn2['fondo'];
          $ran2total += $rn2['total'];
        }
      }else{
        $ran2escr = 0;
        $ran2super =  0;
        $ran2fondo = 0;
        $ran2total = 0;
      }


      /*----------  Rango3  ----------*/

      foreach ($excenta as $i => $exc) {
        foreach ($rango3 as $j => $rn3) {
          if($exc['escr'] == $rn3['escr']){
            unset($excenta[$i]);
          }
        }
      }

      foreach ($sincuantia as $i => $sinc) {
        foreach ($rango3 as $j => $rn3) {
          if($sinc['escr'] == $rn3['escr']){
            unset($sincuantia[$i]);
          }
        }
      }

      if($rango3){
        $ran3escr = 0;
        $ran3super = 0;
        $ran3fondo = 0;
        $ran3total = 0;
        foreach ($rango3 as $key => $rn3) {
          $ran3escr += 1;
          $ran3super +=  $rn3['super'];
          $ran3fondo += $rn3['fondo'];
          $ran3total += $rn3['total'];
        }
      }else{
        $ran3escr = 0;
        $ran3super =  0;
        $ran3fondo = 0;
        $ran3total = 0;
      }


      /*----------  Rango4  ----------*/

      foreach ($excenta as $i => $exc) {
        foreach ($rango4 as $j => $rn4) {
          if($exc['escr'] == $rn4['escr']){
            unset($excenta[$i]);
          }
        }
      }

      foreach ($sincuantia as $i => $sinc) {
        foreach ($rango4 as $j => $rn4) {
          if($sinc['escr'] == $rn4['escr']){
            unset($sincuantia[$i]);
          }
        }
      }


      if($rango4){
        $ran4escr = 0;
        $ran4super = 0;
        $ran4fondo = 0;
        $ran4total = 0;
        foreach ($rango4 as $key => $rn4) {
          $ran4escr += 1;
          $ran4super += $rn4['super'];
          $ran4fondo += $rn4['fondo'];
          $ran4total += $rn4['total'];
        }
      }else{
        $ran4escr = 0;
        $ran4super =  0;
        $ran4fondo = 0;
        $ran4total = 0;
      }


      /*----------  Rango5  ----------*/

      foreach ($excenta as $i => $exc) {
        foreach ($rango5 as $j => $rn5) {
          if($exc['escr'] == $rn5['escr']){
            unset($excenta[$i]);
          }
        }
      }

      foreach ($sincuantia as $i => $sinc) {
        foreach ($rango5 as $j => $rn5) {
          if($sinc['escr'] == $rn5['escr']){
            unset($sincuantia[$i]);
          }
        }
      }
      

      if($rango5){
        $ran5escr = 0;
        $ran5super = 0;
        $ran5fondo = 0;
        $ran5total = 0;
        foreach ($rango5 as $key => $rn5) {
          $ran5escr += 1;
          $ran5super += $rn5['super'];
          $ran5fondo += $rn5['fondo'];
          $ran5total += $rn5['total'];
        }
      }else{
        $ran5escr = 0;
        $ran5super =  0;
        $ran5fondo = 0;
        $ran5total = 0;
      }


      /*----------  Rango6  ----------*/

      foreach ($excenta as $i => $exc) {
        foreach ($rango6 as $j => $rn6) {
          if($exc['escr'] == $rn6['escr']){
            unset($excenta[$i]);
          }
        }
      }

      foreach ($sincuantia as $i => $sinc) {
        foreach ($rango6 as $j => $rn6) {
          if($sinc['escr'] == $rn6['escr']){
            unset($sincuantia[$i]);
          }
        }
      }

      if($rango6){
        $ran6escr = 0;
        $ran6super = 0;
        $ran6fondo = 0;
        $ran6total = 0;
        foreach ($rango6 as $key => $rn6) {
          $ran6escr += 1;
          $ran6super += $rn6['super'];
          $ran6fondo += $rn6['fondo'];
          $ran6total += $rn6['total'];
        }

      }else{
        $ran6escr = 0;
        $ran6super =  0;
        $ran6fondo = 0;
        $ran6total = 0;
      }

      /*----------  Excentas  ----------*/


      if($excenta){
        $excescr = 0;
        $excsuper =  0;
        $excfondo = 0;
        $exctotal = 0;
        foreach ($excenta as $key => $value) {
          $excescr += 1;
          $excsuper +=  $value['super'];
          $excfondo += $value['fondo'];
          $exctotal += $value['total'];
        }
      }else{
        $excescr = 0;
        $excsuper =  0;
        $excfondo = 0;
        $exctotal = 0;
      }


      /*----------  Sin Cuantía  ----------*/


      if($sincuantia){
        $sincescr = 0;
        $sincsuper = 0;
        $sincfondo = 0;
        $sinctotal = 0;
        foreach ($sincuantia as $key => $value) {
          $sincescr += 1;
          $sincsuper +=  $value['super'];
          $sincfondo += $value['fondo'];
          $sinctotal += $value['total'];
        }

      }else{
        $sincescr = 0;
        $sincsuper =  0;
        $sincfondo = 0;
        $sinctotal = 0;
      }


      $total_escrituras = $ran1escr + $ran2escr + $ran3escr + $ran4escr + $ran5escr + 
      $ran6escr + $sincescr + $excescr;
      $total_super =  $ran1super +  $ran2super +  $ran3super +  $ran4super +
      $ran5super +  $ran6super + $sincsuper + $excsuper;
      $total_fondo = $ran1fondo +  $ran2fondo +  $ran3fondo +  $ran4fondo +
      $ran5fondo +  $ran6fondo + $sincfondo + $excfondo;

      $total_recaudos = $ran1total + $ran2total + $ran3total + $ran4total +
      $ran5total + $ran6total + $sinctotal + $exctotal;
      

      $tarifa = Tarifa::find(8);//:Tarifa de Recaudo Super y Fondo
      $valor1 = $tarifa['valor1'];
      $valor2 = $tarifa['valor2'];
      $valor3 = $tarifa['valor3'];
      $valor4 = $tarifa['valor4'];
      $valor5 = $tarifa['valor5'];
      $valor6 = $tarifa['valor6'];
      $valor7 = $tarifa['valor7'];
      
      
      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha;
      $data['fecha_impresion'] = $fecha_impresion;


      $data['ran1escr'] = $ran1escr;
      $data['ran2escr'] = $ran2escr;
      $data['ran3escr'] = $ran3escr;
      $data['ran4escr'] = $ran4escr;
      $data['ran5escr'] = $ran5escr;
      $data['ran6escr'] = $ran6escr;

      $data['sincescr'] = $sincescr;
      $data['excescr'] = $excescr;
      $data['ran1super'] = $ran1super;
      $data['ran2super'] = $ran2super;
      $data['ran3super'] = $ran3super;
      $data['ran4super'] = $ran4super;
      $data['ran5super'] = $ran5super;
      $data['ran6super'] = $ran6super;
      $data['sincsuper'] = $sincsuper;
      $data['excsuper'] = $excsuper;
      $data['ran1fondo'] = $ran1fondo;
      $data['ran2fondo'] = $ran2fondo;
      $data['ran3fondo'] = $ran3fondo;
      $data['ran4fondo'] = $ran4fondo;
      $data['ran5fondo'] = $ran5fondo;
      $data['ran6fondo'] = $ran6fondo;
      $data['sincfondo'] = $sincfondo;
      $data['excfondo'] = $excfondo;
      $data['ran1total'] = $ran1total;
      $data['ran2total'] = $ran2total;
      $data['ran3total'] = $ran3total;
      $data['ran4total'] = $ran4total;
      $data['ran5total'] = $ran5total;
      $data['ran6total'] = $ran6total;
      $data['sinctotal'] = $sinctotal;
      $data['exctotal'] = $exctotal;
      $data['total_escrituras'] = $total_escrituras;
      $data['total_super'] = $total_super;
      $data['total_fondo'] =  $total_fondo;
      $data['total_recaudos'] = $total_recaudos;
      $data['valor1'] = $valor1;
      $data['valor2'] = $valor2;
      $data['valor3'] = $valor3;
      $data['valor4'] = $valor4;
      $data['valor5'] = $valor5;
      $data['valor6'] = $valor6;
      $data['valor7'] = $valor7;


      $html = view('pdf.informederecaudos',$data)->render();

      $namefile = 'InfoRecaudos_'.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
    }


    public function Cajadiariocajarapidaconceptospdf(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
     
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');

      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

      $raw = \DB::raw("min(id_concep) AS id_concep,
        min((nombre_concep)) AS nombre_concep,
        sum(cantidad) AS cantidad,
        sum(subtotal) AS subtotal,
        sum(iva) AS iva,
        sum(total) AS total");
      $cajadiario = Cajadiario_conceptos_rapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->groupBy('id_concep')
      ->select($raw)->get()->toArray();

      $contcajadiario = count ($cajadiario, 0);
      $subtotal = 0;
      $total_iva = 0;
      $total_fact = 0;

      foreach ($cajadiario as $key => $value) {
        $subtotal = $value['subtotal'] + $subtotal;
        $total_iva =$value['iva'] + $total_iva;
        $total_fact = $value['total'] + $total_fact;
      }

      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['cajadiario'] = $cajadiario;
      $data['contcajadiario'] = $contcajadiario;
      $data['subtotal'] = round($subtotal);
      $data['total_iva'] = $total_iva;
      $data['total_fact'] = round($total_fact);
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;

      $html = view('pdf.cajadiario_cajarapidaconceptos',$data)->render();

      $namefile = 'cajadiario_cajarapida_conceptos'.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-P',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }

    
    public function CajaDiarioCajaRapidaPdf(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
     
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

      $cajadiario = Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->get()
      ->toArray();

      /*TOTALES POR FACTURADOR*/
      $facturadores =  Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('nota_credito', false)
      ->selectRaw('MIN(name) as facturador, 
        SUM(subtotal) as subtotal, 
        SUM(total_iva) as iva,
        SUM(total_fact) as total')
      ->groupBy('id')
      ->get()->toArray();

      $contcajadiario = count ($cajadiario, 0);
      $subtotal = 0;
      $total_iva = 0;
      $total_fact = 0;

      foreach ($cajadiario as $key => $value) {
        $subtotal = $value['subtotal'] + $subtotal;
        $total_iva =$value['total_iva'] + $total_iva;
        $total_fact = $value['total_fact'] + $total_fact;
      }

    //Consulta para sacar las facturas de contado y credito
    //

      $raw1 = \DB::raw("sum(total_iva) AS total_contado_iva, sum(subtotal) AS subtotal_contado, sum(total_fact) AS total_contado_fact");
      $Contado = Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('forma_pago', '=', 'Contado')
      ->select($raw1)->get()->toArray();

      foreach ($Contado as $key => $value) {
        $total_contado_iva = $value['total_contado_iva'];
        $subtotal_contado = $value['subtotal_contado'];
        $total_contado_fact = $value['total_contado_fact'];
      }


      $raw2 = \DB::raw("sum(total_iva) AS total_credito_iva, sum(subtotal) AS subtotal_credito, sum(total_fact) AS total_credito_fact");
      $Credito = Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('forma_pago', '=', 'Credito')
      ->select($raw2)->get()->toArray();

      foreach ($Credito as $key => $value) {
        $total_credito_iva = $value['total_credito_iva'];
        $subtotal_credito = $value['subtotal_credito'];
        $total_credito_fact = $value['total_credito_fact'];
      }


      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['cajadiario'] = $cajadiario;
      $data['contcajadiario'] = $contcajadiario;
      $data['subtotal'] = round($subtotal);
      $data['total_iva'] = $total_iva;
      $data['total_fact'] = round($total_fact);
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      $data['total_contado_iva'] = $total_contado_iva;
      $data['subtotal_contado'] = $subtotal_contado;
      $data['total_contado_fact'] = $total_contado_fact;
      $data['total_credito_iva'] = $total_credito_iva;
      $data['subtotal_credito'] = $subtotal_credito;
      $data['total_credito_fact'] = $total_credito_fact;
      $data['facturadores'] = $facturadores;

      $html = view('pdf.cajadiario_cajarapida',$data)->render();

      $namefile = 'cajadiario_cajarapida_'.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }


     public function RelacionNotaCreditoCajaRapidaPdf(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
     
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

      $cajadiario = Relacion_nota_credito_caja_rapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('nota_credito', '=', true)
      ->orderBy('id_ncf')
      ->get()
      ->toArray();

      
      $contcajadiario = count ($cajadiario, 0);
      $subtotal = 0;
      $total_iva = 0;
      $total_fact = 0;

      foreach ($cajadiario as $key => $value) {
        $subtotal = $value['subtotal'] + $subtotal;
        $total_iva =$value['total_iva'] + $total_iva;
        $total_fact = $value['total_fact'] + $total_fact;
      }

    //Consulta para sacar las facturas de contado y credito
    //

     

      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['cajadiario'] = $cajadiario;
      $data['contcajadiario'] = $contcajadiario;
      $data['subtotal'] = round($subtotal);
      $data['total_iva'] = $total_iva;
      $data['total_fact'] = round($total_fact);
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
     
      $html = view('pdf.relacionnotacreditocajarapida',$data)->render();

      $namefile = 'relacionnotacredito_cajarapida_'.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }

    public function PdfCajaDiarioGeneral(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
     
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');

      /*CONSULTA PARA FACTURAS DE CONTADO Y  CREDITO*/

      $facturas_contado = Factura::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                        ->where('credito_fact', false)
                        ->where('nota_credito', false)
                        ->selectRaw('SUM(total_derechos) as derechos, SUM(total_conceptos) as conceptos, SUM(total_derechos + total_conceptos) as ingresos, 
                          SUM(total_iva) as iva, 
                          SUM(total_fondo + total_super) as recaudos, 
                          SUM(total_aporteespecial) as aporteespecial,
                          SUM(total_impuesto_timbre) as impuestotimbre,
                          SUM(total_rtf) as rtf,
                          SUM(deduccion_reteiva) as deduccion_reteiva,
                          SUM(deduccion_reteica) as deduccion_reteica,
                          SUM(deduccion_retertf) as deduccion_retertf,
                          SUM(total_fact) as total_fact')
                        ->first();
    $facturas_credito = Factura::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                        ->where('credito_fact', true)
                        ->where('nota_credito', false)
                        ->selectRaw('SUM(total_derechos) as derechos, SUM(total_conceptos) as conceptos, SUM(total_derechos + total_conceptos) as ingresos, 
                          SUM(total_iva) as iva, 
                          SUM(total_fondo + total_super) as recaudos, 
                          SUM(total_aporteespecial) as aporteespecial,
                          SUM(total_impuesto_timbre) as impuestotimbre,
                          SUM(total_rtf) as rtf,
                          SUM(deduccion_reteiva) as deduccion_reteiva,
                          SUM(deduccion_reteica) as deduccion_reteica,
                          SUM(deduccion_retertf) as deduccion_retertf,
                          SUM(total_fact) as total_fact')
                        ->first();

      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

    $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY

    $tipoinforme = $request->session()->get('tipoinforme');

    if($tipoinforme == 'completo'){
      $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('anio_esc', '=', $anio_trabajo)
      ->get()
      ->toArray();

      $cajadiario_otros_periodos1 = Cajadiariogeneral_notas_otros_periodos_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('anio_esc', '=', $anio_trabajo)
      ->where('nota_periodo', '=', 0)
      ->where('nota_credito', '=', 'false')
      ->get()
      ->toArray();

      $cajadiario_otros_periodos = [];
      $i = 0;
      foreach ($cajadiario_otros_periodos1 as $key => $value) {
        $num_fact_otros_p = $value['id_fact_otroperiodo'];


        $tempo = Factura::where('id_fact', '=', $num_fact_otros_p)
        ->get()
        ->toArray();


        foreach ($tempo as $key => $value) {
          $cajadiario_otros_periodos[$i]['derechos'] = $value['total_derechos'];
          $cajadiario_otros_periodos[$i]['conceptos'] = $value['total_conceptos'];
          $cajadiario_otros_periodos[$i]['recaudo'] = ($value['total_fondo'] + $value['total_super']);
          $cajadiario_otros_periodos[$i]['aporteespecial'] = $value['total_aporteespecial'];
          $cajadiario_otros_periodos[$i]['impuesto_timbre'] = $value['total_impuesto_timbre'];
          $cajadiario_otros_periodos[$i]['retencion'] = $value['total_rtf'];
          $cajadiario_otros_periodos[$i]['iva'] = $value['total_iva'];
          $cajadiario_otros_periodos[$i]['total'] = $value['total_fact'];
          $cajadiario_otros_periodos[$i]['total_gravado'] = ($value['total_derechos'] + $value['total_conceptos']);
          $cajadiario_otros_periodos[$i]['reteiva'] = $value['deduccion_reteiva'];
          $cajadiario_otros_periodos[$i]['reteica'] = $value['deduccion_reteica'];
          $cajadiario_otros_periodos[$i]['retertf'] = $value['deduccion_retertf'];
        }

        $i++;
      }

      $total_derechos_otros = 0;
      $total_conceptos_otros = 0;
      $total_recaudo_otros = 0;
      $total_aporteespecial_otros = 0;
      $impuesto_timbre_otros = 0;
      $total_retencion_otros = 0;
      $total_iva_otros = 0;
      $total_otros = 0;
      $total_gravado_otros = 0;
      $total_reteiva_otros = 0;
      $total_reteica_otros = 0;
      $total_retertf_otros = 0;

      $total_derechos_resta = 0;
      $total_conceptos_resta = 0;
      $total_recaudo_resta = 0;
      $total_aporteespecial_resta = 0;
      $impuesto_timbre_resta = 0;
      $total_retencion_resta = 0;
      $total_iva_resta = 0;
      $total_resta = 0;
      $total_gravado_resta = 0;
      $total_reteiva_resta = 0;
      $total_reteica_resta = 0;
      $total_retertf_resta = 0;


    }else if($tipoinforme == 'contado'){
      $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('anio_esc', '=', $anio_trabajo)
      ->where('tipo_pago', '=', 'Contado')
      ->get()
      ->toArray();
      $total_derechos_otros = 0;
      $total_conceptos_otros = 0;
      $total_recaudo_otros = 0;
      $total_aporteespecial_otros = 0;
      $impuesto_timbre_otros = 0;
      $total_retencion_otros = 0;
      $total_iva_otros = 0;
      $total_otros = 0;
      $total_gravado_otros = 0;
      $total_reteiva_otros = 0;
      $total_reteica_otros = 0;
      $total_retertf_otros = 0;

      $total_derechos_resta = 0;
      $total_conceptos_resta = 0;
      $total_recaudo_resta = 0;
      $total_aporteespecial_resta = 0;
      $impuesto_timbre_resta = 0;
      $total_retencion_resta = 0;
      $total_iva_resta = 0;
      $total_resta = 0;
      $total_gravado_resta = 0;
      $total_reteiva_resta = 0;
      $total_reteica_resta = 0;
      $total_retertf_resta = 0;
    }else if($tipoinforme == 'credito'){
      $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('anio_esc', '=', $anio_trabajo)
      ->where('tipo_pago', '=', 'Crédito')
      ->get()
      ->toArray();
      $total_derechos_otros = 0;
      $total_conceptos_otros = 0;
      $total_recaudo_otros = 0;
      $total_aporteespecial_otros = 0;
      $impuesto_timbre_otros = 0;
      $total_retencion_otros = 0;
      $total_iva_otros = 0;
      $total_otros = 0;
      $total_gravado_otros = 0;
      $total_reteiva_otros = 0;
      $total_reteica_otros = 0;
      $total_retertf_otros = 0;

      $total_derechos_resta = 0;
      $total_conceptos_resta = 0;
      $total_recaudo_resta = 0;
      $total_aporteespecial_resta = 0;
      $impuesto_timbre_resta = 0;
      $total_retencion_resta = 0;
      $total_iva_resta = 0;
      $total_resta = 0;
      $total_gravado_resta = 0;
      $total_reteiva_resta = 0;
      $total_reteica_resta = 0;
      $total_retertf_resta = 0;
    }

    $contcajadiario = count ($cajadiario, 0);
    $total_derechos = 0;
    $total_conceptos = 0;
    $total_recaudo = 0;
    $total_aporteespecial = 0;
    $impuesto_timbre = 0;
    $total_retencion = 0;
    $total_iva = 0;
    $total = 0;
    $total_gravado = 0;
    $total_reteiva = 0;
    $total_reteica = 0;
    $total_retertf = 0;

    foreach ($cajadiario as $key => $value) {
      $total_derechos = $value['derechos'] + $total_derechos;
      $total_conceptos =$value['conceptos'] + $total_conceptos;
      $total_recaudo = $value['recaudo'] + $total_recaudo;
      $total_aporteespecial = $value['aporteespecial'] + $total_aporteespecial;
      $impuesto_timbre = $value['impuesto_timbre'] + $impuesto_timbre;
      $total_retencion = $value['retencion'] + $total_retencion;
      $total_iva =$value['iva'] + $total_iva;
      $total = $value['total'] + $total;
      $total_gravado = $value['total_gravado'] + $total_gravado;
      $total_reteiva =$value['reteiva'] + $total_reteiva;
      $total_reteica = $value['reteica'] + $total_reteica;
      $total_retertf = $value['retertf'] + $total_retertf;
    }

    /*----------  OTROS PERIODOS  ----------*/
    if($tipoinforme == 'completo'){
      foreach ($cajadiario_otros_periodos as $key => $value) {
        $total_derechos_otros = $value['derechos'] + $total_derechos_otros;
        $total_conceptos_otros =$value['conceptos'] + $total_conceptos_otros;
        $total_recaudo_otros = $value['recaudo'] + $total_recaudo_otros;
        $total_aporteespecial_otros = $value['aporteespecial'] + $total_aporteespecial_otros;
        $impuesto_timbre_otros = $value['impuesto_timbre'] + $impuesto_timbre_otros;
        $total_retencion_otros = $value['retencion'] + $total_retencion_otros;
        $total_iva_otros =$value['iva'] + $total_iva_otros;
        $total_otros = $value['total'] + $total_otros;
        $total_gravado_otros = $value['total_gravado'] + $total_gravado_otros;
        $total_reteiva_otros =$value['reteiva'] + $total_reteiva_otros;
        $total_reteica_otros = $value['reteica'] + $total_reteica_otros;
        $total_retertf_otros = $value['retertf'] + $total_retertf_otros;
      }

      $total_derechos_resta = $total_derechos - $total_derechos_otros;
      $total_conceptos_resta = $total_conceptos - $total_conceptos_otros;
      $total_recaudo_resta = $total_recaudo - $total_recaudo_otros;
      $total_aporteespecial_resta = $total_aporteespecial - $total_aporteespecial_otros;
      $impuesto_timbre_resta = $impuesto_timbre - $impuesto_timbre_otros;
      $total_retencion_resta = $total_retencion - $total_retencion_otros;
      $total_iva_resta = $total_iva - $total_iva_otros;
      $total_resta = $total - $total_otros;
      $total_gravado_resta = $total_gravado - $total_gravado_otros;
      $total_reteiva_resta = $total_reteiva - $total_reteiva_otros;
      $total_reteica_resta = $total_reteica - $total_reteica_otros;
      $total_retertf_resta = $total_retertf - $total_retertf_otros;

    }
    

    /****POR CONCEPTOS*****/
    if($tipoinforme == 'completo'){
      $sumaconceptos = Factura::join("liq_conceptos","facturas.id_radica","=","liq_conceptos.id_radica")
      ->whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where("facturas.nota_credito","=",false)
      ->where("facturas.anio_radica","=",$anio_trabajo)
      ->get()->toArray();
      
    }else if($tipoinforme == 'contado'){
      $sumaconceptos = Factura::join("liq_conceptos","facturas.id_radica","=","liq_conceptos.id_radica")
      ->whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('credito_fact', '=', 'false')
      ->where("facturas.nota_credito","=",false)
      ->where("facturas.anio_radica","=",$anio_trabajo)
      ->get()->toArray();
      
    }else if($tipoinforme == 'credito'){
      $sumaconceptos = Factura::join("liq_conceptos","facturas.id_radica","=","liq_conceptos.id_radica")
      ->whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('credito_fact', '=', 'true')
      ->where("facturas.nota_credito","=",false)
      ->where("facturas.anio_radica","=",$anio_trabajo)
      ->get()->toArray();
      
    }
    

    $Conceptos = Concepto::all();
    $Conceptos = $Conceptos->sortBy('id_concep');
    $i=1;
    foreach ($Conceptos as $clave => $valor) {
      $total_concepto = 0;
      $atributo = $valor['nombre_concep'];
      $totalatributo = 'total'.$valor['atributo'];
      $dataconcept[$i]['concepto'] = $atributo;
      foreach ($sumaconceptos as $key => $value) {
        if($value[$totalatributo] > 0){
          $total_concepto = $value[$totalatributo] + $total_concepto;
        }
      }
      $dataconcept[$i]['total'] = $total_concepto;
      $i = $i + 1;
    }

    $contdataconcept = count ($dataconcept, 0);

    $totalconceptos = 0;
    foreach ($dataconcept as $key => $value) {
      $totalconceptos = $value['total'] + $totalconceptos;
    }

    $cruces = Cruces_actas_deposito_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)->get()->toArray();
    $contcruces = count ($cruces, 0);

    $total_egreso = 0;
    foreach ($cruces as $key => $cru) {
      $total_egreso = $cru['valor_egreso'] + $total_egreso;
    }
    
    $nombre_reporte = $request->session()->get('nombre_reporte');

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['cajadiario'] = $cajadiario;
    $data['contcajadiario'] = $contcajadiario;
    $data['total_derechos'] = round($total_derechos);
    $data['total_conceptos'] = $total_conceptos;
    $data['total_ingresos'] = round($total_derechos + $total_conceptos);
    $data['total_recaudo'] = $total_recaudo;
    $data['total_aporteespecial'] = $total_aporteespecial;
    $data['impuesto_timbre'] = $impuesto_timbre;
    $data['total_retencion'] = $total_retencion;
    $data['total_iva'] = round($total_iva);
    $data['total'] = $total;
    $data['total_gravado'] = $total_gravado;
    $data['total_reteiva'] = $total_reteiva;
    $data['total_reteica'] = $total_reteica;
    $data['total_retertf'] = $total_retertf;
    $data['dataconcept'] = $dataconcept;
    $data['contdataconcept'] = $contdataconcept;
    $data['totalconceptos'] = $totalconceptos;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['fecha_impresion'] = $fecha_impresion;
    $data['total_egreso'] = $total_egreso;
    $data['cruces'] = $cruces;
    $data['contcruces'] = $contcruces;
    $data['nombre_reporte'] = $nombre_reporte;

    $data['total_derechos_resta'] = round($total_derechos_resta);
    $data['total_derechos_otros'] = round($total_derechos_otros);
    $data['total_conceptos_resta'] = $total_conceptos_resta;
    $data['total_conceptos_otros'] = $total_conceptos_otros;
    $data['total_recaudo_resta'] = $total_recaudo_resta;
    $data['total_recaudo_otros'] = $total_recaudo_otros;
    $data['total_aporteespecial_resta'] = $total_aporteespecial_resta;
    $data['impuesto_timbre_resta'] = $impuesto_timbre_resta;
    $data['total_aporteespecial_otros'] = $total_aporteespecial_otros;
    $data['impuesto_timbre_otros'] = $impuesto_timbre_otros;
    $data['total_retencion_resta'] = $total_retencion_resta;
    $data['total_retencion_otros'] = $total_retencion_otros;
    $data['total_iva_resta'] = round($total_iva_resta);
    $data['total_iva_otros'] = round($total_iva_otros);
    $data['total_resta'] = $total_resta;
    $data['total_otros'] = $total_otros;
    $data['total_gravado_resta'] = round($total_gravado_resta);
    $data['total_gravado_otros'] = round($total_gravado_otros);
    $data['total_reteiva_resta'] = $total_reteiva_resta;
    $data['total_reteiva_otros'] = $total_reteiva_otros;
    $data['total_reteica_resta'] = $total_reteica_resta;
    $data['total_reteica_otros'] = $total_reteica_otros;
    $data['total_retertf_resta'] = $total_retertf_resta;
    $data['total_retertf_otros'] = $total_retertf_otros;

    $data['derechos_contado'] = $facturas_contado->derechos;
    $data['conceptos_contado'] = $facturas_contado->conceptos;
    $data['ingresos_contado'] = $facturas_contado->ingresos;
    $data['iva_contado'] = $facturas_contado->iva;
    $data['recaudos_contado'] = $facturas_contado->recaudos;
    $data['aporteespecial_contado'] = $facturas_contado->aporteespecial;
    $data['impuestotimbre_contado'] = $facturas_contado->impuestotimbre;
    $data['rtf_contado'] = $facturas_contado->rtf;
    $data['deduccion_reteiva_contado'] = $facturas_contado->deduccion_reteiva;
    $data['deduccion_reteica_contado'] = $facturas_contado->deduccion_reteica;
    $data['deduccion_retertf_contado'] = $facturas_contado->deduccion_retertf;
    $data['total_fact_contado'] = $facturas_contado->total_fact;
    $data['derechos_credito'] = $facturas_credito->derechos;
    $data['conceptos_credito'] = $facturas_credito->conceptos;
    $data['ingresos_credito'] = $facturas_credito->ingresos;
    $data['iva_credito'] = $facturas_credito->iva;
    $data['recaudos_credito'] = $facturas_credito->recaudos;
    $data['aporteespecial_credito'] = $facturas_credito->aporteespecial;
    $data['impuestotimbre_credito'] = $facturas_credito->impuestotimbre;
    $data['rtf_credito'] = $facturas_credito->rtf;
    $data['deduccion_reteiva_credito'] = $facturas_credito->deduccion_reteiva;
    $data['deduccion_reteica_credito'] = $facturas_credito->deduccion_reteica;
    $data['deduccion_retertf_credito'] = $facturas_credito->deduccion_retertf;
    $data['total_fact_credito'] = $facturas_credito->total_fact;

    $html = view('pdf.cajadiariogeneral',$data)->render();

    ini_set('pcre.backtrack_limit', '5000000'); // Ajusta el valor según sea necesario
    ini_set('memory_limit', '1024M'); // Ajusta el valor según sea necesario

    $namefile = 'cajadiario_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        //"format" => [216, 140],//Media Carta
      "format" => 'Letter-L',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

  }



  public function PdfRelaciondeFacturasPorConceptos(Request $request){
    $notaria = Notaria::find(1);
    //$anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fecha  = $fecha1.' A '.$fecha2;
    $fecha_impresion = date("d/m/Y");

    $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY

    $atributos = Concepto::all();
    $atributos = $atributos->sortBy('id_concep');
    $y=1;
    foreach ($atributos as $key => $value) {
      $dataconcept[$y]['concepto'] = '';
      $dataconcept[$y]['escrituras'] = 0;
      $dataconcept[$y]['total'] = 0;
      $y++;
    }
    
    $facturas = Factura::whereDate('fecha_fact', '>=', $fecha1)
    ->whereDate('fecha_fact', '<=', $fecha2)
    ->where('nota_credito','<>', true)
    ->where('nota_periodo', '<>', 0)
    ->get()->toArray();

    $facturas = $this->unique_multidim_array($facturas, 'id_radica');


    $sum_conceptos_otros_periodos = 0;
    foreach ($facturas as $key1 => $fc) {
      $id_radica = $fc['id_radica'];
      if($fc['nota_periodo'] == 0  || $fc['nota_periodo'] == 8){
        $radicacion_otro_periodo = $id_radica;
        $facturas_otro_periodo = Factura::where('id_radica', '=', $radicacion_otro_periodo)
        ->where('anio_radica', '=', $anio_trabajo)
        ->where('nota_credito', '=', true)
        ->get()->toArray();
        foreach ($facturas_otro_periodo as $key1 => $fco) {
          $sum_conceptos_otros_periodos +=  $fco['total_conceptos'];
        }
      }

      $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->first();
    
      $canthoja = 0;
      $i = 1;
      foreach ($atributos as $key => $atri) {
        $atributo = $atri['nombre_concep'];
        $totalatributo = 'total'.$atri['atributo'];
        $hojas = 'hojas'.$atri['atributo'];

        if($conceptos->$totalatributo > 0){
          $total = $conceptos->$totalatributo;
          $canthoja = $conceptos->$hojas;
          
          $dataconcept[$i]['concepto'] = $atributo;
          $dataconcept[$i]['escrituras'] += $canthoja;
          $dataconcept[$i]['total'] += $total;
        }
        $i++;
      }
    }

    $grantotal = 0;
    foreach ($dataconcept as $key => $value) {
      if($value['total'] == 0){
        unset($dataconcept[$key]);
      } else {
        $grantotal +=  $value['total'];
      }
    }

    $grantotal = $grantotal - $sum_conceptos_otros_periodos;
    $relconceptos = $dataconcept;
    $contrelconceptos = count ($relconceptos, 0);
    $nombre_reporte = $request->session()->get('nombre_reporte');

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha;
    $data['fecha_impresion'] = $fecha_impresion;
    $data['relconceptos'] = $relconceptos;
    $data['contrelconceptos'] = $contrelconceptos;
    $data['nombre_reporte'] = $nombre_reporte;
    $data['total'] = $grantotal;

    $html = view('pdf.relacionporconceptos',$data)->render();

   
    $namefile = 'ReldeFactPorConceptos_'.$fecha_impresion.'.pdf';
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
      'fontdata' => $fontData + [
        'arial' => [
        'R' => 'arial.ttf',
        'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
      "format" => 'Letter-P',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");

}

  /*=============================================
  =            Reporte Enlaces            =
  =============================================*/
  
  public function PdfEnlaces(Request $request){

    $notaria = Notaria::find(1);
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    
    /*----------  Consulta Radicaciones con un solo acto  ----------*/
    
    //$estadistico = Estadisticonotarial_unicas_view::whereDate('fecha', '>=', $fecha1)
    //->whereDate('fecha', '<=', $fecha2)
    //->get()->toArray();


    /*----------  Consulta Radicaciones con varios actos  ----------*/

    //$estadistico_repe = Estadisticonotarial_repetidas_solo_radi_view::whereDate('fecha', '>=', $fecha1)
    //->whereDate('fecha', '<=', $fecha2)
    //->get()->toArray();
    //
    //

    /*----------  Consulta Radicaciones con un solo acto  ----------*/


    $raw1 = \DB::raw("id_radica");
    $subquery = Estadisticonotarial_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->groupBy('id_radica')
    ->havingRaw('count(*) = 1')
    ->select($raw1)
    ->get()
    ->toArray();

    $estadistico = [];
    foreach ($subquery as $key => $sub) {
      $id_radica = $sub['id_radica'];
      $consulta = Estadisticonotarial_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('id_radica', [$id_radica])->get()->toArray();

      foreach ($consulta as $key2 => $con) {
        $estadistico[$key]['id_actoperrad'] = $con['id_actoperrad'];
        $estadistico[$key]['id_radica'] = $con['id_radica'];
        $estadistico[$key]['fecha'] = $con['fecha'];
        $estadistico[$key]['id_codigoagru'] = $con['id_codigoagru'];
        $estadistico[$key]['id_gru'] = $con['id_gru'];
        $estadistico[$key]['derechos'] = $con['derechos'];
      }

    }



    /*----------  Consulta Radicaciones con varios actos  ----------*/


    $raw2 = \DB::raw("id_radica");
    $subquery2 = Estadisticonotarial_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->groupBy('id_radica')
    ->havingRaw('count(*) > 1')
    ->select($raw2)
    ->get()
    ->toArray();


    $estadistico_repe = [];
    foreach ($subquery2 as $key => $sub2) {
      $id_radica = $sub2['id_radica'];
      $consulta2 = Estadisticonotarial_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('id_radica', [$id_radica])->get()->toArray();

      foreach ($consulta2 as $key2 => $con2) {
        $estadistico_repe[$key]['id_actoperrad'] = $con2['id_actoperrad'];
        $estadistico_repe[$key]['id_radica'] = $con2['id_radica'];
        $estadistico_repe[$key]['fecha'] = $con2['fecha'];
        $estadistico_repe[$key]['id_codigoagru'] = $con2['id_codigoagru'];
        $estadistico_repe[$key]['id_gru'] = $con2['id_gru'];
        $estadistico_repe[$key]['derechos'] = $con2['derechos'];
      }

    }



    $cantventa = 0;
    $canthipotecas = 0;
    $cantcancelhipo = 0;
    $cantescriturasvis = 0;
    $cantescriturasvip = 0;
    $cantescriturasvipa = 0;
    $cantsucesiones = 0;
    $cantpermutas = 0;
    $cantotrasescrsobreinmueb = 0;
    $cantcontratodearrenda = 0;
    $cantfiducias = 0;
    $cantleasing = 0;
    $cantconstitusocied = 0;
    $cantliqsocied = 0;
    $cantreformsocial = 0;
    $cantmatrimoniociv = 0;
    $cantmatrimismosexo = 0;
    $cantdivorcios = 0;
    $cantdeclaunionmaritdhech = 0;
    $cantdisounimaritdhech = 0;
    $cantdisoluliqsocconyu = 0;
    $cantcorrecregcivil = 0;
    $cantcambionombre = 0;
    $cantligitimhijos = 0;
    $cantcapitumatrimo = 0;
    $cantinterdicjudic = 0;
    $cantunipersomismosexo = 0;
    $cantactascomparec = 0;
    $cantautenticac = 0;
    $cantdeclarextrajuic = 0;
    $cantdeclarsuperviv = 0;
    $cantconciliac = 0;
    $cantrematinmueb = 0;
    $cantcopiregcivil = 0;
    $cantregcivnacim = 0;
    $cantregcivimatrim = 0;
    $cantregcivdefunc = 0;
    $cantescrpublicorreccomposexmasca = 0;
    $cantescrpublicorreccomposexfema = 0;
    $cantmatrimenoredad = 0;
    $cantprocedinsoleconopersonatur = 0;
    $cantotros = 0;


    foreach ($estadistico as $key => $est) {
      $id_radica = $est['id_radica'];
      $id_gru = $est['id_gru'];
      
      if($id_gru == 1){
        $cantventa++;
      }else if($id_gru == 2){
        $canthipotecas++;
      }else if($id_gru == 3){
        $cantcancelhipo++;
      }else if($id_gru == 4){
        $cantescriturasvis++;
      }else if($id_gru == 5){
        $cantescriturasvip++;
      }else if($id_gru == 6){
        $cantescriturasvipa++;
      }else if($id_gru == 7){
        $cantsucesiones++;
      }else if($id_gru == 8){
        $cantpermutas++;
      }else if($id_gru == 9){
        $cantotrasescrsobreinmueb++;
      }else if($id_gru == 10){
        $cantcontratodearrenda++;
      }else if($id_gru == 11){
        $cantfiducias++;
      }else if($id_gru == 12){
        $cantleasing++;
      }else if($id_gru == 13){
        $cantconstitusocied++;
      }else if($id_gru == 14){
        $cantliqsocied++;
      }else if($id_gru == 15){
        $cantreformsocial++;
      }else if($id_gru == 16){
        $cantmatrimoniociv++;
      }else if($id_gru == 17){
        $cantmatrimismosexo++;
      }else if($id_gru == 18){
        $cantdivorcios++;
      }else if($id_gru == 19){
        $cantdeclaunionmaritdhech++;
      }else if($id_gru == 20){
        $cantdisounimaritdhech++;
      }else if($id_gru == 21){
        $cantdisoluliqsocconyu++;
      }else if($id_gru == 22){
        $cantcorrecregcivil++;
      }else if($id_gru == 23){
        $cantcambionombre++;
      }else if($id_gru == 24){
        $cantligitimhijos++;
      }else if($id_gru == 25){
        $cantcapitumatrimo++;
      }else if($id_gru == 26){
        $cantinterdicjudic++;
      }else if($id_gru == 27){
        $cantunipersomismosexo++;
      }else if($id_gru == 28){
        $cantactascomparec++;
      }else if($id_gru == 29){
        $cantautenticac++;
      }else if($id_gru == 30){
        $cantdeclarextrajuic++;
      }else if($id_gru == 31){
        $cantdeclarsuperviv++;
      }else if($id_gru == 32){
        $cantconciliac++;
      }else if($id_gru == 33){
        $cantrematinmueb++;
      }else if($id_gru == 34){
        $cantcopiregcivil++;
      }else if($id_gru == 35){
        $cantregcivnacim++;
      }else if($id_gru == 36){
        $cantregcivimatrim++;
      }else if($id_gru == 37){
        $cantregcivdefunc++;
      }else if($id_gru == 38){
        $cantescrpublicorreccomposexmasca++;
      }else if($id_gru == 39){
        $cantescrpublicorreccomposexfema++;
      }else if($id_gru == 40){
        $cantmatrimenoredad++;
      }else if($id_gru == 41){
        $cantprocedinsoleconopersonatur++;
      }else if($id_gru == 42){
        $cantotros++;
      }
      
    }//Fin del for estadisticonotarial



    foreach ($estadistico_repe as $key => $esr) {
      $id_radica = $esr['id_radica'];
      $estadistico_rad = Estadisticonotarial_view::where('id_radica', [$id_radica])->get()->toArray();

      $i = 0;
      unset($arr_codigo);
      $arr_codigo = array();
      
      foreach ($estadistico_rad as $key => $num) {
        $arr_codigo[$i] = $num['id_gru'];
        $i++;
      }


      if (in_array("1", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo)) {
        $cantventa++;
      }

      if (in_array("2", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("1", $arr_codigo) && !in_array("9", $arr_codigo)) {
        $canthipotecas++;
      }

      if (in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("1", $arr_codigo) && !in_array("9", $arr_codigo)) {
        $cantcancelhipo++;
      }

      if (in_array("4", $arr_codigo)  && !in_array("7", $arr_codigo) ) {
        $cantescriturasvis++;
      }

      if (in_array("5", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo)) {
        $cantescriturasvip++;
      }

      if (in_array("6", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo)) {
        $cantescriturasvipa++;
      }


      if (in_array("7", $arr_codigo) ) {
        $cantsucesiones++;
      }

      if (in_array("8", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("22", $arr_codigo) && !in_array("18", $arr_codigo)  && !in_array("17", $arr_codigo) && !in_array("9", $arr_codigo)) {
        $cantpermutas++;
      }

      if (in_array("9", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("1", $arr_codigo) ) {
        $cantotrasescrsobreinmueb++;
      }


      if (in_array("10", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantcontratodearrenda++;
      }

      if (in_array("11", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantfiducias++;
      }

      if (in_array("12", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantleasing++;
      }

      if (in_array("13", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantconstitusocied++;
      }

      if (in_array("14", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantliqsocied++;
      }


      if (in_array("15", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantreformsocial++;
      }

      if (in_array("16", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantmatrimoniociv++;
      }


      if (in_array("17", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantmatrimismosexo++;
      }

      if (in_array("18", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantdivorcios++;
      }

      if (in_array("19", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantdeclaunionmaritdhech++;
      }

      if (in_array("20", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantdisounimaritdhech++;
      }

      if (in_array("21", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("19", $arr_codigo)) {
        $cantdisoluliqsocconyu++;
      }

      if (in_array("22", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantcorrecregcivil++;
      }

      if (in_array("23", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantcambionombre++;
      }

      if (in_array("24", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantligitimhijos++;
      }

      if (in_array("25", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantcapitumatrimo++;
      }

      if (in_array("26", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantinterdicjudic++;
      }

      if (in_array("27", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantunipersomismosexo++;
      }

      if (in_array("28", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantactascomparec++;
      }

      if (in_array("29", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantautenticac++;
      }

      if (in_array("30", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantdeclarextrajuic++;
      }

      if (in_array("31", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantdeclarsuperviv++;
      }

      if (in_array("32", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantconciliac++;
      }

      if (in_array("33", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantrematinmueb++;
      }

      if (in_array("34", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantcopiregcivil++;
      }

      if (in_array("35", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantregcivnacim++;
      }

      if (in_array("36", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantregcivimatrim++;
      }

      if (in_array("37", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantregcivdefunc++;
      }

      if (in_array("38", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantescrpublicorreccomposexmasca++;
      }

      if (in_array("39", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantescrpublicorreccomposexfema++;
      }

      if (in_array("40", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantmatrimenoredad++;
      }

      if (in_array("41", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("7", $arr_codigo) && !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("1", $arr_codigo)) {
        $cantprocedinsoleconopersonatur++;
      }

      if (in_array("42", $arr_codigo) && !in_array("1", $arr_codigo) &&
        !in_array("2", $arr_codigo) && !in_array("3", $arr_codigo) &&
        !in_array("4", $arr_codigo) && !in_array("5", $arr_codigo) && 
        !in_array("6", $arr_codigo) && !in_array("7", $arr_codigo) &&   
        !in_array("8", $arr_codigo) && !in_array("9", $arr_codigo) &&
        !in_array("10", $arr_codigo) && !in_array("11", $arr_codigo) &&
        !in_array("12", $arr_codigo) && !in_array("13", $arr_codigo) &&
        !in_array("14", $arr_codigo) && !in_array("15", $arr_codigo) &&
        !in_array("16", $arr_codigo) && !in_array("17", $arr_codigo) &&
        !in_array("18", $arr_codigo) && !in_array("19", $arr_codigo) &&
        !in_array("20", $arr_codigo) && !in_array("21", $arr_codigo) &&
        !in_array("22", $arr_codigo) && !in_array("23", $arr_codigo) &&
        !in_array("24", $arr_codigo) && !in_array("25", $arr_codigo) &&
        !in_array("26", $arr_codigo) && !in_array("27", $arr_codigo) &&
        !in_array("28", $arr_codigo) && !in_array("29", $arr_codigo) &&
        !in_array("30", $arr_codigo) && !in_array("31", $arr_codigo) &&
        !in_array("32", $arr_codigo) && !in_array("33", $arr_codigo) &&
        !in_array("34", $arr_codigo) && !in_array("35", $arr_codigo) &&
        !in_array("36", $arr_codigo) && !in_array("37", $arr_codigo) &&
        !in_array("38", $arr_codigo) && !in_array("39", $arr_codigo) &&
        !in_array("40", $arr_codigo) && !in_array("41", $arr_codigo)) {
        $cantotros++;
      }

    }


    $totalcantidad = $cantventa + $canthipotecas + $cantcancelhipo + 
    $cantescriturasvis + $cantescriturasvip + $cantescriturasvipa + 
    $cantsucesiones + $cantpermutas + $cantotrasescrsobreinmueb + 
    $cantcontratodearrenda + $cantfiducias + $cantleasing + 
    $cantconstitusocied + $cantliqsocied + $cantreformsocial + 
    $cantmatrimoniociv + $cantmatrimismosexo + $cantdivorcios + 
    $cantdeclaunionmaritdhech + $cantdisounimaritdhech + 
    $cantdisoluliqsocconyu + $cantcorrecregcivil + $cantcambionombre + 
    $cantligitimhijos + $cantcapitumatrimo + $cantinterdicjudic + 
    $cantunipersomismosexo + $cantactascomparec + $cantautenticac + 
    $cantdeclarextrajuic + $cantdeclarsuperviv + $cantconciliac + 
    $cantrematinmueb + $cantcopiregcivil + $cantregcivnacim + 
    $cantregcivimatrim + $cantregcivdefunc + 
    $cantescrpublicorreccomposexmasca + $cantescrpublicorreccomposexfema + 
    $cantmatrimenoredad + $cantprocedinsoleconopersonatur + $cantotros;
    $nombre_reporte = $request->session()->get('nombre_reporte');

    
    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha1'] = $fecha1;
    $data['fecha2'] = $fecha2;
    $data ['cantventa'] = $cantventa;
    $data ['canthipotecas'] = $canthipotecas;
    $data ['cantcancelhipo'] = $cantcancelhipo;
    $data ['cantescriturasvis'] = $cantescriturasvis;
    $data ['cantescriturasvip'] = $cantescriturasvip;
    $data ['cantescriturasvipa'] = $cantescriturasvipa;
    $data ['cantsucesiones'] = $cantsucesiones;
    $data ['cantpermutas'] = $cantpermutas;
    $data ['cantotrasescrsobreinmueb'] = $cantotrasescrsobreinmueb;
    $data ['cantcontratodearrenda'] = $cantcontratodearrenda;
    $data ['cantfiducias'] = $cantfiducias;
    $data ['cantleasing'] = $cantleasing;
    $data ['cantconstitusocied'] = $cantconstitusocied;
    $data ['cantliqsocied'] = $cantliqsocied;
    $data ['cantreformsocial'] = $cantreformsocial;
    $data ['cantmatrimoniociv'] = $cantmatrimoniociv;
    $data ['cantmatrimismosexo'] = $cantmatrimismosexo;
    $data ['cantdivorcios'] = $cantdivorcios;
    $data ['cantdeclaunionmaritdhech'] = $cantdeclaunionmaritdhech;
    $data ['cantdisounimaritdhech'] = $cantdisounimaritdhech;
    $data ['cantdisoluliqsocconyu'] = $cantdisoluliqsocconyu;
    $data ['cantcorrecregcivil'] = $cantcorrecregcivil;
    $data ['cantcambionombre'] = $cantcambionombre;
    $data ['cantligitimhijos'] = $cantligitimhijos;
    $data ['cantcapitumatrimo'] = $cantcapitumatrimo;
    $data ['cantinterdicjudic'] = $cantinterdicjudic;
    $data ['cantunipersomismosexo'] = $cantunipersomismosexo;
    $data ['cantactascomparec'] = $cantactascomparec;
    $data ['cantautenticac'] = $cantautenticac;
    $data ['cantdeclarextrajuic'] = $cantdeclarextrajuic;
    $data ['cantdeclarsuperviv'] = $cantdeclarsuperviv;
    $data ['cantconciliac'] = $cantconciliac;
    $data ['cantrematinmueb'] = $cantrematinmueb;
    $data ['cantcopiregcivil'] = $cantcopiregcivil;
    $data ['cantregcivnacim'] = $cantregcivnacim;
    $data ['cantregcivimatrim'] = $cantregcivimatrim;
    $data ['cantregcivdefunc'] = $cantregcivdefunc;
    $data ['cantescrpublicorreccomposexmasca'] = $cantescrpublicorreccomposexmasca;
    $data ['cantescrpublicorreccomposexfema'] = $cantescrpublicorreccomposexfema;
    $data ['cantmatrimenoredad'] = $cantmatrimenoredad;
    $data ['cantprocedinsoleconopersonatur'] = $cantprocedinsoleconopersonatur;
    $data ['cantotros'] = $cantotros;
    $data ['nombre_reporte'] = $nombre_reporte;

    
    $data['totalcantidad'] = $totalcantidad;


    $html = view('pdf.enlaces',$data)->render();

    $fecha_reporte = date("Y/m/d");
    $namefile = 'enlaces_'.$fecha_reporte.'.pdf';

    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];
    $mpdf = new Mpdf([
      'fontDir' => array_merge($fontDirs, [
        public_path() . '/fonts',
      ]),
      'fontdata' => $fontData + [
        'arial' => [
          'R' => 'arial.ttf',
          'B' => 'arialbd.ttf',
        ],
      ],
      'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
      "format" => 'Letter-L',
      'margin_bottom' => 10,
    ]);

    $mpdf->defaultfooterfontsize=2;
    $mpdf->SetTopMargin(5);
    $mpdf->SetDisplayMode('fullpage');
    $mpdf->WriteHTML($html);
    $mpdf->Output($namefile,"I");
  }
  
  /*=====  End of Section comment block  ======*/
  

  /***************TODO:COPIA FACTURA*******************/
  public function PdfCopiaFactura(Request $request){
    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_fact;
    $anio_trabajo = $request->session()->get('anio_trabajo');
    $num_fact = $request->session()->get('numfact');//TODO:Obtiene el número de factura por session
    $fecha_impresion = date("d/m/Y");


    //TARIFA DEL IVA
    $porcentaje_iva = round((Tarifa::find(9)->valor1));
    /********Valida Si la factura es doble o unica*********/
    if (Detalle_factura::where('id_fact', $num_fact)->where('prefijo', $prefijo_fact)->exists()){
      $factura_oto = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($factura_oto as $factura_otor) {
        $total_iva_otor = $factura_otor->total_iva;
        $total_rtf_otor = $factura_otor->total_rtf;
        $total_reteconsumo_otor = $factura_otor->total_reteconsumo;
        $total_fondo_otor = $factura_otor->total_fondo;
        $total_super_otor = $factura_otor->total_super;
        $total_aporteespecial_otor = $factura_otor->total_aporteespecial;
        $total_impuesto_timbre = $factura_otor->total_impuesto_timbre;
        $total_fact_otor = $factura_otor->total_fact;
        $reteiva_otor = $factura_otor->deduccion_reteiva;
        $retertf_otor = $factura_otor->deduccion_retertf;
        $reteica_otor = $factura_otor->deduccion_reteica;
        $subtotal1_otor = $factura_otor->total_derechos + $factura_otor->total_conceptos;
        $fecha_fact = Carbon::parse($factura_otor->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura_otor->fecha_fact)->format('h-i-s');
        $hora_cufe = Carbon::parse($factura_otor->updated_at)->format('h:i:s');
        $derechos_otor = $factura_otor->total_derechos;
        $identificacioncli1_otor = $factura_otor->a_nombre_de;
        $id_radica =  $factura_otor->id_radica;
        $cuf =  $factura_otor->cufe;
        $forma_pago = $factura_otor->credito_fact;
        $a_cargo_de = $factura_otor->a_cargo_de;
        $detalle_acargo_de = $factura_otor->detalle_acargo_de;
      }

     /*Medios de Pago*/


      $mediodepago = '';
      
      $Medpago = Mediosdepago::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }


      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }

      
      $escrituras = Escritura::where("id_radica","=",$id_radica)->where("anio_esc","=",$anio_trabajo)->get();
      foreach ($escrituras as $esc) {
        $num_esc = $esc->num_esc;
      }


      $protocolista = Protocolistas_view::where('num_esc', $num_esc)
      ->where('anio_esc', $anio_trabajo)
      ->get();
      foreach ($protocolista as $value) {
        $nameprotocolista = $value['nombre_proto'];
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente_otor = Cliente::where('identificacion_cli', $identificacioncli1_otor)->select($raw)->get();
      foreach ($cliente_otor as $key => $cli_otor) {
        $nombrecli1_otor = $cli_otor['fullname'];
        $direccioncli1_otor = $cli_otor['direccion_cli'];
      }


      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }

      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(2)->get()->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(30)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos_otor = Detalle_factura::where('id_fact', $num_fact)->get()->toArray();
      $cantidades = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');

      $i = 1;
      $dataconcept_otor = array();
      foreach ($conceptos_otor as $key => $conc1) {
        foreach ($cantidades as $key => $cnt){ 
          foreach ($atributos as $key => $atri) {
            $atributo = $atri['nombre_concep'];
            $totalatributo = 'total'.$atri['atributo'];
            $hojasatributo = 'hojas'.$atri['atributo'];
            if($conc1[$totalatributo] > 0){
              $dataconcept_otor[$i]['concepto'] = $atributo;
              $dataconcept_otor[$i]['cantidad'] = $cnt[$hojasatributo];
              $dataconcept_otor[$i]['total'] = $conc1[$totalatributo];
              $i = $i + 1;
            }
          }
        }
      }


      $contdataconcept_otor = count($dataconcept_otor, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;

      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$num_fact;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva_otor;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica_otor;
      $valTot  = $total_fact_otor;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1_otor;
      $ingresos = $subtotal1_otor;
      $ClTec   = '266669c6-4b51-429d-aedb-da51c8270516'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

      $cufe = trim($cuf);

      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      $QRCode = $cufe;

      $iva = "Somos Responsables de IVA";
      $data_otor['nit'] = $nit;
      $data_otor['nombre_nota'] = $nombre_nota;
      $data_otor['direccion_nota'] = $direccion_nota;
      $data_otor['telefono_nota'] = $telefono_nota;
      $data_otor['email'] = $email;
      $data_otor['nombre_notario'] = $nombre_notario;
      $data_otor['resolucion'] = $resolucion;
      $data_otor['piepagina_fact'] = $piepagina_fact;
      $data_otor['IVA'] = $iva;
      $data_otor['prefijo_fact'] = $prefijo_fact;
      $data_otor['num_fact'] = $num_fact;
      $data_otor['num_esc'] = $num_esc;
      $data_otor['identificacioncli1'] = $identificacioncli1_otor;
      $data_otor['nombrecli1'] = $nombrecli1_otor;
      $data_otor['direccioncli1'] = $direccioncli1_otor;
      $data_otor['fecha_fact'] = $fecha_fact;
      $data_otor['fecha_impresion'] = $fecha_impresion;

      $data_otor['hora_fact'] = $hora_fact;
      $data_otor['hora_cufe'] = $hora_cufe;
      $data_otor['principales'] = $principales;
      $data_otor['contprincipales'] = $contprincipales;
      $data_otor['actos'] = $actos;
      $data_otor['contactos'] = $contactos;//contador actos
      $data_otor['derechos'] = $derechos_otor;
      $data_otor['dataconcept'] = $dataconcept_otor;
      $data_otor['contdataconcept'] = $contdataconcept_otor;
      $data_otor['subtotal1'] = $subtotal1_otor;
      $data_otor['total_fact'] = $total_fact_otor;
      $data_otor['QRCode'] = $QRCode;
      $data_otor['cufe'] = $cufe;
      $data_otor['titulo'] = "Factura de Venta No.";
      $data_otor['protocolista'] = $nameprotocolista;
      $data_otor['id_radica'] = $id_radica;
      $data_otor['formadepago'] = $formadepago;
      $data_otor['a_cargo_de'] = $a_cargo_de;
      $data_otor['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data_otor['detalle_acargo_de'] = $detalle_acargo_de;
      $data_otor['mediodepago'] = $mediodepago;

      $j = 0;
      if($total_super_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super_otor;
      }
      if($total_fondo_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo_otor;
      }
      if($total_aporteespecial_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial_otor;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto Timbre";
        $terceros[$j]['total'] = $total_impuesto_timbre;
      }
      if($total_rtf_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf_otor;
      }
      if($total_reteconsumo_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo_otor;
      }
      if($total_iva_otor > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = $total_iva_otor;
      }

      $contterceros = count ($terceros, 0);
      $data_otor['terceros'] = $terceros;
      $data_otor['contterceros'] = $contterceros;

      $totalterceros = $total_iva_otor + $total_rtf_otor + $total_reteconsumo_otor + $total_fondo_otor + $total_super_otor + $total_aporteespecial_otor + $total_impuesto_timbre;
      $data_otor['totalterceros'] = $totalterceros;

      $k = 0;
      if($reteiva_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteIva 15%";
        $deducciones_otor[$k]['total'] = $reteiva_otor;
      }
      if($retertf_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteFuente 11%";
        $deducciones_otor[$k]['total'] = $retertf_otor;
      }
      if($reteica_otor > 0){
        $k = $k + 1;
        $deducciones_otor[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones_otor[$k]['total'] = $reteica_otor;
      }

      if (isset($deducciones_otor)){
        $contdeducciones = count ($deducciones_otor, 0);
        $data_otor['deducciones'] = $deducciones_otor;
        $data_otor['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva_otor + $retertf_otor + $reteica_otor;
        $data_otor['totaldeducciones'] = round($totaldeducciones);
      }

      $html_otor = view('pdf.generar',$data_otor)->render();

      $namefile = 'Copia_Factura'.$num_fact.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHeader('Factura '.'{PAGENO} de {nbpg}');

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html_otor);
      $mpdf->Output($namefile,"I");
    }else{//Para radicación con una sola factura
      $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();


      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = $factura->total_rtf;
        $total_reteconsumo = $factura->total_reteconsumo;
        $total_aporteespecial = $factura->total_aporteespecial;
        $total_impuesto_timbre = $factura->total_impuesto_timbre;
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $id_radica = $factura->id_radica;
        $cuf = $factura->cufe;
        $forma_pago = $factura->credito_fact;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
      }

      /*Medios de Pago*/
      
      $mediodepago = '';
      
      $Medpago = Mediosdepago::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }


     
      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }

      $escrituras = Escritura::where("id_radica","=",$id_radica)->where("anio_esc","=",$anio_trabajo)->get();
      foreach ($escrituras as $esc) {
        $num_esc = $esc->num_esc;
      }

      
      $protocolista = Protocolistas_copias_view::where('num_esc', $num_esc)
      ->where('anio_esc', $anio_trabajo)
      ->get();
      foreach ($protocolista as $value) {
        $nameprotocolista = $value['nombre_proto'];
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }

      $raw_acargo = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $a_cargo = Cliente::where('identificacion_cli', $a_cargo_de)->select($raw_acargo)->get();
      foreach ($a_cargo as $key => $acar) {
        $nombrecli_acargo_de = $acar['fullname'];
      }



      $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
      $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(2)->get()->toArray();
      $contprincipales = count ($principales, 0);

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(30)->get()->toArray();
      $contactos = count ($actos, 0);
      $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

      $atributos = Concepto::all();
      $atributos = $atributos->sortBy('id_concep');
      $i = 1;

      foreach ($conceptos as $key => $conc) {
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          $hojasatributo = 'hojas'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $dataconcept[$i]['concepto'] = $atributo;
            $dataconcept[$i]['cantidad'] = $conc[$hojasatributo];
            $dataconcept[$i]['total'] = $conc[$totalatributo];
            $i = $i + 1;
          }

        }
      }
      $contdataconcept = count ($dataconcept, 0);

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$num_fact;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica;
      $valTot  = $total_fact;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1;
      $ingresos = $subtotal1;
      $ClTec   = '266669c6-4b51-429d-aedb-da51c8270516'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

      $cufe = trim($cuf);

      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      $QRCode = $cufe;

      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['num_esc'] = $num_esc;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['principales'] = $principales;
      $data['contprincipales'] = $contprincipales;
      $data['actos'] = $actos;
      $data['contactos'] = $contactos;
      $data['derechos'] = $derechos;
      $data['dataconcept'] = $dataconcept;
      $data['contdataconcept'] = $contdataconcept;
      $data['subtotal1'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;$data['titulo'] = "Factura de Venta No.";
      $data['protocolista'] = $nameprotocolista;
      $data['id_radica'] = $id_radica;
      $data['formadepago'] = $formadepago;
      $data['a_cargo_de'] = $a_cargo_de;
      $data['nombrecli_acargo_de'] = $nombrecli_acargo_de;
      $data['detalle_acargo_de'] = $detalle_acargo_de;
      $data['mediodepago'] = $mediodepago;
      $data['fecha_impresion'] = $fecha_impresion;

      $j = 0;
      if($total_super > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Superintendencia de Notariado";
        $terceros[$j]['total'] = $total_super;
      }
      if($total_fondo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
        $terceros[$j]['total'] = $total_fondo;
      }
      if($total_rtf > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Retención en la Fuente";
        $terceros[$j]['total'] = $total_rtf;
      }
      if($total_reteconsumo > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al Consumo";
        $terceros[$j]['total'] = $total_reteconsumo;
      }
      if($total_aporteespecial > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Aporte Especial";
        $terceros[$j]['total'] = $total_aporteespecial;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto Timbre";
        $terceros[$j]['total'] = $total_impuesto_timbre;
      }
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $k = 0;
      if($reteiva > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIva 15%";
        $deducciones[$k]['total'] = $reteiva;
      }
      if($retertf > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteFuente 11%";
        $deducciones[$k]['total'] = $retertf;
      }
      if($reteica > 0){
        $k = $k + 1;
        $deducciones[$k]['concepto'] = "ReteIca 6.6/1000";
        $deducciones[$k]['total'] = $reteica;
      }

      if (isset($deducciones)){ //Si está definida la variable
        $contdeducciones = count ($deducciones, 0);
        $data['deducciones'] = $deducciones;
        $data['contdeducciones'] = $contdeducciones;

        $totaldeducciones = $reteiva + $retertf + $reteica;
        $data['totaldeducciones'] = round($totaldeducciones);
      }

      $html = view('pdf.generar',$data)->render();

      $namefile = 'notacredito_n13_'.$num_fact.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
    }
  }

  public function PdfLiquidacion(Request $request){

    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_fact;
    $anio_trabajo = $notaria->anio_trabajo;
    $id_radica = $request->session()->get('key');
    $tipo_impre_liq   = $request->session()->get('tipo_impre_liq');
    
    if($tipo_impre_liq == 'provisional'){

      $titulo_liq = 'LIQUIDACIÓN PROVISIONAL';

    }else if($tipo_impre_liq == 'real'){

      $titulo_liq = 'LIQUIDACIÓN DE LA RADICACIÓN No.'.$id_radica;

    }

    $sumaderechos = Liq_derecho::join("detalle_liqderechos","liq_derechos.id_liqd","=","detalle_liqderechos.id_liqd")
    ->where("liq_derechos.id_radica","=",$id_radica)
    ->where("liq_derechos.anio_radica","=",$anio_trabajo)
    ->get()->toArray();

    $total_derechos = 0;
    $total_derechos_otorgante = 0;
    $total_derechos_compareciente = 0;
    $iva_derechos_otor = 0;
    $iva_derechos_compa = 0;

    foreach ($sumaderechos as $key => $sum) {
      $total_derechos = $sum['derechos'] + $total_derechos;
      $total_derechos_otorgante = $sum['derechos_otorgante'] + $total_derechos_otorgante;
      $total_derechos_compareciente = $sum['derechos_compareciente'] + $total_derechos_compareciente;

      $iva_derechos_otor = $sum['iva_derechos_otor'] + $iva_derechos_otor;
      $iva_derechos_compa = $sum['iva_derechos_compa'] + $iva_derechos_compa;
    }

    $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
    $contactos = count ($actos, 0);
    $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

    $atributos = Concepto::all();
    $atributos = $atributos->sortBy('id_concep');

    $i = 1;
    $total_conceptos = 0;
    foreach ($conceptos as $key => $conc1) {
      foreach ($atributos as $key => $atri) {
        $atributo = $atri['nombre_concep'];
        $totalatributo = 'total'.$atri['atributo'];
        $hojasatributo = 'hojas'.$atri['atributo'];
        if($conc1[$totalatributo] > 0){
          $dataconcept[$i]['concepto'] = $atributo;
          $dataconcept[$i]['cantidad'] = $conc1[$hojasatributo];
          $dataconcept[$i]['total'] = $conc1[$totalatributo];
          $total_conceptos = $dataconcept[$i]['total'] + $total_conceptos;
          $i++;
        }
      }
    }

    $subtotal1 = $total_derechos + $total_conceptos;

   
    if (isset($dataconcept)) {
      $contdataconcept = count($dataconcept, 0);
    } else {
    // Redirigir a la página de error
    //return redirect('errors/erroresgenerales');
      $Mensaje = "Undefined variable: dataconcept ";
      return view('errors.erroresgenerales', compact('Mensaje'));
    }

    //$contdataconcept = count($dataconcept, 0);
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $resolucion = $notaria->resolucion;
    $piepagina_fact = $notaria->piepagina_fact;
    $fecha_impresion = date("d/m/Y");

    $data['titulo_liq'] = $titulo_liq;
    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['resolucion'] = $resolucion;
    $data['piepagina_fact'] = $piepagina_fact;
    $data['actos'] = $actos;
    $data['contactos'] = $contactos;//contador actos
    $data['derechos'] = $total_derechos;
    $data['dataconcept'] = $dataconcept;
    $data['contdataconcept'] = $contdataconcept;
    $data['subtotal1'] = $subtotal1;
    $data['id_radica'] = $id_radica;
    $data['fecha_impresion'] = $fecha_impresion;


      $recaudos = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      $total_iva = 0;
      $total_rtf = 0;
      $total_reteconsumo = 0;
      $total_fondo = 0;
      $total_super = 0;
      $total_aporteespecial = 0;
      $total_impuesto_tiembre = 0;

      foreach ($recaudos as $key => $rec) {
        $j = 0;
        if($rec['recsuper'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Superintendencia de Notariado";
          $terceros[$j]['total'] = $rec['recsuper'];
          $total_super = $terceros[$j]['total'];
        }
        if($rec['recfondo'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Fondo Nacional de Notariado";
          $terceros[$j]['total'] = $rec['recfondo'];
          $total_fondo = $terceros[$j]['total'];
        }
        if($rec['retefuente'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Retención en la Fuente";
          $terceros[$j]['total'] = $rec['retefuente'];
          $total_rtf = $terceros[$j]['total'];
        }
        if($rec['reteconsumo'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Impuesto al Consumo";
          $terceros[$j]['total'] = $rec['reteconsumo'];
          $total_reteconsumo = $terceros[$j]['total'];
        }
        if($rec['aporteespecial'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Aporte Especial";
          $terceros[$j]['total'] = $rec['aporteespecial'];
          $total_aporteespecial = $terceros[$j]['total'];
        }
        if($rec['iva'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Iva";
          $terceros[$j]['total'] = $rec['iva'];
          $total_iva = $terceros[$j]['total'];
        }
        if($rec['impuestotimbre'] > 0){
          $j = $j + 1;
          $terceros[$j]['concepto'] = "Impuesto de timbre";
          $terceros[$j]['total'] = $rec['impuestotimbre'];
          $total_impuesto_tiembre = $terceros[$j]['total'];
        }
      }


      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + 
      $total_fondo + $total_super + $total_aporteespecial + $total_impuesto_tiembre;
      $total_fact = $totalterceros + $subtotal1;
      $data['totalterceros'] = $totalterceros;
      $data['total_fact'] = $total_fact;

       /*********TOTALES OTORGANTE Y COMPARECIENTE**********/

      //$calcularderechos = new LiqderechoController();
      //$infoderechos = $calcularderechos->derechos_para_pagos_otor_compa($request);

     
       $total_conceptos_otorgante = $total_conceptos / 2;
       $total_conceptos_compareciente = $total_conceptos / 2;
       $recaudos_otor = ($total_fondo + $total_super) / 2;
       $recaudos_compa = ($total_fondo + $total_super) / 2;
       $iva_conceptos_otor = ($total_iva - ($iva_derechos_otor + $iva_derechos_compa)) / 2;
       $iva_conceptos_compa = ($total_iva - ($iva_derechos_otor + $iva_derechos_compa)) / 2;

       $reteconsumo_otor = $total_reteconsumo / 2;
       $reteconsumo_compa = $total_reteconsumo / 2;
       $aporteespecial_otor = $total_aporteespecial / 2;
       $aporteespecial_compa = $total_aporteespecial / 2;
       $impuesto_tiembre_otor = $total_impuesto_tiembre / 2;
       $impuesto_tiembre_compa = $total_impuesto_tiembre / 2;

       
       $total_otorgante = $total_rtf 
       + $total_conceptos_otorgante 
       + $total_derechos_otorgante 
       + $iva_derechos_otor
       + $iva_conceptos_otor
       + $recaudos_otor
       + $reteconsumo_otor
       + $aporteespecial_otor
       + $impuesto_tiembre_otor;
       

       $total_compareciente = $total_conceptos_compareciente 
       + $total_derechos_compareciente
       + $iva_derechos_compa
       + $recaudos_compa
       + $iva_conceptos_compa
       + $reteconsumo_compa
       + $aporteespecial_compa
       + $impuesto_tiembre_compa;

       $data['total_otorgante'] = $total_otorgante;
       $data['total_compareciente'] = $total_compareciente;


      $html = view('pdf.liquidacion',$data)->render();

      $namefile = 'Liquidacion'.$id_radica.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
          // "format" => "Letter en mm",
        "format" => 'Letter',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);
      

    }

    

    public function FacturaCajaRapidaPost(Request $request){

      $notaria = Notaria::find(1);
      $prefijo_fact = $notaria->prefijo_facturarapida;
      $id_concepto = $request->id_concepto;
      $num_fact  = $request->session()->get('numfactrapida');
      $anio_trabajo = $notaria->anio_trabajo;
      //TARIFA DEL IVA
      $porcentaje_iva = round((Tarifa::find(9)->valor1));
      

      $facturas = Facturascajarapida::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = 0;
        $total_reteconsumo = 0;
        $total_aporteespecial = 0;
        $total_fondo = 0;
        $total_super = 0;
        $total_fact = $factura->total_fact;
        $reteiva = 0;
        $retertf = 0;
        $reteica = 0;
        $subtotal1 = $factura->subtotal;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $cufe_almacenado = $factura->cufe;
      }

       /*Medios de Pago*/


      $mediodepago = '';
      
      $Medpago = Mediodepagocajarapida_view::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }

      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }
      
      
      $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
      ->where('id_fact', $num_fact)
      ->get()
      ->toArray();

      $contdetalle = count ($detalle, 0);
      
      $subtotal_all = 0;
      $total_iva = 0;
      $total_all = 0;

      foreach ($detalle as $Key => $value) {
        $subtotal_all += $value['subtotal'];
        $total_iva += $value['iva'];
        $total_all += $value['total'];
      }
      

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion_cajarapida;
      $piepagina_fact = $notaria->piepagina_factcajarapida;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================


      $cufe = $cufe_almacenado;//$request->session()->get('CUFE_SESION');
      if(is_null($cufe)){
        $cufe = "sin facturar";
      }
      $QRCode = $cufe;

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura o comprobante
      
      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['detalle'] = $detalle;
      $data['contdetalle'] = $contdetalle;
      $data['subtotal'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['subtotal_all'] = $subtotal_all;
      $data['total_iva'] = $total_iva;
      $data['total_all'] = $total_all;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;
      $data['titulo'] = $FactComprobante;
      $data['formadepago'] = $formadepago;
      $data['mediodepago'] = $mediodepago;
      $data['porcentaje_iva'] = $porcentaje_iva;

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);

      if($cufe == "sin facturar"){
        $piepagina_fact = '';
        $html = view('pdf.generar_recibo_caja_rapida',$data)->render();
      }else{
        $html = view('pdf.generarcajarapidapos',$data)->render();
      }
      

      $namefile = $num_fact.'_F1'.'.pdf';
      //$namefile = 'facturan13'.$num_fact.'.pdf';



      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $tamano_hoja = array(80, 250); // Ancho x Alto en milímetros
      
      // Configurar márgenes (en milímetros)
      $margenes = array('left' => 5, 'right' => 5, 'top' => 2, 'bottom' => 2);


      // Combinar las configuraciones
      $configuracion = [
        'format' => $tamano_hoja,
        'margin_left' => $margenes['left'],
        'margin_right' => $margenes['right'],
        'margin_top' => $margenes['top'],
        'margin_bottom' => $margenes['bottom'],
      ];

      $mpdf = new \Mpdf\Mpdf($configuracion);


        $mpdf->SetHTMLFooter('
          <table width="100%">
          <tr>
          <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
          </tr>
          </table>');
        $carpeta_destino_cliente = public_path() . '/cliente_cajarapida/';
        $mpdf->defaultfooterfontsize=2;
        $mpdf->SetTopMargin(5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($namefile,"i");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'f'); //guarda a ruta
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);
      $request->session()->forget('numfactrapida');


    }


    public function FacturaCajaRapida(Request $request){

      $notaria = Notaria::find(1);
      $prefijo_fact = $notaria->prefijo_facturarapida;
      $id_concepto = $request->id_concepto;
      $num_fact  = $request->session()->get('numfactrapida');
      $anio_trabajo = $notaria->anio_trabajo;
      //TARIFA DEL IVA
      $porcentaje_iva = round((Tarifa::find(9)->valor1));
      

      $facturas = Facturascajarapida::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = 0;
        $total_reteconsumo = 0;
        $total_aporteespecial = 0;
        $total_fondo = 0;
        $total_super = 0;
        $total_fact = $factura->total_fact;
        $reteiva = 0;
        $retertf = 0;
        $reteica = 0;
        $subtotal1 = $factura->subtotal;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $cufe_almacenado = $factura->cufe;
      }

      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Efectivo";
      }

       /*Medios de Pago*/


      $mediodepago = '';
      
      $Medpago = Mediodepagocajarapida_view::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }
      
      
      $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
      ->where('id_fact', $num_fact)
      ->get()
      ->toArray();

      $contdetalle = count ($detalle, 0);
      
      $subtotal_all = 0;
      $total_iva = 0;
      $total_all = 0;

      foreach ($detalle as $Key => $value) {
        $subtotal_all += $value['subtotal'];
        $total_iva += $value['iva'];
        $total_all += $value['total'];
      }
      

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion_cajarapida;
      $piepagina_fact = $notaria->piepagina_factcajarapida;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================


      $cufe = $cufe_almacenado;//$request->session()->get('CUFE_SESION');
      if(is_null($cufe)){
        $cufe = "sin facturar";
      }
      $QRCode = $cufe;

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura o comprobante
      
      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['detalle'] = $detalle;
      $data['contdetalle'] = $contdetalle;
      $data['subtotal'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['subtotal_all'] = $subtotal_all;
      $data['total_iva'] = $total_iva;
      $data['total_all'] = $total_all;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;
      $data['titulo'] = $FactComprobante;
      $data['formadepago'] = $formadepago;
      $data['mediodepago'] = $mediodepago;
      $data['porcentaje_iva'] = $porcentaje_iva;

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);

      if($cufe == "sin facturar"){
        $piepagina_fact = '';
        $html = view('pdf.generar_recibo_caja_rapida',$data)->render();
      }else{
        $html = view('pdf.generarcajarapidapos',$data)->render();
      }
      

      $namefile = $num_fact.'_F1'.'.pdf';
      //$namefile = 'facturan13'.$num_fact.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $tamano_hoja = array(80, 250); // Ancho x Alto en milímetros
      
      // Configurar márgenes (en milímetros)
      $margenes = array('left' => 5, 'right' => 5, 'top' => 5, 'bottom' => 5);


      // Combinar las configuraciones
      $configuracion = [
        'format' => $tamano_hoja,
        'margin_left' => $margenes['left'],
        'margin_right' => $margenes['right'],
        'margin_top' => $margenes['top'],
        'margin_bottom' => $margenes['bottom'],
      ];

      $mpdf = new \Mpdf\Mpdf($configuracion);


        $mpdf->SetHTMLFooter('
          <table width="100%">
          <tr>
          <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
          </tr>
          </table>');
        $carpeta_destino_cliente = public_path() . '/cliente_cajarapida/';
        $mpdf->defaultfooterfontsize=2;
        $mpdf->SetTopMargin(5);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->WriteHTML($html);
        $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);
      $request->session()->forget('numfactrapida');
    }


    public function PdfCopiaFacturaCajaRapidaPOS(Request $request){

      $notaria = Notaria::find(1);
      $prefijo_fact = $notaria->prefijo_facturarapida;
      $id_concepto = $request->id_concepto;
      $num_fact  = $request->session()->get('numfact');
      //TARIFA DEL IVA
      $porcentaje_iva = round((Tarifa::find(9)->valor1));
      
      $facturas = Facturascajarapida::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = 0;
        $total_reteconsumo = 0;
        $total_aporteespecial = 0;
        $total_fondo = 0;
        $total_super = 0;
        $total_fact = $factura->total_fact;
        $reteiva = 0;
        $retertf = 0;
        $reteica = 0;
        $subtotal1 = $factura->subtotal;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $cufe = $factura->cufe;
      }

      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }

      /*Medios de Pago*/


      $mediodepago = '';
      
      $Medpago = Mediodepagocajarapida_view::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($Medpago as $med) {
        $efectivo = $med->efectivo;
        $cheque = $med->cheque;
        $consignacion_bancaria = $med->consignacion_bancaria;
        $pse = $med->pse;
        $transferencia_bancaria = $med->transferencia_bancaria;
        $tarjeta_credito = $med->tarjeta_credito;
        $tarjeta_debito = $med->tarjeta_debito;
      }

      if($efectivo > 0){
        $mediodepago = 'Efectivo';
      }

      if($cheque > 0){
        $mediodepago = $mediodepago.', '.'Cheque';
      }

       if($consignacion_bancaria > 0){
          $mediodepago = $mediodepago.', '.'Consig_banc';
      }

     
      if($pse > 0){
        $mediodepago = $mediodepago.', '.'Pse';
      }

      if($transferencia_bancaria > 0){
        $mediodepago = $mediodepago.', '.'Transfe_banca';
      }

      if($tarjeta_credito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_cred';
      }

      if($tarjeta_debito > 0){
        $mediodepago = $mediodepago.', '.'Tarj_deb';
      }


      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }

      
      
      $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
      ->where('id_fact', $num_fact)
      ->get()
      ->toArray();

      $contdetalle = count ($detalle, 0);
      
      $subtotal_all = 0;
      $total_iva = 0;
      $total_all = 0;

      foreach ($detalle as $Key => $value) {
        $subtotal_all += $value['subtotal'];
        $total_iva += $value['iva'];
        $total_all += $value['total'];
      }

      

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion_cajarapida;
      $piepagina_fact = $notaria->piepagina_factcajarapida;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================
      if(is_null($cufe)){
        $cufe = "sin facturar";
      }
      $QRCode = $cufe;

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura o comprobante
      
      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['detalle'] = $detalle;
      $data['contdetalle'] = $contdetalle;
      $data['subtotal'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['subtotal_all'] = $subtotal_all;
      $data['total_iva'] = $total_iva;
      $data['total_all'] = $total_all;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $cufe;
      $data['titulo'] = $FactComprobante;
      $data['formadepago'] = $formadepago;
      $data['mediodepago'] = $mediodepago;
      $data['porcentaje_iva'] = $porcentaje_iva;

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);

      if($cufe == "sin facturar"){
        $html = view('pdf.recibofactcajarapida',$data)->render();
      }else{
        $html = view('pdf.generarcajarapidapos',$data)->render();
      }
      
      //$html = view('pdf.generarcajarapida',$data)->render();

      $namefile = $num_fact.'_F1'.'.pdf';
      //$namefile = 'facturan13'.$num_fact.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];


      $tamano_hoja = array(80, 250); // Ancho x Alto en milímetros
      
      // Configurar márgenes (en milímetros)
      $margenes = array('left' => 5, 'right' => 5, 'top' => 2, 'bottom' => 2);


      // Combinar las configuraciones
      $configuracion = [
        'format' => $tamano_hoja,
        'margin_left' => $margenes['left'],
        'margin_right' => $margenes['right'],
        'margin_top' => $margenes['top'],
        'margin_bottom' => $margenes['bottom'],
      ];

      $mpdf = new \Mpdf\Mpdf($configuracion);


      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      //$carpeta_destino_cliente = public_path() . '/cliente_cajarapida/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"f");
      $mpdf->Output($namefile,"i");
      //$mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);
      
    }


    public function PdfNotaCreditoFacturaCajaRapida(Request $request){

      $notaria = Notaria::find(1);
      $prefijo_fact = $notaria->prefijo_facturarapida;
      $id_concepto = $request->id_concepto;
      $num_fact  = $request->session()->get('numfact');
      $id_ncf  = $request->session()->get('id_ncf');
      $anio_trabajo = $notaria->anio_trabajo;

      //TARIFA DEL IVA
      $porcentaje_iva = round((Tarifa::find(9)->valor1));


      $nota_credito = Notas_credito_cajarapida::where("prefijo_ncf","=",$prefijo_fact)->where("id_ncf","=",$id_ncf)->get();
      foreach ($nota_credito as $notacre) {
        $detalle_ncf = $notacre->detalle_ncf;
        $fecha_ncf = $notacre->created_at;
      }


      $facturas = Facturascajarapida::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = 0;
        $total_reteconsumo = 0;
        $total_aporteespecial = 0;
        $total_fondo = 0;
        $total_super = 0;
        $total_fact = $factura->total_fact;
        $reteiva = 0;
        $retertf = 0;
        $reteica = 0;
        $subtotal1 = $factura->subtotal;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h:i:s');
        $hora_cufe = Carbon::parse($factura->updated_at)->format('h:i:s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
      }

      if($forma_pago == true){
        $formadepago = "Credito";

      }else if($forma_pago == false){
        $formadepago = "Contado";
      }

      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        direccion_cli");
      $cliente = Cliente::where('identificacion_cli', $identificacioncli1)->select($raw)->get();
      foreach ($cliente as $key => $cli) {
        $nombrecli1 = $cli['fullname'];
        $direccioncli1 = $cli['direccion_cli'];
      }
      
      
      $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
      ->where('id_fact', $num_fact)
      ->get()
      ->toArray();

      $contdetalle = count ($detalle, 0);
      
      $subtotal_all = 0;
      $total_iva = 0;
      $total_all = 0;

      foreach ($detalle as $Key => $value) {
        $subtotal_all += $value['subtotal'];
        $total_iva += $value['iva'];
        $total_all += $value['total'];
      }
      

      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion_cajarapida;
      $piepagina_fact = $notaria->piepagina_factcajarapida;


      # =====================================
      # =           CUFE y QRCODE           =
      # =====================================

      $ID = $prefijo_fact.$id_ncf;
      $codImp1 = '01'; //IVA
      $valImp1 = $total_iva;
      $codImp2 = '04'; //Impuesto al consumo bolsa no se genera para nuestro caso
      $valImp2 = 0.00;
      $codImp3 = '03'; //ICA
      $valImp3 = $reteica;
      $valTot  = $total_fact;
      $NitOfe  = $nit;//Nit Notaría
      $NumAdq  = $identificacioncli1;
      //$ClTec   = '266669c6-4b51-429d-aedb-da51c8270516'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '1'; //1=AmbienteProduccion , 2: AmbientePruebas

      $cufe = $request->session()->get('CUFE_SESION');
      $UUID = hash('sha384', $cufe); //se deja vacio mientras tanto
      $QRCode = $cufe;

      $FactComprobante = $request->session()->get('recibo_factura'); //Si es factura o comprobante
      
      $iva = "Somos Responsables de IVA";
      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['resolucion'] = $resolucion;
      $data['piepagina_fact'] = $piepagina_fact;
      $data['IVA'] = $iva;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_fact'] = $num_fact;
      
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
      $data['hora_fact'] = $hora_fact;
      $data['hora_cufe'] = $hora_cufe;
      $data['detalle'] = $detalle;
      $data['contdetalle'] = $contdetalle;
      $data['subtotal'] = $subtotal1;
      $data['total_fact'] = $total_fact;
      $data['subtotal_all'] = $subtotal_all;
      $data['total_iva'] = $total_iva;
      $data['total_all'] = $total_all;
      $data['QRCode'] = $QRCode;
      $data['cufe'] = $UUID;
      $data['titulo'] = $FactComprobante;
      $data['formadepago'] = $formadepago;
      $data['id_ncf'] = $id_ncf;
      $data['detalle_ncf'] = $detalle_ncf;
      $data['fecha_ncf'] = $fecha_ncf;
      $data['porcentaje_iva'] = $porcentaje_iva;

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $html = view('pdf.generarnotacreditocajarapidapos',$data)->render();

      $namefile = $id_ncf.'_NC'.'.pdf';
      //$namefile = 'facturan13'.$num_fact.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];

      $tamano_hoja = array(80, 250); // Ancho x Alto en milímetros
      
      // Configurar márgenes (en milímetros)
      $margenes = array('left' => 5, 'right' => 5, 'top' => 2, 'bottom' => 2);


      // Combinar las configuraciones
      $configuracion = [
        'format' => $tamano_hoja,
        'margin_left' => $margenes['left'],
        'margin_right' => $margenes['right'],
        'margin_top' => $margenes['top'],
        'margin_bottom' => $margenes['bottom'],
      ];

      $mpdf = new \Mpdf\Mpdf($configuracion);

      $mpdf->SetHTMLFooter('
        <table width="100%">
        <tr>
        <td align="center"><font size="1">'.$piepagina_fact.'</font></td>
        </tr>
        </table>');
      $carpeta_destino_cliente = public_path() . '/cliente_cajarapida/';
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");
      $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);
      

    }

    public function Certificado_impuesto_timbre(Request $request)
    {
      $notaria = Notaria::find(1);
      $nombre_nota = $notaria->nombre_nota;
      $nombre_notario = $notaria->nombre_notario;
      $nit = $notaria->nit;
      $direccion_nota = $notaria->direccion_nota;
      $email = $notaria->email;
      $id_ciud = $notaria->id_ciud;
      $ciudad = Ciudad::find($id_ciud);
      $nombre_ciud = $ciudad->nombre_ciud;
      $num_factura = $request->session()->get('numfact');
      $anio_fiscal = $request->session()->get('anio_trabajo');
      $tipo_certificado = $request->session()->get('tipo_certificado');

      if($tipo_certificado == 1){
        $Tipo_certificado = "CERTIFICADO DE IMPUESTO AL TIMBRE No. ";
        $nombredelpdf = "certimbre";
        $consecutivo = Consecutivo::find(1);
        $consecutivo_timbre = $consecutivo->certi_impuesto_timbre;
        $id_cer = $consecutivo_timbre + 1;
        $consecutivo->certi_impuesto_timbre = $id_cer;
        $consecutivo->save();

      }else  if($tipo_certificado == 2){
        $Tipo_certificado = "CERTIFICADO DE RETENCIÓN EN LA FUENTE No. ";
        $nombredelpdf = "certrtf";
        $consecutivo = Consecutivo::find(1);
        $consecutivo_timbre = $consecutivo->certi_retencion_fuente;
        $id_cer = $consecutivo_timbre + 1;
        $consecutivo->certi_retencion_fuente = $id_cer;
        $consecutivo->save();
      }

      
      $fecha_certificado = date("d/m/Y");

      $Factura = Factura::where('id_fact', $num_factura)->where('anio_radica', $anio_fiscal)->get();
      foreach ($Factura as $fact) {
        $id_radica = $fact->id_radica;
        $prefijo_fact = $fact->prefijo;
        $fecha_factura = Carbon::parse($fact->fecha_fact)->format('d-m-Y');
        if($tipo_certificado == 1){
          $total_impuesto_timbre = $fact->total_impuesto_timbre;
        }else if($tipo_certificado == 2){
          $total_impuesto_timbre = $fact->total_rtf;
        }

        $identificacion_cli = $fact->a_nombre_de;
      }

      $Escritura = Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_fiscal)->get();
      foreach ($Escritura as $esc) {
        $num_escritura = $esc->num_esc;
        $fecha_escritura = Carbon::parse($esc->fecha_esc)->format('d-m-Y');
      }

      $nombre_cli = $this->Trae_Nombres($identificacion_cli);

      $Actos_persona_radica = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_fiscal)->get();
      foreach ($Actos_persona_radica as $apr) {
        if($apr->porcentajecli1 > 0){
          $cuantia = $apr->cuantia;
        }
      }

      
      $data['id_cer'] = $id_cer;
      $data['nombre_nota'] = $nombre_nota;
      $data['nombre_notario'] = $nombre_notario;
      $data['nit'] = $nit;
      $data['direccion_nota'] = $direccion_nota;
      $data['email'] = $email;
      $data['num_escritura'] = $num_escritura;
      $data['anio_gravable'] = $anio_fiscal;
      $data['fecha_escritura'] = $fecha_escritura;
      $data['ciudad'] = $nombre_ciud;
      $data['nombre_contribuyente'] = $nombre_cli;
      $data['identificacion_contribuyente'] = $identificacion_cli;
      $data['prefijo_fact'] = $prefijo_fact;
      $data['num_factura'] = $num_factura;
      $data['fecha_factura'] = $fecha_factura;
      $data['valor_venta'] = $cuantia;
      $data['total_retenido'] = $total_impuesto_timbre;
      $data['fecha_certificado'] = $fecha_certificado;
      $data['nombre_del_certificado'] = $Tipo_certificado;

      $html = view('pdf.certificadotimbre',$data)->render();

      $namefile =  $nombredelpdf.'_No.'.$id_cer.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        "format" => [216, 140],
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");


    }

    
    public function DepositosDiarios(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      

      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');

      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

      $Actas_deposito = Actas_deposito_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->where('anulada','<>', true)
      ->orderBy('id_act')
      ->get()->toArray();

      $totaldepositos = 0;
      $totalsaldo = 0;

      foreach ($Actas_deposito  as $key => $ad) {
        $totaldepositos += $ad['deposito_act'];
        $totalsaldo += $ad['saldo'];
      }

     

      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['depositos'] = $Actas_deposito;
      $data['totaldepositos'] = round($totaldepositos);
      $data['totalsaldo'] = round($totalsaldo);
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      
      $html = view('pdf.relaciondepositosdiarios',$data)->render();

      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }


     public function EgresosDiarios(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      

      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      $opcionreporte = $request->session()->get('opcionreporte');

      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");

      if($opcionreporte == 'completo'){
      $Actas_egreso = Actas_deposito_egreso_view::whereDate('fecha_egreso', '>=', $fecha1)
      ->whereDate('fecha_egreso', '<=', $fecha2)
      ->orderBy('id_act')
      ->get()->toArray();
    }else if($opcionreporte == 'maycero'){
      $Actas_egreso = Actas_deposito_egreso_view::whereDate('fecha_egreso', '>=', $fecha1)
      ->whereDate('fecha_egreso', '<=', $fecha2)
      ->where('nuevo_saldo', '>', 0)
      ->orderBy('id_act')
      ->get()->toArray();
    }


      $totaldepositos = 0;
      $totalegresos = 0;
      $totalsaldo = 0;

      foreach ($Actas_egreso  as $key => $ad) {
        //$totaldepositos += $ad['deposito_act'];
        $totalegresos += $ad['egreso_egr'];
        //$totalsaldo += $ad['saldo'];
      }

     

      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['egresos'] = $Actas_egreso;
      //$data['totaldepositos'] = round($totaldepositos);
      $data['totalegresos'] = round($totalegresos);
      //$data['totalsaldo'] = round($totalsaldo);
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      
      $html = view('pdf.relaciondeegresosdiarios',$data)->render();

      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }


    public function IngresosporEscriturador(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      

      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      $opcionreporte = $request->session()->get('opcionreporte');
      $id_proto = $request->session()->get('id_proto');


      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");
       $resultadoFinal = [];

      if($opcionreporte == 'general'){
        $alfabeto = range('A', 'Z');
       
        foreach ($alfabeto as $letra) {
          $Relingescr = Ingresosporescrituradores_view::
          whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->where('nombre_proto', 'like', $letra . '%')
        ->orderBy('num_esc')
        ->get()->toArray();
          $resultadoFinal[$letra] = $Relingescr;
        }

         $resultadoFinal = array_merge(...array_values($resultadoFinal));
         $cantescrituras = 'Solo cuando el informe es agrupado por Escriturador';
        
      }else if($opcionreporte == 'porescriturador'){
        $Relingescr = Ingresosporescrituradores_view::
          whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->where('id_proto', '=', $id_proto)
        ->orderBy('num_esc')
        ->get()->toArray();
         $resultadoFinal = $Relingescr;

         $cantidad = Ingresosporescrituradores_view::
          whereDate('fecha_fact', '>=', $fecha1)
          ->whereDate('fecha_fact', '<=', $fecha2)
          ->where('id_proto', '=', $id_proto)
          ->groupBy('num_esc')
          ->selectRaw('num_esc, count(*) as cantidad')
          ->get();
        $cantescrituras = $cantidad->count();
      }

        $totalderechos = 0;
        $totalconceptos = 0;
        $totalingresos = 0;

      foreach ($resultadoFinal  as $key => $res) {
        $totalderechos += $res['total_derechos'];
        $totalconceptos += $res['total_conceptos'];
        $totalingresos += $res['ingresos'];
      }


      $nombre_reporte = $request->session()->get('nombre_reporte');

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['relingescr'] = $resultadoFinal;
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      $data['totalderechos'] = $totalderechos;
      $data['totalconceptos'] = $totalconceptos;
      $data['totalingresos'] = $totalingresos;
      $data['cantescrituras'] = $cantescrituras;

      
      $html = view('pdf.ingresosporescriturador',$data)->render();
      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }


    public function Retefuentesaplicadaspdf(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");
      $nombre_reporte = $request->session()->get('nombre_reporte');
      
      $Informe = Retencionesaplicadas_view::
          whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        //->where('nombre_proto', 'like', $letra . '%')
        ->orderBy('id_fact')
        ->get()->toArray();
         
  
        $totalderechos = 0;
        $totalconceptos = 0;
        $totalreteica = 0;
        $totalreteiva = 0;
        $totalretefte = 0;

      foreach ($Informe  as $key => $res) {
        $totalderechos += $res['total_derechos'];
        $totalconceptos += $res['total_conceptos'];
        $totalreteica += $res['ica'];
        $totalreteiva += $res['retefte'];
        $totalretefte += $res['reteiva'];
      }

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['informe'] = $Informe;
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      $data['totalderechos'] = $totalderechos;
      $data['totalconceptos'] = $totalconceptos;
      $data['totalreteica'] = $totalreteica;
      $data['totalreteiva'] = $totalreteiva;
      $data['totalretefte'] = $totalretefte;

      
      $html = view('pdf.reteaplicadas',$data)->render();
      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }

     public function Retencionenlafuente_pdf(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");
      $nombre_reporte = $request->session()->get('nombre_reporte');
      
      $Informe = Retencionenlafuente_view::
          whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->orderBy('id_fact')
        ->get()->toArray();
         
  
        $totalretefte = 0;

      foreach ($Informe  as $key => $res) {
        $totalretefte += $res['total_rtf'];
      }

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['informe'] = $Informe;
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      $data['totalretefte'] = $totalretefte;

      
      $html = view('pdf.retefuentes',$data)->render();
      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }

    public function Escrituras_Sin_Factura(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");
      $nombre_reporte = $request->session()->get('nombre_reporte');
      
      // Subconsulta para obtener facturas con nota de crédito
        $facturasConNotaCredito = Factura::join('escrituras', function($join) {
                $join->on('facturas.id_radica', '=', 'escrituras.id_radica')
                     ->on('facturas.anio_radica', '=', 'escrituras.anio_radica');
            })
            ->where('facturas.nota_credito', true)
            ->whereBetween('facturas.fecha_fact', [$fecha1, $fecha2])
            ->select('facturas.id_fact', 'facturas.id_radica', 'facturas.anio_radica', 'escrituras.num_esc', 'escrituras.fecha_esc')
            ->get();

        // Subconsulta para obtener facturas sin nota de crédito
        $facturasSinNotaCredito = Factura::join('escrituras', function($join) {
                $join->on('facturas.id_radica', '=', 'escrituras.id_radica')
                     ->on('facturas.anio_radica', '=', 'escrituras.anio_radica');
            })
            ->where('facturas.nota_credito', false)
            ->whereBetween('facturas.fecha_fact', [$fecha1, $fecha2])
            ->select('facturas.id_fact', 'facturas.id_radica', 'facturas.anio_radica', 'escrituras.num_esc', 'escrituras.fecha_esc')
            ->get();

        // Filtrar las escrituras que no tienen una nota de crédito correspondiente
        $result = $facturasConNotaCredito->filter(function($fcnc) use ($facturasSinNotaCredito) {
            return !$facturasSinNotaCredito->contains('num_esc', $fcnc->num_esc);
        });

        // Transformar el resultado al formato deseado
        $finalResult = $result->map(function($item) {
            return [
                'num_esc' => $item->num_esc,
                'fecha_esc'=> $item->fecha_esc,
                'id_radica' => $item->id_radica,
            ];
        });

      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['informe'] = $finalResult;
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
           
      $html = view('pdf.informeescriturassinfactura',$data)->render();
      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }

    
     public function ConsolidadoCaja(Request $request){
      $notaria = Notaria::find(1);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $identificacion_not = $notaria->identificacion_not;
      
      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');
      
      $fecha_reporte =  $fecha1." A ". $fecha2;
      $fecha_impresion = date("d/m/Y");
      $nombre_reporte = $request->session()->get('nombre_reporte');

      $escri_contado = 0;
      $escri_credito = 0;
      $facturas_contado = Factura::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('credito_fact', false)
                      ->where('nota_credito', false)
                      ->selectRaw('SUM(total_fact) as total_fact')
                      ->first();
      $facturas_credito = Factura::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('credito_fact', true)
                      ->where('nota_credito', false)
                      ->selectRaw('SUM(total_fact) as total_fact')
                      ->first();

        if (!$facturas_contado) {
          $escri_contado = 0;

        } else {
          $escri_contado = $facturas_contado->total_fact;
        }

        if (!$facturas_credito) {
          $escri_credito = 0;

        } else {
          $escri_credito = $facturas_credito->total_fact;
        }


      $cajarapida_contado = 0;
      $cajarapida_credito = 0;
      
      $facturas_contado_cajarapida = Facturascajarapida::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('credito_fact', false)
                      ->where('nota_credito', false)
                      ->selectRaw('SUM(total_fact) as total_fact')
                      ->first();
      $facturas_credito_cajarapida = Facturascajarapida::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('credito_fact', true)
                      ->where('nota_credito', false)
                      ->selectRaw('SUM(total_fact) as total_fact')
                      ->first();

        if (!$facturas_contado_cajarapida) {
          $cajarapida_contado = 0;

        } else {
          $cajarapida_contado = $facturas_contado_cajarapida->total_fact;
        }

        if (!$facturas_credito_cajarapida) {
          $cajarapida_credito = 0;

        } else {
          $cajarapida_credito = $facturas_credito_cajarapida->total_fact;
        }


      $total_contado = $escri_contado + $cajarapida_contado;
      $total_credito = $escri_credito + $cajarapida_credito;
      $total_escrituras = $escri_contado + $escri_credito;
      $total_cajarapida = $cajarapida_contado + $cajarapida_credito;
      $total = $total_escrituras + $total_cajarapida;


      $Base_cajarapida = Base_cajarapida::whereDate('fecha_base', '>=', $fecha1)
        ->whereDate('fecha_base', '<=', $fecha2)
        ->get()->toArray();
  
        if(!$Base_cajarapida){
          $cajarapida_base = 0;
        }else{
          foreach ($Base_cajarapida  as $key => $res) {
            $cajarapida_base = $res['valor_base'];
          }
        }

      $actas_base = 0;
      $escrituras_base = 0;
      $total_base = $cajarapida_base;


      $facturas_escrituras = Factura::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('nota_credito', false)
                      ->get();

       $facturas_cajarapida = Facturascajarapida::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('nota_credito', false)
                      ->get();

          $efectivo_es = 0;
          $cheque_es = 0;
          $consignacion_bancaria_es = 0;
          $pse_es = 0;
          $transferencia_bancaria_es = 0;
          $tarjeta_credito_es = 0;
          $tarjeta_debito_es = 0;

          $efectivo_cr = 0;
          $cheque_cr = 0;
          $consignacion_bancaria_cr = 0;
          $pse_cr = 0;
          $transferencia_bancaria_cr = 0;
          $tarjeta_credito_cr = 0;
          $tarjeta_debito_cr = 0;

          $efectivo_act = 0;
          $cheque_act = 0;
          $consignacion_bancaria_act = 0;
          $pse_act = 0;
          $transferencia_bancaria_act = 0;
          $tarjeta_credito_act = 0;
          $tarjeta_debito_act = 0;

          if (!$facturas_escrituras) {
            $efectivo_es = 0;
            $cheque_es = 0;
            $consignacion_bancaria_es = 0;
            $pse_es = 0;
            $transferencia_bancaria_es = 0;
            $tarjeta_credito_es = 0;
            $tarjeta_debito_es = 0;
          }else{
            foreach ($facturas_escrituras as $key => $fe) {
              $num_fact = $fe->id_fact;
              $prefijo_fact = $fe->prefijo;

              $Medpago = Mediosdepago::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
              foreach ($Medpago as $med) {
                $efectivo_es += $med->efectivo;
                $cheque_es += $med->cheque;
                $consignacion_bancaria_es += $med->consignacion_bancaria;
                $pse_es += $med->pse;
                $transferencia_bancaria_es += $med->transferencia_bancaria;
                $tarjeta_credito_es += $med->tarjeta_credito;
                $tarjeta_debito_es += $med->tarjeta_debito;
              }
            }

          }

           if (!$facturas_cajarapida) {
            $efectivo_cr = 0;
            $cheque_cr = 0;
            $consignacion_bancaria_cr = 0;
            $pse_cr = 0;
            $transferencia_bancaria_cr = 0;
            $tarjeta_credito_cr = 0;
            $tarjeta_debito_cr = 0;
          }else{
            foreach ($facturas_cajarapida as $key => $fc) {
              $num_fact = $fc->id_fact;
              $prefijo_fact = $fc->prefijo;

              $Medpago = Mediodepagocajarapida_view::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
              foreach ($Medpago as $med) {
                $efectivo_cr += $med->efectivo;
                $cheque_cr += $med->cheque;
                $consignacion_bancaria_cr += $med->consignacion_bancaria;
                $pse_cr += $med->pse;
                $transferencia_bancaria_cr += $med->transferencia_bancaria;
                $tarjeta_credito_cr += $med->tarjeta_credito;
                $tarjeta_debito_cr += $med->tarjeta_debito;
              }
            }
          }


         $actas_deposito = Actas_deposito::whereDate('fecha_acta', '>=', $fecha1)
                      ->whereDate('fecha_acta', '<=', $fecha2)
                      ->where('anulada', false)
                      ->get();
         
         if ($actas_deposito->isEmpty()) {
            $efectivo_act = 0;
            $cheque_act = 0;
            $consignacion_bancaria_act = 0;
            $pse_act = 0;
            $transferencia_bancaria_act = 0;
            $tarjeta_credito_act = 0;
            $tarjeta_debito_act = 0;
         }else{
           foreach ($actas_deposito as $med) {
            $efectivo_act += $med->efectivo;
            $cheque_act += $med->cheque;
            $consignacion_bancaria_act += $med->consignacion_bancaria;
            $pse_act += $med->pse;
            $transferencia_bancaria_act += $med->transferencia_bancaria;
            $tarjeta_credito_act += $med->tarjeta_credito;
            $tarjeta_debito_act += $med->tarjeta_debito;
          }
         }

        $total_efectivo = $efectivo_es + 
                          $efectivo_cr + 
                          $efectivo_act;

        $total_transbanc = $transferencia_bancaria_es + 
                           $transferencia_bancaria_cr + 
                           $transferencia_bancaria_act;

        $total_consgbanc =  $consignacion_bancaria_es +
                            $consignacion_bancaria_cr +
                            $consignacion_bancaria_act;

        $total_pse =  $pse_es +
                      $pse_cr +
                      $pse_act;

        $total_tcredito = $tarjeta_credito_es +
                          $tarjeta_credito_cr +
                          $tarjeta_credito_act;

        $total_tdebito = $tarjeta_debito_es +
                          $tarjeta_debito_cr +
                          $tarjeta_debito_act;

        $total_cheque = $cheque_es +
                        $cheque_cr +
                        $cheque_act;


        $total_mediosescrituras = $cheque_es +
                                  $tarjeta_debito_es +
                                  $tarjeta_credito_es +
                                  $pse_es +
                                  $consignacion_bancaria_es +
                                  $transferencia_bancaria_es +
                                  $efectivo_es +
                                  $escrituras_base;

        $total_medioscajarapida = $cheque_cr +
                                  $tarjeta_debito_cr +
                                  $tarjeta_credito_cr +
                                  $pse_cr +
                                  $consignacion_bancaria_cr +
                                  $transferencia_bancaria_cr +
                                  $efectivo_cr +
                                  $cajarapida_base;

        $total_mediosactas =  $cheque_act +
                              $tarjeta_debito_act +
                              $tarjeta_credito_act +
                              $pse_act +
                              $consignacion_bancaria_act +
                              $transferencia_bancaria_act +
                              $efectivo_act +
                              $actas_base;


        $totalmediosdepago =  $total_mediosescrituras +
                              $total_medioscajarapida + 
                              $total_mediosactas;
 


      $data['nit'] = $nit;
      $data['nombre_nota'] = $nombre_nota;
      $data['direccion_nota'] = $direccion_nota;
      $data['telefono_nota'] = $telefono_nota;
      $data['email'] = $email;
      $data['nombre_notario'] = $nombre_notario;
      $data['nombre_reporte'] = $nombre_reporte;
      $data['fecha_reporte'] = $fecha_reporte;
      $data['fecha_impresion'] = $fecha_impresion;
      $data['escri_contado'] = $escri_contado;
      $data['cajarapida_contado'] = $cajarapida_contado;
      $data['total_contado'] = $total_contado;
      $data['escri_credito'] = $escri_credito;
      $data['cajarapida_credito'] = $cajarapida_credito;
      $data['total_credito'] = $total_credito;
      $data['total_escrituras'] = $total_escrituras;
      $data['total_cajarapida'] = $total_cajarapida;
      $data['total'] = $total;
      $data['actas_base'] = $actas_base;
      $data['escrituras_base'] = $escrituras_base;
      $data['cajarapida_base'] = $cajarapida_base;
      $data['efectivo_act'] = $efectivo_act;
      $data['efectivo_es'] = $efectivo_es;
      $data['efectivo_cr'] = $efectivo_cr;
      $data['total_efectivo'] = $total_efectivo;
      $data['transferencia_bancaria_act'] = $transferencia_bancaria_act;
      $data['transferencia_bancaria_es'] = $transferencia_bancaria_es;
      $data['transferencia_bancaria_cr'] = $transferencia_bancaria_cr;
      $data['total_transbanc'] = $total_transbanc;
      $data['consignacion_bancaria_act'] = $consignacion_bancaria_act;
      $data['consignacion_bancaria_es'] = $consignacion_bancaria_es;
      $data['consignacion_bancaria_cr'] = $consignacion_bancaria_cr;
      $data['total_consgbanc'] = $total_consgbanc;
      $data['pse_act'] = $pse_act;
      $data['pse_es'] = $pse_es;
      $data['pse_cr'] = $pse_cr;
      $data['total_pse'] = $total_pse;
      $data['tarjeta_credito_act'] = $tarjeta_credito_act;
      $data['tarjeta_credito_es'] = $tarjeta_credito_es;
      $data['tarjeta_credito_cr'] = $tarjeta_credito_cr;
      $data['total_tcredito'] = $total_tcredito;
      $data['tarjeta_debito_act'] = $tarjeta_debito_act;
      $data['tarjeta_debito_es'] = $tarjeta_debito_es;
      $data['tarjeta_debito_cr'] = $tarjeta_debito_cr;
      $data['total_tdebito'] = $total_tdebito;
      $data['cheque_act'] = $cheque_act;
      $data['cheque_es'] = $cheque_es;
      $data['cheque_cr'] = $cheque_cr;
      $data['total_cheque'] = $total_cheque;
      $data['total_mediosactas'] = $total_mediosactas;
      $data['total_mediosescrituras'] = $total_mediosescrituras;
      $data['total_medioscajarapida'] = $total_medioscajarapida;
      $data['totalmediosdepago'] = $totalmediosdepago;
      $data['total_base'] = $total_base;
                
      $html = view('pdf.informeconsolidadocaja',$data)->render();
      $namefile = $nombre_reporte.$fecha_reporte.'.pdf';

      $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
      $fontDirs = $defaultConfig['fontDir'];

      $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
      $fontData = $defaultFontConfig['fontdata'];
      $mpdf = new Mpdf([
        'fontDir' => array_merge($fontDirs, [
          public_path() . '/fonts',
        ]),
        'fontdata' => $fontData + [
          'arial' => [
            'R' => 'arial.ttf',
            'B' => 'arialbd.ttf',
          ],
        ],
        'default_font' => 'arial',
        //"format" => [216, 140],//TODO: Media Carta
        "format" => 'Letter-L',
        'margin_bottom' => 10,
      ]);

      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output($namefile,"I");

    }




    private function Trae_Nombres($identificacion){
      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname");
      $nombre = Cliente::where('identificacion_cli', $identificacion)->select($raw)->get();
      foreach ($nombre as $nom) {
        $nom = $nom->fullname;
      }
      return $nom;
    }


    private function convertir($n) {
      switch (true) {
        case ( $n >= 1 && $n <= 29) : return $this->basico($n); break;
        case ( $n >= 30 && $n < 100) : return $this->decenas($n); break;
        case ( $n >= 100 && $n < 1000) : return $this->centenas($n); break;
        case ($n >= 1000 && $n <= 999999): return $this->miles($n); break;
        case ($n >= 1000000): return $this->millones($n);
      }
    }


    private function basico($numero) {
      $valor = array ('un','dos','tres','cuatro','cinco','seis','siete','ocho',
        'nueve','diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis',
        'diecisiete', 'dieciocho', 'diecinueve', 'veinte', 'veintiunu', 'veintidos',
        'veintitres', 'veinticuatro','veinticinco', 'veintiséis','veintisiete',
        'veintiocho','veintinueve');
      return $valor[$numero - 1];
    }

    private function decenas($n) {
      $decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
        70=>'setenta',80=>'ochenta',90=>'noventa');
      if( $n <= 29) return $this->basico($n);
      $x = $n % 10;
      if ( $x == 0 ) {
        return $decenas[$n];
      } else return $decenas[$n - $x].' y '. $this->basico($x);
    }

    private function centenas($n) {
      $cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
        400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
        700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
      if( $n >= 100) {
        if ( $n % 100 == 0 ) {
          return $cientos[$n];
        } else {
          $u = (int) substr($n,0,1);
          $d = (int) substr($n,1,2);
          return (($u == 1)?'ciento':$cientos[$u*100]).' '.$this->decenas($d);
        }
      } else return $this->decenas($n);
    }

    private function miles($n) {
      if($n > 999) {
        if( $n == 1000) {return 'mil';}
        else {
          $l = strlen($n);
          $c = (int)substr($n,0,$l-3);
          $x = (int)substr($n,-3);
          if($c == 1) {$cadena = 'mil '.$this->centenas($x);}
          else if($x != 0) {$cadena = $this->centenas($c).' mil '.$this->centenas($x);}
          else $cadena = $this->centenas($c). ' mil';
          return $cadena;
        }
      } else return $this->centenas($n);
    }

    private function millones($n) {
      if($n == 1000000) {return 'un millón';}
      else {
        $l = strlen($n);
        $c = (int)substr($n,0,$l-6);
        $x = (int)substr($n,-6);
        if($c == 1) {
          $cadena = ' millón ';
        } else {
          $cadena = ' millones ';
        }
        return $this->miles($c).$cadena.(($x > 0)?$this->miles($x):'');
      }
    }
  }

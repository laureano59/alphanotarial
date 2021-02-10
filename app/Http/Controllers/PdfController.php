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
use App\Cajadiariogeneral_view;
use App\Cruces_actas_deposito_view;
use App\Egreso_acta_deposito;
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
use App\Detalle_cajarapidafacturas;
use App\Facturascajarapida;
use App\Notas_credito_cajarapida;
use App\Protocolistas_copias_view;


class PdfController extends Controller
{

  public function pdf(Request $request){
    $opcion = $request->session()->get('opcion');//TODO:Session para tipo de factura
    $prefijo_fact = $request->session()->get('prefijo_fact');
    $num_fact = $request->session()->get('numfactura');//TODO:Obtiene el número de factura por session
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $id_radica = $request->session()->get('key');//Obtiene el número de radicación por session
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
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $ingresos = $factura->total_derechos + $factura->total_conceptos;
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
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


      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(2)->get()->toArray();
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
      //$ClTec   = '266669c6-4b51-429d-aedb-da51c8270516'; //Clave tecnica, se encuentra en el portal de la pactura electronica que nos provve la dian
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas

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
      $data['num_esc'] = $num_esc;
      $data['id_radica'] = $id_radica;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
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
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva";
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
      //$prefijo_fact = $request->session()->get('prefijo_fact');
      //$num_fact = $request->session()->get('numfactura');//TODO:Obtiene el número de factura por session
      //$id_radica = $request->session()->get('key');//TODO:Obtiene el número de radicación por session
      //$num_esc = $request->session()->get('num_esc');//TODO:Obtiene el número de escritura por session

      //$factura = Factura::find($num_fact);
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
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = $factura->credito_fact;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
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

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(2)->get()->toArray();
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
      $TipoAmbiente = '2'; //1=AmbienteProduccion , 2: AmbientePruebas
      
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
      $data['num_esc'] = $num_esc;
      $data['id_radica'] = $id_radica;
      $data['identificacioncli1'] = $identificacioncli1;
      $data['nombrecli1'] = $nombrecli1;
      $data['direccioncli1'] = $direccioncli1;
      $data['fecha_fact'] = $fecha_fact;
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
        $terceros[$j]['concepto'] = "Iva";
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

    $fecha_recibido = $fecha_radica->format('d/m/yy');
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
  $anio_trabajo = $notaria->anio_trabajo;
  $nombre_nota = $notaria->nombre_nota;
  $nombre_notario = $notaria->nombre_notario;
  $nit = $notaria->nit;
  $direccion_nota = $notaria->direccion_nota;
  $email = $notaria->email;
  $anio_gravable = $anio_trabajo;
  $fecha_certificado = date("Y/m/d");
  $identificacion = $request->identificacion;

  $certificado_rtf = Certificado_rtf::where("id_radica","=",$id_radica)->where("anio_gravable","=",$anio_gravable)->where("identificacion_contribuyente","=",$identificacion)->get();
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
      "format" => [216, 140],//TODO: Media Carta
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


  /***************TODO:NOTA CREDITO FACTURA*******************/
  public function PdfNotaCreditoFact(Request $request){
    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_fact;
    //$anio_trabajo = $notaria->anio_trabajo;
    $num_fact = $request->session()->get('numfact');//TODO:Obtiene el número de factura por session
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
        $total_fact_otor = $factura_otor->total_fact;
        $reteiva_otor = $factura_otor->deduccion_reteiva;
        $retertf_otor = $factura_otor->deduccion_retertf;
        $reteica_otor = $factura_otor->deduccion_reteica;
        $subtotal1_otor = $factura_otor->total_derechos + $factura_otor->total_conceptos;
        $fecha_fact = Carbon::parse($factura_otor->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura_otor->fecha_fact)->format('h-i-s');
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
        $terceros[$j]['concepto'] = "Iva";
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
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
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
        $terceros[$j]['concepto'] = "Iva";
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
        $total_fact_otor = $factura_otor->total_fact;
        $reteiva_otor = $factura_otor->deduccion_reteiva;
        $retertf_otor = $factura_otor->deduccion_retertf;
        $reteica_otor = $factura_otor->deduccion_reteica;
        $subtotal1_otor = $factura_otor->total_derechos + $factura_otor->total_conceptos;
        $fecha_fact = Carbon::parse($factura_otor->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura_otor->fecha_fact)->format('h-i-s');
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
        $terceros[$j]['concepto'] = "Iva";
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
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
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
        $terceros[$j]['concepto'] = "Iva";
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

    $id_act = $Actas_deposito->id_act;
    $nombre = $Actas_deposito->nombre;
    $identificacion_cli = $Actas_deposito->identificacion_cli;
    $fecha = $Actas_deposito->fecha;
    $descripcion_tip = $Actas_deposito->descripcion_tip;
    $efectivo = $Actas_deposito->efectivo;
    $cheque = $Actas_deposito->cheque;
    $tarjeta_credito = $Actas_deposito->tarjeta_credito;
    $num_cheque = $Actas_deposito->num_cheque;
    $num_tarjetacredito = $Actas_deposito->num_tarjetacredito;
    $nombre_ban = $Actas_deposito->nombre_ban;
    $total_recibido = round($Actas_deposito->deposito_act);
    $total_en_letras = strtoupper($this->convertir($total_recibido)).' '.'PESOS M/CTE';


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

    $data['efectivo'] = $efectivo;
    $data['cheque'] = $cheque;
    $data['tarjeta_credito'] = $tarjeta_credito;
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
        'margin_bottom' => 10,
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
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');

    
    /*----------  Consulta Radicaciones con un solo acto  ----------*/
    
    $estadistico = Estadisticonotarial_unicas_view::whereBetween('fecha', [$fecha1, $fecha2])->get()->toArray();
       

    /*----------  Consulta Radicaciones con varios actos  ----------*/

    $estadistico_repe = Estadisticonotarial_repetidas_solo_radi_view::whereBetween('fecha', [$fecha1, $fecha2])->get()->toArray();

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
          $cantventa++;
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
      //$id_codigoagru = $esr['id_codigoagru'];
      $ingresos = round($esr['derechos']);
      $estadistico_rad = Estadisticonotarial_repetidas_view::where('id_radica', [$id_radica])->get()->toArray();

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


      if (in_array("7", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

            $cantliqsocie++;
            $ingreliqsocie += $ingresos;
      }

      if (in_array("8", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

            $cantreforsocial++;
            $ingrereforsocial += $ingresos;

      }

      if (in_array("9", $arr_codigo) ) {

            $cantsuce++;
            $ingresuce += $ingresos;

      }


      if (in_array("10", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

            $cantreglaproprefor++;
            $ingrereglaprorefor += $ingresos;

      }

      if (in_array("11", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) && !in_array("1", $arr_codigo)) {

              $cantproto++;
              $ingreproto += $ingresos;

      }

      if (in_array("12", $arr_codigo) && !in_array("18", $arr_codigo) && !in_array("14", $arr_codigo) && !in_array("9", $arr_codigo) && !in_array("3", $arr_codigo) && !in_array("4", $arr_codigo) ) {

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

    /*$ingreventas = $ingreventas;
    $ingrepermuta = $ingrepermuta;
    $ingrehipoteca = $ingrehipoteca;
    $ingrecancelhipo = $ingrecancelhipo;
    $ingreventaconhipo = $ingreventaconhipo;
    $ingreconstisocie = $ingreconstisocie;
    $ingreliqsocie = $ingreliqsocie;
    $ingrereforsocial = $ingrereforsocial;
    $ingresuce = $ingresuce;
    $ingrereglaprorefor = $ingrereglaprorefor;
    $ingreproto = $ingreproto;
    $ingrematri = $ingrematri;
    $ingrecorrecregis = $ingrecorrecregis;
    $ingrevis = $ingrevis;
    $ingredivor = $ingredivor;
    $ingremismosexo = $ingremismosexo;
    $ingreotros = $ingreotros;
    $ingrevipa = $ingrevipa;*/

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
    $fecha_reporte = date("Y/m/d");

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $anio_trabajo = date("Y", strtotime($fecha1));

    $fecha = $fecha1.' A '.$fecha2;

    $ordenar = $request->session()->get('ordenar');
    if($ordenar == 'pornumescritura'){ //Ordena por fatura
      $libroindice = Actos_notariales_escritura_view::whereBetween('fecha', [$fecha1, $fecha2])->orderBy('num_esc')->get()->toArray();
    }elseif($ordenar == 'libroindice'){//Ordena por nombre
      $libroindice = Libroindice_view::whereBetween('fecha', [$fecha1, $fecha2])->get()->toArray();
    }

    $contlibroindice = count ($libroindice, 0);

    $nombre_reporte = $request->session()->get('nombre_reporte');

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha;
    $data['libroindice'] = $libroindice;
    $data['contlibroindice'] = $contlibroindice;
    $data['nombre_reporte'] = $nombre_reporte;

    $html = view('pdf.libroindice',$data)->render();

    $namefile = 'libroindice_'.$fecha_reporte.'.pdf';

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

  public function PdfRelacionNotaCredito(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $fecha_reporte = date("Y/m/d");

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');

    $rel_notas_credito = Relacion_notas_credito_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->orderBy('id_ncf')->get()->toArray();
    $cont_rel_notas_credito = count ($rel_notas_credito, 0);

    $nombre_reporte = $request->session()->get('nombre_reporte');

    $data['nit'] = $nit;
    $data['nombre_nota'] = $nombre_nota;
    $data['direccion_nota'] = $direccion_nota;
    $data['telefono_nota'] = $telefono_nota;
    $data['email'] = $email;
    $data['nombre_notario'] = $nombre_notario;
    $data['fecha_reporte'] = $fecha_reporte;
    $data['rel_notas_credito'] = $rel_notas_credito;
    $data['cont_rel_notas_credito'] = $cont_rel_notas_credito;
    $data['nombre_reporte'] = $nombre_reporte;

    $html = view('pdf.relacionnotacredito',$data)->render();

    $namefile = 'relnotacredito'.$fecha_reporte.'.pdf';

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
    $fecha_reporte = date("Y/m/d");

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');

    $identificacion_cli = $request->session()->get('identificacion_cli');
    $ordenar = $request->session()->get('ordenar');
    if($ordenar == 'porfecha'){ //por fecha
      $informecartera = Informe_cartera_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('nota_credito', false)
      ->where('saldo_fact', '>=', 1)
      ->orderBy('id_fact')
      ->get()
      ->toArray();
    }elseif($ordenar == 'porcliente'){//por cliente
      $informecartera = Informe_cartera_view::where('identificacion_cli', $identificacion_cli)
      ->where('nota_credito', false)
      ->where('saldo_fact', '>=', 1)
      ->orderBy('id_fact')->get()->toArray();
    }

    $total_pago = 0;
    $total_saldo = 0;
    foreach ($informecartera as $key => $inf) {
      $total_pago = $inf['total_fact'] + $total_pago;
      $total_saldo = $inf['saldo_fact'] + $total_saldo;
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
    $data['informecartera'] = $informecartera;
    $data['continformecartera'] = $continformecartera;
    $data['nombre_reporte'] = $nombre_reporte;
    $data['total_pago'] = $total_pago;
    $data['total_saldo'] = $total_saldo;

    $html = view('pdf.informecartera',$data)->render();

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
    $fecha_reporte = date("Y/m/d");
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
      $fecha_reporte = date("Y/m/d");

      $fecha1 = $request->session()->get('fecha1');
      $fecha2 = $request->session()->get('fecha2');

      $fecha = $fecha1.' A '.$fecha2;

      $raw1 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
      $rango1 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->where('cuantia','>=', 0)
      ->where('cuantia','<=', 100000000)
      ->groupBy('escr')
      ->select($raw1)->get()->toArray();

     
      $raw2 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
      $rango2 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->where('cuantia','>=', 100000001)
      ->where('cuantia','<=', 300000000)
      ->groupBy('escr')
      ->select($raw2)->get()->toArray();



      $raw3 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
      $rango3 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->where('cuantia','>=', 300000001)
      ->where('cuantia','<=', 500000000)
      ->groupBy('escr')
      ->select($raw3)->get()->toArray();


      
      $raw4 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
      $rango4 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->where('cuantia','>=', 500000001)
      ->where('cuantia','<=', 1000000000)
      ->groupBy('escr')
      ->select($raw4)->get()->toArray();

            

      $raw5 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
      $rango5 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->where('cuantia','>=', 1000000001)
      ->where('cuantia','<=', 1500000000)
      ->groupBy('escr')
      ->select($raw5)->get()->toArray();
      

      $raw6 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(Total) AS total");
      $rango6 = Recaudos_concuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->where('cuantia','>', 1500000000)
      ->groupBy('escr')
      ->select($raw6)->get()->toArray();

      

      $raw7 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(super + fondo) AS total");
      $sincuantia = Recaudos_sincuantia_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->groupBy('escr')
      ->select($raw7)->get()->toArray();

           
      $raw8 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(super + fondo) AS total");
      $excenta = Recaudos_excenta_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
      ->groupBy('escr')
      ->select($raw8)->get()->toArray();

      $raw9 = \DB::raw("MIN(escr) AS escr, SUM(super) AS super, SUM(fondo) AS fondo, SUM(super + fondo) AS total");
      $sincuantiaexcenta = Recaudos_sincuantia_excenta_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<', $fecha2)
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

  public function PdfCajaDiarioGeneral(Request $request){
    $notaria = Notaria::find(1);
    $nit = $notaria->nit;
    $nombre_nota = strtoupper($notaria->nombre_nota);
    $direccion_nota = $notaria->direccion_nota;
    $telefono_nota = $notaria->telefono_nota;
    $email = $notaria->email;
    $nombre_notario = $notaria->nombre_notario;
    $identificacion_not = $notaria->identificacion_not;
    $fecha_reporte = date("Y/m/d");

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');

    $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY

    $tipoinforme = $request->session()->get('tipoinforme');

    if($tipoinforme == 'completo'){
      $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2)
        ->where('anio_esc', '=', $anio_trabajo)
        ->get()
        ->toArray();
    }else if($tipoinforme == 'contado'){
      $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2)
        ->where('anio_esc', '=', $anio_trabajo)
        ->where('tipo_pago', '=', 'Contado')
        ->get()
        ->toArray();
    }else if($tipoinforme == 'credito'){
      $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2)
        ->where('anio_esc', '=', $anio_trabajo)
        ->where('tipo_pago', '=', 'Crédito')
        ->get()
        ->toArray();
    }


    



    $contcajadiario = count ($cajadiario, 0);
    $total_derechos = 0;
    $total_conceptos = 0;
    $total_recaudo = 0;
    $total_aporteespecial = 0;
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
      $total_retencion = $value['retencion'] + $total_retencion;
      $total_iva =$value['iva'] + $total_iva;
      $total = $value['total'] + $total;
      $total_gravado = $value['total_gravado'] + $total_gravado;
      $total_reteiva =$value['reteiva'] + $total_reteiva;
      $total_reteica = $value['reteica'] + $total_reteica;
      $total_retertf = $value['retertf'] + $total_retertf;
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
    $data['total_egreso'] = $total_egreso;
    $data['cruces'] = $cruces;
    $data['contcruces'] = $contcruces;
    $data['nombre_reporte'] = $nombre_reporte;

    $html = view('pdf.cajadiariogeneral',$data)->render();

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
    $fecha_reporte = date("Y/m/d");

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fecha  = $fecha1.' A '.$fecha2;

    $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY

    $atributos = Concepto::all();
    $atributos = $atributos->sortBy('id_concep');
    
    $facturas = Factura::whereDate('fecha_fact', '>=', $fecha1)
    ->whereDate('fecha_fact', '<=', $fecha2)
    ->where('nota_credito','<>', true)
    ->get()->toArray();

    $facturas = $this->unique_multidim_array($facturas, 'id_radica');
    $y=1;
    foreach ($atributos as $key => $value) {
     $dataconcept[$y]['total'] = 0;
     $dataconcept[$y]['escrituras'] = 0;
      $y++;
    }


    foreach ($facturas as $key1 => $fc) {
      $id_radica = $fc['id_radica'];
      $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

      foreach ($conceptos as $key => $conc) {
        $i = 1;
        foreach ($atributos as $key => $atri) {
          $atributo = $atri['nombre_concep'];
          $totalatributo = 'total'.$atri['atributo'];
          if($conc[$totalatributo] > 0){
            $total = $conc[$totalatributo];
            $dataconcept[$i]['concepto'] = $atributo;
            $dataconcept[$i]['escrituras'] += 1;
            $dataconcept[$i]['total'] += $total;
              $i = $i + 1;
          }
        }
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
    $data['relconceptos'] = $relconceptos;
    $data['contrelconceptos'] = $contrelconceptos;
    $data['nombre_reporte'] = $nombre_reporte;
    $data['total'] = $grantotal;

    $html = view('pdf.relacionporconceptos',$data)->render();

    $namefile = 'ReldeFactPorConceptos_'.$fecha_reporte.'.pdf';

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
    
    $estadistico = Estadisticonotarial_unicas_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->get()->toArray();


    /*----------  Consulta Radicaciones con varios actos  ----------*/

    $estadistico_repe = Estadisticonotarial_repetidas_solo_radi_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->get()->toArray();

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
      $estadistico_rad = Estadisticonotarial_repetidas_view::where('id_radica', [$id_radica])->get()->toArray();

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
        $hora_fact = Carbon::parse($factura_otor->fecha_fact)->format('h-i-s');
        $derechos_otor = $factura_otor->total_derechos;
        $identificacioncli1_otor = $factura_otor->a_nombre_de;
        $id_radica =  $factura_otor->id_radica;
        $cuf =  $factura_otor->cufe;
        $forma_pago = $factura_otor->credito_fact;
        $a_cargo_de = $factura_otor->a_cargo_de;
        $detalle_acargo_de = $factura_otor->detalle_acargo_de;
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

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(2)->get()->toArray();
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
        $terceros[$j]['concepto'] = "Iva";
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
        $total_fondo = $factura->total_fondo;
        $total_super = $factura->total_super;
        $total_fact = $factura->total_fact;
        $reteiva = $factura->deduccion_reteiva;
        $retertf = $factura->deduccion_retertf;
        $reteica = $factura->deduccion_reteica;
        $subtotal1 = round($factura->total_derechos + $factura->total_conceptos);
        $fecha_fact = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
        $derechos = round($factura->total_derechos);
        $identificacioncli1 = $factura->a_nombre_de;
        $id_radica = $factura->id_radica;
        $cuf = $factura->cufe;
        $forma_pago = $factura->credito_fact;
        $a_cargo_de = $factura->a_cargo_de;
        $detalle_acargo_de = $factura->detalle_acargo_de;
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

      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->take(2)->get()->toArray();
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
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva";
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

    $sumaderechos = Liq_derecho::join("detalle_liqderechos","liq_derechos.id_liqd","=","detalle_liqderechos.id_liqd")
    ->where("liq_derechos.id_radica","=",$id_radica)
    ->where("liq_derechos.anio_radica","=",$anio_trabajo)
    ->get()->toArray();

    $total_derechos = 0;
    foreach ($sumaderechos as $key => $sum) {
      $total_derechos = $sum['derechos'] + $total_derechos;
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
            $dataconcept[$i]['cantidad'] = "";
            $dataconcept[$i]['total'] = $conc1[$totalatributo];
            $total_conceptos = $dataconcept[$i]['total'] + $total_conceptos;
              $i++;
          }
        }
      }

      $subtotal1 = $total_derechos + $total_conceptos;

      $contdataconcept = count($dataconcept, 0);
      $nit = $notaria->nit;
      $nombre_nota = strtoupper($notaria->nombre_nota);
      $direccion_nota = $notaria->direccion_nota;
      $telefono_nota = $notaria->telefono_nota;
      $email = $notaria->email;
      $nombre_notario = $notaria->nombre_notario;
      $resolucion = $notaria->resolucion;
      $piepagina_fact = $notaria->piepagina_fact;
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

      $recaudos = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      $total_iva = 0;
      $total_rtf = 0;
      $total_reteconsumo = 0;
      $total_fondo = 0;
      $total_super = 0;
      $total_aporteespecial = 0;

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
      }


      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + 
      $total_fondo + $total_super + $total_aporteespecial;
      $total_fact = $totalterceros + $subtotal1;
      $data['totalterceros'] = $totalterceros;
      $data['total_fact'] = $total_fact;

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
      $mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);
      

  }


  public function FacturaCajaRapida(Request $request){

    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_facturarapida;
    $id_concepto = $request->id_concepto;
    $num_fact  = $request->session()->get('numfactrapida');
    $anio_trabajo = $notaria->anio_trabajo;
 

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
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = false;
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


      $cufe = $request->session()->get('CUFE_SESION');
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

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $html = view('pdf.generarcajarapida',$data)->render();

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
          "format" => [216, 140],//Media Carta
          'margin_bottom' => 10,
      ]);

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


  public function PdfCopiaFacturaCajaRapida(Request $request){

    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_facturarapida;
    $id_concepto = $request->id_concepto;
    $num_fact  = $request->session()->get('numfact');
    
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
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = false;
        $cufe = $factura->cufe;
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

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $html = view('pdf.generarcajarapida',$data)->render();

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
          "format" => [216, 140],//Media Carta
          'margin_bottom' => 10,
      ]);

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
      $mpdf->Output($namefile,"I");
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
        $hora_fact = Carbon::parse($factura->fecha_fact)->format('h-i-s');
        $identificacioncli1 = $factura->a_nombre_de;
        $forma_pago = false;
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

      $j = 0;
      $terceros = [];
      if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva";
        $terceros[$j]['total'] = round($total_iva);
      }

      $contterceros = count ($terceros, 0);
      $data['terceros'] = $terceros;
      $data['contterceros'] = $contterceros;

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super;
      $data['totalterceros'] = round($totalterceros);


      $html = view('pdf.generarnotacreditocajarapida',$data)->render();

      $namefile = $id_ncf.'_NC'.'.pdf';
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
          "format" => [216, 140],//Media Carta
          'margin_bottom' => 10,
      ]);

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

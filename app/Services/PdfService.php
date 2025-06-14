<?php

namespace App\Services;
use App\Notaria;
use App\Detalle_factura;
use App\Factura;
use App\Facturascajarapida;
use Carbon\Carbon;
use App\Mediosdepago;
use App\Mediodepagocajarapida_view;
use App\Detalle_cajarapidafacturas;
use App\Escritura;
use App\Protocolistas_view;
use App\Cliente;
use App\Principalesfact_view;
use App\Secundariosfact_view;
use App\Actoscuantia;
use App\Liq_concepto;
use App\Concepto;
use App\Tarifa;
use App\Notas_credito_factura;
use App\Protocolistas_copias_view;
use App\Protocolistas_view_2;
use Mpdf\Mpdf;

class PdfService
{
    public function generarCopiaFactura($anio_trabajo, $num_fact, $directorio)
    {
        $notaria = Notaria::find(1);
        $prefijo_fact = $notaria->prefijo_fact;

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
            $total_timbrec = $factura_otor->total_timbrec;
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


    /*************Principales****************/

    $raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
    $principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(5)->get()->toArray();
    $contprincipales = count ($principales, 0);


    /***************Secundarios***************/

    $raws = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
        identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
    $secundarios = Secundariosfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raws)->take(5)->get()->toArray();
    $contsecundarios = count ($secundarios, 0);


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

      //$UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      //$QRCode = $cufe;
      $urlDIAN = "https://catalogo-vpfe.dian.gov.co/document/searchqr?documentkey={$cufe}";

      $factura = trim($prefijo_fact) . '-' . trim($num_fact);

      $QRCode = "NIT: {$nit}\n"
      . "FACTURA: {$factura}\n"
      . "FECHA: {$fecha_fact}\n"
      . "VALOR: {$total_fact_otor}\n"
      . "CUFE: {$cufe}\n"
      . "URL: {$urlDIAN}";


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
      $data_otor['secundarios'] = $secundarios;
      $data_otor['contsecundarios'] = $contsecundarios;
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
    if($total_timbrec > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Timbre Decreto 175";
        $terceros[$j]['total'] = $total_timbrec;
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

    $totalterceros = $total_iva_otor + $total_rtf_otor + $total_reteconsumo_otor + $total_fondo_otor + $total_super_otor + $total_aporteespecial_otor + $total_impuesto_timbre + $total_timbrec;
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

    $html_otor = view('pdf.generarcopia',$data_otor)->render();

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
    $mpdf->Output(public_path('cliente/'.$directorio.'/'.$namefile), 'F');
    }else{//Para radicación con una sola factura
      $facturas = Factura::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();


      foreach ($facturas as $factura) {
        $total_iva = $factura->total_iva;
        $total_rtf = $factura->total_rtf;
        $total_reteconsumo = $factura->total_reteconsumo;
        $total_aporteespecial = $factura->total_aporteespecial;
        $total_impuesto_timbre = $factura->total_impuesto_timbre;
        $total_timbrec = $factura->total_timbrec;
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


/***************Principales************/

$raw1 = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
    identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
$principales = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw1)->take(2)->get()->toArray();
$contprincipales = count ($principales, 0);

/***************Secundarios***************/

$raws = \DB::raw("identificacion_cli1, CONCAT(pmer_nombre_cli1, ' ', sgndo_nombre_cli1, ' ', pmer_apellido_cli1, ' ', sgndo_apellido_cli1, empresa_cli1) as nombre_cli1,
    identificacion_cli2, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as nombre_cli2");
$secundarios = Secundariosfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raws)->take(5)->get()->toArray();
$contsecundarios = count ($secundarios, 0);


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

      //$UUID = hash('sha384', $cufe); //se deja vacio mientras tanto

      //$QRCode = $cufe;

      $urlDIAN = "https://catalogo-vpfe.dian.gov.co/document/searchqr?documentkey={$cufe}";

      $factura = trim($prefijo_fact) . '-' . trim($num_fact);

      $QRCode = "NIT: {$nit}\n"
      . "FACTURA: {$factura}\n"
      . "FECHA: {$fecha_fact}\n"
      . "VALOR: {$total_fact}\n"
      . "CUFE: {$cufe}\n"
      . "URL: {$urlDIAN}";

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
      $data['secundarios'] = $secundarios;
      $data['contsecundarios'] = $contsecundarios;
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
    if($total_timbrec > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Timbre Decreto 175";
        $terceros[$j]['total'] = $total_timbrec;
    }
    if($total_iva > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Iva(".$porcentaje_iva."%)";
        $terceros[$j]['total'] = round($total_iva);
    }

    $contterceros = count ($terceros, 0);
    $data['terceros'] = $terceros;
    $data['contterceros'] = $contterceros;

    $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super + $total_impuesto_timbre;
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

    $html = view('pdf.generarcopia',$data)->render();

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
    //$mpdf->Output($directorio.$namefile, 'F');
    $mpdf->Output(public_path('cliente/'.$directorio.'/'.$namefile), 'F');
    
}
}

 public function GenerarCopiaFacturaCajarapida($num_fact, $directorio){

       $notaria = Notaria::find(1);
      $prefijo_fact = $notaria->prefijo_facturarapida;     
     
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
      $efectivo = '';
      $cheque = '';
      $consignacion_bancaria = '';
      $transferencia_bancaria = '';
      $tarjeta_credito = '';
      $tarjeta_debito = '';
      $pse  = '';

      
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

      if($efectivo > 0 || $efectivo === ''){
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
      //$QRCode = $cufe;

       $cufe = trim($cufe);
       $urlDIAN = "https://catalogo-vpfe.dian.gov.co/document/searchqr?documentkey={$cufe}";

      $factura = trim($prefijo_fact) . '-' . trim($num_fact);

      $QRCode = "NIT: {$nit}\n"
              . "FACTURA: {$factura}\n"
              . "FECHA: {$fecha_fact}\n"
              . "VALOR: {$total_fact}\n"
              . "CUFE: {$cufe}\n"
              . "URL: {$urlDIAN}";

      $FactComprobante = 'Factura';
      
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

      if ($contdetalle <= 2){
        $tamano_hoja = array(80, 220); // Ancho x Alto en milímetros
      }

      if ($contdetalle > 2 && $contdetalle <= 5){
        $tamano_hoja = array(80, 240); // Ancho x Alto en milímetros
      }

      if ($contdetalle > 5){
        $tamano_hoja = array(80, 250); // Ancho x Alto en milímetros
      }
      
      
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
      //$mpdf->Output($namefile,"f");
      $mpdf->Output($namefile,"i");
      //$mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      //$mpdf->Output($namefile, \Mpdf\Output\Destination::FILE);  
      $mpdf->Output(public_path('cliente_cajarapida/'.$directorio.'/'.$namefile), 'F');
}

public function GenerarCopiaNotaCredito($num_fact, $directorio){
    $notaria = Notaria::find(1);
    $prefijo_fact = $notaria->prefijo_fact;
        
    //TARIFA DEL IVA
    $porcentaje_iva = round((Tarifa::find(9)->valor1));

    $Notacredito = Notas_credito_factura::where("id_fact","=",$num_fact)->where("prefijo","=",$prefijo_fact)->get();
    if ($Notacredito->isEmpty()) {
        $Notacredito = Notas_credito_factura::where("id_ncf","=",$num_fact)->where("prefijo","=",$prefijo_fact)->get(); 
        foreach ($Notacredito as $ncf) {
            $detalle_ncf = $ncf->detalle_ncf;
            $fecha_ncf = Carbon::parse($ncf->created_at)->format('Y-m-d');
            $fecha_ncf_completa = $ncf->created_at;
            $hora_ncf = Carbon::parse($ncf->created_at)->format('h:i:s');
            $id_ncf = $ncf->id_ncf;
            $cuf = $ncf->cufe;
        }      
    }else{
        foreach ($Notacredito as $ncf) {
            $detalle_ncf = $ncf->detalle_ncf;
            $fecha_ncf = Carbon::parse($ncf->created_at)->format('Y-m-d');
            $fecha_ncf_completa = $ncf->created_at;
            $hora_ncf = Carbon::parse($ncf->created_at)->format('h:i:s');
            $id_ncf = $ncf->id_ncf;
            $cuf = $ncf->cufe;
        }
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
        $total_impuesto_timbre = $factura_otor->total_impuesto_timbre;
        $total_timbrec = $factura_otor->total_timbrec;
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

      /********************PROTOCOLISTA***********************/
      $protocolista = Protocolistas_view_2::where('num_esc', $num_esc)
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

      $FactComprobante = 'Factura' ;

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
      $data_otor['fecha_ncf'] = $fecha_ncf;
      $data_otor['id_radica'] = $id_radica;
      $data_otor['nameprotocolista'] = $nameprotocolista;

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
      if($total_timbrec > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Timbre Decreto 175";
        $terceros[$j]['total'] = $total_timbrec;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al timbre";
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

      $totalterceros = $total_iva_otor + $total_rtf_otor + $total_reteconsumo_otor + $total_fondo_otor + $total_super_otor + $total_impuesto_timbre + $total_timbrec;
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
     // $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta

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
        $total_timbrec = $factura->total_timbrec;
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

       /********************PROTOCOLISTA***********************/
      $protocolista = Protocolistas_view_2::where('num_esc', $num_esc)
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
      $data['fecha_ncf'] = $fecha_ncf;
      $data['id_radica'] = $id_radica;
      $data['nameprotocolista'] = $nameprotocolista;

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
      if($total_timbrec > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Timbre Decreto 175";
        $terceros[$j]['total'] = $total_timbrec;
      }
      if($total_impuesto_timbre > 0){
        $j = $j + 1;
        $terceros[$j]['concepto'] = "Impuesto al timbre";
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

      $totalterceros = $total_iva + $total_rtf + $total_reteconsumo + $total_fondo + $total_super + $total_impuesto_timbre + $total_timbrec;

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
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output(public_path('cliente/'.$directorio.'/'.$namefile), 'F');
     // $mpdf->Output($carpeta_destino_cliente.$namefile, 'F'); //guarda a ruta
      
    }

}

public function GenerarCopiaNotaCreditoCajaRapida($num_fact, $directorio){
     
      $notaria = Notaria::find(1);
      $prefijo_fact = $notaria->prefijo_facturarapida;
      $anio_trabajo = $notaria->anio_trabajo;

      //TARIFA DEL IVA
      $porcentaje_iva = round((Tarifa::find(9)->valor1));     

       $nota_credito = Notas_credito_cajarapida::where("prefijo_ncf","=",$prefijo_fact)->where("id_ncf","=",$num_fact)->get();
       if ($nota_credito->isEmpty()) {
            $nota_credito = Notas_credito_cajarapida::where("prefijo_ncf","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
            foreach ($nota_credito as $notacre) {
                $detalle_ncf = $notacre->detalle_ncf;
                $fecha_ncf = $notacre->created_at;
            }

        }else{
            foreach ($nota_credito as $notacre) {
                $detalle_ncf = $notacre->detalle_ncf;
                $fecha_ncf = $notacre->created_at;
                $num_fact  = $notacre->id_fact;
            }
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
      $mpdf->defaultfooterfontsize=2;
      $mpdf->SetTopMargin(5);
      $mpdf->SetDisplayMode('fullpage');
      $mpdf->WriteHTML($html);
      $mpdf->Output(public_path('cliente_cajarapida/'.$directorio.'/'.$namefile), 'F'); 
      

}


}

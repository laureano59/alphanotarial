<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Liq_derecho;
use App\Detalle_liqderecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Factura;
use App\Cajadiario_cajarapida_view;
use App\Cajadiario_conceptos_rapida_view;
use App\Detalle_factura;
use App\Escritura;
use App\Cajadiariogeneral_view;
use App\Cajadiariogeneral_notas_otros_periodos_view;
use App\Concepto;
use App\Cruces_actas_deposito_view;
use App\Libroindice_view;
use App\Actos_notariales_escritura_view;
use App\Relacion_notas_credito_view;
use\App\Informe_cartera_view;
use App\Recaudos_view;
use\App\Recaudos_sincuantia_view;
use\App\Recaudos_excenta_view;
use App\Tarifa;
use\App\Recaudos_sincuantia_excenta_view;
use\App\Recaudos_concuantia_view;
use\App\Actas_deposito_view;
use\App\Actas_deposito_egreso_view;

use App\Exports\RonExport;
use Maatwebsite\Excel\Facades\Excel;


class ReportesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $opcion = $request->session()->get('opcionreporte');
   
    if($opcion == 1){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.cajadiario', compact('nombre_reporte'));
    }else if($opcion == 2){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.libroindice', compact('nombre_reporte'));
    }else if($opcion == 3){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.ingresosporconcepto', compact('nombre_reporte'));
    }else if($opcion == 4){
      return view('reportes.estadisticonotarial');
    }else if($opcion == 5){
      return view('reportes.auxiliarcaja');
    }else if($opcion == 6){
      return view('reportes.registrocivil');
    }else if($opcion == 7){
      return view('reportes.enlaces');
    }else  if($opcion == 8){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.notascredito', compact('nombre_reporte'));
    }else  if($opcion == 9){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informecarterames', compact('nombre_reporte'));
    }else  if($opcion == 10){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informecarteracliente', compact('nombre_reporte'));
    }else  if($opcion == 11){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informederecaudos', compact('nombre_reporte'));
    }else if($opcion == 12){
      return view('reportes.ron');
    }else if($opcion == 13){
      return view('reportes.certificadortf');
    }else if($opcion == 14){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informediariocajarapida', compact('nombre_reporte'));
    }else if($opcion == 15){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informeporconceptoscajarapida', compact('nombre_reporte'));
    }else if($opcion == 16){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.statusfactelectronicacajarapida', compact('nombre_reporte'));
    }else if($opcion == 17){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informededepositos', compact('nombre_reporte'));
    }else if($opcion == 18){
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.informedeegresos', compact('nombre_reporte'));
    }
  }
  

  public function CargarTipoReporte(Request $request){
    $opcion = $request->opcionreporte;
    $nombre_reporte = $request->reporte;
    $ordenar = $request->ordenar;
    $request->session()->put('opcionreporte', $opcion);
    $request->session()->put('nombre_reporte', $nombre_reporte);
    $request->session()->put('ordenar', $ordenar);

    return response()->json([
       "validar"=>1
     ]);
  }

  public function FechaReporte(Request $request){
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    return response()->json([
       "validar"=>1
     ]);
  }

  public function Caja_Diario(Request $request)
  {
    $notaria = Notaria::find(1);
    //$anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY
    //$cajadiario = Cajadiariogeneral_view::whereBetween('fecha', [$fecha1, $fecha2])->get()->toArray();
    $tipo_informe = $request->tipoinforme;
    $request->session()->put('tipoinforme', $tipo_informe);

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


    if($tipo_informe == 'completo'){
        $cajadiario = Cajadiariogeneral_view::whereDate('fecha', '>=', $fecha1)
                      ->whereDate('fecha', '<=', $fecha2)
                      ->where('anio_esc', '=', $anio_trabajo)
                      ->get()
                      ->toArray();
        $cruces = Cruces_actas_deposito_view::whereDate('fecha', '>=', $fecha1)
                  ->whereDate('fecha', '<=', $fecha2)->get()->toArray();

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
            $cajadiario_otros_periodos[$i]['impuesto_timbre'] = $value['impuesto_timbre'];
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

 
               
    }else if($tipo_informe == 'contado'){

      $cajadiario = Cajadiariogeneral_view::
        whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2)
        ->where('tipo_pago', '=', 'Contado')
        ->where('anio_esc', '=', $anio_trabajo)
        ->get()
        ->toArray();
        $cruces = Cruces_actas_deposito_view::
          whereDate('fecha', '>=', $fecha1)
          ->whereDate('fecha', '<=', $fecha2)
          ->get()
          ->toArray();


    }else if($tipo_informe == 'credito'){
      $cajadiario = Cajadiariogeneral_view::
        whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2)
        ->where('anio_esc', '=', $anio_trabajo)
        ->where('tipo_pago', '=', 'Crédito')
        ->get()
        ->toArray();
        $cruces = Cruces_actas_deposito_view::
          whereDate('fecha', '>=', $fecha1)
          ->whereDate('fecha', '<=', $fecha2)
          ->get()
          ->toArray();

    }
   
   
    $total_egreso = 0;
    foreach ($cruces as $key => $cru) {
      $total_egreso = $cru['valor_egreso'] + $total_egreso;
    }



    if($tipo_informe == 'completo'){
      return response()->json([
       "cajadiario"=>$cajadiario,
       "cajadiario_otros_periodos"=>$cajadiario_otros_periodos,
       "cruces"=>$cruces,
       "total_egreso"=>$total_egreso,
       "derechos_contado"=>$facturas_contado->derechos,
       "conceptos_contado"=>$facturas_contado->conceptos,
       "ingresos_contado"=>$facturas_contado->ingresos,
       "iva_contado"=>$facturas_contado->iva,
       "recaudos_contado"=>$facturas_contado->recaudos,
       "aporteespecial_contado"=>$facturas_contado->aporteespecial,
       "impuestotimbre_contado"=>$facturas_contado->impuestotimbre,
       "rtf_contado"=>$facturas_contado->rtf,
       "deduccion_reteiva_contado"=>$facturas_contado->deduccion_reteiva,
       "deduccion_reteica_contado"=>$facturas_contado->deduccion_reteica,
       "deduccion_retertf_contado"=>$facturas_contado->deduccion_retertf,
       "total_fact_contado"=>$facturas_contado->total_fact,
       "derechos_credito"=>$facturas_credito->derechos,
       "conceptos_credito"=>$facturas_credito->conceptos,
       "ingresos_credito"=>$facturas_credito->ingresos,
       "iva_credito"=>$facturas_credito->iva,
       "recaudos_credito"=>$facturas_credito->recaudos,
       "aporteespecial_credito"=>$facturas_credito->aporteespecial,
       "impuestotimbre_credito"=>$facturas_credito->impuestotimbre,
       "rtf_credito"=>$facturas_credito->rtf,
       "deduccion_reteiva_credito"=>$facturas_credito->deduccion_reteiva,
       "deduccion_reteica_credito"=>$facturas_credito->deduccion_reteica,
       "deduccion_retertf_credito"=>$facturas_credito->deduccion_retertf,
       "total_fact_credito"=>$facturas_credito->total_fact
     ]);
    }else{
       $cajadiario_otros_periodos = [];
       return response()->json([
       "cajadiario"=>$cajadiario,
       "cajadiario_otros_periodos"=>$cajadiario_otros_periodos,
       "cruces"=>$cruces,
       "total_egreso"=>$total_egreso
     ]);
    }

    
  }

  public function Libro_Indice(Request $request)
  {
    $notaria = Notaria::find(1);
    //$anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $anio_trabajo = date("Y", strtotime($fecha1));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $ordenar = $request->session()->get('ordenar');

    $resultadoFinal = [];

    if($ordenar == 'libroindice'){ //Ordena por escritura
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

          foreach ($alfabeto as $letra) {
            $libroindice = Libroindice_view::
            whereDate('fecha', '>=', $fecha1)
            ->whereDate('fecha', '<=', $fecha2)
            ->where('otorgante', 'like', $letra . '%')
            ->selectRaw('MIN(otorgante) AS otorgante, MIN(fecha) AS fecha, MIN(num_esc) AS num_esc, MIN(compareciente) AS compareciente, MIN(acto) AS acto')
            ->groupBy('num_esc')
            ->orderBy('num_esc')
            ->orderBy('otorgante')
            ->orderBy('fecha')
            ->get()->toArray();
            $resultadoFinal[$letra] = $libroindice;
      }

       $resultadoFinal = array_merge(...array_values($resultadoFinal));
     }

      
    return response()->json([
       "libroindice"=>$resultadoFinal
     ]);
  }

  public function Relacion_Nota_Credito(Request $request)
  {
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    //$rel_notas_credito = Relacion_notas_credito_view::whereBetween('fecha', [$fecha1, $fecha2])->orderBy('id_ncf')->get()->toArray();
    $rel_notas_credito = Relacion_notas_credito_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->orderBy('id_ncf')->get()->toArray();
      
    return response()->json([
       "rel_notas_credito"=>$rel_notas_credito
     ]);
  }

  public function Informe_Cartera(Request $request)
  {
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $identificacion_cli = $request->identificacion_cli;
    $request->session()->put('identificacion_cli', $identificacion_cli);
    $ordenar = $request->session()->get('ordenar');
    if($ordenar == 'porfecha'){ //por fecha
      //$informecartera = Informe_cartera_view::whereBetween('fecha_fact', [$fecha1, $fecha2])->orderBy('id_fact')->get()->toArray();
      $informecartera = Informe_cartera_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('nota_credito', false)
      ->where('saldo_fact', '>=', 1)
      ->orderBy('id_fact')->get()
      ->toArray();
    }elseif($ordenar == 'porcliente'){//por cliente
      $informecartera = Informe_cartera_view::where('identificacion_cli', $identificacion_cli)
      ->where('nota_credito', false)
      ->where('saldo_fact', '>=', 1)
      ->orderBy('id_fact')
      ->get()
      ->toArray();
    }

    return response()->json([
       "informecartera"=>$informecartera
     ]);
  }

  public function Informe_cajadiario_rapida(Request $request)
  {
    $notaria = Notaria::find(1);
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

    $Informe_cajadiario_rapida = Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->get()
      ->toArray();

      $facturadores =  Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('nota_credito', false)
      ->selectRaw('MIN(name) as facturador, 
        SUM(subtotal) as subtotal, 
        SUM(total_iva) as iva,
        SUM(total_fact) as total')
      ->groupBy('id')
      ->get()->toArray();

            
       $raw1 = \DB::raw("sum(total_iva) AS total_contado_iva, sum(subtotal) AS subtotal_contado, sum(total_fact) AS total_contado_fact");
      $Contado = Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('forma_pago', '=', 'Contado')
      ->select($raw1)->get()->toArray();

     
      $raw2 = \DB::raw("sum(total_iva) AS total_credito_iva, sum(subtotal) AS subtotal_credito, sum(total_fact) AS total_credito_fact");
      $Credito = Cajadiario_cajarapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->where('forma_pago', '=', 'Credito')
      ->select($raw2)->get()->toArray();
            
    return response()->json([
       "Informe_cajadiario_rapida"=>$Informe_cajadiario_rapida,
       "Contado"=>$Contado,
       "Credito"=>$Credito,
       "facturadores"=>$facturadores
     ]);
  }
 

   public function Informe_cajadiario_rapida_conceptos(Request $request)
  {
    $notaria = Notaria::find(1);
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

    $raw = \DB::raw("min(id_concep) AS id_concep,
                    min((nombre_concep)) AS nombre_concep,
                    sum(cantidad) AS cantidad,
                    sum(subtotal) AS subtotal,
                    sum(iva) AS iva,
                    sum(total) AS total");
      $Informe_cajadiario_rapida_conceptos = Cajadiario_conceptos_rapida_view::whereDate('fecha_fact', '>=', $fecha1)
      ->whereDate('fecha_fact', '<=', $fecha2)
      ->groupBy('id_concep')
      ->select($raw)->get()->toArray();
        
    return response()->json([
       "Informe_cajadiario_rapida_conceptos"=>$Informe_cajadiario_rapida_conceptos
     ]);
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


  public function Informe_Recaudos(Request $request)
  {
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2."+ 1 days"));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

    
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
    

    return response()->json([
       "ran1escr"=>$ran1escr, 
       "ran2escr"=>$ran2escr,
       "ran3escr"=>$ran3escr,
       "ran4escr"=>$ran4escr,
       "ran5escr"=>$ran5escr,
       "ran6escr"=>$ran6escr,
       "sincescr"=>$sincescr,
       "excescr"=>$excescr,
       "ran1super"=>$ran1super,
       "ran2super"=>$ran2super,
       "ran3super"=>$ran3super,
       "ran4super"=>$ran4super,
       "ran5super"=>$ran5super,
       "ran6super"=>$ran6super,
       "sincsuper"=>$sincsuper,
       "excsuper"=>$excsuper,
       "ran1fondo"=>$ran1fondo,
       "ran2fondo"=>$ran2fondo,
       "ran3fondo"=>$ran3fondo,
       "ran4fondo"=>$ran4fondo,
       "ran5fondo"=>$ran5fondo,
       "ran6fondo"=>$ran6fondo,
       "sincfondo"=>$sincfondo,
       "excfondo"=>$excfondo,
       "ran1total"=>$ran1total,
       "ran2total"=>$ran2total,
       "ran3total"=>$ran3total,
       "ran4total"=>$ran4total,
       "ran5total"=>$ran5total,
       "ran6total"=>$ran6total,
       "sinctotal"=>$sinctotal,
       "exctotal"=>$exctotal,
       "total_escrituras"=>$total_escrituras,
       "total_super"=>$total_super,
       "total_fondo"=> $total_fondo,
       "total_recaudos"=>$total_recaudos,
       "valor1"=>$valor1,
       "valor2"=>$valor2,
       "valor3"=>$valor3,
       "valor4"=>$valor4,
       "valor5"=>$valor5,
       "valor6"=>$valor6,
       "valor7"=>$valor7
     ]);
  }

  public function Ingreso_Conceptos(Request $request)
  {
    $notaria = Notaria::find(1);
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

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
    ->get()->toArray();


    $facturas = $this->unique_multidim_array($facturas, 'id_radica');
    
    $sum_conceptos_otros_periodos = 0;
        
    foreach ($facturas as $key => $fc) {
      $id_radica = $fc['id_radica'];
      $not_per = $fc['nota_periodo'];
      
     
      if($not_per == 0  || $not_per == 8){

        $radicacion_otro_periodo = $id_radica;
                      
        //$id_fact_otro_periodo = $fc['id_fact_otroperiodo'];

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

    return response()->json([
        "conceptos"=>$dataconcept,
        "grantotal"=>$grantotal
      ]);


  }

  public function Relaciondepositosdiarios(Request $request)
  {
    $notaria = Notaria::find(1);
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
   
    $fecha1 = date("d-m-Y", strtotime($fecha1)); //Convierte Fecha a dd-mm-YYYY
    $fecha2 = date("d-m-Y", strtotime($fecha2));
    
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

    //$anio_trabajo = date("Y", strtotime($fecha1)); //Convierte Fecha a YYYY


    $Actas_deposito = Actas_deposito_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->where('anulada','<>', true)
    ->orderBy('id_act')
    ->get()->toArray();

     return response()->json([
        "depositos"=>$Actas_deposito
      ]);

    
  }


  public function Relacionegresosdiarios(Request $request)
  {
    $notaria = Notaria::find(1);
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
   
    $fecha1 = date("d-m-Y", strtotime($fecha1)); //Convierte Fecha a dd-mm-YYYY
    $fecha2 = date("d-m-Y", strtotime($fecha2));
    
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    
    $Actas_egreso = Actas_deposito_egreso_view::whereDate('fecha_egreso', '>=', $fecha1)
    ->whereDate('fecha_egreso', '<=', $fecha2)
    ->orderBy('id_act')
    ->get()->toArray();

     return response()->json([
        "egresos"=>$Actas_egreso
      ]);

    
  }



  public function Ron(Request $request){

     
    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $nombrefile = 'ron'.'_'.$fecha1.'.'.'xls';
    
    return Excel::download(new RonExport($fecha1, $fecha2), $nombrefile);

  }
}

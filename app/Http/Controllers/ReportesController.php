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
use App\Exports\BonosExportCli;
use App\Exports\IngresosdianescriturasExport;
use App\Exports\EnajenacionesExport;
use App\Exports\BonosExportFecha;
use App\Exports\BonosExportActivos;
use App\Exports\NotasCreditoExport;
use App\Exports\ExcelReteaplicadaExport;
use App\Exports\NotasCreditoCajaRapidaExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Protocolista;
use App\Cuenta_cobro_escr;
use App\Mediosdepago;
use App\Informe_cartera_bonos_view;
use App\Informe2_bonos_view;


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
    //var_dump($opcion);
    //exit;

    if($opcion == 1){
      $request->user()->authorizeRoles(['relfactmensualescr','administrador']);
      $nombre_reporte = $request->session()->get('nombre_reporte');
      return view('reportes.cajadiario', compact('nombre_reporte'));
    }else if($opcion == 2){
      $request->user()->authorizeRoles(['actosjurinotar','administrador']);
      $reporte_view = $request->session()->get('ordenar');
      $nombre_reporte = $request->session()->get('nombre_reporte');

      if($reporte_view == 'pornombre'){       
      $request->user()->authorizeRoles(['libroindiceescr','administrador']);       
       return view('reportes.libroindice', compact('nombre_reporte'));
     }else if($reporte_view == 'porescritura'){
      $request->user()->authorizeRoles(['librorelaescr','administrador']);
      return view('reportes.librorelacion', compact('nombre_reporte'));
    }else if($reporte_view == 'pornumescritura'){
      $request->user()->authorizeRoles(['librorelaescr','administrador']);
      return view('reportes.librorelacion', compact('nombre_reporte'));
    }
  }else if($opcion == 3){
    $request->user()->authorizeRoles(['conceptosescr','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.ingresosporconcepto', compact('nombre_reporte'));
  }else if($opcion == 4){
    $request->user()->authorizeRoles(['estadistico','administrador']);
    return view('reportes.estadisticonotarial');
  }else if($opcion == 5){
    return view('reportes.auxiliarcaja');
  }else if($opcion == 6){
    return view('reportes.registrocivil');
  }else if($opcion == 7){
    $request->user()->authorizeRoles(['enlaces','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.enlaces', compact('nombre_reporte'));
  }else  if($opcion == 8){
    $request->user()->authorizeRoles(['rnotacredescr','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.notascredito', compact('nombre_reporte'));
  }else  if($opcion == 9){
    $request->user()->authorizeRoles(['relcarterames','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informecarterames', compact('nombre_reporte'));
  }else  if($opcion == 10){
    $request->user()->authorizeRoles(['relcarteraclient','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informecarteracliente', compact('nombre_reporte'));
  }else  if($opcion == 11){
    $request->user()->authorizeRoles(['recaudosescr','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informederecaudos', compact('nombre_reporte'));
  }else if($opcion == 12){
    $request->user()->authorizeRoles(['reporteron','administrador']);
    return view('reportes.ron');
  }else if($opcion == 13){
    $request->user()->authorizeRoles(['certiretefuente','administrador']);
    return view('reportes.certificadortf');
  }else if($opcion == 14){
    $request->user()->authorizeRoles(['rdiariocaja','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informediariocajarapida', compact('nombre_reporte'));
  }else if($opcion == 15){
    $request->user()->authorizeRoles(['rgrupos','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeporconceptoscajarapida', compact('nombre_reporte'));
  }else if($opcion == 16){
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.statusfactelectronicacajarapida', compact('nombre_reporte'));
  }else if($opcion == 17){
    $request->user()->authorizeRoles(['infodepositos','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informededepositos', compact('nombre_reporte'));
  }else if($opcion == 18){
    $request->user()->authorizeRoles(['Infoegresos','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informedeegresos', compact('nombre_reporte'));
  }else if($opcion == 19){
    $request->user()->authorizeRoles(['ingresosclientedian','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeingresosdian', compact('nombre_reporte'));
  }else if($opcion == 20){
    $request->user()->authorizeRoles(['infoenajenacionesdian','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.enajenacionesdian', compact('nombre_reporte'));
  }else if($opcion == 21){
    $request->user()->authorizeRoles(['ingrescriturador','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    $Protocolistas = Protocolista::all();
    return view('reportes.ingresosporescrituradores', compact('nombre_reporte', 'Protocolistas'));
  }else if($opcion == 22){
    $request->user()->authorizeRoles(['inforetefuentesapli','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.retefuentesaplicadas', compact('nombre_reporte'));
  }else if($opcion == 23){
    $request->user()->authorizeRoles(['inforetefuentes','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeretefuentes', compact('nombre_reporte'));
  }else if($opcion == 24){
    $request->user()->authorizeRoles(['consolidadocaja','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.consolidadocaja', compact('nombre_reporte'));
  }else if($opcion == 25){
    $request->user()->authorizeRoles(['infogastos','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informedegastos', compact('nombre_reporte'));
  }else if($opcion == 26){
    $request->user()->authorizeRoles(['rnotacred','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.relacionnotacreditocajarapida', compact('nombre_reporte'));
  }else if($opcion == 27){
    $request->user()->authorizeRoles(['relcarterafactactivas','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informecarterafacturasactivas', compact('nombre_reporte'));
  }else if($opcion == 28){
    $request->user()->authorizeRoles(['escripendientescr','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeescriturassinfactura', compact('nombre_reporte'));
  }else if($opcion == 29){
    $request->user()->authorizeRoles(['infotimbre','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informedetimbre', compact('nombre_reporte'));
  }else if($opcion == 30){
    $request->user()->authorizeRoles(['cuentascobrogenbonos','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.cuentasdecobrogeneradas', compact('nombre_reporte'));
  }else if($opcion == 31){
    $request->user()->authorizeRoles(['trazabilbonosclient','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.carterabonoscliente', compact('nombre_reporte'));
  }else if($opcion == 32){
    $request->user()->authorizeRoles(['trazabilbonosfech','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.carterabonosmes', compact('nombre_reporte'));
  }else if($opcion == 33){
    $request->user()->authorizeRoles(['carterabonosactivos','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informecarterabonosactiva', compact('nombre_reporte'));
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
  $ingreso = $request->ingreso;
  $opcionreporte = $request->opcionreporte;
  $id_proto = $request->id_proto;
  $request->session()->put('id_proto', $id_proto);
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $request->session()->put('parametroingreso', $ingreso);
    $request->session()->put('opcionreporte', $opcionreporte);
    return response()->json([
     "validar"=>1
   ]);
  }

   public function Escrituras_Sin_Factura(Request $request){
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

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

        return response()->json([
          "Reporte"=>$finalResult
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
      SUM(total_timbrec) as timbreley175,
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
      SUM(total_timbrec) as timbreley175,
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
          $cajadiario_otros_periodos[$i]['impuesto_timbre'] = $value['total_impuesto_timbre'];
          $cajadiario_otros_periodos[$i]['timbreley175'] = $value['total_timbrec'];
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

    /*********************BONOS***********************/

     $facturas_escrituras = Factura::whereDate('fecha_fact', '>=', $fecha1)
                      ->whereDate('fecha_fact', '<=', $fecha2)
                      ->where('nota_credito', false)
                      ->where('credito_fact', false)
                      ->get();
      $bonos_es = 0;

      foreach ($facturas_escrituras as $key => $fe) {
              $num_fact = $fe->id_fact;
              $prefijo_fact = $fe->prefijo;

              $Medpago = Mediosdepago::where("prefijo","=",$prefijo_fact)->where("id_fact","=",$num_fact)->get();
              foreach ($Medpago as $med) {
                //$efectivo_es += $med->efectivo;
                //$cheque_es += $med->cheque;
                //$consignacion_bancaria_es += $med->consignacion_bancaria;
                //$pse_es += $med->pse;
                //$transferencia_bancaria_es += $med->transferencia_bancaria;
                //$tarjeta_credito_es += $med->tarjeta_credito;
                //$tarjeta_debito_es += $med->tarjeta_debito;
                $bonos_es += $med->bono;
              }
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
       "timbreley175contado"=>$facturas_contado->timbreley175,
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
       "timbreley175credito"=>$facturas_credito->timbreley175,
       "rtf_credito"=>$facturas_credito->rtf,
       "deduccion_reteiva_credito"=>$facturas_credito->deduccion_reteiva,
       "deduccion_reteica_credito"=>$facturas_credito->deduccion_reteica,
       "deduccion_retertf_credito"=>$facturas_credito->deduccion_retertf,
       "total_fact_credito"=>$facturas_credito->total_fact,
       "bonos_es"=>$bonos_es
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
    $paragrid = '';

    $resultadoFinal = [];

    if($ordenar == 'porescritura'){ //Ordena por escritura
      $paragrid = '1';
      $raw1 = \DB::raw("MIN(id_radica) AS id_radica, MIN(id_actperrad) AS id_actperrad, MIN(fecha) AS fecha, MIN(num_esc) AS num_esc, MIN(identificacion_otor) AS identificacion_otor, MIN(otorgante) AS otorgante, MIN(identificacion_comp) AS identificacion_comp, MIN(compareciente) AS compareciente, MIN(acto) AS acto");
      $libroindice = Libroindice_view::whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
      ->groupBy('num_esc')
      ->orderBy('num_esc')
      ->select($raw1)
      ->get()
      ->toArray();
      $resultadoFinal = $libroindice;

    }else if($ordenar == 'pornombre'){//Ordena por nombre
      $paragrid = '2';
      $alfabeto = range('A', 'Z');

      foreach ($alfabeto as $letra) {
        $libroindice = Libroindice_view::
        whereDate('fecha', '>=', $fecha1)
        ->whereDate('fecha', '<=', $fecha2)
        ->where('otorgante', 'like', $letra . '%')
        ->selectRaw('MIN(otorgante) AS otorgante, MIN(fecha) AS fecha, MIN(num_esc) AS num_esc, MIN(compareciente) AS compareciente, MIN(acto) AS acto')
        ->groupBy('num_esc')
        ->orderBy('num_esc')
          //->orderBy('otorgante')
        ->orderBy('fecha')
        ->get()->toArray();
        $resultadoFinal[$letra] = $libroindice;
      }
      $resultadoFinal = array_merge(...array_values($resultadoFinal));

    }else if($ordenar == 'pornumescritura'){ //Ordena por escritura
      $paragrid = '3';
      $raw1 = \DB::raw("(id_radica) AS id_radica, (id_actperrad) AS id_actperrad, (fecha) AS fecha, (num_esc) AS num_esc, (identificacion_otor) AS identificacion_otor, (otorgante) AS otorgante, (identificacion_comp) AS identificacion_comp, (compareciente) AS compareciente, (acto) AS acto");
      $libroindice = Actos_notariales_escritura_view::
      whereDate('fecha', '>=', $fecha1)
      ->whereDate('fecha', '<=', $fecha2)
        //->groupBy('num_esc')
      ->orderBy('num_esc')
      ->select($raw1)
      ->get()
      ->toArray();
      $resultadoFinal = $libroindice;
    }

    return response()->json([
     "libroindice"=>$resultadoFinal,
     "paragrid"=>$paragrid
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
    
    
    $rel_notas_credito = Relacion_notas_credito_view::whereDate('fecha', '>=', $fecha1)
    ->whereDate('fecha', '<=', $fecha2)
    ->orderBy('id_ncf')->get()->toArray();

    return response()->json([
     "rel_notas_credito"=>$rel_notas_credito
   ]);
  }

  
  public function Cuentas_Cobro_Generadas(Request $request)
  {
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    
    $Cuenta_cobro_escr = Cuenta_cobro_escr::whereDate('created_at', '>=', $fecha1)
    ->whereDate('created_at', '<=', $fecha2)
    ->orderBy('id_cce')->get()->toArray();

    return response()->json([
     "cuenta_cobro_escr"=>$Cuenta_cobro_escr
   ]);
  }


  public function Informe_Cartera(Request $request)
  {
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $opcionreporte = $request->opcionreporte;
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $identificacion_cli = $request->identificacion_cli;
    $request->session()->put('identificacion_cli', $identificacion_cli);
    $request->session()->put('opcionreporte', $opcionreporte);
    $ordenar = $request->session()->get('ordenar');

    if($ordenar == 'porfecha'){ //por fecha
      if($opcionreporte == 'maycero'){
        $informecartera = Informe_cartera_view::whereDate('fecha_abono', '>=', $fecha1)
        ->whereDate('fecha_abono', '<=', $fecha2)
        ->where('nota_credito', false)
        ->where('saldo_fact', '>=', 1)
        ->orderBy('fecha_abono')->get()
        ->toArray();
      }else if($opcionreporte == 'completo'){
       $informecartera = Informe_cartera_view::whereDate('fecha_abono', '>=', $fecha1)
       ->whereDate('fecha_abono', '<=', $fecha2)
       ->where('nota_credito', false)
       ->orderBy('fecha_abono')->get()
       ->toArray();
     }
    }elseif($ordenar == 'porcliente'){//por cliente
      if($opcionreporte == 'maycero'){
        $informecartera = Informe_cartera_view::where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo_fact', '>=', 1)
        ->orderBy('fecha_abono')
        ->get()
        ->toArray();
      }else  if($opcionreporte == 'completo'){
        $informecartera = Informe_cartera_view::where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->orderBy('fecha_abono')
        ->get()
        ->toArray();
      }
    }elseif($ordenar == 'facturasactivas'){

     $informecartera = Informe_cartera_view::
     where('nota_credito', false)
     ->where('saldo_fact', '>=', 1)
     ->orderBy('id_fact')->get()
     ->toArray();
   }
   
   return response()->json([
     "informecartera"=>$informecartera
   ]);
 }

 
 public function Informe_Cartera_Bonos(Request $request)
  {
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $fecha1 = $request->fecha1;
    $fecha2 = $request->fecha2;
    $opcionreporte = $request->opcionreporte;
    $request->session()->put('opcionreporte', $opcionreporte);
    $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $identificacion_cli = $request->identificacion_cli;
    $request->session()->put('identificacion_cli', $identificacion_cli);
    $request->session()->put('opcionreporte', $opcionreporte);
    $ordenar = $request->session()->get('ordenar');
    $porfactura = $request->porfactura;
    if($porfactura == 'porfactura'){
      $id_fact = $request->num_factura;
    }
   
    if($ordenar == 'porfecha'){ //por fecha
      if($opcionreporte == 'maycero'){
        $informecarterabonos = Informe_cartera_bonos_view::whereDate('fecha_abono', '>=', $fecha1)
        ->whereDate('fecha_abono', '<=', $fecha2)
        ->where('nota_credito', false)
        ->where('saldo_bon', '>=', 1)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get()
        ->toArray();
      }else if($opcionreporte == 'completo'){
       $informecarterabonos = Informe_cartera_bonos_view::whereDate('fecha_abono', '>=', $fecha1)
       ->whereDate('fecha_abono', '<=', $fecha2)
       ->where('nota_credito', false)
       ->orderBy('id_fact')
       ->orderBy('fecha_abono')
       ->get()
       ->toArray();
     }
    }elseif($ordenar == 'porcliente'){//por cliente
      if($opcionreporte == 'maycero'){
        $informecarterabonos = Informe_cartera_bonos_view::where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo_bon', '>=', 1)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get()
        ->toArray();
      }else  if($opcionreporte == 'completo'){
        $informecarterabonos = Informe_cartera_bonos_view::where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get()
        ->toArray();
      }
    }elseif($ordenar == 'bonosactivos'){

      if($opcionreporte == 'maycero'){

        $informecarterabonos = Informe2_bonos_view::where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo', '>=', 1)
        ->orderBy('id_fact')
        ->orderBy('fecha_fact')
        ->get()
        ->toArray();
      }else  if($opcionreporte == 'completo'){
        $informecarterabonos = Informe2_bonos_view::where('identificacion_cli', $identificacion_cli)
        ->where('nota_credito', false)
        ->orderBy('id_fact')
        ->orderBy('fecha_fact')
        ->get()
        ->toArray();
      }
   }

   if($porfactura == 'porfactura'){
     $informecarterabonos = Informe_cartera_bonos_view::where('id_fact', $id_fact)
        ->where('nota_credito', false)
        ->orderBy('id_fact')
        ->orderBy('fecha_abono')
        ->get()
        ->toArray();
   }

         
   return response()->json([
     "informecarterabon"=>$informecarterabonos
   ]);
 }


 public function Informe_cajadiario_rapida(Request $request)
 {

  $request->user()->authorizeRoles(['rdiariocaja','administrador']);
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
    ->where('nota_periodo', '<>', 0)
    //->where('nota_periodo', '<>', 8)
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

      
     //if($not_per <> 0  ){
      
        $conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->first();

      //echo $conceptos->id_radica."\n";
              


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


   //}


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

    $opcionreporte = $request->opcionreporte;

    $request->session()->put('opcionreporte', $opcionreporte);
    
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

  
  public function ExcelcarteraClienteBonos(Request $request){


    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $opcionreporte = $request->session()->get('opcionreporte');
    $identificacion_cli = $request->session()->get('identificacion_cli');
    $nombrefile = 'BonosCliente'.'_'.$fecha1.'.'.'xls';
    
    return Excel::download(new BonosExportCli($identificacion_cli, $opcionreporte), $nombrefile);

  }
  

  public function ExcelCarteraFechaBonos(Request $request){

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $opcionreporte = $request->session()->get('opcionreporte');
    $nombrefile = 'BonosCliente'.'_'.$fecha1.'.'.'xls';


    return Excel::download(new BonosExportFecha($fecha1, $fecha2, $opcionreporte), $nombrefile);

  }

  public function ExcelNotasCredito(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $opcionreporte = $request->session()->get('opcionreporte');
    $nombrefile = 'RelacionNotaCredito'.'_'.$fecha1.'.'.'xls';


    return Excel::download(new NotasCreditoExport($fecha1, $fecha2), $nombrefile);

  }

  

  public function ExcelReteaplicada(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $nombrefile = 'ReteFuenteAplicada'.'_'.$fecha1.'.'.'xls';
    
    return Excel::download(new ExcelReteaplicadaExport($fecha1, $fecha2), $nombrefile);

  }

  

  public function ExcelNotasCreditoCajaRapida(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $nombrefile = 'RelNotaCreditoCajaRapida'.'_'.$fecha1.'.'.'xls';
    
    return Excel::download(new NotasCreditoCajaRapidaExport($fecha1, $fecha2), $nombrefile);

  }

  

   public function ExcelCarteraClienteBonosActi(Request $request){
    
    $fecha1 = $request->session()->get('fecha1');
    $opcionreporte = $request->session()->get('opcionreporte');
    $identificacion_cli = $request->session()->get('identificacion_cli');
    $nombrefile = 'BonosCliente'.'_'.$fecha1.'.'.'xls';
    
    return Excel::download(new BonosExportActivos($identificacion_cli, $opcionreporte), $nombrefile);

  }



  public function Reporte_ingresos_Dian(Request $request){

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fecha_reporte = date("d-m-Y");
    $ingreso = $request->session()->get('parametroingreso');
    $opcionreporte = $request->session()->get('opcionreporte');
    $nombrefile = 'reporte_ingresos_dian'.'_'. $opcionreporte . '_' . $fecha_reporte.'.'.'xls';

    return Excel::download(new IngresosdianescriturasExport($fecha1, $fecha2, $ingreso, $opcionreporte), $nombrefile);     
    
  }

  public function Reporte_enejenaciones_Dian(Request $request){

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fecha_reporte = date("d-m-Y");
    $opcionreporte = $request->session()->get('opcionreporte');
    $nombrefile = 'enajenaciones_dian'.'_'. $opcionreporte . '_' . $fecha_reporte.'.'.'xls';

    return Excel::download(new EnajenacionesExport($fecha1, $fecha2, $opcionreporte), $nombrefile);     
    
  }
  
}

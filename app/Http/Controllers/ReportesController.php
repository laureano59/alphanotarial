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
use App\Tarifa;
use App\Recaudos_sincuantia_excenta_view;
use App\Recaudos_concuantia_view;
use App\Actas_deposito_view;
use App\Exports\RonExport;
use App\Exports\BonosExportCli;
use App\Exports\CajaDiarioEspecial;
use App\Exports\IngresosdianescriturasExport;
use App\Exports\EnajenacionesExport;
use App\Exports\BonosExportFecha;
use App\Exports\BonosExportActivos;
use App\Exports\NotasCreditoExport;
use App\Exports\ExcelReteaplicadaExport;
use App\Exports\NotasCreditoCajaRapidaExport;
use App\Exports\ExcelDataXExport;
use App\Exports\ExcelDataXExportNC;
use App\Exports\ExcelDataXActasDepo;
use App\Exports\ExcelDataXExportCJ;
use App\Exports\ExcelDataXExportCJNC;
use App\Exports\ExcelIngresosExcedentes;
use App\Exports\ExcelEgresosDiarios;
use App\Exports\ExcelTrazabilidadEgreso;
use App\Exports\ExcelEscriturasPorActo;
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
    $ordenar = $request->session()->get('ordenar');
    return view('reportes.certificadortf' , compact('ordenar'));
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
  }else if($opcion == 34){
    $request->user()->authorizeRoles(['interfazdatax','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
     return view('reportes.interfazdatax', compact('nombre_reporte'));
  }else if($opcion == 35){   
    $request->user()->authorizeRoles(['interfazdatax','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
     return view('reportes.interfazdataxcajarapida', compact('nombre_reporte'));
  }else if($opcion == 36){   
    $request->user()->authorizeRoles(['interfazdatax','administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
     return view('reportes.interfazdataxactasdepo', compact('nombre_reporte'));
  }else if($opcion == 37){   
    $request->user()->authorizeRoles(['administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeactasporidentificacion', compact('nombre_reporte'));
  }else if($opcion == 38){   
    $request->user()->authorizeRoles(['administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeactasporidentificacion', compact('nombre_reporte'));
  }else if($opcion == 40){
    $request->user()->authorizeRoles(['relfactmensualescr', 'Infoegresos', 'consultar', 'administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.informeingresosexcedentes', compact('nombre_reporte'));
  }else if($opcion == 41){
    $request->user()->authorizeRoles(['relfactmensualescr', 'Infoegresos', 'consultar', 'administrador']);
    $nombre_reporte = $request->session()->get('nombre_reporte');
    return view('reportes.trazabilidadegreso', compact('nombre_reporte'));
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

    if (!$request->user()->roles->pluck('name')->intersect(['administrador', 'avanzado'])->count()) {
      $fecha1 = date('d/m/Y');
      $fecha2 = date('d/m/Y');    
    } else {
      $fecha1 = $request->fecha1;
      $fecha2 = $request->fecha2;
    }
   
   
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

      //$identificacion_cli

      if ($identificacion_cli === null || $identificacion_cli === ''){
         $informecartera = Informe_cartera_view::
          where('nota_credito', false)
          ->where('saldo_fact', '>=', 1)
          ->orderBy('id_fact')->get()
          ->toArray();
      }else{
          $informecartera = Informe_cartera_view::
          where('nota_credito', false)
          ->where('saldo_fact', '>=', 1)
          ->where('identificacion_cli', $identificacion_cli)
          ->orderBy('id_fact')->get()
          ->toArray();
      }

    
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

  

    if (!$request->user()->roles->pluck('name')->intersect(['administrador', 'avanzado'])->count()) {
        $fecha1 = date('m/d/Y');
        $fecha2 = date('m/d/Y');        
      } else {
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
      }   

   

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


    if (!$request->user()->roles->pluck('name')->intersect(['administrador', 'avanzado'])->count()) {
        $fecha1 = date('m/d/Y');
        $fecha2 = date('m/d/Y');        
      } else {
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
      }   




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
    $fecha2 = date("Y-m-d", strtotime($fecha2));
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);

    $anio = date("Y", strtotime($fecha1));

    $notaCredito = false;

    $recaudos = \DB::select("
    SELECT *
    FROM public.fn_informe_recaudos(?, ?, ?, ?)
        ", [
            $fecha1,
            $fecha2,
            $anio,
            $notaCredito
          ]);

    

      return response()->json([

        "recaudos"=>$recaudos

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
    $identificacion = trim((string) $request->get('identificacion'));

    $f1_arr = explode('/', (string) $fecha1);
    $f2_arr = explode('/', (string) $fecha2);
    if (count($f1_arr) == 3 && count($f2_arr) == 3) {
      $fecha1 = $f1_arr[2].'-'.$f1_arr[0].'-'.$f1_arr[1];
      $fecha2 = $f2_arr[2].'-'.$f2_arr[0].'-'.$f2_arr[1];
    } else {
      $fecha1 = date("Y-m-d", strtotime($fecha1));
      $fecha2 = date("Y-m-d", strtotime($fecha2));
    }
    
    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $request->session()->put('identificacion_cli', $identificacion);

    $opcionreporte = $request->opcionreporte ?: 'completo';

    $request->session()->put('opcionreporte', $opcionreporte);

    $Actas_egreso = $this->obtenerDatosInformeEgresosDiarios($fecha1, $fecha2, $opcionreporte, $identificacion);

    return response()->json([
      'egresos' => $Actas_egreso,
    ]);
  }

  public function ExcelEgresosDiarios(Request $request)
  {
    $fecha1 = $request->get('fecha1') ?: $request->session()->get('fecha1');
    $fecha2 = $request->get('fecha2') ?: $request->session()->get('fecha2');
    $opcionreporte = $request->get('opcionreporte') ?: $request->session()->get('opcionreporte');
    $identificacion = trim((string) ($request->get('identificacion') ?: $request->session()->get('identificacion_cli')));

    if (empty($fecha1) || empty($fecha2)) {
      return "Filtros de fecha requeridos";
    }

    $f1_arr = explode('/', (string) $fecha1);
    $f2_arr = explode('/', (string) $fecha2);
    if (count($f1_arr) == 3 && count($f2_arr) == 3) {
      $fecha1 = $f1_arr[2].'-'.$f1_arr[0].'-'.$f1_arr[1];
      $fecha2 = $f2_arr[2].'-'.$f2_arr[0].'-'.$f2_arr[1];
    } else {
      $fecha1 = date("Y-m-d", strtotime($fecha1));
      $fecha2 = date("Y-m-d", strtotime($fecha2));
    }

    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $request->session()->put('opcionreporte', $opcionreporte);
    $request->session()->put('identificacion_cli', $identificacion);

    $nombrefile = 'EgresosDiarios_'.$fecha1.'_'.$fecha2.'.xls';
    return Excel::download(new ExcelEgresosDiarios($fecha1, $fecha2, $opcionreporte, $identificacion), $nombrefile);
  }

  public function buildTrazabilidadEgresoQuery($fecha1, $fecha2, $identificacion = '', $tipoActa = 'todas')
  {
    $tipoActa = strtolower(trim((string) $tipoActa));
    if ($tipoActa === 'creedo' || $tipoActa === 'credit') {
      $tipoActa = 'credito';
    }

    $facturasSub = \DB::table('facturas')
      ->select('id_radica', 'anio_radica', \DB::raw('MIN(id_fact) as id_fact'))
      ->where('nota_credito', '=', false)
      ->groupBy('id_radica', 'anio_radica');

    // Cambiamos a actas_deposito_view como base para incluir actas sin egresos
    $query = \DB::table('actas_deposito_view as act')
      ->leftJoin('egreso_acta_deposito as egr', 'act.id_act', '=', 'egr.id_act')
      ->leftJoin('concepto_egreso as ce', 'ce.id_con', '=', 'egr.id_con')
      ->leftJoin(\DB::raw('('.$facturasSub->toSql().') as f'), function($join) {
        $join->on('f.id_radica', '=', 'act.id_radica')
             ->on('f.anio_radica', '=', 'act.anio_radica');
      })
      ->mergeBindings($facturasSub)
      ->where(function($q) use ($fecha1, $fecha2) {
          $q->whereBetween('act.fecha', [$fecha1, $fecha2])
            ->orWhereBetween('egr.fecha_egreso', [$fecha1, $fecha2]);
      })
      ->select(
        'egr.id_egr',
        'egr.id_con',
        'act.id_act',
        'egr.fecha_egreso',
        'act.id_radica',
        'act.fecha as fecha_acta',
        'egr.prefijo',
        'egr.id_fact as id_fact_egreso',
        'act.identificacion_cli',
        'act.nombre',
        'act.deposito_act',
        'act.deposito_boleta',
        'act.deposito_registro',
        'act.deposito_escrituras',
        'act.credito_act',
        'act.saldo as saldo_acta',
        'egr.egreso_egr',
        'egr.saldo as nuevo_saldo',
        'egr.observaciones_egr',
        'f.id_fact',
        'ce.concepto as concepto_egreso'
      )
      ->orderBy('act.id_act')
      ->orderBy('egr.fecha_egreso')
      ->orderBy('egr.id_egr');

    if (!empty($identificacion)) {
      $query->where('act.identificacion_cli', $identificacion);
    }

    if ($tipoActa === 'credito') {
      $query->where(function($q) {
        $q->where('act.credito_act', '=', true)
          ->orWhere('act.credito_act', '=', '1')
          ->orWhere('act.credito_act', '=', 1)
          ->orWhere('act.credito_act', '=', 't')
          ->orWhere('act.credito_act', '=', 'true');
      });
    } else if ($tipoActa === 'normal') {
      $query->where(function($q) {
        $q->whereNull('act.credito_act')
          ->orWhere('act.credito_act', '=', false)
          ->orWhere('act.credito_act', '=', 0)
          ->orWhere('act.credito_act', '=', '0')
          ->orWhere('act.credito_act', '=', 'f')
          ->orWhere('act.credito_act', '=', 'false');
      });
    }

    return $query;
  }

  public function calcularDescuentosTrazabilidad($rows)
  {
    $data = array();
    foreach ($rows as $row) {
      $baseActa = (float) (isset($row->deposito_act) ? $row->deposito_act : 0);
      $baseBol = (float) (isset($row->deposito_boleta) ? $row->deposito_boleta : 0);
      $baseReg = (float) (isset($row->deposito_registro) ? $row->deposito_registro : 0);
      $baseEsc = (float) (isset($row->deposito_escrituras) ? $row->deposito_escrituras : 0);
      $egreso = (float) (isset($row->egreso_egr) ? $row->egreso_egr : 0);
      $totalComponentes = $baseBol + $baseReg + $baseEsc;

      if ($totalComponentes > 0) {
        $descBol = round($egreso * ($baseBol / $totalComponentes), 2);
        $descReg = round($egreso * ($baseReg / $totalComponentes), 2);
        $descEsc = round($egreso * ($baseEsc / $totalComponentes), 2);
      } else {
        $descBol = 0;
        $descReg = 0;
        $descEsc = 0;
      }
      $descActa = $egreso;
      $saldoFinal = (float) (isset($row->nuevo_saldo) ? $row->nuevo_saldo : 0);
      
      // Si no hay egreso, el saldo final es el saldo de la propia acta
      if ($row->id_egr === null) {
          $saldoFinal = (float) $row->saldo_acta;
      }

      $data[] = (object) [
        'id_egr' => $row->id_egr,
        'id_con' => $row->id_con,
        'id_act' => $row->id_act,
        'fecha_acta' => isset($row->fecha_acta) ? $row->fecha_acta : '',
        'fecha_egreso' => $row->fecha_egreso,
        'id_radica' => $row->id_radica,
        'id_fact' => $row->id_fact,
        'factura' => !empty($row->id_fact_egreso) ? trim(($row->prefijo ? $row->prefijo.'-' : '').$row->id_fact_egreso) : $row->id_fact,
        'concepto_egreso' => $row->concepto_egreso,
        'identificacion_cli' => $row->identificacion_cli,
        'nombre' => $row->nombre,
        'deposito_act' => $baseActa,
        'deposito_boleta' => $baseBol,
        'deposito_registro' => $baseReg,
        'deposito_escrituras' => $baseEsc,
        'descuento_acta' => $descActa,
        'descuento_boleta' => $descBol,
        'descuento_registro' => $descReg,
        'descuento_escritura' => $descEsc,
        'egreso_egr' => $egreso,
        'saldo_final' => $saldoFinal,
        'observaciones_egr' => $row->observaciones_egr,
        'credito_act' => isset($row->credito_act) ? $row->credito_act : false
      ];
    }

    return $data;
  }

  /**
   * Relación de egresos (pantalla, Excel, PDF): mismos datos que Trazabilidad por acta,
   * con filtros completo | saldo>0 | solo actas a crédito.
   *
   * @param  string  $opcionreporte  completo|maycero|credito
   * @return array<int, array<string, mixed>>
   */
  public function obtenerDatosInformeEgresosDiarios($fecha1, $fecha2, $opcionreporte, $identificacion = '')
  {
    $opcionreporte = $opcionreporte ?: 'completo';
    if (! in_array($opcionreporte, ['completo', 'maycero', 'credito'], true)) {
      $opcionreporte = 'completo';
    }

    $tipoActa = ($opcionreporte === 'credito') ? 'credito' : 'todas';

    $rows = $this->buildTrazabilidadEgresoQuery($fecha1, $fecha2, $identificacion, $tipoActa)->get();
    $data = $this->calcularDescuentosTrazabilidad($rows);

    // Filtro saldo > 1 según solicitud (o > 0 para maycero)
    if ($opcionreporte === 'maycero') {
      $data = array_values(array_filter($data, function ($row) {
        return (float) $row->saldo_final > 1;
      }));
    }

    return $data;
  }

  public function ReporteTrazabilidadEgreso(Request $request)
  {
    $fecha1 = $request->get('fecha1');
    $fecha2 = $request->get('fecha2');
    $identificacion = trim((string) $request->get('identificacion'));
    $tipoActa = trim((string) $request->get('tipo_acta'));
    if ($tipoActa === '') {
      $tipoActa = 'todas';
    }

    $f1_arr = explode('/', (string) $fecha1);
    $f2_arr = explode('/', (string) $fecha2);
    if (count($f1_arr) == 3 && count($f2_arr) == 3) {
      $fecha1 = $f1_arr[2].'-'.$f1_arr[0].'-'.$f1_arr[1];
      $fecha2 = $f2_arr[2].'-'.$f2_arr[0].'-'.$f2_arr[1];
    } else {
      $fecha1 = date("Y-m-d", strtotime($fecha1));
      $fecha2 = date("Y-m-d", strtotime($fecha2));
    }

    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $request->session()->put('identificacion_cli', $identificacion);
    $request->session()->put('tipo_acta_egreso', $tipoActa);

    $rows = $this->buildTrazabilidadEgresoQuery($fecha1, $fecha2, $identificacion, $tipoActa)->get();
    $data = $this->calcularDescuentosTrazabilidad($rows);
    $agrupado = array();

    foreach ($data as $row) {
      $idAct = $row->id_act;
      if (!isset($agrupado[$idAct])) {
        $conceptoBase = 'Acta';
        if ((float) $row->deposito_escrituras > 0) {
          $conceptoBase = 'Escritura';
        } else if ((float) $row->deposito_registro > 0) {
          $conceptoBase = 'Registro';
        } else if ((float) $row->deposito_boleta > 0) {
          $conceptoBase = 'Boleta';
        }

        $agrupado[$idAct] = [
          'id_act' => $row->id_act,
          'fecha_acta' => $row->fecha_acta,
          'id_radica' => $row->id_radica,
          'identificacion_cli' => $row->identificacion_cli,
          'nombre' => $row->nombre,
          'deposito_act' => $row->deposito_act,
          'deposito_boleta' => $row->deposito_boleta,
          'deposito_registro' => $row->deposito_registro,
          'deposito_escrituras' => $row->deposito_escrituras,
          'credito_estado' => ($row->credito_act == true || $row->credito_act == 1 || $row->credito_act === '1' || $row->credito_act === 't' || $row->credito_act === 'true') ? 'CREDITO' : 'NORMAL',
          'concepto_base' => $conceptoBase,
          'egresos' => []
        ];
      }

      $agrupado[$idAct]['egresos'][] = [
        'id_egr' => $row->id_egr,
        'fecha_egreso' => $row->fecha_egreso,
        'factura' => $row->factura,
        'id_con' => $row->id_con,
        'concepto_egreso' => $row->concepto_egreso,
        'descuento_acta' => $row->descuento_acta,
        'descuento_boleta' => $row->descuento_boleta,
        'descuento_registro' => $row->descuento_registro,
        'descuento_escritura' => $row->descuento_escritura,
        'egreso_egr' => $row->egreso_egr,
        'saldo_final' => $row->saldo_final,
        'observaciones_egr' => $row->observaciones_egr
      ];
    }

    return response()->json([
      'trazabilidad' => array_values($agrupado)
    ]);
  }

  public function ExcelTrazabilidadEgreso(Request $request)
  {
    $fecha1 = $request->get('fecha1') ?: $request->session()->get('fecha1');
    $fecha2 = $request->get('fecha2') ?: $request->session()->get('fecha2');
    $identificacion = trim((string) ($request->get('identificacion') ?: $request->session()->get('identificacion_cli')));
    $tipoActa = trim((string) ($request->get('tipo_acta') ?: $request->session()->get('tipo_acta_egreso')));
    if ($tipoActa === '') {
      $tipoActa = 'todas';
    }

    if (empty($fecha1) || empty($fecha2)) {
      return "Filtros de fecha requeridos";
    }

    $f1_arr = explode('/', (string) $fecha1);
    $f2_arr = explode('/', (string) $fecha2);
    if (count($f1_arr) == 3 && count($f2_arr) == 3) {
      $fecha1 = $f1_arr[2].'-'.$f1_arr[0].'-'.$f1_arr[1];
      $fecha2 = $f2_arr[2].'-'.$f2_arr[0].'-'.$f2_arr[1];
    } else {
      $fecha1 = date("Y-m-d", strtotime($fecha1));
      $fecha2 = date("Y-m-d", strtotime($fecha2));
    }

    $request->session()->put('fecha1', $fecha1);
    $request->session()->put('fecha2', $fecha2);
    $request->session()->put('identificacion_cli', $identificacion);
    $request->session()->put('tipo_acta_egreso', $tipoActa);

    $nombrefile = 'TrazabilidadEgreso_'.$fecha1.'_'.$fecha2.'.xls';
    return (new ExcelTrazabilidadEgreso($fecha1, $fecha2, $identificacion, $tipoActa))->export();
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

  public function CajadiarioEspecial(Request $request){


    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $tipo_informe = $request->session()->get('tipoinforme');    
    $nombrefile = 'CajaEspecial'.'_'.$fecha1.'.'.'xls';
    
    return Excel::download(new CajaDiarioEspecial($fecha1, $fecha2, $tipo_informe), $nombrefile);

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

  public function ExcelDataX(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fechaActual = date('d-m-Y'); 
    //$conEncabezado = $request->session()->get('opcionreporte');
    $conEncabezado = ($request->session()->get('opcionreporte') === 'on');

    $nombrefile = 'CargaDataX'.'_'.$fechaActual.'.'.'xls';
    
    return Excel::download(new ExcelDataXExport($fecha1, $fecha2, $conEncabezado), $nombrefile);
  }

  public function ExcelDataXNC(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fechaActual = date('d-m-Y'); 
    //$conEncabezado = $request->session()->get('opcionreporte');
    $conEncabezado = ($request->session()->get('opcionreporte') === 'on');

    $nombrefile = 'CargaDataXNC'.'_'.$fechaActual.'.'.'xls';
    
    return Excel::download(new ExcelDataXExportNC($fecha1, $fecha2, $conEncabezado), $nombrefile);
  }

  public function ExcelDataXCajaRapida(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fechaActual = date('d-m-Y'); 
    //$conEncabezado = $request->session()->get('opcionreporte');
    $conEncabezado = ($request->session()->get('opcionreporte') === 'on');

    $nombrefile = 'CargaDataXCajarapida'.'_'.$fechaActual.'.'.'xls';
    
    return Excel::download(new ExcelDataXExportCJ($fecha1, $fecha2, $conEncabezado), $nombrefile);
  }

  public function ExcelDataXActasDepo(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fechaActual = date('d-m-Y'); 
    //$conEncabezado = $request->session()->get('opcionreporte');
    $conEncabezado = ($request->session()->get('opcionreporte') === 'on');

    $nombrefile = 'CargaDataXActasDepo'.'_'.$fechaActual.'.'.'xls';
    
    return Excel::download(new ExcelDataXActasDepo($fecha1, $fecha2, $conEncabezado), $nombrefile);
  }

  public function ExceldataxCajarapidaNC(Request $request){   

    $fecha1 = $request->session()->get('fecha1');
    $fecha2 = $request->session()->get('fecha2');
    $fechaActual = date('d-m-Y'); 
    //$conEncabezado = $request->session()->get('opcionreporte');
    $conEncabezado = ($request->session()->get('opcionreporte') === 'on');

    $nombrefile = 'CargaDataXCajarapidaNC'.'_'.$fechaActual.'.'.'xls';
    
    return Excel::download(new ExcelDataXExportCJNC($fecha1, $fecha2, $conEncabezado), $nombrefile);
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

  public function IngresosExcedentesOtrosPeriodos(Request $request)
  {
      $fecha1 = $request->get('fecha1');
      $fecha2 = $request->get('fecha2');
      if (empty($fecha1) || empty($fecha2)) {
          return response()->json(['reporte' => []]);
      }

      $f1_arr = explode('/', (string)$fecha1);
      $f2_arr = explode('/', (string)$fecha2);
      if (count($f1_arr) == 3 && count($f2_arr) == 3) {
          $f1 = $f1_arr[2].'-'.str_pad($f1_arr[1], 2, "0", STR_PAD_LEFT).'-'.str_pad($f1_arr[0], 2, "0", STR_PAD_LEFT);
          $f2 = $f2_arr[2].'-'.str_pad($f2_arr[1], 2, "0", STR_PAD_LEFT).'-'.str_pad($f2_arr[0], 2, "0", STR_PAD_LEFT);
      } else {
          $f1 = date("Y-m-d", strtotime($fecha1));
          $f2 = date("Y-m-d", strtotime($fecha2));
      }

      $request->session()->put('fecha1', $f1);
      $request->session()->put('fecha2', $f2);

      $reporte = \DB::table('facturas as f')
          ->leftJoin('escrituras as e', function ($join) {
              $join->on('e.id_radica', '=', 'f.id_radica')
                   ->on('e.anio_radica', '=', 'f.anio_radica');
          })
          ->select(
              'f.id_fact',
              'f.id_radica',
              'f.anio_radica',
              'f.fecha_fact',
              'e.num_esc',
              'e.fecha_esc',
              'f.total_derechos',
              'f.total_conceptos',
              'f.total_iva',
              'f.total_rtf',
              'f.total_fondo',
              'f.total_super',
              'f.total_fact as total_fac'
          )
          ->whereDate('f.fecha_fact', '>=', $f1)
          ->whereDate('f.fecha_fact', '<=', $f2)
          ->where('f.nota_credito', '=', false)
          ->where('f.nota_periodo', '=', 0)
          ->orderBy('f.fecha_fact')
          ->get();

      return response()->json(['reporte' => $reporte]);
  }

  public function ExcelIngresosExcedentes(Request $request)
  {
      $fecha1 = $request->get('fecha1') ?: $request->session()->get('fecha1');
      $fecha2 = $request->get('fecha2') ?: $request->session()->get('fecha2');
      if (empty($fecha1) || empty($fecha2)) {
          return 'Filtros de fecha requeridos';
      }
      $f1_arr = explode('/', (string)$fecha1);
      $f2_arr = explode('/', (string)$fecha2);
      if (count($f1_arr) == 3 && count($f2_arr) == 3) {
          $f1 = $f1_arr[2].'-'.str_pad($f1_arr[1], 2, "0", STR_PAD_LEFT).'-'.str_pad($f1_arr[0], 2, "0", STR_PAD_LEFT);
          $f2 = $f2_arr[2].'-'.str_pad($f2_arr[1], 2, "0", STR_PAD_LEFT).'-'.str_pad($f2_arr[0], 2, "0", STR_PAD_LEFT);
      } else {
          $f1 = date("Y-m-d", strtotime($fecha1));
          $f2 = date("Y-m-d", strtotime($fecha2));
      }
      $request->session()->put('fecha1', $f1);
      $request->session()->put('fecha2', $f2);

      return Excel::download(new ExcelIngresosExcedentes($f1, $f2), 'IngresosExcedentes.xlsx');
  }

  public function RelacionActasIdentificacion(Request $request)
  {
      $fecha1 = $request->get('fecha1');
      $fecha2 = $request->get('fecha2');
      $identificacion = $request->get('identificacion');
      $estado_acta = $request->get('estado_acta');
      $estadoNorm = is_string($estado_acta) ? strtolower(trim($estado_acta)) : '';

      // La fecha viene de JS en formato MM/DD/YYYY
      $f1_arr = explode('/', $fecha1);
      $f2_arr = explode('/', $fecha2);
      if(count($f1_arr) == 3 && count($f2_arr) == 3){
          $f1 = $f1_arr[2].'-'.$f1_arr[0].'-'.$f1_arr[1];
          $f2 = $f2_arr[2].'-'.$f2_arr[0].'-'.$f2_arr[1];
      } else {
          $f1 = date("Y-m-d", strtotime($fecha1));
          $f2 = date("Y-m-d", strtotime($fecha2));
      }

      
      $request->session()->put('fecha1', $f1);
      $request->session()->put('fecha2', $f2);
      $request->session()->put('identificacion_cli', $identificacion);
      $request->session()->put('estado_acta', $estado_acta);

      $query = \DB::table('actas_deposito_view')
          ->leftJoin('escrituras', function($join) {
                $join->on('actas_deposito_view.id_radica', '=', 'escrituras.id_radica')
                     ->on('actas_deposito_view.anio_radica', '=', 'escrituras.anio_radica');
          })
          ->leftJoin('facturas as f', function($join) {
              $join->on('f.id_radica', '=', 'actas_deposito_view.id_radica')
                   ->on('f.anio_radica', '=', 'actas_deposito_view.anio_radica')
                   ->where('f.nota_credito', '=', false);
          })
          ->select(
              'actas_deposito_view.*',
              'escrituras.num_esc',
              'f.id_fact'
          );

      $query->whereDate('actas_deposito_view.fecha', '>=', $f1)
            ->whereDate('actas_deposito_view.fecha', '<=', $f2);

      if (!empty($identificacion)) {
          $query->where('actas_deposito_view.identificacion_cli', '=', $identificacion);
      }

      if ($estadoNorm !== '') {
          if ($estadoNorm === 'con_saldo') {
              $query->where('actas_deposito_view.saldo', '>', 1);
          } elseif ($estadoNorm === 'anuladas') {
              $query->where(function ($q) {
                  $q->where('actas_deposito_view.anulada', '=', true)
                    ->orWhere('actas_deposito_view.anulada', '=', '1')
                    ->orWhere('actas_deposito_view.anulada', '=', 1)
                    ->orWhere('actas_deposito_view.anulada', '=', 't')
                    ->orWhere('actas_deposito_view.anulada', '=', 'true');
              });
          } elseif ($estadoNorm === 'credito') {
              $query->where(function ($q) {
                  $q->where('actas_deposito_view.credito_act', '=', true)
                    ->orWhere('actas_deposito_view.credito_act', '=', '1')
                    ->orWhere('actas_deposito_view.credito_act', '=', 1)
                    ->orWhere('actas_deposito_view.credito_act', '=', 't')
                    ->orWhere('actas_deposito_view.credito_act', '=', 'true');
              });
          }
      }

      $Actas_deposito = $query->orderBy('actas_deposito_view.id_act')->get()->toArray();
      \Log::info("Actas Found: " . count($Actas_deposito));
      if(count($Actas_deposito) > 0) \Log::info("Sample Record: ", (array)$Actas_deposito[0]);

      return response()->json([
          "depositos"=>$Actas_deposito
      ]);
  }

  public function RelacionActasCredito(Request $request)
  {
      return $this->RelacionActasIdentificacion($request);
  }

  public function ExcelActasIdentificacion(Request $request)
  {
      $fecha1 = $request->get('fecha1') ?: $request->session()->get('fecha1');
      $fecha2 = $request->get('fecha2') ?: $request->session()->get('fecha2');
      $identificacion = $request->get('identificacion') ?: $request->session()->get('identificacion_cli');
      $estado_acta = $request->get('estado_acta') ?: $request->session()->get('estado_acta');

      if (empty($fecha1) || empty($fecha2)) {
          return "Filtros de fecha requeridos";
      }

      // Mismo criterio que RelacionActasIdentificacion / PDF (MM/DD/YYYY desde el datepicker)
      $f1_arr = explode('/', $fecha1);
      $f2_arr = explode('/', $fecha2);
      if (count($f1_arr) === 3 && count($f2_arr) === 3) {
          $f1 = $f1_arr[2] . '-' . $f1_arr[0] . '-' . $f1_arr[1];
          $f2 = $f2_arr[2] . '-' . $f2_arr[0] . '-' . $f2_arr[1];
      } else {
          $f1 = date('Y-m-d', strtotime($fecha1));
          $f2 = date('Y-m-d', strtotime($fecha2));
      }

      $request->session()->put('fecha1', $f1);
      $request->session()->put('fecha2', $f2);
      $request->session()->put('identificacion_cli', $identificacion);
      $request->session()->put('estado_acta', $estado_acta);

      $nombrefile = 'ActasIdentificacion_' . $f1 . '_' . $f2 . '.xls';
      return (new \App\Exports\ExcelActasIdentificacion($f1, $f2, $identificacion, $estado_acta))->export();
  }

  public function ExcelActasCredito(Request $request)
  {
      return $this->ExcelActasIdentificacion($request);
  }

  private function parseDateForQuery($dateRaw)
  {
      $dateRaw = trim((string)$dateRaw);
      if ($dateRaw === '') {
          return null;
      }

      // Iso formato Y-m-d
      $dt = \DateTime::createFromFormat('Y-m-d', $dateRaw);
      if ($dt && $dt->format('Y-m-d') === $dateRaw) {
          return $dateRaw;
      }

      // Slash dd/mm/yyyy o mm/dd/yyyy
      if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $dateRaw, $parts)) {
          list(, $p1, $p2, $p3) = $parts;
          $d = (int)$p1;
          $m = (int)$p2;
          $y = (int)$p3;

          if (checkdate($m, $d, $y)) {
              return sprintf('%04d-%02d-%02d', $y, $m, $d);
          }
          if (checkdate($d, $m, $y)) {
              return sprintf('%04d-%02d-%02d', $y, $d, $m);
          }
      }

      // Guión dd-mm-yyyy o mm-dd-yyyy
      if (preg_match('/^(\d{1,2})-(\d{1,2})-(\d{4})$/', $dateRaw, $parts)) {
          list(, $p1, $p2, $p3) = $parts;
          $d = (int)$p1;
          $m = (int)$p2;
          $y = (int)$p3;

          if (checkdate($m, $d, $y)) {
              return sprintf('%04d-%02d-%02d', $y, $m, $d);
          }
          if (checkdate($d, $m, $y)) {
              return sprintf('%04d-%02d-%02d', $y, $d, $m);
          }
      }

      $ts = strtotime(str_replace('/', '-', $dateRaw));
      if ($ts !== false) {
          return date('Y-m-d', $ts);
      }

      throw new \InvalidArgumentException('Formato de fecha inválido: ' . $dateRaw);
  }

  public function getEscriturasPorActo(Request $request)
  {
      $request->user()->authorizeRoles(['administrador','consultar','escripendientescr','actosjurinotar','relfactmensualescr']);
      $actos = \DB::table('actos')->orderBy('nombre_acto')->get();
      return view('reportes.informeescrituraporacto', compact('actos'));
  }

  public function getEscriturasPorActoData(Request $request)
  {
      $fecha1_raw = $request->get('fecha1');
      $fecha2_raw = $request->get('fecha2');
      $actos = $request->get('actos');

      // Normaliza las fechas a Y-m-d garantizando que se entienda dd/mm/yyyy y mm/dd/yyyy
      try {
          $fecha1 = $this->parseDateForQuery($fecha1_raw);
          $fecha2 = $this->parseDateForQuery($fecha2_raw);
      } catch (\InvalidArgumentException $e) {
          return response()->json(['error' => 'Fecha inválida: ' . $e->getMessage()], 422);
      }

      if (empty($actos) || (is_array($actos) && in_array('TODOS', $actos)) || $actos == 'TODOS') {
          $actos_list = \DB::table('actos')->pluck('id_acto')->toArray();
      } else {
          $actos_list = is_array($actos) ? $actos : explode(',', (string)$actos);
      }

      // Filtrar solo numéricos y asegurar que no esté vacío
      $actos_list = array_filter($actos_list, 'is_numeric');
      if (empty($actos_list)) $actos_list = array(-1);

      $sql = "
          SELECT DISTINCT ON (apr.id_radica, apr.anio_radica, a.id_acto)
              e.num_esc AS escritura,
              apr.id_radica,
              apr.anio_radica,
              a.id_acto,
              a.nombre_acto,
              e.fecha_esc::text AS fecha_esc,
              f.id_fact,
              f.total_fact,
              TRIM(COALESCE(cli1.pmer_nombrecli,'') || ' ' || COALESCE(cli1.sgndo_nombrecli,'') || ' ' || COALESCE(cli1.pmer_apellidocli,'') || ' ' || COALESCE(cli1.sgndo_apellidocli,'')) AS otorgante,
              TRIM(COALESCE(cli2.pmer_nombrecli,'') || ' ' || COALESCE(cli2.sgndo_nombrecli,'') || ' ' || COALESCE(cli2.pmer_apellidocli,'') || ' ' || COALESCE(cli2.sgndo_apellidocli,'')) AS compareciente
          FROM actos_persona_radica apr
          INNER JOIN actos a ON apr.id_acto = a.id_acto
          LEFT JOIN escrituras e ON e.id_radica::text = apr.id_radica::text AND e.anio_radica = apr.anio_radica
          LEFT JOIN facturas f ON f.id_radica::text = apr.id_radica::text AND f.anio_radica = apr.anio_radica AND f.nota_credito = false
          LEFT JOIN clientes cli1 ON cli1.identificacion_cli = apr.identificacion_cli
          LEFT JOIN clientes cli2 ON cli2.identificacion_cli = apr.identificacion_cli2
          WHERE
              apr.id_acto IN (".implode(',', array_filter($actos_list, 'is_numeric')).")
              AND e.num_esc IS NOT NULL
              AND e.fecha_esc::date BETWEEN ? AND ?
          ORDER BY apr.id_radica, apr.anio_radica, a.id_acto, e.num_esc ASC NULLS LAST;
      ";

      $reporte = \DB::select($sql, array($fecha1, $fecha2));

      return response()->json(['reporte' => $reporte]);
  }

  public function ExcelEscriturasPorActo(Request $request)
  {
      $fecha1 = $request->get('fecha1') ?: $request->session()->get('fecha1');
      $fecha2 = $request->get('fecha2') ?: $request->session()->get('fecha2');
      $actos = $request->get('actos');

      if (empty($fecha1) || empty($fecha2)) {
          return response('Seleccione un rango de fechas para exportar.', 422);
      }

      return (new ExcelEscriturasPorActo($fecha1, $fecha2, $actos))->export();
  }
}

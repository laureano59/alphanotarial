<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Notaria;
use App\Factura;
use App\Notas_credito_factura;
use App\Actas_deposito_view;
use App\Cruces_actas_deposito_view;
use App\Bono;
use Mpdf\Mpdf;

class ConsultaEspecializadaController extends Controller
{
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['consultar', 'administrador']);
        return view('consultas.especializada');
    }

    public function buscar(Request $request)
    {
        try {
            $acta = trim((string)$request->get('acta', ''));
            $radica = trim((string)$request->get('radica', ''));
            $escritura = trim((string)$request->get('escritura', ''));
            $anio_escritura = trim((string)$request->get('anio_escritura', ''));
            $factura = trim((string)$request->get('factura', ''));

            $notaria = DB::table('notaria')->first();
            $anioActual = $notaria ? $notaria->anio_trabajo : date('Y');
            
            // Determinamos el año de búsqueda por defecto o especificado
            $targetAnio = !empty($anio_escritura) ? $anio_escritura : $anioActual;

            $facturasQuery = DB::table('facturas as f')
                ->leftJoin('escrituras as e', function($join) {
                    $join->on('e.id_radica', '=', 'f.id_radica')
                         ->on('e.anio_radica', '=', 'f.anio_radica');
                })
                ->select('f.*', 'e.num_esc', 'e.anio_esc', 'f.a_nombre_de as cliente_nombre');

            if (!empty($factura)) {
                $facturasQuery->whereRaw("f.id_fact::text ilike ?", ["%{$factura}%"]);
            }

            if (!empty($radica)) {
                $radicaSanitized = str_replace(' ', '', $radica);
                if (strpos($radicaSanitized, '-') !== false) {
                    list($radVal, $anioVal) = explode('-', $radicaSanitized, 2);
                    $facturasQuery->whereRaw("f.id_radica::text = ?", [trim($radVal)])
                                  ->whereRaw("f.anio_radica::text = ?", [trim($anioVal)]);
                } else {
                    $facturasQuery->whereRaw("f.id_radica::text = ?", [$radicaSanitized])
                                  ->whereRaw("f.anio_radica::text = ?", [$targetAnio]);
                }
            }

            if (!empty($escritura)) {
                $facturasQuery->whereRaw("e.num_esc::text = ?", [$escritura]);
            }

            if (!empty($anio_escritura)) {
                $facturasQuery->whereRaw("e.anio_esc::text = ?", [$anio_escritura]);
            }

            // Obtenemos los posibles contextos de radicación si se busca por acta o factura específica
            $radicasFromActas = collect([]);
            if (!empty($acta)) {
                $radicasFromActas = DB::table('actas_deposito_view')
                    ->whereRaw("id_act::text ilike ?", ["%{$acta}%"])
                    ->select('id_radica', 'anio_radica')
                    ->distinct()
                    ->get();
            }

            $radicasFromFacturas = collect([]);
            if (!empty($factura)) {
                $radicasFromFacturas = DB::table('facturas')
                    ->whereRaw("id_fact::text ilike ?", ["%{$factura}%"])
                    ->select('id_radica', 'anio_radica')
                    ->distinct()
                    ->get();
            }

            $facturasQuery = DB::table('facturas as f')
                ->leftJoin('escrituras as e', function($join) {
                    $join->on('e.id_radica', '=', 'f.id_radica')
                         ->on('e.anio_radica', '=', 'f.anio_radica');
                })
                ->select('f.*', 'e.num_esc', 'e.anio_esc', 'f.a_nombre_de as cliente_nombre');

            if (!empty($factura)) {
                $facturasQuery->whereRaw("f.id_fact::text ilike ?", ["%{$factura}%"]);
            }

            if (!empty($radica)) {
                $radicaSanitized = str_replace(' ', '', $radica);
                if (strpos($radicaSanitized, '-') !== false) {
                    list($radVal, $anioVal) = explode('-', $radicaSanitized, 2);
                    $facturasQuery->whereRaw("f.id_radica::text = ?", [trim($radVal)])
                                  ->whereRaw("f.anio_radica::text = ?", [trim($anioVal)]);
                } else {
                    $facturasQuery->whereRaw("f.id_radica::text = ?", [$radicaSanitized])
                                  ->whereRaw("f.anio_radica::text = ?", [$targetAnio]);
                }
            }

            if (!empty($escritura)) {
                $facturasQuery->whereRaw("e.num_esc::text = ?", [$escritura]);
            }

            if (!empty($anio_escritura)) {
                $facturasQuery->whereRaw("e.anio_esc::text = ?", [$anio_escritura]);
            }

            // Si el usuario busca por acta, incluimos facturas asociadas a todas las actas que coincidan
            if ($radicasFromActas->count() > 0) {
                $facturasQuery->where(function($q) use ($radicasFromActas) {
                    foreach ($radicasFromActas as $ra) {
                        $q->orWhere(function($sq) use ($ra) {
                            $sq->where('f.id_radica', $ra->id_radica)
                               ->where('f.anio_radica', $ra->anio_radica);
                        });
                    }
                });
            }

            $facturasData = $facturasQuery->limit(300)->get();

            $notasQuery = DB::table('notas_credito_factura as n')
                ->join('facturas as f', function($join) {
                    $join->on('f.id_fact', '=', 'n.id_fact')
                         ->on('f.prefijo', '=', 'n.prefijo');
                })
                ->select('n.*', 'f.id_radica', 'f.anio_radica');

            $hasFilterNC = false;
            
            if (!empty($factura)) {
                $notasQuery->whereRaw("n.id_fact::text ilike ?", ["%{$factura}%"]);
                $hasFilterNC = true;
            }
            if (!empty($radica)) {
                $notasQuery->whereRaw("f.id_radica::text = ?", [$radica]);
                $hasFilterNC = true;
            }
            if ($radicasFromActas->count() > 0) {
                $notasQuery->where(function($q) use ($radicasFromActas) {
                    foreach ($radicasFromActas as $ra) {
                        $q->orWhere(function($sq) use ($ra) {
                            $sq->where('f.id_radica', $ra->id_radica)
                               ->where('f.anio_radica', $ra->anio_radica);
                        });
                    }
                });
                $hasFilterNC = true;
            }
            if ($radicasFromFacturas->count() > 0) {
                $notasQuery->where(function($q) use ($radicasFromFacturas) {
                    foreach ($radicasFromFacturas as $rf) {
                        $q->orWhere(function($sq) use ($rf) {
                            $sq->where('f.id_radica', $rf->id_radica)
                               ->where('f.anio_radica', $rf->anio_radica);
                        });
                    }
                });
                $hasFilterNC = true;
            }
            
            if ($hasFilterNC) {
                $notasData = $notasQuery->limit(300)->get();
            } else {
                $notasData = collect([]);
            }

            // Query actas uniendo con escrituras para tener info de num_esc/anio_esc
            $actasQuery = DB::table('actas_deposito_view as a')
                ->leftJoin('escrituras as e', function($join) {
                    $join->on('e.id_radica', '=', 'a.id_radica')
                         ->on('e.anio_radica', '=', 'a.anio_radica');
                })
                ->select('a.*', 'e.num_esc', 'e.anio_esc');

            $hasFilterActas = false;
            if (!empty($acta)) {
                $actasQuery->whereRaw("a.id_act::text ilike ?", ["%{$acta}%"]);
                $hasFilterActas = true;
            }
            if (!empty($radica)) {
                if (strpos($radica, '-') !== false) {
                    list($radVal, $anioVal) = explode('-', $radica, 2);
                    $actasQuery->whereRaw("a.id_radica::text = ?", [trim($radVal)])
                               ->whereRaw("a.anio_radica::text = ?", [trim($anioVal)]);
                } else {
                    $actasQuery->whereRaw("a.id_radica::text = ?", [$radica])
                               ->whereRaw("a.anio_radica::text = ?", [$targetAnio]);
                }
                $hasFilterActas = true;
            }
            if (!empty($escritura)) {
                $actasQuery->whereRaw("e.num_esc::text = ?", [$escritura]);
                $hasFilterActas = true;
            }
            if (!empty($anio_escritura)) {
                $actasQuery->whereRaw("e.anio_esc::text = ?", [$anio_escritura]);
                $hasFilterActas = true;
            }
            if ($radicasFromFacturas->count() > 0) {
                $actasQuery->where(function($q) use ($radicasFromFacturas) {
                    foreach ($radicasFromFacturas as $rf) {
                        $q->orWhere(function($sq) use ($rf) {
                            $sq->where('a.id_radica', $rf->id_radica)
                               ->where('a.anio_radica', $rf->anio_radica);
                        });
                    }
                });
                $hasFilterActas = true;
            }

            if ($hasFilterActas) {
                $actasData = $actasQuery->take(200)->get();
            } else {
                $actasData = collect([]);
            }

            if($actasData->count() > 0) {
                // Obtener todos los cruces en una sola consulta para mayor eficiencia
                $actaIds = $actasData->pluck('id_act')->map(function($id) { return (string)$id; })->toArray();
                
                // Usamos la tabla egreso_acta_deposito directamente como sugiere el usuario
                $allCruces = DB::table('egreso_acta_deposito')
                    ->whereIn(DB::raw("id_act::text"), $actaIds)
                    ->get()
                    ->groupBy(function($c) { return (string)$c->id_act; });
                
                $actasData = $actasData->map(function ($item) use ($allCruces) {
                    $key = (string)$item->id_act;
                    $item->cruces = $allCruces->has($key) ? $allCruces->get($key) : [];
                    return $item;
                });
            } else {
                $actasData = [];
            }

            // Query bonos uniendo con escrituras para tener info de num_esc/anio_esc
            $bonosQuery = DB::table('bonos as b')
                ->leftJoin('escrituras as e', function($join) {
                    $join->on('e.id_radica', '=', 'b.id_radica')
                         ->on('e.anio_radica', '=', 'b.anio_radica');
                })
                ->select('b.*', 'e.num_esc', 'e.anio_esc', 
                         'b.anio_radica as anio_radicacion',
                         'b.valor_bon as valor_bono',
                         'b.saldo_bon as saldo_bono');

            $hasFilterBonos = false;
            if (!empty($radica)) {
                if (strpos($radica, '-') !== false) {
                    list($rV, $aV) = explode('-', $radica, 2);
                    $bonosQuery->whereRaw("b.id_radica::text = ?", [trim($rV)])
                               ->whereRaw("b.anio_radica::text = ?", [trim($aV)]);
                } else {
                    $bonosQuery->whereRaw("b.id_radica::text = ?", [$radica])
                               ->whereRaw("b.anio_radica::text = ?", [$targetAnio]);
                }
                $hasFilterBonos = true;
            }
            if (!empty($escritura)) {
                $bonosQuery->whereRaw("e.num_esc::text = ?", [$escritura]);
                $hasFilterBonos = true;
            }
            if (!empty($anio_escritura)) {
                $bonosQuery->whereRaw("e.anio_esc::text = ?", [$anio_escritura]);
                $hasFilterBonos = true;
            }
            if ($radicasFromActas->count() > 0) {
                $bonosQuery->where(function($q) use ($radicasFromActas) {
                    foreach ($radicasFromActas as $ra) {
                        $q->orWhere(function($sq) use ($ra) {
                            $sq->where('b.id_radica', $ra->id_radica)
                               ->where('b.anio_radica', $ra->anio_radica);
                        });
                    }
                });
                $hasFilterBonos = true;
            }
            if ($radicasFromFacturas->count() > 0) {
                $bonosQuery->where(function($q) use ($radicasFromFacturas) {
                    foreach ($radicasFromFacturas as $rf) {
                        $q->orWhere(function($sq) use ($rf) {
                            $sq->where('b.id_radica', $rf->id_radica)
                               ->where('b.anio_radica', $rf->anio_radica);
                        });
                    }
                });
                $hasFilterBonos = true;
            }

            if ($hasFilterBonos) {
                $bonosData = $bonosQuery->limit(200)->get();
            } else {
                $bonosData = collect([]);
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'facturas' => $facturasData,
                    'notas_credito' => $notasData,
                    'actas' => $actasData,
                    'bonos' => $bonosData,
                ],
                'escritura_info' => '',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'mensaje' => 'Error al realizar la búsqueda: ' . $e->getMessage()
            ], 500);
        }
    }

    public function exportExcel(Request $request)
    {
        $searchResponse = $this->buscar($request);
        $json = $searchResponse->getData();

        $filename = 'consulta_especializada_' . date('Ymd_His') . '.csv';

        $callback = function () use ($json) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Tipo', 'Id', 'Detalle', 'Valor']);

            foreach ($json->data->facturas as $f) {
                fputcsv($handle, ['Factura', isset($f->id_fact) ? $f->id_fact : '', isset($f->a_nombre_de) ? $f->a_nombre_de : '', isset($f->total_fact) ? $f->total_fact : '']);
            }

            foreach ($json->data->notas_credito as $nc) {
                fputcsv($handle, ['NotaCredito', isset($nc->id_ncf) ? $nc->id_ncf : '', isset($nc->id_fact) ? $nc->id_fact : '', isset($nc->total_iva) ? $nc->total_iva : '']);
            }

            foreach ($json->data->actas as $a) {
                fputcsv($handle, ['Acta', isset($a->id_act) ? $a->id_act : '', isset($a->identificacion_cli) ? $a->identificacion_cli : '', isset($a->saldo) ? $a->saldo : '']);
            }

            foreach ($json->data->bonos as $b) {
                fputcsv($handle, ['Bono', isset($b->id_bon) ? $b->id_bon : '', isset($b->codigo_bono) ? $b->codigo_bono : '', isset($b->saldo_bono) ? $b->saldo_bono : '']);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function exportPdf(Request $request)
    {
        $searchResponse = $this->buscar($request);
        $json = $searchResponse->getData();

        $notaria = Notaria::find(1);
        $f1 = $request->get('f1', '');
        $f2 = $request->get('f2', '');

        $html = view('pdf.consulta_especializada', [
            'nombre_nota' => isset($notaria->nombre_nota) ? $notaria->nombre_nota : '',
            'nombre_notario' => isset($notaria->nombre_notario) ? $notaria->nombre_notario : '',
            'nit' => isset($notaria->nit) ? $notaria->nit : '',
            'direccion_nota' => isset($notaria->direccion_nota) ? $notaria->direccion_nota : '',
            'email' => isset($notaria->email) ? $notaria->email : '',
            'fecha_impresion' => date('Y-m-d H:i:s'),
            'query' => 'Consulta Especializada',
            'usuario' => $request->user() ? $request->user()->name : '',
            'facturas' => $json->data->facturas,
            'actas' => $json->data->actas,
            'bonos' => $json->data->bonos,
            'escritura_destacada' => '',
        ])->render();

        $mpdf = new Mpdf(['format' => 'Letter', 'margin_top' => 10, 'margin_bottom' => 10]);
        $mpdf->WriteHTML($html);

        return $mpdf->Output('consulta_especializada_' . date('Ymd_His') . '.pdf', 'I');
    }
}

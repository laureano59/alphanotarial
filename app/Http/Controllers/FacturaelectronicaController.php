<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Notaria;
use App\Notas_credito_factura;
use App\Notas_debito_factura;
use Carbon\Carbon;

class FacturaelectronicaController extends Controller
{
    public function index(Request $request)
    {

    	return view('facturacion.facturaelectronica');
    }

    public function CargarFacturas(Request $request){

        # ======================================================================
        # =           Se cargan facturas, notas credito, notas debito          =
        # ======================================================================

        $prefijo_fact = Notaria::find(1)->prefijo_fact;
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
        $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
        $fecha2 = date("Y-m-d", strtotime($fecha2));
        $raw = \DB::raw("id_fact");
        $facturas = Factura::where("prefijo","=",$prefijo_fact)
        ->whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->where('status_factelectronica', '=', '0')
        ->select($raw)->get();

        $raw1 = \DB::raw("id_ncf");
        $notas_c = Notas_credito_factura::where("prefijo_ncf","=",$prefijo_fact)
        ->whereDate('created_at', '>=', $fecha1)
        ->whereDate('created_at', '<=', $fecha2)
        ->where('status_factelectronica', '=', '0')
        ->select($raw1)->get();

        $raw2 = \DB::raw("id_ndf");
        $notas_d = Notas_debito_factura::where("prefijo_ndf","=",$prefijo_fact)
        ->whereDate('created_at', '>=', $fecha1)
        ->whereDate('created_at', '<=', $fecha2)
        ->where('status_factelectronica', '=', '0')
        ->select($raw2)->get();

        return response()->json([
            "facturas"=>$facturas,
            "notas_c"=> $notas_c,
            "notas_d"=> $notas_d
        ]);
    }
}

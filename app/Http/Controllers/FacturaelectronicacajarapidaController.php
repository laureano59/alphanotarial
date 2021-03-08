<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturascajarapida;
use App\Notaria;
use App\Notas_credito_cajarapida;
use Carbon\Carbon;

class FacturaelectronicacajarapidaController extends Controller
{
	
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function CargarFacturas_cajarapida(Request $request){

        # ======================================================================
        # =           Se cargan facturas, notas credito, notas debito          =
        # ======================================================================

        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $fecha1 = $request->fecha1;
        $fecha2 = $request->fecha2;
        $fecha1 = date("Y-m-d", strtotime($fecha1)); //Convierte Fecha a YYYY-mm-dd
        $fecha2 = date("Y-m-d", strtotime($fecha2));
        $raw = \DB::raw("id_fact");
        $facturas = Facturascajarapida::where("prefijo","=",$prefijo_fact)
        ->whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->where('status_factelectronica', '=', '0')
        ->select($raw)->get();

        $raw1 = \DB::raw("id_ncf");
        $notas_c = Notas_credito_cajarapida::where("prefijo_ncf","=",$prefijo_fact)
        ->whereDate('created_at', '>=', $fecha1)
        ->whereDate('created_at', '<=', $fecha2)
        ->where('status_factelectronica', '=', '0')
        ->select($raw1)->get();

       
        return response()->json([
        	"validar"=>1,
            "facturas"=>$facturas,
            "notas_c"=> $notas_c,
        ]);
    }
}



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Detalle_cajarapidafacturas;
use App\Facturascajarapida;
use App\Conceptos_cajarapida;
use App\Tarifa;

class AgregaritemcajarapidaController extends Controller
{
    
    public function AgregarItemCajaRapida(Request $request)
    {
        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $id_concepto = $request->id_concepto;
        $cantidad = $request->cantidad;

        $tarifa = Tarifa::find(9);//IVA
        $porcentaje_iva = $tarifa['valor1'];
        $porcentaje_iva = $porcentaje_iva / 100;

        $concepto = Conceptos_cajarapida::find($id_concepto);
        $nombre_concep = $concepto['nombre_concep'];
        $valor_unitario = $concepto['valor'];
        $excento_iva = $concepto['iva_cajarap'];
        $subtotal = $concepto['valor'] * $cantidad;

        $iva = 0;
        if($excento_iva == 0){
            $iva = round($subtotal * $porcentaje_iva);
        }
        
        $total= round($subtotal + $iva);


        return response()->json([
         "validar"=>1,
         "nombre_concep"=>$nombre_concep,
         "valor_unitario"=>$valor_unitario,
         "subtotal"=>$subtotal,
         "total_iva"=>$iva,
         "total"=>$total
       ]);

    }
}

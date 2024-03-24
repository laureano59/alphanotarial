<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Base_cajarapida;

class BasecajarapidaController extends Controller
{
     public function store(Request $request){
       //$request->user()->authorizeRoles(['facturacion','administrador']);
        
        if ($request->user()->hasRole('administrador') || $request->user()->hasRole('caja_rapida')) {
            $fecha_base = date("Y-m-d");
            $registro = Base_cajarapida::where('fecha_base', $fecha_base)->first();

            if ($registro) {
                return response()->json([
                "validar"=>2,
                "mensaje"=>"Solo puedes aperturar la caja una vez por día"
                ]);
   
            } else {
                $base_cajarapida = new Base_cajarapida();
                $base_cajarapida->valor_base = $request->valor_base;
                $base_cajarapida->fecha_base = $fecha_base;
                $base_cajarapida->save();

                return response()->json([
                "validar"=>1,
                "mensaje"=>"Muy bien! ya pueden facturar"
                ]);
            }
        } else {
           return response()->json([
                "validar"=>7,
                "mensaje"=>"El usuario actual no está autorizado para hacer apertura de caja"
                ]);
        }
     }
}

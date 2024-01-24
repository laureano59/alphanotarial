<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Consulta_caja_rapida_view;


class ConsultacajarapidaController extends Controller
{
    /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

       return view('caja_rapida.consultas');
     
  }

  public function Consulta_CajaRapida(Request $request){

     $anio_trabajo = Notaria::find(1)->anio_trabajo;
     $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;

      $filtro = $request->filtro;
      $info = $request->info;
      $anio = $request->anio;

      if($anio == ''){
        $anio = $anio_trabajo;
      }

     if($filtro == 'factura'){
        $Consulta = Consulta_caja_rapida_view::
                    where('id_fact', '=', $info)
                    ->where('prefijo', '=', $prefijo_fact)
                    ->whereYear('fecha_fact', '=', $anio)
                    ->get()
                    ->toArray();
      }else if($filtro == 'identificacion'){
        $Consulta = Consulta_caja_rapida_view::
                      where('a_nombre_de', '=', $info)
                      ->whereYear('fecha_fact', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'nombre'){
        $Consulta = Consulta_caja_rapida_view::
                    where('nombre', 'ilike', '%' . $info . '%')
                    ->whereYear('fecha_fact', '=', $anio)
                    ->get()
                    ->toArray();
     }else if($filtro == 'Facturador'){
        $Consulta = Consulta_caja_rapida_view::
                      where('usuario', 'ilike', '%' . $info . '%')
                      ->whereYear('fecha_fact', '=', $anio)
                      ->get()
                      ->toArray();
      }
      
       return response()->json([
         "consulta"=>$Consulta
       ]);

  }
}

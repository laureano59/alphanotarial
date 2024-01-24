<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Seguimiento_radicacion_view;
use App\Seguimiento_radicacion_secundarios_view;
use App\Notaria;

class ConsultasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {

       return view('consultas.seguimiento_radicacion');
       //return view('consultas.panel_consultas');
  }

    /*public function Rastrear_Radicacion(Request $request){
      return view('consultas.seguimiento_radicacion');
    }*/


    public function Consultar(Request $request){

      $anio_trabajo = Notaria::find(1)->anio_trabajo;

      $filtro = $request->filtro;
      $info = $request->info;
      $anio = $request->anio;

      if($anio == ''){
        $anio = $anio_trabajo;
      }

      if($filtro == 'radicacion'){
        $Seguimiento = Seguimiento_radicacion_view::
                      where('id_radica', '=', $info)
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'factura'){
        $Seguimiento = Seguimiento_radicacion_view::
                    where('id_fact', '=', $info)
                    //->where('anio_radica', '=', $anio)
                    ->get()
                    ->toArray();
      }else if($filtro == 'escritura'){
        $Seguimiento = Seguimiento_radicacion_view::
                      where('num_esc', '=', $info)
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'otorgante'){
        $Seguimiento = Seguimiento_radicacion_view::
                    //where('otorgante', '=', $info)
                    where('nombre_otorgante','ilike', '%'.$info.'%')
                    //->where('anio_radica', '=', $anio)
                    ->get()
                    ->toArray();
      }else if($filtro == 'compareciente'){
         $Seguimiento = Seguimiento_radicacion_view::
                      //where('compareciente', '=', $info)
                      where('nombre_compareciente','ilike', '%'.$info.'%')
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'protocolista'){
        $Seguimiento = Seguimiento_radicacion_view::
                      where('protocolista','ilike','%'.$info.'%')
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'usuario'){
        $Seguimiento = Seguimiento_radicacion_view::
                      where('usuario','ilike', '%'.$info.'%')
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }
      
       return response()->json([
         "consulta"=>$Seguimiento
       ]);
     
    }


    public function Consultar_secun(Request $request){

      $anio_trabajo = Notaria::find(1)->anio_trabajo;

      $filtro = $request->filtro;
      $info = $request->info;
      $anio = $request->anio;

      if($anio == ''){
        $anio = $anio_trabajo;
      }

      if($filtro == 'radicacion'){
        $Seguimiento = Seguimiento_radicacion_secundarios_view::
                      where('id_radica', '=', $info)
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'factura'){
        $Seguimiento = Seguimiento_radicacion_secundarios_view::
                    where('id_fact', '=', $info)
                    //->where('anio_radica', '=', $anio)
                    ->get()
                    ->toArray();
      }else if($filtro == 'escritura'){
        $Seguimiento = Seguimiento_radicacion_secundarios_view::
                      where('num_esc', '=', $info)
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'otorgante'){
        $Seguimiento = Seguimiento_radicacion_secundarios_view::
                    where('otorgante', '=', $info)
                    ->orWhere('nombre_otorgante','like', '%'.$info.'%')
                   // ->where('anio_radica', '=', $anio)
                    ->get()
                    ->toArray();
      }else if($filtro == 'compareciente'){
         $Seguimiento = Seguimiento_radicacion_secundarios_view::
                      where('otorgante', '=', $info)
                      ->orWhere('nombre_otorgante','like', '%'.$info.'%')
                     // ->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'protocolista'){
        $Seguimiento = Seguimiento_radicacion_secundarios_view::
                      where('protocolista','like','%'.$info.'%')
                      //->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }else if($filtro == 'usuario'){
        $Seguimiento = Seguimiento_radicacion_secundarios_view::
                      where('usuario','like', '%'.$info.'%')
                     // ->where('anio_radica', '=', $anio)
                      ->get()
                      ->toArray();
      }
      
       return response()->json([
         "consulta"=>$Seguimiento
       ]);
     
    }

}

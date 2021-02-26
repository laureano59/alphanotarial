<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SesionesController extends Controller
{
    public function Sessiones(Request $request){
      $id = $request->input('id_radica');
      $request->session()->put('key', $id);
    }



    public function Sessiones_cajarapida(Request $request){
    	$request->session()->forget('opcioncajarapida');
      	$opcion = $request->input('opcion');
      	$request->session()->put('opcioncajarapida', $opcion);

      return response()->json([
      	"validar"=>1,
      ]);
    }


    public function Sessiones_protocolistas(Request $request){
      $request->session()->forget('opcion_protocolista');
      $opcion = $request->input('opcion');
      $request->session()->put('opcion_protocolista', $opcion);

      return response()->json([
        "validar"=>1,
      ]);
    }


    public function Sessiones_Identificacion(Request $request){
      $request->session()->forget('identificacion');
      $opcion = $request->identificacion;
      $request->session()->put('identificacion', $opcion);

      return response()->json([
        "validar"=>1,
      ]);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciudad;

class CiudadController extends Controller
{
    public function ciudad(Request $request){
      $id_depa = $request->input('id_depa');
      $raw = \DB::raw("id_ciud, nombre_ciud");
      $ciudad = Ciudad::where('id_depa', $id_depa)->select($raw)->get();
      $ciudad = $ciudad->sortBy('nombre_ciud')->toArray();
      //print_r($ciudad);

      return response()->json([
         "ciudad"=>$ciudad
       ]);

    }
}

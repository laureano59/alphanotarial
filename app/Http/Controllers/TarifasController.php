<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarifa;

class TarifasController extends Controller
{
    /**TODO:Tarifas***/
    public function Tarifas(Request $reques){
      $id = $reques->input('id_tar');
      $porcentajeiva = $this->Iva($id);
      return response()->json([
        "porcentajeiva"=>$porcentajeiva
      ]);

    }

    /***TODO:IVA, RTF, Retenciones y cualquier tarifa****/
    private function Iva($id){
      $porcentaje = Tarifa::find($id)->valor1;
      return $porcentaje;
    }
}

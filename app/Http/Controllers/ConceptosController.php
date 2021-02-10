<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acto;
use App\Concepto;

class ConceptosController extends Controller
{
    /*TODO:************Retorna todos los atributos de un acto******************/
    public function ConceptoActo(Request $request){
      $id = $request->input('id_acto');
      $conceptosacto = Acto::find($id);
      // if($conceptosacto->telegrama){
      //   printf("verdadero");
      // }else{
      //   printf("falso");
      // }

      $Conceptos = Concepto::all();
      $Conceptos = $Conceptos->sortBy('id_concep');
      $i=1;
      foreach ($Conceptos as $clave => $valor) {
        $atributo = $valor['atributo'];
        if($conceptosacto->$atributo){
          $estado = 1;
        }else {
            $estado = 0;
        }
          $dataconcept[$i]['atributo'] = $valor['atributo'];
          $dataconcept[$i]['estado'] = $estado;
          $i++;
       }

      return response()->json([
         "conceptos"=> $dataconcept
       ]);


    }

    public function ValorConceptos(Request $request){
      $id = $request->input('id_concep');
      $valor = Concepto::find($id)->valor;
      $total = $request->input('hojas') * $valor;

      return response()->json([
         "total"=> $total
       ]);

    }

    public function Conceptos_All(){
      $Conceptos = Concepto::all();
      $Conceptos = $Conceptos->sortBy('id_concep');
      return response()->json([
         "conceptos"=> $Conceptos
       ]);
    }

    public function TraeConceptoPorId(Request $request){
      $id_concep = $request->input('id_concep');
      $Concepto = Concepto::find($id_concep);
      return response()->json([
         "concepto"=> $Concepto
       ]);
    }
}

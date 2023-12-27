<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Principal;
use App\Otorganteview;
use App\Comparecienteview;
use App\Actosclienteradica;
use App\Tipo_reportados;
use App\Reportados;

class PrincipalesController extends Controller
{

    //TODO: Valida si Existe el Cliente

    public function existecliente(Request $request){

      $id = $request->input('identificacion_cli');//$request->identificacion_cli;
      $tipo_doc = $request->input('tipo_doc');//$request->tipo_doc;+

      /*Valida si hay algun tipo de reporte en el cliente y envia una alerta*/
      $reportado = Reportados::where('identificacion_rep', $id)->where('activo', true)->first();
      if($reportado){
          $nombre = $reportado->nombre_rep;
          $id_tipo = $reportado->id_tipo_rep;
          $concepto = $reportado->concepto_rep;
          $activo = $reportado->activo;

           return response()->json([
            "validar"=> "7",
            "nombre"=> $nombre,
            "concepto"=>$concepto
          ]);

      }else{
        if (Cliente::where('identificacion_cli', $id)->exists()){
        $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname");
        $nombre = Cliente::where('identificacion_cli', $id)->select($raw)->get();
        foreach ($nombre as $nom) {
          $nom = $nom->fullname;
        }

        return response()->json([
          "validar"=> "1",
           "nombre"=> $nom
         ]);
      }else{
        return response()->json([
           //"mensaje"=> $request->all()
           "validar"=> "0",
           "identificacion_cli" => $id,
           "tipo_doc" => $tipo_doc
         ]);
      }

      }
      
    }

    /**
     * Muestra Principales.
    **/

      public function listingprincipales(Request $request){
        
        $cuantia = $request->valor_cuantia;
        $tradicion = $request->tradicion;
        $request->session()->put('cuantia_otor', $cuantia);
        $request->session()->put('tradi', $tradicion);

        $id = $request->input('id_actoperrad');
        $raw = \DB::raw("CONCAT(pmer_nombrecli1, ' ', sgndo_nombrecli1, ' ', pmer_apellidocli1, ' ', sgndo_apellidocli1, empresa1) as fullname1, CONCAT(pmer_nombrecli2, ' ', sgndo_nombrecli2, ' ', pmer_apellidocli2, ' ', sgndo_apellidocli2, empresa2) as fullname2");
        $nombre = Principal::where('id_actoperrad', $id)->select($raw)->get();
        if (!$nombre->isEmpty()){//Valida si la cosulta NÓ es vacía
          foreach ($nombre as $nom) {
            $nom1 = $nom->fullname1;
            $nom2 = $nom->fullname2;
          }
        }else{
          $nom1 = 'Vacio';
          $nom2 = 'Vacio';
        }

        $principales = Principal::find($id);

        /**********TODO:Envía 1 o Cero para validar los campos vacios************/
        if ($principales){//TODO:Valida si la cosulta NÓ es vacía
          $validarprincipales = 1;
        }else{
          $validarprincipales = 0;
        }

        $raw1 = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        id_otor, identificacion_cli, porcentaje_otor");
        $otorgantes = Otorganteview::where('id_actoperrad', $id)->select($raw1)->get();

        $raw2 = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        id_comp, identificacion_cli2, porcentaje_comp");
        $comparecientes = Comparecienteview::where('id_actoperrad', $id)->select($raw2)->get();

        /** TODO:Este id_acto lo mando vía json al ajax para validar la retefuente**/
        $acto = \DB::table('actos_persona_radica')->where('id_actoperrad', $id)->get();
        foreach ($acto as $id_act) {
            $id_acto = $id_act->id_acto;
        }

        return response()->json([
           "nombre1"=> $nom1,
           "nombre2"=> $nom2,
           "validarprincipales"=>$validarprincipales,
           "principales" => $principales,
           "otorgantes" => $otorgantes,
           "comparecientes" => $comparecientes,
           "id_acto"=> $id_acto
         ]);
    }
}

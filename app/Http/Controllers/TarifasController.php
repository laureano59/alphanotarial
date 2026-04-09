<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarifa;
use App\Notaria;

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


    public function Retenciones(Request $reques){

      $id_ciud_nota = Notaria::find(1)->id_ciud;
      $autoreteiva  =  $reques->autoreteiva;
      $autoretertf  =  $reques->autoretertf;
      $autoreteica  =  $reques->autoreteica;
      $id_ciud      =  $reques->id_ciud;
      $iva          =  $reques->total_iva;//para reteiva      
      $ingresos     =  $reques->ingresos;
      $reteiva      =  0;
      $reteica      =  0;
      $retefuente   =  0;
        

      if ($id_ciud == $id_ciud_nota){
          $ica_flash = 1;
         
      }elseif ($id_ciud != $id_ciud_nota){
          $ica_flash = 0;
      }      


      if ($autoreteiva == 'true') {
            $id_tar = 26;
            $porcentaje = $this->Iva($id_tar);
            $reteiva    = round($iva * $porcentaje);
      }elseif ($autoreteiva == 'false'){
        $reteiva = 0;
      }


      if ($autoreteica == 'true') {
            
        if ($ica_flash == 1){
            $id_tar = 27;
            $porcentaje = $this->Iva($id_tar);
            $porcentaje = $porcentaje / 1000;
            $reteica    = round($ingresos * $porcentaje); 
        }elseif ($ica_flash == 0){
          $reteica = 0;
        }

      }elseif ($autoreteica == 'false'){
          $reteica = 0;
      }   


      if ($autoretertf == 'true') {
            $id_tar = 28;
            $porcentaje = $this->Iva($id_tar);
            $retefuente = round($ingresos * $porcentaje);

                     
      }elseif ($autoretertf == 'false'){
            $retefuente = 0;
      }


      return response()->json([
        "reteiva"=>     $reteiva,    
        "reteica"=>     $reteica,    
        "retefuente"=>  $retefuente
      ]);


    }


     /***TODO:IVA, RTF, Retenciones y cualquier tarifa****/
    private function Iva($id){
      $porcentaje = Tarifa::find($id)->valor1;
      return $porcentaje;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarifa;
use App\Otorgante;
use App\Cliente;
use App\Actosclienteradica;

class RecaudosController extends Controller
{
    /*************:Recaudos RTF, Super, Fondo, Iva, ReteConsumo************/
    public function Recaudos(Request $request){
      $actos = $request->input('actos');
      $recsuperfondo = $this->SuperFondo($actos);
      $recsuper = $recsuperfondo / 2;
      $recfondo = $recsuperfondo / 2;
      $rtf = $this->ReteFuente($actos);
      $reteconsumo = $this->ReteConsumo($actos);
      $aporteespecial = $this->AporteEspecial($actos);
      $impuesto_timbre = $this->ImpuestoTimbre($actos);
      $timbredecreto175 = $this->ImpuestoTimbreC($actos);


      if($recsuper === null || $recsuper <=0){
        $validar = 5;
        $mensaje = "Ups! Algo pasa con los recaudos";
      }else{
        $validar = 1;
        $mensaje = "";
      }

      if($recfondo === null || $recfondo <=0){
        $validar = 5;
        $mensaje = "Ups! Algo pasa con los recaudos";
      }else{
        $validar = 1;
        $mensaje = "";
      }
  

      return response()->json([
         "recsuper"=>$recsuper,
         "recfondo"=>$recfondo,
         "rtf"=>$rtf,
         "reteconsumo"=>$reteconsumo,
         "aporteespecial"=>$aporteespecial,
         "impuesto_timbre"=>$impuesto_timbre,
         "timbredecreto175"=>$timbredecreto175,
         "validar"=>$validar,
         "mensaje"=>$mensaje
      ]);
    }

    private function AporteEspecial($actos){

      if (!isset($actos['valor_aporte_especial'])) {
          $mayor = 0;
          $mayor_acum = 0;
          $id_array = 0;
        foreach ($actos as $key => $value) {
          $mayor = $value['valor_aporte_especial'];
          if($mayor > $mayor_acum){
            $mayor_acum = $mayor;
            $id_array = $key;//tomo el id del acto con mayor cuantia
          }
          //$valor = $value['valor_aporte_especial'];

        }
        $act = $actos[$id_array];
        $valor = $act['valor_aporte_especial'];
        return $valor;

      }else{
          return 0;
        }
    }

    private function SuperFondo($actos){
      $tarifa = Tarifa::find(8);//:Tarifa de Recaudo Super y Fondo
      $valor1 = $tarifa['valor1'];

      if(count($actos) > 1){//:Si son Varios Actos se elige el de mayor cuantia
        $cont = 0;
        $cont2 = 0;
        $mayor = 0;
        foreach ($actos as $key => $value) {
          if($value['actos_con_cuantia'] == 'false'){//:valida los actos sin cuantia
            $cont = $cont + 1;
          }
          if($value['recsuper'] == 'false' || $value['recfondo'] == 'false'){//Entra cuando recsuper o recfondo son false
            $cont2 = $cont2 + 1;
          }
          if($value['cuantia'] > $mayor){//:Para obtener la mayor cuantia
            $mayor = $value['cuantia'];
          }
        }//fin foreach

        if(count($actos) == $cont){//:en caso de que s los actos sean sin cuantia
          return $valor1;
        }

        if(count($actos) == $cont2){//:en caso de que s los actos no se les aplique recsuper, recfondo
          $valor = 0;
          return $valor;
        }else{
          if($mayor >= 0){//:Si el acto es con cuantia
            $valor = $this->CalCularRecaudos($mayor);//:Envío la cuantia mayor
            return $valor;
          }
        }
      }else if(count($actos) == 1){//:Si es un solo acto
        if($actos[0]['recsuper'] != 'false' || $actos[0]['recfondo'] != 'false'){//Entra cuando recsuper o recfondo son true
          if($actos[0]['actos_con_cuantia'] == 'false'){//:Si es acto sin cuantia
            return $valor1;
          }else if($actos[0]['actos_con_cuantia'] == 'true'){//:Si es acto con cuantia
            $valor = $this->CalCularRecaudos($actos[0]['cuantia']);
            return $valor;
            }
        }else if($actos[0]['recsuper'] == 'false'){//:Si No se aplica Recaudos
          $valor = 0;
          return $valor;
        }
      }//Fin del if si es un solo acto
    }

    private function CalCularRecaudos($cuantia){
      $tarifa = Tarifa::find(8);//:Tarifa de Recaudo Super y Fondo
      $valor2 = $tarifa['valor2'];
      $valor3 = $tarifa['valor3'];
      $valor4 = $tarifa['valor4'];
      $valor5 = $tarifa['valor5'];
      $valor6 = $tarifa['valor6'];
      $valor7 = $tarifa['valor7'];
      if($cuantia >= 0 && $cuantia <= 100000000){
        return $valor2;//Valor de la base de datos
      }else if($cuantia >= 100000001 && $cuantia <= 300000000){
        return $valor3;//Valor de la base de datos
      }else if($cuantia >= 300000001 && $cuantia <= 500000000){
        return $valor4;//:Valor de la base de datos
      }else if($cuantia >= 500000001 && $cuantia <= 1000000000){
        return $valor5;//Valor de la base de datos
      }else if($cuantia >= 1000000001 && $cuantia <= 1500000000){
        return $valor6;//Valor de la base de datos
      }else if($cuantia > 1500000000){
        return $valor7;//Valor de la base de datos
      }
    }

    private function ReteFuente($actos){
      $tarifa = Tarifa::find(11);//:Tarifa de ReteFuente
      $porcentaje = $tarifa['valor1'] / 100;
      $retencion = 0;
      $valor = 0;
      $valoracum = 0;
      $porcentaje_liq = 0;
      
      foreach ($actos as $key => $value) {
        if($value['retefuente'] == 'true' && $value['id_tipoident'] != 31){//valida si al acto se le aplica rtf
          $id_actoperrad = $value['id_actoperrad'];
          $Actosclienteradica = Actosclienteradica::where('id_actoperrad', $id_actoperrad)->first();
          $porcentaje_liq = $Actosclienteradica->porcentajecli1;
         
          $Otorgante = Otorgante::where('id_actoperrad', $id_actoperrad)
          ->get()
          ->toArray();
      
          foreach ($Otorgante as $key => $val) {
            $Identificacion_cli = $val['identificacion_cli'];

            $Cliente = Cliente::where('identificacion_cli', $Identificacion_cli)->first();

            if($Cliente->id_tipoident != 31){
             $porcentaje_liq = $porcentaje_liq + $val['porcentaje_otor'];
          
            }

          }
            
            $porcentaje_liq = $porcentaje_liq / 100;

            $flag = 0;

            if($value['catastro'] > 0){
              $flag = 1;
            }

            if($flag == 1){
               if($value['cuantia'] >= $value['catastro']){
                  $retencion = (($value['cuantia'] * $porcentaje)) * $porcentaje_liq;
                }else{
                //$retencion = (($value['catastro'] * $porcentaje)) * $porcentaje_liq;
                  $retencion = (($value['cuantia'] * $porcentaje)) * $porcentaje_liq;
              }
            }else{
              $retencion = (($value['cuantia'] * $porcentaje)) * $porcentaje_liq;
            }          

            
            $valor = $retencion;

                    


          # ==================================
          # =           Descuentos           =
          # ==================================

          $Tradicion = date("Y", strtotime($value['tradicion']));
                   
          if($value['descuento_rtf'] == 0){ //no es un lote

            if($Tradicion == 1986){
              $retencion = $retencion * 0.9;
              $valor = $retencion;
            }
            
            if($Tradicion == 1985){
              $retencion = $retencion * 0.8;
              $valor = $retencion;
            }

            if($Tradicion == 1984){
              $retencion = $retencion * 0.7;
              $valor = $retencion;
            }

            if($Tradicion == 1983){
              $retencion = $retencion * 0.6;
              $valor = $retencion;
            }

            if($Tradicion == 1982){
              $retencion = $retencion * 0.5;
              $valor = $retencion;
            }

            if($Tradicion == 1981){
              $retencion = $retencion * 0.4;
              $valor = $retencion;
            }

            if($Tradicion == 1980){
              $retencion = $retencion * 0.3;
              $valor = $retencion;
            }

            if($Tradicion == 1979){
              $retencion = $retencion * 0.2;
              $valor = $retencion;
            }

            if($Tradicion == 1978){
              $retencion = $retencion * 0.1;
              $valor = $retencion;
            }

            for ($i=1900; $i <= 1977 ; $i++) { 
              if($value['tradicion'] == $i){
                $retencion = 0;
                $valor = $retencion;
              }
              
            }

          }
        }else{
          $retencion = 0;
          $valor = $retencion;
        }

       
        $valoracum += $valor;

      }//Fin del Foreach

     
    
      return $valoracum;
    }



private function ImpuestoTimbre($actos){

      $tarifa = Tarifa::find(32);//:Tarifa de impuesto timbre
      $porcentaje1 = $tarifa['valor1'] / 100;//para formula 1
      $porcentaje2 = $tarifa['valor2'] / 100;//para formula 2
      $uvt = $tarifa['uvt'];
      $uvtformula2 = $tarifa['valor3'];//para sumar en formula 2

      $rango1 = $tarifa['valor4'];
      $rango2 = $tarifa['valor5'];
      
      $impuestotimbre = 0;
      $valor = 0;
      $valoracum = 0;


      $mayor = 0;
      $mayor_acum = 0;
      $id_array = 0;
      $flagCat = 0;// flagCat = 1 Catastro;  flagCat = 0 Cuantia

      foreach ($actos as $key => $value) {//Para tomar el acto de mayor cuantia siempre y cuando ambos tengan tiembre

        if($value['impuesto_timbre'] == 'true'){//solo si se le aplica timbre
          if($value['catastro'] > 0){
            $flagCat = 1;
          }
          if($flagCat == 1){
            if($value['cuantia'] >= $value['catastro']){
                $mayor = $value['cuantia'];
                if($mayor > $mayor_acum){
                  $mayor_acum = $mayor;
                  $id_array = $key;//tomo el id del acto con mayor cuantia
                }
            }else{
               $flagCat = 2;
               $mayor = $value['catastro'];
                if($mayor > $mayor_acum){
                  $mayor_acum = $mayor;
                  $id_array = $key;//tomo el id del acto con mayor cuantia
                }
            }

          }
        }
       
      }
     

      $act = $actos[$id_array];
      $flag = 0;
      $nombre_acto = $act['nombre_acto'];
        if($nombre_acto == 'VENTA BIENES INMUEBLES CON EL ESTADO'){
          $flag = 1;
        }

      if($act['impuesto_timbre'] == 'true'){//valida si al acto se le aplica impuesto timbre

       
        if($flagCat == 0 || $flagCat == 1){
          $cuantia_en_uvt = ($act['cuantia']) / $uvt;
        }else if($flagCat == 2){
          $cuantia_en_uvt = ($act['catastro']) / $uvt;
        }        
        
          if($cuantia_en_uvt <= $rango1){
            $valor = 0;
          }else if($cuantia_en_uvt > $rango1 and $cuantia_en_uvt <= $rango2){
            $valor = ($cuantia_en_uvt - $rango1) * $porcentaje1;
            $valor_en_pesos = $valor * $uvt;
            $valor =  $valor_en_pesos;
          }else if($cuantia_en_uvt > $rango2){
            $valor = (($cuantia_en_uvt - $rango2) * $porcentaje2) + $uvtformula2;
            $valor_en_pesos = $valor * $uvt;
            $valor =  $valor_en_pesos;

          }
      }else{
        $valor = 0;
      }
        
     if($flag == 1){//Si es con el estado el timbre se cobra al mitad
      $valor = $valor * 0.5;
     }

      return $valor;

          
}

    private function ImpuestoTimbreC($actos){
      
      foreach ($actos as $key => $value) {
        $id_radica = $value['id_radica'];
        $anio_radica = $value['anio_radica'];
      }

       $Actosclienteradica = Actosclienteradica::
       where('id_radica', $id_radica)
       ->where('anio_radica', $anio_radica)
       ->get();

       $timbreley175 = 0;

       foreach ($Actosclienteradica as $key => $value) {
         $timbreley175 += $value['timbrec_temp'];
       }

       return $timbreley175;
                

    }

    

    private function ReteConsumo($actos){
      $tarifa = Tarifa::find(12);//:Tarifa de Impuesto al Consumo
      $porcentaje = $tarifa['valor1'] / 100;
      $valoracomparar = $tarifa['valor2'];
      $reteconsumo = 0;
        foreach ($actos as $key => $value) {
          if($value['reteconsumo'] == 'true'){//valida si al acto se le aplica reteconsumo
            if($value['cuantia'] >= $valoracomparar){
                $reteconsumo = ($value['cuantia'] * $porcentaje) + $reteconsumo;
            }
          }
        }
        return $reteconsumo;
    }
}

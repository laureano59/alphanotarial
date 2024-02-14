<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liq_derecho;
use App\Detalle_liqderecho;
use App\Notaria;
use App\Derechos_view;
use App\Derechos_cotiza_view;
use App\Radicacion;
use App\Tarifa;
use App\Concepto;



class LiqderechoController extends Controller
{
/**
* Create a new controller instance.
*
* @return void
*/
public function __construct()
{
$this->middleware('auth');
}

/**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index(Request $request)
{
  $request->user()->authorizeRoles(['administrador', 'liquidacion']);
  $anio_trabajo = Notaria::find(1)->anio_trabajo;
  $Conceptos = Concepto::all();
  $Conceptos = $Conceptos->sortBy('id_concep');
  return view('liquidacion.liquidacion', compact('Conceptos'));
}

/***Trae las tarifas de la base de datos y calcula los derechos
según el acto y retorna un array de los actos con su liquidacion***/

public function derechos(Request $request){
  if($request->ajax()){
    $anio_trabajo = Notaria::find(1)->anio_trabajo;
    $id_radica = $request->id_radica;

    if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){

      if($id_radica == 0){
        $der_view = Derechos_cotiza_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
        $derechos = $this->Derechos_Not($der_view);
      }else{
        $der_view = Derechos_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
        $derechos = $this->Derechos_Not($der_view);
      }
        

      /************TODO:Calcular IVA Solo Derechos Notariales*************/
      $porcentaje = (Tarifa::find(9)->valor1)/100;
      $iva = 0;
      foreach ($derechos as $key => $value) {
        if($value['derechos'] > 0){
          if($value['iva'] === true){
            $iva = ($value['derechos'] * $porcentaje) + $iva;
          }
        }
      }

      return response()->json([
       "validar"=> "1",
       "derechos"=>$derechos,
       "iva"=>$iva
     ]);
    }else{
      return response()->json([
       "validar"=> "0",
       "mensaje"=> "La radicación no existe"
     ]);
    }
  }
}

  private function Derechos_Not($derview){
      $dere = $derview;
      $op = 0;
      //print_r($dere);
      foreach ($dere as $key => $values):
        $op = $values['id_tar'];
        if($op == 1){//Tarifa General
          if( $values['cuantia'] ==  $values['valor1']){
            $dere[$key]['derechos']= $values['valor2'];
            $dere[$key]['valor_aporte_especial'] = 0;
            $dere[$key]['impuestotimbre'] = 0;
          }else if($values['cuantia'] <= $values['valor3']){
            $dere[$key]['derechos']= $values['valor4'];
            $dere[$key]['valor_aporte_especial'] = 0;
            $dere[$key]['impuestotimbre'] = 0;
          }else if($values['cuantia'] > $values['valor3']){
            $res = (($values['cuantia'] - $values['valor3']) * $values['valor5']) + $values['valor4'];
            $valor = $this->Redondear($res); //Redondea a dos decimales
            $tarifa = Tarifa::find(29);//Aporte Especial
            $aporte_especial = $tarifa['valor1'];

           /********IMPUESTO APORTE ESPECIAL************/
        
         
            if($valor > $aporte_especial){
                $valor_aporte_especial = round($valor - $aporte_especial);
                $dere[$key]['valor_aporte_especial']=$valor_aporte_especial;
                $valor = $aporte_especial;
            }else{
                $dere[$key]['valor_aporte_especial'] = 0;
              }

               $dere[$key]['derechos']=$valor;

          }
        }else if($op == 2){//Tarifa Especifica
          $dere[$key]['derechos'] = $values['valor1'];
          $dere[$key]['valor_aporte_especial'] = 0;
        }else if($op == 3){//Tarifa Conciliación
          if( $values['cuantia'] <=  $values['valor1']){
            $dere[$key]['derechos']=  $this->Redondear($values['valor2'] * $values['valor3']);
            $dere[$key]['valor_aporte_especial'] = 0;
          }else  if( $values['cuantia'] >  $values['valor1'] && $values['cuantia'] <=  $values['valor4']){
            $dere[$key]['derechos']= $values['valor5'] * $values['valor3'];
            $dere[$key]['valor_aporte_especial'] = 0;
          }else if( $values['cuantia'] >=  $values['valor6'] && $values['cuantia'] <=  $values['valor7']){
            $dere[$key]['derechos']= $values['valor8'] * $values['valor3'];
            $dere[$key]['valor_aporte_especial'] = 0;
          }
        }else if($op == 13){//Tarifa Sucesión
          if($values['cuantia'] == $values['valor1']){
            $dere[$key]['derechos'] = $values['valor2'];
            $dere[$key]['valor_aporte_especial'] = 0;
          }else if($values['cuantia'] <= $values['valor3']){
            $dere[$key]['derechos'] = $values['valor2'];
            $dere[$key]['valor_aporte_especial'] = 0;
          }else if($values['cuantia'] > $values['valor3']){
              $res = (($values['cuantia'] - $values['valor3']) *  $values['valor5']/100) + $values['valor2'];
              $valor = $this->Redondear($res); //Redondea a dos decimales
              $tarifa = Tarifa::find(29);//Aporte Especial
              $aporte_especial = $tarifa['valor1'];
              if($valor > $aporte_especial){
                 $valor_aporte_especial = round($valor - $aporte_especial);
                 $dere[$key]['valor_aporte_especial']=$valor_aporte_especial;
                 $valor = $aporte_especial;
               }else{
                  $dere[$key]['valor_aporte_especial'] = 0;
               }
                  $dere[$key]['derechos'] = $valor;
            }
        }else if($op == 14){//Costo base varios actos
            $dere[$key]['derechos'] = $values['valor1'];
            $dere[$key]['valor_aporte_especial'] = 0;
          }else if($op == 15){//Tarifa Liquidación Conyugal
             if($values['cuantia'] == $values['valor1']){
                $dere[$key]['derechos'] = $values['valor2'];
                $dere[$key]['valor_aporte_especial'] = 0;
             }else if($values['cuantia'] <= $values['valor3']){
                $dere[$key]['derechos'] = $values['valor2'];
                $dere[$key]['valor_aporte_especial'] = 0;
             }else if($values['cuantia'] > $values['valor3']){
                  $res = (($values['cuantia'] - $values['valor3']) *  $values['valor4']) + $values['valor2'];
                  $valor = $this->Redondear($res); //Redondea a dos decimales
                  $tarifa = Tarifa::find(29);//Aporte Especial
                  $aporte_especial = $tarifa['valor1'];
                  if($valor > $aporte_especial){
                      $valor_aporte_especial = round($valor - $aporte_especial);
                      $dere[$key]['valor_aporte_especial']=$valor_aporte_especial;
                      $valor = $aporte_especial;
                    }else{
                        $dere[$key]['valor_aporte_especial'] = 0;
                      }
                      $dere[$key]['derechos'] = $valor;
                }
          }else if($op == 16){//Tarifa Cancelación Vivienda Familiar
              if( $values['cuantia'] ==  $values['valor1']){
                 $dere[$key]['derechos']= $values['valor2'];
                 $dere[$key]['valor_aporte_especial'] = 0;
              } else if($values['cuantia'] <= $values['valor3']){
                  $dere[$key]['derechos'] = $values['valor4'];
                  $dere[$key]['valor_aporte_especial'] = 0;
              }else if($values['cuantia'] > $values['valor3']){
                  $res = (($values['cuantia'] - $values['valor3']) * $values['valor4']) + $values['valor2'];
                  $valor = $this->Redondear($res); //Redondea a dos decimales
                  $tarifa = Tarifa::find(29);//Aporte Especial
                  $aporte_especial = $tarifa['valor1'];
                  if($valor > $aporte_especial){
                    $valor_aporte_especial = round($valor - $aporte_especial);
                    $dere[$key]['valor_aporte_especial']=$valor_aporte_especial;
                    $valor = $aporte_especial;
                  }else{
                      $dere[$key]['valor_aporte_especial'] = 0;
                    }
                    $dere[$key]['derechos'] = $valor;
              }
          }else if($op == 17){//Tarifa General Cancelaciones
              if( $values['cuantia'] ==  $values['valor1']){
                $dere[$key]['derechos']=  $this->Redondear($values['valor2'] / 2);
                $dere[$key]['valor_aporte_especial'] = 0;
              }else  if( $values['cuantia'] <=  $values['valor3']){
                  $dere[$key]['derechos']= $values['valor4'];
                  $dere[$key]['valor_aporte_especial'] = 0;
              }else if( $values['cuantia'] >  $values['valor3']){
                  $res = (($values['cuantia'] - $values['valor4']) * $values['valor5']) + $values['valor6'] / 2;
                  $valor = $this->Redondear($res); //Redondea a dos decimales
                  $tarifa = Tarifa::find(29);//Aporte Especial
                  $aporte_especial = $tarifa['valor1'];
                  if($valor > $aporte_especial){
                    $valor_aporte_especial = round($valor - $aporte_especial);
                    $dere[$key]['valor_aporte_especial']=$valor_aporte_especial;
                    $valor = $aporte_especial;
                  }else{
                      $dere[$key]['valor_aporte_especial'] = 0;
                    }
                    $dere[$key]['derechos'] = $valor;
              }
          }else if($op == 18){//Tarifa Corrección al Reg Civil
              $dere[$key]['derechos']= $values['valor1'];
              $dere[$key]['valor_aporte_especial'] = 0;
          }else if($op == 19 || $op == 20 || $op == 21){//TODO:Tarifa Hipoteca Vis 10%, 40%, 70%
             if( $values['cuantia'] ==  $values['valor1']){
                $dere[$key]['derechos']= $values['valor2'];
                $dere[$key]['valor_aporte_especial'] = 0;
              } else if($values['cuantia'] <= $values['valor3']){
                  $dere[$key]['derechos'] = $values['valor4'] * $values['valor5'];
                  $dere[$key]['valor_aporte_especial'] = 0;
                 }else if($values['cuantia'] > $values['valor3']){
                    $res = (((($values['cuantia'] - $values['valor3']) * $values['valor6'])) * $values['valor5']) + ($values['valor4'] * $values['valor5']);
                    $valor = $this->Redondear($res); //Redondea a dos decimales
                    $dere[$key]['derechos'] = $valor;
                    $dere[$key]['valor_aporte_especial'] = 0;
                  }
          }else if($op == 22){//Tarifa Matrimonio fuera del despacho
              $dere[$key]['derechos']= $values['valor1'];
              $dere[$key]['valor_aporte_especial'] = 0;
          }else if($op == 23){//Tarifa Venta Vivienda Vipa
              $dere[$key]['derechos']= $values['valor1'];
              $dere[$key]['valor_aporte_especial'] = 0;
          }else if($op == 24){//Tarifa Venta Vis 50%
              if( $values['cuantia'] ==  $values['valor1']){
                 $dere[$key]['derechos']= $values['valor2'];
                 $dere[$key]['valor_aporte_especial'] = 0;
              } else if($values['cuantia'] <= $values['valor3']){
                  $dere[$key]['derechos'] = $values['valor4'] / 2;
                  $dere[$key]['valor_aporte_especial'] = 0;
                }else if($values['cuantia'] > $values['valor3']){
                    $res = ((((($values['cuantia'] - $values['valor3']) * $values['valor5'])) + $values['valor4']) / 2);
                    $valor = $this->Redondear($res); //Redondea a dos decimales
                    $dere[$key]['derechos'] = $valor;
                    $dere[$key]['valor_aporte_especial'] = 0;
                  }
          }else if($op == 25){//Tarifa Venta Vis con el Estado
              if($values['cuantia'] == $values['valor1']){
                $dere[$key]['derechos'] = $values['valor2'] / 2;
                $dere[$key]['valor_aporte_especial'] = 0;
              }else if($values['cuantia'] <= $values['valor3']){
                  $dere[$key]['derechos'] = $values['valor4'] / 2;
                  $dere[$key]['valor_aporte_especial'] = 0;
                }else if($values['cuantia'] > $values['valor3']){
                    $res = (($values['cuantia'] - $values['valor3']) * $values['valor5']) + $values['valor4'] / 2;
                    $valor = $this->Redondear($res); //Redondea a dos decimales
                    $tarifa = Tarifa::find(29);//Aporte Especial
                    $aporte_especial = $tarifa['valor1'];
                    if($valor > $aporte_especial){
                      $valor_aporte_especial = round($valor - $aporte_especial);
                      $dere[$key]['valor_aporte_especial']=$valor_aporte_especial;
                      $valor = $aporte_especial;
                    }else{
                       $dere[$key]['valor_aporte_especial'] = 0;
                      }
                      $dere[$key]['derechos'] = $valor;
                  }
          }else if($op == 7){//Tarifa Venta Vivienda Vipa
             $dere[$key]['derechos']= $values['valor1'];
             $dere[$key]['valor_aporte_especial'] = 0;
            }
      endforeach;
      return $dere;
  }

  private function Redondear($valor) {
    $numredondeado = round($valor * 100) / 100;
    return $numredondeado;
  }

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
  public function create()
  {
      //
  }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
  if($request->ajax()){
    $liq_derechos = new Liq_derecho();
    $anio_trabajo = Notaria::find(1)->anio_trabajo;
    $id_radica = $request->input('id_radica');
    if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
      $der_view = Derechos_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
      $derechos = $this->Derechos_Not($der_view);
      $liq_derechos->id_radica = $id_radica;
      $liq_derechos->anio_radica = $anio_trabajo;


      if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
        //No hace nada si ya exixte
      }else{
        $liq_derechos->save();
        $id_liqd = $liq_derechos->id_liqd;

        /************Calcular Derechos e IVA Otorgante y Compareciente*************/
        $porcentaje = (Tarifa::find(9)->valor1)/100;
        $derechos_otor = 0;
        $derechos_compa = 0;
        $iva_derechos_otor = 0;
        $iva_derechos_compa = 0;
        foreach ($derechos as $key => $value) {
          if($value['retefuente'] === true){
            $derechos_otor = $value['derechos'] / 2;
            $derechos_compa = $value['derechos'] / 2;
            if($value['derechos'] > 0){
              if($value['iva'] === true){
                $iva_derechos_otor = ($derechos_otor * $porcentaje);
                $iva_derechos_compa = ($derechos_compa * $porcentaje);
              }
            }
          }else if($value['retefuente'] === false){
            $derechos_otor = 0;
            $derechos_compa = $value['derechos'];
            if($value['derechos'] > 0){
              if($value['iva'] === true){
                $iva_derechos_otor = ($derechos_otor * $porcentaje);
                $iva_derechos_compa = ($derechos_compa * $porcentaje);
              }
            }
          }
     
          $detalleliqderechos = new Detalle_liqderecho();
          $detalleliqderechos->id_liqd = $id_liqd;
          $detalleliqderechos->nombre_acto = $value['nombre_acto'];
          $detalleliqderechos->derechos = $value['derechos'];
          $detalleliqderechos->cuantia = $value['cuantia'];
          $detalleliqderechos->derechos_otorgante =  $derechos_otor;
          $detalleliqderechos->derechos_compareciente = $derechos_compa;
          $detalleliqderechos->iva_derechos_otor = $iva_derechos_otor;
          $detalleliqderechos->iva_derechos_compa = $iva_derechos_compa;
          $detalleliqderechos->save();
        }

        return response()->json([
         "validarliqd"=> "1",
         "mensaje"=> "Bien Hecho, Liquidación Lista para Factura"
       ]);
      }

    }else{
      return response()->json([
       "validar"=> "0",
       "mensaje"=> "La radicación no existe"
     ]);
    }
  }
}

public function Cargar_Derechos(Request $request){
  if($request->ajax()){

    $anio_trabajo = Notaria::find(1)->anio_trabajo;
    $id_radica = $request->input('id_radica');
      $request->session()->put('key', $id_radica); //Inicia Variable de Session con la radicacion
      if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
        $liq_dere = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
        foreach ($liq_dere as $key => $value) {
          $id_liqd = $value['id_liqd'];
        }
        $derechos = Detalle_liqderecho::where('id_liqd', $id_liqd)->get()->toArray();
        return response()->json([
          "validarliqd"=> "1",
          "mensaje"=> "Esta radicación ya está liquidada",
          "derechos"=>$derechos
        ]);

      }else{
        return response()->json([
         "validarliqd"=> "0"
       ]);
      }
    }
  }
/**
 * Display the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function show($id)
{
    //
}

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function edit($id)
{
    //
}

/**
 * Update the specified resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function update(Request $request, $id)
{
    //
}

/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
    //
}
}
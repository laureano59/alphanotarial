<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liq_concepto;
use App\Notaria;
use App\Radicacion;
use App\Concepto;

class LiqconceptosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $liq_conceptos = new Liq_concepto();
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $id_radica = $request->input('id_radica');
        if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
          $liq_conceptos->id_radica = $id_radica;
          $liq_conceptos->anio_radica = $anio_trabajo;

          if (Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            //TODO:No hace nada si ya exixte
          }else{

            $Conceptos = Concepto::all();
            $Conceptos = $Conceptos->sortBy('id_concep');

            foreach ($Conceptos as $clave => $valor) {
              $atributo = 'hojas'.$valor['atributo'];
              $id_concep = 'total'.$valor['id_concep'];
              $total = 'total'.$valor['atributo'];
              $liq_conceptos->$atributo = $request->input($atributo);
              $liq_conceptos->$total = $request->input($id_concep);
            }
            
            $liq_conceptos->totalconceptos = $request->input('totalconceptos');
            $liq_conceptos->id_radica = $id_radica;
            $liq_conceptos->anio_radica = $anio_trabajo;
            $liq_conceptos->save();
            return response()->json([
               "validarliqc"=> "1",
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

    //TODO: Cargar Conceptos
    public function Cargar_Conceptos(Request $request){
        if($request->ajax()){

          $anio_trabajo = Notaria::find(1)->anio_trabajo;
          $id_radica = $request->input('id_radica');
          if (Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            $liq_conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
            return response()->json([
              "validarliqc"=> "1",
              "conceptos"=>$liq_conceptos
              ]);
          }else{
            return response()->json([
               "validarliqc"=> "0"
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

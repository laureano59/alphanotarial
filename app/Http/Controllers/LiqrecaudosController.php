<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Liq_recaudo;
use App\Notaria;
use App\Radicacion;


class LiqrecaudosController extends Controller
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
        $liq_recaudos = new Liq_recaudo();
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $id_radica = $request->input('id_radica');
        if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
          $liq_recaudos->id_radica = $id_radica;
          $liq_recaudos->anio_radica = $anio_trabajo;

          if (Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            //No hace nada si ya exixte
          }else{

            $liq_recaudos->id_radica = $id_radica;
            $liq_recaudos->anio_radica = $anio_trabajo;
            $liq_recaudos->recsuper = $request->input('totrecsuper');
            $liq_recaudos->recfondo = $request->input('totrecfondo');
            $liq_recaudos->iva = $request->input('totiva');
            $liq_recaudos->retefuente = $request->input('totrtf');
            $liq_recaudos->reteconsumo = $request->input('totreteconsumo');
            $liq_recaudos->aporteespecial = $request->input('totaporteespecial');
            $liq_recaudos->impuestotimbre = $request->input('total_impuesto_timbre');
            $liq_recaudos->totalrecaudos = $request->input('totalrecaudos');
            $liq_recaudos->grantotalliq = $request->input('grantotalliq');
            $liq_recaudos->save();

            return response()->json([
               "validarliqr"=> "1",
               "mensaje"=> "Bien Hecho!, Liquidación Lista para Facturar"
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

    //TODO: Cargar Recaudos
    public function Cargar_Recaudos(Request $request){
        if($request->ajax()){

          $anio_trabajo = Notaria::find(1)->anio_trabajo;
          $id_radica = $request->input('id_radica');
          if (Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            $liq_recaudos = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
           
            return response()->json([
              "validarliqr"=> "1",
              "recaudos"=>$liq_recaudos
              ]);
          }else{
            return response()->json([
               "validarliqr"=> "0"
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

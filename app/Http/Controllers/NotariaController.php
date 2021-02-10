<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;

class NotariaController extends Controller
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
        //
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
        $notaria = Notaria::find($id);
        if($request->opcion == 1){
          $fecha_fact = date("Y-m-d", strtotime($request->fecha_fact)); //Convierte Fecha a YYYY-mm-dd
          $fecha_esc = date("Y-m-d", strtotime($request->fecha_esc));

          $notaria->fecha_fact = $fecha_fact;
          $notaria->fecha_esc = $fecha_esc;
          $notaria->fecha_fact_automatica = $request->fecha_fact_automatica;
          $notaria->fecha_esc_automatica = $request->fecha_esc_automatica;
          $notaria->save();

          return response()->json([
             "validar"=> "1",
             "mensaje"=> "Muy bien!. Los Cambios Fueron Almacenados"
           ]);

      }else if($request->opcion == 2){
      
        $fecha_acta = date("Y-m-d", strtotime($request->fecha_acta)); //Convierte Fecha a YYYY-mm-dd
        $fecha_egreso = date("Y-m-d", strtotime($request->fecha_egreso));

        $notaria->fecha_acta = $fecha_acta;
        $notaria->fecha_egreso = $fecha_egreso;
        $notaria->fecha_acta_automatica = $request->fecha_acta_automatica;
        $notaria->fecha_egreso_automatica = $request->fecha_egreso_automatica;
        $notaria->save();

        return response()->json([
           "validar"=> "1",
           "mensaje"=> "Muy bien!. Los Cambios Fueron Almacenados"
         ]);

      }

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

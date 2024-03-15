<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gastos_notaria;

class Gastos_notariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['facturacion','administrador']);
        return view('gastos.gastos_notaria');
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
        
        $fecha_gasto = date("Y/m/d");
        $Gasto = new Gastos_notaria();

        $Gasto->concepto_gas = $request->concepto;
        $Gasto->valor_gas = $request->valor_gasto;
        $Gasto->autorizado_por = $request->autoriza;
        $Gasto->fecha_gas = $fecha_gasto;
        $Gasto->save();
        $nuevo_id = $Gasto->id_gas;

        $request->session()->put('numrecibo', $nuevo_id);

        $nuevoregistro = Gastos_notaria::where('id_gas', $nuevo_id)->get();
       
        return response()->json([
           "gasto"=>$nuevoregistro,
           "id_gas"=>$nuevo_id
         ]);
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
        
        $Gastos = Gastos_notaria::find($id);
        $Gastos->concepto_gas = $request->concepto;
        $Gastos->valor_gas = $request->valor_gasto;
        $Gastos->autorizado_por = $request->autoriza;
        $Gastos->save();

        $registros = Gastos_notaria::where('id_gas', $id)->get();
        return response()->json([
           "gasto"=>$registros
         ]);
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

     public function validar_existencia(Request $request)
    {
         $id_gas = $request->id_gas;
         
         if (Gastos_notaria::where('id_gas', $id_gas)->exists()){
            $request->session()->put('numrecibo', $id_gas);

            $gasto = Gastos_notaria::where('id_gas', $id_gas)->get()->toArray();
                return response()->json([
                "validar"=> 1,
                "gasto"=> $gasto
                ]);

         }else{

             return response()->json([
                "validar"=> 0,
                "mensaje"=> "No existe este número de recibo"
                ]);

         }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Registro;
use App\Detalleregistro;
use App\Conceptos_cajarapida;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Conceptos = Conceptos_cajarapida::whereIn('id_concep', [2, 19])
                ->orderBy('id_concep')
                ->get();
        return view('registro.registro', compact('Conceptos')); 
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

        $detalle = $request->detalle;

        if (empty($detalle)){
            return response()->json([
                "validar"=>999
            ]);
        }

        $registro = new Registro();       
        $registro->id = Auth()->user()->id;
        $registro->save();

        $id_registro = $registro->id_registro;

         foreach ($detalle as $key => $det) {
            $detalle_registro = new Detalleregistro();
            $detalle_registro->id_registro = $id_registro;
            $detalle_registro->cantidad = $det['cantidad'];
            $detalle_registro->id_concep = $det['id_concep'];
            $detalle_registro->serial = $det['serial'];          
            $detalle_registro->save(); 
        }


        return response()->json([
            "validar"=>1,
            "id_registro"=> $id_registro
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

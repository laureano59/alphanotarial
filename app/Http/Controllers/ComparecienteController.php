<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compareciente;
use App\Actosclienteradica;
use App\Comparecienteview;

class ComparecienteController extends Controller
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
      $compareciente = new Compareciente();
      $id = $request->input('id_actoperrad');
      $id_cal1 = $request->input('id_cal1');
      $porcentajeprincipal = Actosclienteradica::find($id)->porcentajecli2;
      $compareciente->identificacion_cli2 = $request->input('identificacion_cli');
      $compareciente->id_actoperrad = $request->input('id_actoperrad');
      $compareciente->id_cal1 = $id_cal1;
      $compareciente->porcentaje_comp = $request->input('porcentaje');

      $raw2 = \DB::raw("SUM(porcentaje_comp) as total2");
      $porcentajecompareciente = Compareciente::where('id_actoperrad', $id)->select($raw2)->get();
      foreach ($porcentajecompareciente as $porc2) {
        $total = $porc2->total2;
      }

      $porcentaje2 = $compareciente->porcentaje_comp + $porcentajeprincipal + $total;

      if($porcentaje2 > 100){
        $msg = "Los porcentajes exceden el 100 %";
        return response()->json([
          "validar"=> 0,
           "msg"=>$msg
         ]);
      }else if($porcentaje2 <= 100){
        $compareciente->save();
        $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        id_comp, identificacion_cli2, porcentaje_comp");
        $comparecientes = Comparecienteview::where('id_actoperrad', $id)->select($raw)->get();
        return response()->json([
          "validar"=> 1,
          "comparecientes"=> $comparecientes
         ]);
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
      $compareciente = Compareciente::find($id);
      $id_actoperrad = Comparecienteview::find($id)->id_actoperrad;
      $compareciente->delete();
      $raw1 = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
      id_comp, identificacion_cli2, porcentaje_comp");
      $comparecientes = Comparecienteview::where('id_actoperrad', $id_actoperrad)->select($raw1)->get();
      return response()->json([
         "comparecientes"=>$comparecientes
       ]);
    }
}

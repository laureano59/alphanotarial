<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Otorgante;
use App\Actosclienteradica;
use App\Otorganteview;

class OtorganteController extends Controller
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
      $otorgante = new Otorgante();
      $id = $request->input('id_actoperrad');
      $id_cal1 = $request->input('id_cal1');
      $otorgante->identificacion_cli = $request->input('identificacion_cli');
      $otorgante->id_actoperrad = $request->input('id_actoperrad');
      $otorgante->porcentaje_otor = $request->input('porcentaje');
      $otorgante->id_cal1 = $id_cal1;
      $otorgante->cuantia = $request->session()->get('cuantia_otor');

      if($request->session()->get('tradi') === 'null'){
        $tradicion = NULL;
      }else{
        $tradicion = $request->session()->get('tradi');
        }
      
      $otorgante->tradicion = $tradicion;
      $otorgante->id_radica = $id_radica = $request->session()->get('key');
      
      $porcentajeprincipal = Actosclienteradica::find($id)->porcentajecli1;

      $raw1 = \DB::raw("SUM(porcentaje_otor) as total1");
      $porcentajeotorgante = Otorgante::where('id_actoperrad', $id)->select($raw1)->get();
      foreach ($porcentajeotorgante as $porc1) {
        $total = $porc1->total1;
      }

      $porcentaje1 = $otorgante->porcentaje_otor + $porcentajeprincipal + $total;

      if($porcentaje1 > 100){
        $msg = "Los porcentajes exceden el 100 %";
        return response()->json([
          "validar"=> 0,
           "msg"=>$msg
         ]);
      }else if($porcentaje1 <= 100){
        $otorgante->save();
        $raw1 = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
        id_otor, identificacion_cli, porcentaje_otor");
        $otorgantes = Otorganteview::where('id_actoperrad', $id)->select($raw1)->get();
        return response()->json([
          "validar"=> 1,
          "otorgantes"=> $otorgantes
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
      $otorgante = Otorgante::find($id);
      $id_actoperrad = Otorganteview::find($id)->id_actoperrad;
      $otorgante->delete();
      $raw1 = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname,
      id_otor, identificacion_cli, porcentaje_otor");
      $otorgantes = Otorganteview::where('id_actoperrad', $id_actoperrad)->select($raw1)->get();
      return response()->json([
         "otorgantes"=>$otorgantes
       ]);
    }
}

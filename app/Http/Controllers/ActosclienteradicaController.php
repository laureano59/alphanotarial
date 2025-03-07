<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Radicacion;
use App\Actosclienteradica;
use App\Actoscuantia;
use App\Cliente;
use App\Otorgante;
use App\Compareciente;
use App\Acto;
use Carbon\Carbon;

class ActosclienteradicaController extends Controller
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
    * TODO: Lista actos, cuantia y tradición de los actos radicados según argumentos*
    */

    public function listing(Request $request){
        if($request->ajax()){
          $anio_trabajo = $request->periodo;
          if($anio_trabajo == ''){
            $anio_trabajo = Notaria::find(1)->anio_trabajo;
          }
          
          $id_radica = $request->input('id_radica');
          $request->session()->put('key', $id_radica); //TODO:Inicia Variable de Session con la radicacion

          if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
            $raw = \DB::raw("id_proto");
            $radicacion = Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw)->get();
            foreach ($radicacion as $rad) {
              $protocolista = $rad->id_proto;
            }

            return response()->json([
               "validar"=> "1",
               "actos"=>$actos,
               "protocolista"=>$protocolista
             ]);
          }else{
            return response()->json([
               "validar"=> "0",
               "mensaje"=> "La radicación no existe"
             ]);
          }
        }
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
          $Actosclienteradica = new Actosclienteradica();
          $Actosclienteradica->anio_radica = Notaria::find(1)->anio_trabajo;
          $Actosclienteradica->id_radica = $request->input('id_radica');
          $Actosclienteradica->id_acto = $request->input('id_acto');
          $revisar = $request->input('cuantia');
          if($revisar =! 0){
            $cuantia = $request->input('cuantia');
            //$cuantia = str_replace(".00", " ", $cuantia);//reemplaza el punto y los ultimos dos ceros por espacio
            $cuantia = str_replace(",", " ", $cuantia);//Reemplaza las comas por espacios
            $cuantia = str_replace(" ", "", $cuantia);//elimina los espacios
            $Actosclienteradica->cuantia = $cuantia;
          }else if($revisar == 0){
            $Actosclienteradica->cuantia = 0;
          }

          /*VALIDO SI LLEVA TRADICION*/

          $id_acto = $request->input('id_acto');
          $actos = Acto::where('id_acto', $id_acto)->get();
          
          foreach ($actos as $value) {
            $codigo_dian = $value['cod_dian'];
            //$id_acto = $value['id_acto'];
          }

          $codigo_dian = str_replace(" ", "", $codigo_dian);//elimina los espacios

          if($codigo_dian != '0'){
            $tradicion = Carbon::parse($request->input('tradicion'))->format('Y-m-d h:i:s');
          }else{
            $tradicion = NULL;
          }
            

          $Actosclienteradica->tradicion                  = $tradicion;
          $Actosclienteradica->timbrec_temp               = $request->timbrec;
          $Actosclienteradica->catastro                   = $request->catastro;
          $Actosclienteradica->prefijo_matricula_inmob    = $request->matriprefijo;
          $Actosclienteradica->matricula_inmob            = $request->matricula;

        
          if (Radicacion::where('id_radica', $Actosclienteradica->id_radica)->where('anio_radica', $Actosclienteradica->anio_radica)->exists()){
            $Actosclienteradica->save();

            $actos = Actoscuantia::where('id_radica', $Actosclienteradica->id_radica)->where('anio_radica', $Actosclienteradica->anio_radica)->orderBy('id_actoperrad','asc')->get()->toArray();
            //$actos = Actoscuantia::all();

            return response()->json([
               //"mensaje"=> $request->all()
               "validar"=> "1",
               "mensaje"=> "Guardado",
               "actos"=>$actos
             ]);

          }else{
            return response()->json([
               //"mensaje"=> $request->all()
               "validar"=> "0",
               "mensaje"=> "La radicación no existe"
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
        $actoscuantia = Actoscuantia::find($id);
       
        return response()->json(
          $actoscuantia->toArray()
        );
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

      if($request->actualizar == 1){
        $actosclienteradica = Actosclienteradica::find($id);
        $actosclienteradica->id_acto = $request->id_acto;
        $cuantia = $request->cuantia;
        $catastro = $request->catastro;
        $matripref = $request->matripref;
        $matricu = $request->matricu;

       
        if($request->tradicion === 'null'){
           $tradicion = NULL;//date("Y-m-d H:i:s");
           $actosclienteradica->tradicion = $tradicion;
        }else{
          $tradicion = Carbon::parse($request->tradicion)->format('Y-m-d h:i:s');
          $actosclienteradica->tradicion = $tradicion;
        }

        $cuantia = str_replace(",", " ", $cuantia);//Reemplaza las comas por espacios
        $cuantia = str_replace(" ", "", $cuantia);//elimina los espacios
        $actosclienteradica->cuantia = $cuantia;
        $actosclienteradica->catastro = $catastro;
        $actosclienteradica->prefijo_matricula_inmob = $matripref;
        $actosclienteradica->matricula_inmob = $matricu;

        $actosclienteradica->save();
        $id_radica = $request->id_radica;
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->get()->toArray();

        $id_otorgante =  Otorgante::where('id_actoperrad', $id)->get()->toArray();
        foreach ($id_otorgante as $key => $id_o) {
          $id_otor = $id_o['id_otor'];
        }

        $Otorgante = Otorgante::find($id_otor);
        $Otorgante->cuantia = $cuantia;
        $Otorgante->tradicion = $tradicion;
        $Otorgante->catastro = $catastro;
        $Otorgante->save();

       
        return response()->json([
           "actos"=>$actos
         ]);
      }else if($request->actualizar == 2){
        $actosclienteradica = Actosclienteradica::find($id);
        $actosclienteradica->id_cal1 = $request->id_cal1;
        $actosclienteradica->id_cal2 = $request->id_cal2;
        $actosclienteradica->identificacion_cli = $request->identificacion_cli;
        $actosclienteradica->identificacion_cli2 = $request->identificacion_cli2;

        $raw1 = \DB::raw("SUM(porcentaje_otor) as total1");
        $porcentajeotorgante = Otorgante::where('id_actoperrad', $id)->select($raw1)->get();
        foreach ($porcentajeotorgante as $porc1) {
          $porc1 = $porc1->total1;
        }

        $raw1 = \DB::raw("SUM(porcentaje_comp) as total2");
        $porcentajecompareciente = Compareciente::where('id_actoperrad', $id)->select($raw1)->get();
        foreach ($porcentajecompareciente as $porc2) {
          $porc2 = $porc2->total2;
        }
        $porcentaje1 = $request->porcentajecli1 + $porc1;
        $porcentaje2 = $request->porcentajecli2 + $porc2;

        if($porcentaje1 > 100 || $porcentaje2 > 100){
          $msg = "Los porcentajes exceden el 100 %";
          return response()->json([
            "validar"=> 0,
             "msg"=>$msg
           ]);
        }else if($porcentaje1 <= 100 && $porcentaje2 <= 100){
          $actosclienteradica->porcentajecli1 = $request->porcentajecli1;
          $actosclienteradica->porcentajecli2 = $request->porcentajecli2;
          $actosclienteradica->save();
          return response()->json([
            "validar"=> 1,
           ]);
        }
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
      $actosclienteradica = Actosclienteradica::find($id);
      $id_radica = Actoscuantia::find($id)->id_radica;
      $actosclienteradica->delete();

      $anio_trabajo = Notaria::find(1)->anio_trabajo;
      $actos = Actoscuantia::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->orderBy('id_actoperrad','asc')->get()->toArray();

      return response()->json([
         "actos"=>$actos
       ]);

    }
}

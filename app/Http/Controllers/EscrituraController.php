<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Escritura;

class EscrituraController extends Controller
{
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
        $request->user()->authorizeRoles(['radicacion','administrador']);

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
    public function store(Request $request){
      $id_radica = $request->input('id_radica');
      $anio_radica = Notaria::find(1)->anio_trabajo;
      $fecha_manual = Notaria::find(1)->fecha_esc;
      $fecha_automatica = Notaria::find(1)->fecha_esc_automatica;
      if($fecha_automatica == true){
        $fecha_escritura = date("Y/m/d");
      }else if($fecha_automatica == false){
        $fecha_escritura = $fecha_manual;
      }
      if(Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->exists()){
        $raw = \DB::raw("num_esc");
        $escritura = Escritura::where('id_radica', $id_radica)->where('anio_esc', $anio_radica)->select($raw)->get();
        foreach ($escritura as $esc) {
          $num_esc = $esc->num_esc;
        }
        return response()->json([
           "validar"=>0,
           "num_esc"=>$num_esc,
           "mensaje"=>"La radicación ya tiene número de escritura"
         ]);
      }else{

        /*Autonumerico*/
        /*$raw = \DB::raw("MAX(num_esc) as num_esc");
        $consecutivo = Escritura::where('anio_esc', $anio_radica)->select($raw)->get();
        foreach ($consecutivo as $esc) {
          $nuevo_num_esc = ($esc->num_esc) + 1;
        }*/

        /*Autonumerico*/
         
        $consecutivo = Escritura::where('anio_esc', $anio_radica)->max('num_esc');
        $nuevo_num_esc = $consecutivo + 1;

        $escritura = new Escritura();
        $escritura->num_esc = $nuevo_num_esc;
        $escritura->anio_esc = $anio_radica;
        $escritura->id_radica = $id_radica;
        $escritura->anio_radica = $anio_radica;
        $escritura->fecha_esc = $fecha_escritura;
        $escritura->save();
        $num_esc = $escritura->num_esc;
        $fecha_esc = $escritura->fecha_esc;

        //$request->session()->put('num_esc', $num_esc);

        $request->session()->put('fecha_esc', $fecha_esc);//TODO:Session fecha para escritura

        return response()->json([
          "validar"=>1,
          "num_esc"=>$num_esc
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

    }
}

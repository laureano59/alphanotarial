<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RadicacionRequest;
use App\Radicacion;
use App\Liq_derecho;
use App\Detalle_liqderecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Factura;
use App\Notaria;
use App\Protocolista;
use App\Acto;
use App\Tipoidentificacion;
use App\Calidad1;
use App\Calidad2;
use App\Departamento;

class RadicacionController extends Controller
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
      // /*******TODO:Roles de usuario*********/
      // $request->user()->authorizeRoles(['radicacion','administrador']);
      //
      // $AnioTrabajo = Notaria::find(1);
      // $Protocolistas = Protocolista::all();
      // $Actos = Acto::all();
      // return view('radicacion.radicacion', compact('AnioTrabajo', 'Protocolistas', 'Actos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      $request->user()->authorizeRoles(['radicacion','administrador']);
       $AnioTrabajo = Notaria::find(1);
       $Protocolistas = Protocolista::all();
       $Actos = Acto::all();
       $calidad1 = Calidad1::all();
       $calidad1 = $calidad1->sortBy('nombre_cal1');
       $calidad2 = Calidad2::all();
       $calidad2 = $calidad2->sortBy('nombre_cal2');
       $Departamentos = Departamento::all();
       $Departamentos = $Departamentos->sortBy('nombre_depa'); //TODO:Ordenar por nombre
       $TipoIdentificaciones = Tipoidentificacion::all();
       return view('radicacion.create', compact('AnioTrabajo', 'Protocolistas', 'Actos', 'TipoIdentificaciones', 'calidad1', 'calidad2', 'Departamentos'));
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
        $radicacion = new Radicacion();
        $radicacion->anio_radica = $request->input('anio_radica');
        $radicacion->id_proto = $request->input('id_proto');
        $radicacion->id = Auth()->user()->id;
        $radicacion->save();
        return response()->json([
           //"mensaje"=> $request->all()
           "idradica"=> $radicacion->id_radica
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

      $anio_radica = $request->anio_radica;
      $id_proto = $request->id_proto;

      $radicacion = Radicacion::where("anio_radica","=",$anio_radica)->find($id);

      $radicacion->id_proto = $request->input('id_proto');
      $radicacion->save();
      return response()->json([
           "validar"=> 1,
           "mensaje"=> "Muy bien!. Se actualizó el protocolista de la radicación"
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

    public function Liberar_Radicacion(Request $request){
      $anio_trabajo = Notaria::find(1)->anio_trabajo;
      $id_radica = $request->input('id_radica');

      if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
        if (Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->where('nota_credito', false)->exists()){
          return response()->json([
             "validar"=> "1",
             "mensaje"=> "La radicación ya está Facturada, No es posible liberarla"
           ]);

        }else{
          //Eliminar liquidación
          $raw = \DB::raw("id_liqd");
          $liqd = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw)->get();
          foreach ($liqd as $lq) {
            $id_liqd = $lq->id_liqd;
          }
          $detalle_liqderecho = Detalle_liqderecho::where("id_liqd","=",$id_liqd);
          $detalle_liqderecho->delete();

          $liq_concepto = Liq_concepto::where("id_radica", "=",$id_radica)->where("anio_radica","=",$anio_trabajo);
          $liq_concepto->delete();

          $liq_recaudo = Liq_recaudo::where("id_radica", "=",$id_radica)->where("anio_radica","=",$anio_trabajo);
          $liq_recaudo->delete();

          $liq_derecho = Liq_derecho::where("id_radica", "=",$id_radica)->where("anio_radica","=",$anio_trabajo);
          $liq_derecho->delete();

          return response()->json([
             "validar"=> "7",
             "mensaje"=> "Muy bien : La radicación se ha liberado Exitosamente"
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

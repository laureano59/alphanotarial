<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Egreso_acta_deposito;
use App\Concepto_egreso;
use App\Actas_deposito;
use App\Actas_deposito_view;
use App\Factura;

class EgresoactasdepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $Concepto_egreso = Concepto_egreso::all();
      // $Concepto_egreso = $Concepto_egreso->sortBy('concepto'); //TODO:Ordenar por concepto
      $Concepto_egreso = Concepto_egreso::where("id_con",">=",1)->get();
      $Concepto_egreso = $Concepto_egreso->sortBy('concepto');
         return view('actas_deposito.egresos', compact('Concepto_egreso'));
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
      $anio_trabajo = $request->anio_fiscal;//Notaria::find(1)->anio_trabajo;
      $fecha_manual = Notaria::find(1)->fecha_egreso;
      $fecha_automatica = Notaria::find(1)->fecha_egreso_automatica;
      $nuevosaldo = $request->nuevosaldo;
      if($fecha_automatica == true){
        $fecha_egreso = date("Y/m/d");
      }else if($fecha_automatica == false){
        $fecha_egreso = $fecha_manual;
      }
      $opcion = $request->input('opcion');
      if($opcion == 1){//cuando se hace la factura
        $id_radica = $request->input('id_radica');
        $id_acta = $request->input('id_acta');
        $descuento = $request->input('descuento');
        $concepto_egreso = $request->input('concepto_egreso');
       
        $Egreso = new Egreso_acta_deposito();
        $Egreso->fecha_egreso = $fecha_egreso;
        $Egreso->id_con = $concepto_egreso;
        $Egreso->id_radica = $id_radica;
        $Egreso->anio_radica = $anio_trabajo;
        $Egreso->id_act = $id_acta;
        $Egreso->egreso_egr = $descuento;
        $Egreso->saldo = $nuevosaldo;
        $Egreso->usuario = auth()->user()->name;
        $Egreso->save();

        return response()->json([
           "validar"=> "1"
         ]);

      }else if($opcion == 2){

        $id_acta = $request->input('id_acta');
        $id_radica = $request->id_radica;
        $prefijo = $request->prefijo;
        $id_fact = $request->id_fact;
        $descuento = $request->input('descuento');
        $concepto_egreso = $request->input('concepto_egreso');
        $observaciones = $request->observaciones;
        $id_con = $request->id_con;

        if($id_con == 1){//si el concepto es escritura
            if($prefijo == '' ||   $id_fact  == ''){
                return response()->json([
                    "validar"=> 888,
                    "mensaje"=> "!Ups. Para el caso de Escrituras el número de factura es obligatorio."
                ]);
            }else{
                /******validar que la factura exista y no esté anulada****/
                if (Factura::where('prefijo', $prefijo)->where('id_fact', $id_fact)->where('nota_credito', false)->exists()){
                    //No hace nada y sigue
                }else{
                    return response()->json([
                        "validar"=>555,
                        "mensaje"=>"!UPS. Es posible que la factura no exista o que tenga nota crédito"
                    ]);

                }

            }
        }

        $Egreso = new Egreso_acta_deposito();
        $Egreso->fecha_egreso = $fecha_egreso;
        $Egreso->id_con = $concepto_egreso;
        $Egreso->id_radica = $id_radica;
        $Egreso->prefijo = $prefijo;
        $Egreso->id_fact = $id_fact;
        $Egreso->anio_radica = $anio_trabajo;
        $Egreso->id_act = $id_acta;
        $Egreso->egreso_egr = $descuento;
        $Egreso->observaciones_egr = $observaciones;
        $Egreso->saldo = $nuevosaldo;
        $Egreso->usuario = auth()->user()->name;
        $Egreso->save();
        $id_egr = $Egreso->id_egr;
        $request->session()->put('id_egr', $id_egr);
        return response()->json([
           "validar"=> 1,
           "mensaje"=> "!Muy bien. Cruce Exitoso"
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
        //
    }
}

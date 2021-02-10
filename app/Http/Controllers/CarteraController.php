<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Factura;
use App\Cartera_fact;
use App\informe_cartera_view;

class CarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cartera.cartera');
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

      $prefijo_fact = Notaria::find(1)->prefijo_fact;
      $id_fact = $request->input('id_fact');
      $abono = $request->input('abono');

      $cartera = new Cartera_fact();
      $cartera->id_fact = $id_fact;
      $cartera->prefijo = $prefijo_fact;
      $cartera->abono_car = $abono;
      $cartera->usuario = auth()->user()->name;
      $cartera->save();

      return response()->json([
          "validar"=> "1"
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
        $factura = Factura::find($id);
        $factura->saldo_fact = $request->input('nuevosaldo');
        $factura->save();

        return response()->json([
           "validar"=> "1"
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

    public function BuscarCartera(Request $request)
    {
      $opcion = $request->input('opcion');
      if($opcion == 1){//Buscar Cartera por identificación
        $Identificacion_cli = $request->input('identificacion_cli');
        $cartera_fact = informe_cartera_view::where('identificacion_cli', $Identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo_fact', '>=', 1)
        ->get();
        return response()->json([
           "cartera_fact"=>$cartera_fact
         ]);

      }else if($opcion == 2){//Buscar Cartera por Número de Factura
        $id_fact = $request->input('id_fact');
        $cartera_fact = informe_cartera_view::where('id_fact', $id_fact)
        ->where('nota_credito', false)
        ->where('saldo_fact', '>=', 1)
        ->get();
        return response()->json([
           "cartera_fact"=>$cartera_fact
         ]);
      }
    }


    public function SessionFact(Request $request){
        $num_fact = $request->factura;
        $request->session()->put('abonos_fact', $num_fact);
    }
}

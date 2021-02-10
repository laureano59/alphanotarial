<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Concepto;
use App\Tarifa;
use App\Detalle_notas_debito;

class DetallenotadebitoController extends Controller
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
        $notaria = Notaria::find(1);
        $prefijo_fact = $notaria->prefijo_fact;
        $id_ndf = $request->id_ndf;
        $Iva = Tarifa::find(9)->valor1;
        $Iva = ($Iva / 100); 
        $id_concep = $request->id_conc;
        $cantidad = $request->cantidad;
        $Concepto =  Concepto::where("id_concep","=",$id_concep)->get();
        foreach ($Concepto as $con) {
          $nombre_concep = $con->nombre_concep;
          $valor = $con->valor;
        }

        $subtotal = round($valor * $cantidad);
        $Tot_Iva = round($subtotal * $Iva);
        $Total = $subtotal + $Tot_Iva;


        $Detalle = new Detalle_notas_debito();
        $Detalle->id_ndf = $id_ndf;
        $Detalle->prefijo_ndf = $prefijo_fact;
        $Detalle->concepto = $nombre_concep;
        $Detalle->cantidad_concepto = $cantidad;
        $Detalle->subtotal = $subtotal;
        $Detalle->iva = $Tot_Iva;
        $Detalle->total_concepto = $Total;
        $Detalle->valor_concepto = $valor;
        $Detalle->save();
        $Detalle_notas_debito = Detalle_notas_debito::where('id_ndf', $id_ndf)->get();

        return response()->json([
          "validar"=>1,
          "detalle"=>$Detalle_notas_debito
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

        $detalle = Detalle_notas_debito::find($id);
        $id_ndf = Detalle_notas_debito::find($id)->id_ndf;
        $detalle->delete();

        $Detalle_notas_debito = Detalle_notas_debito::where('id_ndf', $id_ndf)->get();
        return response()->json([
          "validar"=>1,
          "detalle"=>$Detalle_notas_debito
         ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notas_debito_factura;
use App\Detalle_notas_debito;
use App\Factura_cliente_escritura_view;
use App\Notaria;
use App\Concepto;

class NotasdebitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Conceptos = Concepto::all();
        $Conceptos->sortBy('nombre_concep');
        $request->user()->authorizeRoles(['liquidacion','administrador']);
        return view('notas_debito_fact.notas_debito_fact', compact('Conceptos'));
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
        $id_fact = $request->input('num_factura');

        $notadebito = new Notas_debito_factura();
        $notadebito->prefijo_ndf = $prefijo_fact;
        $notadebito->id_fact = $id_fact;
        $notadebito->prefijo = $prefijo_fact;
        $notadebito->save();
        $id_ndf = $notadebito->id_ndf;
        $request->session()->put('id_ndf', $id_ndf);
        $request->session()->put('numfact', $id_fact);
        return response()->json([
          "validar"=>1,
          "id_ndf"=>$id_ndf,
          "id_fact"=>$id_fact,
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

    public function CargarFactura(Request $request){
        $numfact = $request->num_factura;
        $factura = Factura_cliente_escritura_view::where('id_fact', $numfact)->get();
         return response()->json([
            "validar"=>1,
            "factura"=>$factura
        ]);

    }
}

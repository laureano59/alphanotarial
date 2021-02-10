<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notas_credito_factura;
use App\Notaria;

class NotascreditofacturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $request->user()->authorizeRoles(['liquidacion','administrador']);
      return view('notas_credito_fact.notas_credito_fact');
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
      $id_fact = $request->input('id_fact');

      if (Notas_credito_factura::where('id_fact', $id_fact)->where('prefijo', $prefijo_fact)->exists()){
            $request->session()->put('numfact', $id_fact);
        return response()->json([
          "validar"=>0,
          "mensaje"=>"Ups!. Esta Factura ya contiene Nota Crédito"
         ]);
      }else{
        $notacredito = new Notas_credito_factura();
        $notacredito->prefijo_ncf = $prefijo_fact;
        $notacredito->detalle_ncf = $request->input('detalle_ncf');
        $notacredito->id_fact = $id_fact;
        $notacredito->prefijo = $prefijo_fact;
        $notacredito->save();
        $id_ncf = $notacredito->id_ncf;
        $request->session()->put('id_ncf', $id_ncf);
        $request->session()->put('numfact', $id_fact);
        return response()->json([
          "validar"=>1,
          "id_ncf"=>$id_ncf,
          "id_fact"=>$id_fact,
          "mensaje"=>"Muy Bien!. Nota Crédito Generada con ÉXITO"
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

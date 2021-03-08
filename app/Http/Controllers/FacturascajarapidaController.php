<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Facturascajarapida;
use App\Detalle_cajarapidafacturas;

class FacturascajarapidaController extends Controller
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

        $request->session()->forget('numfactrapida'); 

        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $fecha_factura = date("Y-m-d H:i:s");//date("Y/m/d");
       
        $Facturascajarapida = new Facturascajarapida();

        $Facturascajarapida->prefijo = $prefijo_fact;
        $Facturascajarapida->id = Auth()->user()->id;
        $Facturascajarapida->fecha_fact = $fecha_factura;
        $Facturascajarapida->save();
        $numfactrapida = $Facturascajarapida->id_fact;
        $request->session()->put('numfactrapida', $numfactrapida);

       
        # ==================================================
        # =           Para vaciar Grilla detalle           =
        # ==================================================

        $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
                    ->where('id_fact', $numfactrapida)
                    ->get();
        
        $subtotal_all = 0;
        $total_iva = 0;
        $total_all = 0;

        foreach ($detalle as $value) {
            $subtotal_all += $value['subtotal'];
            $total_iva += $value['iva'];
            $total_all += $value['total'];
        }
        
        return response()->json([
            "validar"=>1,
            "prefijo"=>$prefijo_fact,
            "id_fact"=> $numfactrapida,
            "detalle"=>$detalle,
            "subtotal"=>$subtotal_all,
            "total_iva"=>$total_iva,
            "total"=>$total_all
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
}

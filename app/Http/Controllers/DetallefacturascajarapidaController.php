<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Detalle_cajarapidafacturas;
use App\Facturascajarapida;
use App\Conceptos_cajarapida;
use App\Tarifa;

class DetallefacturascajarapidaController extends Controller
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
    public function destroy(Request $request, $id)
    {
        
        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $id_fact  = $request->session()->get('numfactrapida');
        $delete_detalle = Detalle_cajarapidafacturas::find($id);
        $delete_detalle->delete();

        $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
                    ->where('id_fact', $id_fact)
                    ->get();
        
        $subtotal_all = 0;
        $total_iva = 0;
        $total_all = 0;

        foreach ($detalle as $value) {
            $subtotal_all += $value['subtotal'];
            $total_iva += $value['iva'];
            $total_all += $value['total'];
        }


        # ===================================================================
        # =           Almacena totales en tabla facturacajarapida y cliente =
        # ===================================================================
        
        $factura_rapida = Facturascajarapida::where("prefijo","=",$prefijo_fact)->find($id_fact);
        $factura_rapida->total_iva = $total_iva;
        $factura_rapida->subtotal = $subtotal_all;
        $factura_rapida->total_fact = $total_all;
        $factura_rapida->save();

        return response()->json([
         "validar"=>1,
         "detalle"=>$detalle,
         "subtotal"=>$subtotal_all,
         "total_iva"=>$total_iva,
         "total"=>$total_all
       ]);

    }
}

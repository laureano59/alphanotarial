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
        
        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $id_concepto = $request->id_concepto;
        $cantidad = $request->cantidad;
        $id_fact  = $request->session()->get('numfactrapida');

        # =============================================
        # =           Valida limite de item           =
        # =============================================

        $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
                    ->where('id_fact', $id_fact)
                    ->get()
                    ->toArray();
        $contdetalle = count ($detalle, 0);

        if($contdetalle >= 6){

            return response()->json([
            "validar"=>7
            ]);
            exit;
        }


        $tarifa = Tarifa::find(9);//IVA
        $porcentaje_iva = $tarifa['valor1'];
        $porcentaje_iva = $porcentaje_iva / 100;

        $concepto = Conceptos_cajarapida::find($id_concepto);
        $nombre_concep = $concepto['nombre_concep'];
        $valor_unitario = $concepto['valor'];
        $excento_iva = $concepto['iva_cajarap'];
        $subtotal = $concepto['valor'] * $cantidad;

        $iva = 0;
        if($excento_iva == 0){
            $iva = round($subtotal * $porcentaje_iva);
        }
        
        $total= round($subtotal + $iva);
        
        $detalle_factura = new Detalle_cajarapidafacturas();

        $detalle_factura->prefijo = $prefijo_fact;
        $detalle_factura->id_fact = $id_fact;
        $detalle_factura->id_concep = $id_concepto;
        $detalle_factura->cantidad = $cantidad;
        $detalle_factura->nombre_concep = $nombre_concep;
        $detalle_factura->valor_unitario = $valor_unitario;
        $detalle_factura->subtotal = $subtotal;
        $detalle_factura->iva = $iva;
        $detalle_factura->total = $total;
        $detalle_factura->save();

       
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

        $identificacion_cli1 = $request->identificacion_cli1;
        $factura_rapida = Facturascajarapida::where("prefijo","=",$prefijo_fact)->find($id_fact);
        $factura_rapida->a_nombre_de = $identificacion_cli1;
        $factura_rapida->total_iva = $total_iva;
        $factura_rapida->subtotal = $subtotal_all;
        $factura_rapida->total_fact = $total_all;
        $factura_rapida->save();

        return response()->json([
         "validar"=>1,
         "detalle"=>$detalle,
         "id_concepto"=>$id_concepto,
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

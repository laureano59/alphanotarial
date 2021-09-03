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

        //$request->session()->forget('numfactrapida'); 
        
        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $fecha_factura = date("Y-m-d H:i:s");//date("Y/m/d");

        $identificacion_cli1 = $request->identificacion_cli1;
        $formapago = $request->formapago;
        $total_iva = $request->total_iva;
        $total = $request->total;
        $total_all = $request->total_all;
        $detalle = $request->detalle;
              
        $Facturascajarapida = new Facturascajarapida();

        $Facturascajarapida->prefijo = $prefijo_fact;
        $Facturascajarapida->id = Auth()->user()->id;
        $Facturascajarapida->fecha_fact = $fecha_factura;
        $Facturascajarapida->a_nombre_de = $identificacion_cli1;
        $Facturascajarapida->total_iva = $total_iva;
        $Facturascajarapida->total_fact = $total_all;
        $Facturascajarapida->subtotal = $total;

         /*----------  Forma pago  ----------*/

        if($formapago == 1){
            $Facturascajarapida->credito_fact = true;
            $Facturascajarapida->dias_credito = 30;
        }else if($formapago == 0){
            $Facturascajarapida->credito_fact = false;
            $Facturascajarapida->dias_credito = 0;
        }
        
        $Facturascajarapida->save();
        $numfactrapida = $Facturascajarapida->id_fact;
        $request->session()->put('numfactrapida', $numfactrapida);
        
       
        # =======================================
        # =           Guardar detalle           =
        # =======================================


        foreach ($detalle as $key => $det) {
            $detalle_factura = new Detalle_cajarapidafacturas();
            $detalle_factura->prefijo = $prefijo_fact;
            $detalle_factura->id_fact = $numfactrapida;
            $detalle_factura->id_concep = $det['id_concep'];
            $detalle_factura->cantidad = $det['cantidad'];
            $detalle_factura->nombre_concep = $det['nombre_concep'];
            $detalle_factura->valor_unitario = $det['valor_unitario'];
            $detalle_factura->subtotal = $det['subtotal'];
            $detalle_factura->iva = $det['iva'];
            $detalle_factura->total = $det['total'];
            $detalle_factura->save(); 
        }
      
        
        return response()->json([
            "validar"=>1,
            "prefijo"=>$prefijo_fact,
            "id_fact"=> $numfactrapida
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
        $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
        $factura = Facturascajarapida::where("prefijo","=",$prefijo_fact)->find($id);
        $opcion = $request->opcion;

        
        if($opcion == 'solocartera'){
          $factura->saldo_fact = $request->nuevosaldo;
          $factura->save();
          return response()->json([
            "validar"=>1,
            "mensaje"=>'Muy bien! Abono realizado'
           ]);

        }else if($opcion == 'actualizar'){
                        
            Detalle_cajarapidafacturas::
            where("prefijo","=",$prefijo_fact)
            ->where("id_fact","=", $id)->delete();

            $identificacion_cli1 = $request->identificacion_cli1;
            $formapago = $request->formapago;
            $total_iva = $request->total_iva;
            $total = $request->total;
            $total_all = $request->total_all;
            $detalle = $request->detalle;
            
            $Facturascajarapida = Facturascajarapida::where("prefijo","=",$prefijo_fact)->find($id);

            $Facturascajarapida->prefijo = $prefijo_fact;
            $Facturascajarapida->id = Auth()->user()->id;
            $Facturascajarapida->a_nombre_de = $identificacion_cli1;
            $Facturascajarapida->total_iva = $total_iva;
            $Facturascajarapida->total_fact = $total_all;
            $Facturascajarapida->subtotal = $total;

            /*----------  Forma pago  ----------*/

            if($formapago == 1){
            $Facturascajarapida->credito_fact = true;
            $Facturascajarapida->dias_credito = 30;
            }else if($formapago == 0){
            $Facturascajarapida->credito_fact = false;
            $Facturascajarapida->dias_credito = 0;
            }
            
            $Facturascajarapida->save();
                  
       
            # =======================================
            # =           Guardar detalle           =
            # =======================================


            foreach ($detalle as $key => $det) {
            $detalle_factura = new Detalle_cajarapidafacturas();
            $detalle_factura->prefijo = $prefijo_fact;
            $detalle_factura->id_fact = $id;
            $detalle_factura->id_concep = $det['id_concep'];
            $detalle_factura->cantidad = $det['cantidad'];
            $detalle_factura->nombre_concep = $det['nombre_concep'];
            $detalle_factura->valor_unitario = $det['valor_unitario'];
            $detalle_factura->subtotal = $det['subtotal'];
            $detalle_factura->iva = $det['iva'];
            $detalle_factura->total = $det['total'];
            $detalle_factura->save(); 
            }
      
        
            return response()->json([
            "validar"=>1,
            "Mensaje"=>"MUY BIEN!. Cambios realizados"
            ]);




        }
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

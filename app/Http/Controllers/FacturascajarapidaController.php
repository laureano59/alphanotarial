<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Facturascajarapida;
use App\Detalle_cajarapidafacturas;
use App\Pagos_cajarapida;

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


        $efectivo = $request->efectivo;
         if($efectivo === '' || is_null($efectivo)){
            $efectivo = 0;
          }
        //$efectivo = str_replace(",", " ", $efectivo);//comas por espacios
        //$efectivo = str_replace(" ", "", $efectivo);//elimina espacios

        $cheque = $request->cheque;
        if($cheque === '' || is_null($cheque)){
            $cheque = 0;
          }
        //$cheque = str_replace(",", " ", $cheque);
        //$cheque = str_replace(" ", "", $cheque);

        $consignacion_bancaria = $request->consignacion_bancaria;
        if($consignacion_bancaria === '' || is_null($consignacion_bancaria)){
            $consignacion_bancaria = 0;
          }
        //$consignacion_bancaria = str_replace(",", " ", $consignacion_bancaria);
        //$consignacion_bancaria = str_replace(" ", "", $consignacion_bancaria);

        $pse = $request->pse;
        if($pse === '' || is_null($pse)){
            $pse = 0;
          }
        //$pse = str_replace(",", " ", $pse);
        //$pse = str_replace(" ", "", $pse);

        $transferencia_bancaria = $request->transferencia_bancaria;
        if($transferencia_bancaria === '' || is_null($transferencia_bancaria)){
            $transferencia_bancaria = 0;
          }
        //$transferencia_bancaria = str_replace(",", " ", $transferencia_bancaria);
        //$transferencia_bancaria = str_replace(" ", "", $transferencia_bancaria);

        $tarjeta_credito = $request->tarjeta_credito;
        if($tarjeta_credito === '' || is_null($tarjeta_credito)){
            $tarjeta_credito = 0;
          }
        //$tarjeta_credito = str_replace(",", " ", $tarjeta_credito);
        //$tarjeta_credito = str_replace(" ", "", $tarjeta_credito);

        $tarjeta_debito = $request->tarjeta_debito;
         if($tarjeta_debito === '' || is_null($tarjeta_debito)){
            $tarjeta_debito = 0;
          }
        //$tarjeta_debito = str_replace(",", " ", $tarjeta_debito);
        //$tarjeta_debito = str_replace(" ", "", $tarjeta_debito);

        $total_mediosdepago = $efectivo + $cheque + $consignacion_bancaria +
        $pse + $transferencia_bancaria + $tarjeta_credito + $tarjeta_debito;

        if($total_mediosdepago == $request->total_all){

          }else{

            return response()->json([
                "validar"=>888
            ]);

          }

        
        /*Autonumerico*/
         
        $consecutivo = Facturascajarapida::where('prefijo', $prefijo_fact)->max('id_fact');
        $consecutivo = $consecutivo + 1;

        $Facturascajarapida = new Facturascajarapida();

        $Facturascajarapida->prefijo = $prefijo_fact;
        $Facturascajarapida->id_fact = $consecutivo;
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
            $Facturascajarapida->saldo_fact = $total_all;
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


        # =======================================
        # =           Guardar medio pago        =
        # =======================================

        $pago = new Pagos_cajarapida();
        $pago->codigo_ban = $request->id_banco;
        $pago->id_fact = $numfactrapida;
        $pago->prefijo = $prefijo_fact;
        $pago->efectivo = $efectivo;
        $pago->cheque = $cheque;
        $pago->consignacion_bancaria = $consignacion_bancaria;
        $pago->pse = $pse;
        $pago->transferencia_bancaria = $transferencia_bancaria;
        $pago->tarjeta_credito = $tarjeta_credito;
        $pago->tarjeta_debito = $tarjeta_debito;
        $pago->save();
        
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

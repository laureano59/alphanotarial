<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Factura;
use App\Informe_bonos_view;
use App\Consecutivo;
use App\Bono;
use App\Detalle_cuenta_cobro_escr;
use App\Cuenta_cobro_escr;
use App\Cuenta_cobro_view;
use Carbon\Carbon;

class BonosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['facturacion','administrador']);
        return view('bonos.bonos');
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
        //
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
        /*$id = $request->session()->get('id_bon');
        $bono = Bono::find($id);
        $bono->saldo_bon = $request->saldo;
        $bono->fecha_abono = date("Y-m-d H:i:s");
        $bono->save();

        return response()->json([
           "validar"=> "1",
           "mensaje"=> "Muy bien! El abono fue exitoso"
         ]);*/
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

    public function BuscarBono(Request $request)
    {
      $opcion = $request->input('opcion');
      

      /*===========================================================
      /             VALIDA PARA PODER IMPRIMIR ANTERIORES         /
      /*=========================================================*/
      if($opcion == 1){//Buscar bono por identificación
        $Identifi = $request->input('identificacion_cli');
        $bono_factu = Informe_bonos_view::where('identificacion_cli', $Identifi)
        ->where('nota_credito', false)
        ->get();
         foreach ($bono_factu as $key => $value) {
            $ident = $value['identificacion_cli'];
            $cli = $value['cliente'];
            $id_fact = $value['id_fact'];
        }

        $request->session()->put('abonos_fact', $id_fact);

        $request->session()->put('ident', $ident);//para PdfAbonosCartera()
        $request->session()->put('cli', $cli);//para PdfAbonosCartera()
                                              //
       } else if($opcion == 2){
        $id_factu = $request->input('id_fact');
        $bono_factu = Informe_bonos_view::where('id_fact', $id_factu)
        ->where('nota_credito', false)
        ->get();
         foreach ($bono_factu as $key => $value) {
            $ident = $value['identificacion_cli'];
            $cli = $value['cliente'];
        }

        $request->session()->put('abonos_fact', $id_factu);

        $request->session()->put('ident', $ident);//para PdfAbonosCartera()
        $request->session()->put('cli', $cli);//para PdfAbonosCartera()

        }

      if($opcion == 1){//Buscar bono por identificación
        $Identificacion_cli = $request->input('identificacion_cli');
        $bono_fact = Informe_bonos_view::where('identificacion_cli', $Identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo', '>=', 1)
        ->get();
         
        return response()->json([
           "bono_fact"=>$bono_fact
         ]);

      }else if($opcion == 2){//Buscar Cartera por Número de Factura
        $id_fact = $request->input('id_fact');
        $bono_fact = Informe_bonos_view::where('id_fact', $id_fact)
        ->where('nota_credito', false)
        ->where('saldo', '>=', 1)
        ->get();
      
        return response()->json([
           "bono_fact"=>$bono_fact
         ]);
      }
    }

    public function SessionBon(Request $request){
        $num_fact = $request->factura;
        $id_bon = $request->id_bon;
        $request->session()->put('abonos_fact', $num_fact);
        $request->session()->put('id_bon', $id_bon);
    }

    public function CargarBonos(Request $request){
        //$fecha1 = $request->fecha1;
        //$fecha2 = $request->fecha2;

        $fecha1 = Carbon::parse($request->fecha1)->startOfDay();
        $fecha2 = Carbon::parse($request->fecha2)->endOfDay();

        $bonos = Cuenta_cobro_view::whereDate('fecha_fact', '>=', $fecha1)
        ->whereDate('fecha_fact', '<=', $fecha2)
        ->get()
        ->toArray();

      return response()->json([
           "bonos"=>$bonos
         ]);
    }

     public function GuardarCuentaCobro(Request $request){

        $bonos_sel = $request->seleccionados;
        //var_dump($bonos_sel);
        //exit;

        foreach ($bonos_sel as $key => $value) {
            $id_cli  = $value['identificacion_cli'];
            $cliente = $value['cliente'];
        }


        $prefijo_fact = Notaria::find(1)->prefijo_fact;

        $consecutivo = Consecutivo::find(1);
        $consecutivo_cuenta_cobro = $consecutivo->cuenta_cobro;
        $id_cc = $consecutivo_cuenta_cobro + 1;
        $consecutivo->cuenta_cobro = $id_cc;
        $consecutivo->save();
        
        $CuentaCobro = new Cuenta_cobro_escr();
        $CuentaCobro->id_cce = $id_cc;
        $CuentaCobro->id_cli = $id_cli;
        $CuentaCobro->nombre_cli = $cliente;
        $CuentaCobro->save();

        foreach ($bonos_sel as $key => $value) {
           
            $detalle_cc = new Detalle_cuenta_cobro_escr();
            $detalle_cc->id_cce               = $id_cc;
            $detalle_cc->codigo_bono          = $value['codigo_bono'];
            $detalle_cc->id_fact              = $value['id_fact'];
            $detalle_cc->prefijo              = $prefijo_fact;
            $detalle_cc->fecha_bono           = $value['fecha_fact'];
            $detalle_cc->num_escr             = $value['num_esc'];
            $detalle_cc->identificacion_cli   = $value['identificacion_cli'];
            $detalle_cc->nombre_cli           = $value['cliente'];
            $detalle_cc->direccion_cli        = $value['direccion_cli'];
            $detalle_cc->telefono_cli         = $value['telefono_cli'];
            $detalle_cc->valor_bono           = $value['valor_bono'];
            $detalle_cc->save();

            $id = $value['id_bon'];
            $bono = Bono::find($id);
            $bono->cuenta_cobro = true;
            $bono->save();
        }

        $request->session()->put('id_cuentacobro', $id_cc);

        return response()->json([
           "validar"=>1,
           "id_cce"=>$id_cc
         ]);
     }
    
}

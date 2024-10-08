<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Factura;
use App\Informe_bonos_view;
use App\Bono;

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
        $id = $request->session()->get('id_bon');
        $bono = Bono::find($id);
        $bono->saldo_bon = $request->saldo;
        $bono->fecha_abono = date("Y-m-d H:i:s");
        $bono->save();

        return response()->json([
           "validar"=> "1",
           "mensaje"=> "Muy bien! El abono fue exitoso"
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
}

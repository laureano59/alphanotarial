<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Factura;
use App\Cartera_fact;
use App\Informe_cartera_view;

class CarteraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->user()->authorizeRoles(['cartera','administrador']);
        return view('cartera.cartera');
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

      $prefijo_fact = Notaria::find(1)->prefijo_fact;
      $id_fact = $request->input('id_fact');
      $abono = $request->input('abono');
      $saldo = $request->saldo;

      $cartera = new Cartera_fact();
      $cartera->id_fact = $id_fact;
      $cartera->prefijo = $prefijo_fact;
      $cartera->abono_car = $abono;
      $cartera->saldo = $saldo;
      $cartera->usuario = auth()->user()->name;
      $cartera->save();

      return response()->json([
          "validar"=> "1"
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
        $factura = Factura::find($id);
        $factura->saldo_fact = $request->input('nuevosaldo');
        $factura->save();

        return response()->json([
           "validar"=> "1"
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

    public function BuscarCartera(Request $request)
    {
      $opcion = $request->input('opcion');
      

      /*===========================================================
      /             VALIDA PARA PODER IMPRIMIR ANTERIORES         /
      /*=========================================================*/
      if($opcion == 1){//Buscar Cartera por identificación
        $Identifi = $request->input('identificacion_cli');
        $cartera_factu = Informe_cartera_view::where('identificacion_cli', $Identifi)
        ->where('nota_credito', false)
        ->get();
         foreach ($cartera_factu as $key => $value) {
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
        $cartera_factu = informe_cartera_view::where('id_fact', $id_factu)
        ->where('nota_credito', false)
        ->get();
         foreach ($cartera_factu as $key => $value) {
            $ident = $value['identificacion_cli'];
            $cli = $value['cliente'];
        }

        $request->session()->put('abonos_fact', $id_factu);

        $request->session()->put('ident', $ident);//para PdfAbonosCartera()
        $request->session()->put('cli', $cli);//para PdfAbonosCartera()

        }

      if($opcion == 1){//Buscar Cartera por identificación
        $Identificacion_cli = $request->input('identificacion_cli');
        $cartera_fact = Informe_cartera_view::where('identificacion_cli', $Identificacion_cli)
        ->where('nota_credito', false)
        ->where('saldo_fact', '>=', 1)
        ->get();
         
        return response()->json([
           "cartera_fact"=>$cartera_fact
         ]);

      }else if($opcion == 2){//Buscar Cartera por Número de Factura
        $id_fact = $request->input('id_fact');
        $cartera_fact = Informe_cartera_view::where('id_fact', $id_fact)
        ->where('nota_credito', false)
        ->where('saldo_fact', '>=', 1)
        ->get();
      
        return response()->json([
           "cartera_fact"=>$cartera_fact
         ]);
      }
    }


    public function SessionFact(Request $request){
        $num_fact = $request->factura;
        $request->session()->put('abonos_fact', $num_fact);
    }
}

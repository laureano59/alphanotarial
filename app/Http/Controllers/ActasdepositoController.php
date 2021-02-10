<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Radicacion;
use App\Tipoidentificacion;
use App\Tipo_acta_deposito;
use App\Departamento;
use App\Banco;
use App\Actas_deposito;
use App\Actas_deposito_view;

class ActasdepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $request->user()->authorizeRoles(['facturacion','administrador']);
      $anio_trabajo = Notaria::find(1)->anio_trabajo;
      $id_radica = $request->session()->get('key');
      $TipoIdentificaciones = Tipoidentificacion::all();
      $TipoDeposito = Tipo_acta_deposito::all();
      $TipoDeposito = $TipoDeposito->sortBy('descripcion_tip');
      $Departamentos = Departamento::all();
      $Departamentos = $Departamentos->sortBy('nombre_depa'); //TODO:Ordenar por nombre
      $Banco = Banco::all();
      $Banco = $Banco->Sort();
         return view('actas_deposito.depositos', compact('TipoIdentificaciones', 'TipoDeposito', 'Departamentos', 'Banco'));
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
      $anio_radica = $request->anio_fiscal;//Notaria::find(1)->anio_trabajo;
      $fecha_manual = Notaria::find(1)->fecha_acta;
      $fecha_automatica = Notaria::find(1)->fecha_acta_automatica;
      if($fecha_automatica == true){
        $fecha_acta = date("Y/m/d");
      }else if($fecha_automatica == false){
        $fecha_acta = $fecha_manual;
      }
      $id_radica = $request->input('id_radica');
      $actas_deposito = new Actas_deposito();
      $actas_deposito->id_radica = $id_radica;
      $actas_deposito->anio_radica = $anio_radica;
      $actas_deposito->fecha_acta = $fecha_acta;
      $actas_deposito->id_tip = $request->input('id_tip');
      $actas_deposito->codigo_ban = $request->input('codigo_ban');
      $actas_deposito->identificacion_cli = $request->input('identificacion_cli');
      $actas_deposito->proyecto = $request->input('proyecto');
      $actas_deposito->deposito_act = $request->input('deposito_act');
      $actas_deposito->saldo = $request->input('deposito_act');
      $actas_deposito->observaciones_act = $request->input('observaciones_act');
      $actas_deposito->efectivo = $request->input('efectivo');
      $actas_deposito->cheque = $request->input('cheque');
      $actas_deposito->tarjeta_credito = $request->input('tarjeta_credito');
      $actas_deposito->num_cheque = $request->input('num_cheque');
      $actas_deposito->num_tarjetacredito = $request->input('num_tarjetacredito');
      $actas_deposito->usuario = auth()->user()->name;
      $actas_deposito->save();
      $id_act = $actas_deposito->id_act;
      $request->session()->put('id_acta', $id_act);

      $actas_depo_all = Actas_deposito_view::where('identificacion_cli', $actas_deposito->identificacion_cli)->get();

      return response()->json([
         "id_act"=>$id_act,
         "actas_depo_all"=>$actas_depo_all
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
        $actas_deposito = Actas_deposito::find($id);
        $actas_deposito->saldo = $request->input('nuevosaldo');
        $actas_deposito->save();

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

    public function BuscarActa(Request $request)
    {
      $opcion = $request->input('opcion');
      if($opcion == 1){//Buscar Acta por identificación
        $Identificacion_cli = $request->input('identificacion_cli');
        $actas_depo_all = Actas_deposito_view::where('identificacion_cli', $Identificacion_cli)->where('anulada', false)->get();
        return response()->json([
           "actas_depo_all"=>$actas_depo_all
         ]);

      }else if($opcion == 2){//Buscar Acta por Número de Acta
        $Id_acta = $request->input('id_acta');
        $actas_depo_all = Actas_deposito_view::where('id_act', $Id_acta)->where('anulada', 'false')->get();
        return response()->json([
           "actas_depo_all"=>$actas_depo_all
         ]);
      }
    }
}

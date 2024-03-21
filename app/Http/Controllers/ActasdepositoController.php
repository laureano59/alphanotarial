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
use App\Egreso_acta_deposito;


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
      $id_radica = $request->input('id_radica');
      $fecha_manual = Notaria::find(1)->fecha_acta;
      $fecha_automatica = Notaria::find(1)->fecha_acta_automatica;
      if($fecha_automatica == true){
        $fecha_acta = date("Y/m/d");
      }else if($fecha_automatica == false){
        $fecha_acta = $fecha_manual;
      }


      $efectivo = $request->efectivo;
       if($efectivo === '' || is_null($efectivo)){
            $efectivo = 0;
        }
      
      $cheque = $request->cheque;
       if($cheque === '' || is_null($cheque)){
            $cheque = 0;
        }
      
      $consignacion_bancaria = $request->consignacion_bancaria;
      if($consignacion_bancaria === '' || is_null($consignacion_bancaria)){
            $consignacion_bancaria = 0;
        }
      
      $pse = $request->pse;
       if($pse === '' || is_null($pse)){
            $pse = 0;
        }
      
      $transferencia_bancaria = $request->transferencia_bancaria;
      if($transferencia_bancaria === '' || is_null($transferencia_bancaria)){
            $transferencia_bancaria = 0;
        }
      
      $tarjeta_credito = $request->tarjeta_credito;
      if($tarjeta_credito === '' || is_null($tarjeta_credito)){
            $tarjeta_credito = 0;
        }
      
      $tarjeta_debito = $request->tarjeta_debito;
       if($tarjeta_debito === '' || is_null($tarjeta_debito)){
            $tarjeta_debito = 0;
        }


        if($request->id_tip == 2 || $request->id_tip == 3){
            if($id_radica === '' || is_null($id_radica) || $anio_radica === '' || is_null($anio_radica)){
                    return response()->json([
                        "validar"=>888
                    ]);
            }
        }
      
      $actas_deposito = new Actas_deposito();
      $actas_deposito->id_radica = $id_radica;
      $actas_deposito->anio_radica = $anio_radica;
      $actas_deposito->fecha_acta = $fecha_acta;
      $actas_deposito->id_tip = $request->id_tip;
      $actas_deposito->codigo_ban = $request->codigo_ban;
      $actas_deposito->identificacion_cli = $request->identificacion_cli;
      $actas_deposito->proyecto = $request->proyecto;
      $actas_deposito->deposito_act = $request->deposito_act;
      $actas_deposito->saldo = $request->deposito_act;
      $actas_deposito->observaciones_act = $request->observaciones_act;
      $actas_deposito->efectivo = $efectivo;
      $actas_deposito->cheque = $cheque;
      $actas_deposito->consignacion_bancaria = $consignacion_bancaria;
      $actas_deposito->pse = $pse;
      $actas_deposito->transferencia_bancaria = $transferencia_bancaria;
      $actas_deposito->tarjeta_credito = $tarjeta_credito;
      $actas_deposito->tarjeta_debito = $tarjeta_debito;
      $actas_deposito->num_tarjetacredito = $request->num_tarjetacredito;
      $actas_deposito->num_cheque = $request->num_cheque;
      $actas_deposito->usuario = auth()->user()->name;
      $actas_deposito->save();
      $id_act = $actas_deposito->id_act;
      $request->session()->put('id_acta', $id_act);

      $actas_depo_all = Actas_deposito_view::where('identificacion_cli', $actas_deposito->identificacion_cli)->get();

      return response()->json([
        "validar"=>1,
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

    }

    public function Anular(Request $request){

        $id_act = $request->id_act;

        if (Egreso_acta_deposito::where('id_act', $id_act)->exists()) {
            
            return response()->json([
                "validar"=> "888",
                "mensaje"=> "El acta de depósito no se puede anular porque tiene cruces comprometidos"
            ]);

        } else {
            
            $actas_deposito = Actas_deposito::find($id_act);
            $actas_deposito->anulada = true;
            $actas_deposito->motivo_anulacion = $request->motivo_anulacion;
            $actas_deposito->save();

            $actas_depo_all = Actas_deposito_view::where('id_act', $id_act)
            ->where('anulada', false)
            ->get();
            
            return response()->json([
                "validar"=> "1",
                "data"=> $actas_depo_all
            ]);
        }
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
        $request->session()->put('id_acta', $Id_acta);
        $actas_depo_all = Actas_deposito_view::where('id_act', $Id_acta)->where('anulada', 'false')->get();
        return response()->json([
           "actas_depo_all"=>$actas_depo_all
         ]);
      }
    }
}

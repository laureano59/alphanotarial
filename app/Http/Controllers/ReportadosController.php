<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipo_reportados;
use App\Reportados;

class ReportadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $Tipo_reportados = Tipo_reportados::all();
        $Tipo_reportados = $Tipo_reportados->Sort();
        return view('reportados.reportados', compact('Tipo_reportados'));
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
        $Reportados = new Reportados();

        $Reportados->nombre_rep = $request->nombre_rep;
        $Reportados->identificacion_rep = $request->identificacion_rep;
        $Reportados->id_tipo_rep = $request->id_tipo_rep;
        $Reportados->concepto_rep = $request->concepto_rep;
        $Reportados->activo = $request->activo;
        $Reportados->save();

        $registros = Reportados::where('identificacion_rep', $request->identificacion_rep)->get();
        return response()->json([
           "reportado"=>$registros
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
        $Reportados = Reportados::find($id);
        $Reportados->nombre_rep = $request->nombre_rep;
        $Reportados->identificacion_rep = $request->identificacion_rep;
        $Reportados->id_tipo_rep = $request->id_tipo_rep;
        $Reportados->concepto_rep = $request->concepto_rep;
        $Reportados->activo = $request->activo;
        $Reportados->save();

        $registros = Reportados::where('identificacion_rep', $request->identificacion_rep)->get();
        return response()->json([
           "reportado"=>$registros
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
        $reportado = Reportados::find($id);
        $reportado->delete();
        $registros = Reportados::where('id_rep', $id)->get();
        return response()->json([
           "reportado"=>$registros
         ]);
    }
}

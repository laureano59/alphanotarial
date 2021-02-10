<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;

class ConfigurarfechasController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
        $request->user()->authorizeRoles(['facturacion','administrador']);
        $notaria = Notaria::find(1);
        $fecha_fact = $notaria->fecha_fact;
        $fecha_esc = $notaria->fecha_esc;
        $fecha_fact_automatica = $notaria->fecha_fact_automatica;
        $fecha_esc_automatica = $notaria->fecha_esc_automatica;

        $fecha_acta = $notaria->fecha_acta;
        $fecha_egreso = $notaria->fecha_egreso;
        $fecha_acta_automatica = $notaria->fecha_acta_automatica;
        $fecha_egreso_automatica = $notaria->fecha_egreso_automatica;
        
        return view('configuracion.configurarfechas', compact('fecha_fact', 'fecha_esc', 'fecha_fact_automatica', 'fecha_esc_automatica', 'fecha_acta', 'fecha_egreso', 'fecha_acta_automatica', 'fecha_egreso_automatica'));
  }
}

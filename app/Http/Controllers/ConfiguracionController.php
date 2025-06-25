<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
        $request->user()->authorizeRoles(['configuracion','administrador']);
        return view('configuracion.panelconfiguracion');
  }
}

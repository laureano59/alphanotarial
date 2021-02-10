<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Panel_cajarapidaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $request->user()->authorizeRoles(['caja_rapida','administrador']);

    return view('caja_rapida.panel_cajarapida');
  }
}

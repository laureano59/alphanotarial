<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelreporteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $request->user()->authorizeRoles(['facturacion','administrador']);

    return view('reportes.cpanel');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MantenimientoController extends Controller
{
  public function index(Request $request){
    $request->user()->authorizeRoles(['liquidacion','administrador']);
    return view('mantenimiento.mantenimiento');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpcionesdeactasController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('auth');
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
      $request->user()->authorizeRoles(['facturacion','administrador']);
      return view('actas_deposito.actasdeposito');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipoidentificacion;
use App\Departamento;
use App\Conceptos_cajarapida;

class CajarapidaController extends Controller
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
    public function index(Request $request)
    {
        
        $request->user()->authorizeRoles(['caja_rapida','administrador']);
        $opcion = $request->session()->get('opcioncajarapida');
        $TipoIdentificaciones = Tipoidentificacion::all();
        $Departamentos = Departamento::all();
        $Departamentos = $Departamentos->sortBy('nombre_depa');
        $Conceptos = Conceptos_cajarapida::all();
        $Conceptos = $Conceptos->sortBy('id_concep');
        
        if($opcion == 1){
          return view('caja_rapida.cajarapida', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos'));  
        }else if($opcion == 2){
          return view('caja_rapida.editarcajarapida', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos'));  
        }
        
    }
}

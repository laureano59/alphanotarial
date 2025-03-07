<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipoidentificacion;
use App\Departamento;
use App\Conceptos_cajarapida;
use App\Banco;
use App\Medios_pago;
use App\Base_cajarapida;
Use App\Actividad_economica;

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

        $fecha_base = date("Y-m-d");

        $registro = Base_cajarapida::where('fecha_base', $fecha_base)->first();

        if ($registro) {
          $opcion = $request->session()->get('opcioncajarapida');
          $TipoIdentificaciones = Tipoidentificacion::all();
          $Departamentos = Departamento::all();
          $Departamentos = $Departamentos->sortBy('nombre_depa');
          $Conceptos = Conceptos_cajarapida::all();
          $Conceptos = $Conceptos->sortBy('id_concep');

          $Banco = Banco::all();
          $Banco = $Banco->Sort();

          $Actividad_economica = Actividad_economica::All();
          $Actividad_economica = $Actividad_economica->sortBy('actividad');
          
                    
          if($opcion == 1){
            return view('caja_rapida.cajarapida', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos', 'Banco', 'Actividad_economica'));  
          //}else if($opcion == 2){
            //return view('caja_rapida.editarcajarapida', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos', 'Banco'));  
          }

        }else{
          $Mensaje = "La caja no se ha aperturado desde el sistema";
          return view('errors.erroresgenerales', compact('Mensaje'));

          }
        
    }
}

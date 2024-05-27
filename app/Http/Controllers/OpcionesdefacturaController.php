<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Facturascajarapida;

class OpcionesdefacturaController extends Controller
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
       /*VALIDA SI HAY FACTURAS PARA ENVIAR A LA DIAN Y SACAR EL MENSAJE*/


       $facturas_dian = Factura::select(\DB::raw("prefijo, id_fact, TO_CHAR(fecha_fact, 'DD-MM-YYYY') AS fecha_fact"))
       ->where('status_factelectronica', '0')
       ->where('fecha_fact', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
       ->get();

       $facturas_dian_cr = Facturascajarapida::select(\DB::raw("prefijo, id_fact, TO_CHAR(fecha_fact, 'DD-MM-YYYY') AS fecha_fact"))
       ->where('status_factelectronica', '0')
       ->where('fecha_fact', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
       ->get();

       $Fact_Dian = '0';

       if ($facturas_dian->isEmpty()) {
      $Fact_Dian = '0';//No hay facturas para enviar
    } else {
      $Fact_Dian = '1';//Hay facturas para enviar
    }

    $request->session()->put('Fact_Dian', $Fact_Dian);

    $Fact_Dian_cr = '0';

    if ($facturas_dian_cr->isEmpty()) {
      $Fact_Dian_cr = '0';//No hay facturas para enviar
    } else {
      $Fact_Dian_cr = '1';//Hay facturas para enviar
    }

    $request->session()->put('Fact_Dian_cr', $Fact_Dian_cr);


      $request->user()->authorizeRoles(['facturacion','administrador']);
      return view('facturacion.facturacion');
    }

}

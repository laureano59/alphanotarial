<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Radicacion;
use App\Factura;
use App\Escritura;
use App\Facturascajarapida;
use App\Notas_credito_factura;
use App\Notas_credito_cajarapida;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
      $AnioTrabajo = Notaria::find(1);
      $prefijo = $AnioTrabajo->prefijo_fact;

      $raw = \DB::raw("Max(id_radica) as id_radica");
      $radicacion = Radicacion::where('anio_radica', $AnioTrabajo->anio_trabajo)->select($raw)->get();
      foreach ($radicacion as $rad) {
        $Id_radica = $rad->id_radica;
      }

      $raw1 = \DB::raw("Max(id_fact) as id_fact");
      $factura = Factura::where('prefijo', $prefijo)->select($raw1)->get();
      foreach ($factura as $fac) {
        $Id_fact = $fac->id_fact;
      }

      $raw2 = \DB::raw("Max(num_esc) as num_escr");
      $escritura = Escritura::where('anio_esc', $AnioTrabajo->anio_trabajo)->select($raw2)->get();
      foreach ($escritura as $esc) {
        $Num_esc = $esc->num_escr;
      }


      $facturas_dian = Factura::select(\DB::raw("prefijo, id_fact, TO_CHAR(fecha_fact, 'DD-MM-YYYY') AS fecha_fact"))
      ->where('status_factelectronica', '0')
      ->where('fecha_fact', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
      ->get();

      $facturas_dian_cr = Facturascajarapida::select(\DB::raw("prefijo, id_fact, TO_CHAR(fecha_fact, 'DD-MM-YYYY') AS fecha_fact"))
      ->where('status_factelectronica', '0')
      ->where('fecha_fact', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
      ->get();


      $notascredito_dian = Notas_credito_factura::select(\DB::raw("prefijo_ncf, id_ncf, TO_CHAR(created_at, 'DD-MM-YYYY') AS fecha_fact"))
      ->where('status_factelectronica', '0')
      ->where('created_at', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
      ->get();

      $notascredito_dian_cr = Notas_credito_cajarapida::select(\DB::raw("prefijo_ncf, id_ncf, TO_CHAR(created_at, 'DD-MM-YYYY') AS fecha_fact"))
      ->where('status_factelectronica', '0')
      ->where('created_at', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
      ->get();

      $Fact_Dian = '0';      
    
      if ($facturas_dian->isEmpty() && $notascredito_dian->isEmpty()) {
          $Fact_Dian = '0'; // No hay facturas ni notas crédito para enviar
      } else {
        $Fact_Dian = '1'; // Hay facturas o notas crédito para enviar
      }

    $request->session()->put('Fact_Dian', $Fact_Dian);

    $Fact_Dian_cr = '0';

    if ($facturas_dian_cr->isEmpty() && $notascredito_dian_cr->isEmpty()) {
        $Fact_Dian_cr = '0'; // No hay facturas ni notas crédito para enviar
    } else {
      $Fact_Dian_cr = '1'; // Hay facturas o notas crédito para enviar
    }

    $request->session()->put('Fact_Dian_cr', $Fact_Dian_cr);


      return view('home', compact('Id_radica', 'AnioTrabajo', 'Id_fact', 'Num_esc'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Radicacion;
use App\Factura;
use App\Escritura;

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
    public function index()
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


      return view('home', compact('Id_radica', 'AnioTrabajo', 'Id_fact', 'Num_esc'));
    }
}

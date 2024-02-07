<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditaracargodeController extends Controller
{
     public function index(Request $request)
    {
       $request->user()->authorizeRoles(['administrador']);
       $Factura = $request->session()->get('factura');

       foreach ($Factura as $value) {
          $Identificacion = $value['identificacion'];
          $Detalle = $value['detalle'];
       }
       return view('facturacion.editar_acargo_de', compact('Factura', 'Identificacion', 'Detalle'));
    }
}

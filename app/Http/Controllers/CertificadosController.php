<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CertificadosController extends Controller
{
    public function index(Request $request){
        $request->user()->authorizeRoles(['administrador', 'radicacion']);
       
        return view('certificados.panel_certificados');

    }

   
}

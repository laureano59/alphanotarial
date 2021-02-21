<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protocolista;

class ProtocolistasController extends Controller
{

	 public function index(Request $request){
	 	$request->user()->authorizeRoles(['administrador', 'radicacion']);
    	$opcion = $request->session()->get('opcion_protocolista');
    	
    	if($opcion === null){
          	return view('protocolistas.panel_protocolistas');
    	}else if($opcion == 1){//Cambiar protocolista
    	   	$request->session()->forget('opcion_protocolista');
    	   	$Protocolistas = Protocolista::all();
       	   	return view('protocolistas.cambiar_protocolista', compact('Protocolistas'));

        }
		

	 }
    
    


    
}

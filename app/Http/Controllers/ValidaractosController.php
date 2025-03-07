<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Acto;

class ValidaractosController extends Controller
{
	/****TODO:Valida Actos******/
	public function Validar(Request $request){
		$id = $request->input('id_acto');
		$actos = Acto::find($id);
		return response()->json([
			"actos"=>$actos
		]);
	}


	public function ValidarTimbreC(Request $request){
		$id = $request->input('id_acto');
		$actos = Acto::find($id);
		$timbrecata = 0;

		$timbrec = $actos->timbrec;

		if($timbrec === true){
			$timbrecata = 1;
		}

		
		return response()->json([
			"timbrecata"=>$timbrecata
		]);
	}
}

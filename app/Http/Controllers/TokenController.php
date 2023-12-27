<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Token;

class TokenController extends Controller
{
	/****TODO:Valida Actos******/
	public function GenerarToken(Request $request){

		$token_all = Token::all();
		foreach ($token_all as $key => $tk) {
			$token = $tk['token_value'];
		}
		
		return response()->json([
			"token"=>$token
		]);
	}
}

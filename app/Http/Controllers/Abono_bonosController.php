<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Abono_bonos;
use App\Bono;
use App\Notaria;

class Abono_bonosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prefijo_fact = Notaria::find(1)->prefijo_fact;
        $id_fact = $request->input('id_fact');
        $abono = $request->input('abono');
        $saldo = $request->saldo;

        $bono_factu = Bono::
        where('id_fact', $id_fact)
        ->where('prefijo', $prefijo_fact)
        ->where('status', false)
        ->get();
         foreach ($bono_factu as $key => $value) {
            $id_bon = $value['id_bon'];
        }

        $Abono_bonos = new Abono_bonos();
        $Abono_bonos->id_bon = $id_bon;
        $Abono_bonos->valor_abono = $abono;
        $Abono_bonos->fecha_abono = date("Y-m-d H:i:s");
        $Abono_bonos->saldo_bon = $saldo;
        $Abono_bonos->usuario = auth()->user()->name;
        $Abono_bonos->save();

        $bono = Bono::find($id_bon);
        $bono->saldo_bon = $request->saldo;
        $bono->save();

      return response()->json([
          "validar"=> "1",
          "mensaje"=> "Muy bien! El abono fue exitoso"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

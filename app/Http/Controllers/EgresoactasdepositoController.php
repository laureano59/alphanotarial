<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notaria;
use App\Egreso_acta_deposito;
use App\Concepto_egreso;
use App\Actas_deposito;
use App\Actas_deposito_view;
use App\Factura;

class EgresoactasdepositoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $Concepto_egreso = Concepto_egreso::all();
      // $Concepto_egreso = $Concepto_egreso->sortBy('concepto'); //TODO:Ordenar por concepto
      $Concepto_egreso = Concepto_egreso::where("id_con",">=",1)->get();
      $Concepto_egreso = $Concepto_egreso->sortBy('concepto');
         return view('actas_deposito.egresos', compact('Concepto_egreso'));
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
        $fecha_manual = Notaria::find(1)->fecha_egreso;
        $fecha_automatica = Notaria::find(1)->fecha_egreso_automatica;
        if ($fecha_automatica == true) {
            $fecha_egreso = date("Y/m/d");
        } else {
            $fecha_egreso = $fecha_manual;
        }

        $opcion = (int) $request->input('opcion');
        if ($opcion === 1) {
            return $this->guardarEgresoConSaldoDesdeBase($request, $fecha_egreso, 1);
        }
        if ($opcion === 2) {
            return $this->guardarEgresoConSaldoDesdeBase($request, $fecha_egreso, 2);
        }

        return response()->json(['validar' => 0, 'mensaje' => 'Opción no válida.']);
    }

    /**
     * El saldo del egreso y el saldo de la acta se calculan siempre en el servidor
     * leyendo actas_depositos.saldo con bloqueo de fila, para evitar cruces con
     * saldo desactualizado (mismo día, pestañas, o confianza en el navegador).
     */
    private function guardarEgresoConSaldoDesdeBase(Request $request, $fecha_egreso, $opcion)
    {
        $notaria = Notaria::find(1);
        $anio_trabajo = $request->anio_fiscal;
        if ($anio_trabajo === '' || $anio_trabajo === null) {
            $anio_trabajo = $notaria->anio_trabajo;
        }

        $id_acta = (int) $request->input('id_acta');
        $descuento = $this->parseMontoEgreso($request->input('descuento'));
        $id_radica = $request->input('id_radica');
        $concepto_egreso = $request->input('concepto_egreso');
        $prefijo = $request->prefijo;
        $id_fact = $request->id_fact;
        $observaciones = $request->observaciones;
        $id_con = $request->id_con;

        if ($opcion === 2 && $id_con == 1) {
            if ($prefijo == '' || $id_fact == '') {
                return response()->json([
                    'validar' => 888,
                    'mensaje' => '!Ups. Para el caso de Escrituras el número de factura es obligatorio.',
                ]);
            }
            if (! Factura::where('prefijo', $prefijo)->where('id_fact', $id_fact)->where('nota_credito', false)->exists()) {
                return response()->json([
                    'validar' => 555,
                    'mensaje' => '!UPS. Es posible que la factura no exista o que tenga nota crédito',
                ]);
            }
        }

        if ($descuento <= 0) {
            return response()->json([
                'validar' => 888,
                'mensaje' => 'El valor del egreso debe ser mayor a cero.',
            ]);
        }

        return DB::transaction(function () use ($request, $fecha_egreso, $anio_trabajo, $opcion, $id_acta, $descuento, $id_radica, $concepto_egreso, $prefijo, $id_fact, $observaciones) {
            $acta = Actas_deposito::where('id_act', $id_acta)->lockForUpdate()->first();
            if (! $acta) {
                return response()->json([
                    'validar' => 888,
                    'mensaje' => 'No se encontró el acta de depósito.',
                ]);
            }
            if ($acta->anulada) {
                return response()->json([
                    'validar' => 888,
                    'mensaje' => 'El acta de depósito está anulada.',
                ]);
            }

            $saldoActual = (float) $acta->saldo;
            if ($descuento > $saldoActual + 0.01) {
                return response()->json([
                    'validar' => 888,
                    'mensaje' => 'El saldo es insuficiente para este descuento.',
                ]);
            }

            $nuevosaldo = round($saldoActual - $descuento, 2);

            $Egreso = new Egreso_acta_deposito();
            $Egreso->fecha_egreso = $fecha_egreso;
            $Egreso->id_con = $concepto_egreso;
            $Egreso->id_radica = $id_radica;
            $Egreso->anio_radica = $anio_trabajo;
            $Egreso->id_act = $id_acta;
            $Egreso->egreso_egr = $descuento;
            $Egreso->saldo = $nuevosaldo;
            $Egreso->usuario = auth()->user()->name;
            if ($opcion === 2) {
                $Egreso->prefijo = $prefijo;
                $Egreso->id_fact = $id_fact;
                $Egreso->observaciones_egr = $observaciones;
            }
            $Egreso->save();

            $acta->saldo = $nuevosaldo;
            $acta->save();

            if ($opcion === 2) {
                $request->session()->put('id_egr', $Egreso->id_egr);

                return response()->json([
                    'validar' => 1,
                    'mensaje' => '!Muy bien. Cruce Exitoso',
                ]);
            }

            return response()->json([
                'validar' => '1',
            ]);
        });
    }

    /**
     * @param mixed $value
     */
    private function parseMontoEgreso($value)
    {
        if ($value === '' || $value === null) {
            return 0.0;
        }
        if (is_string($value)) {
            $value = str_replace([',', ' '], '', $value);
        }

        return round((float) $value, 2);
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

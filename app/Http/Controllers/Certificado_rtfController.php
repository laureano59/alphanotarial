<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificado_rtf;
use App\Notaria;
use App\Ciudad;
use App\Actosclienteradica;
use App\Otorgante;
use App\Cliente;
use App\Liq_recaudo;
use App\Tarifa;
use App\Escritura;


class Certificado_rtfController extends Controller
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
      $notaria = Notaria::find(1);
      //$prefijo_fact = Notaria::find(1)->prefijo_fact;
      $anio_trabajo = $notaria->anio_trabajo;
      $id_ciud = $notaria->id_ciud;
      $ciudad = Ciudad::find($id_ciud);
      $nombre_ciud = $ciudad->nombre_ciud;
      $porcentaje_rtf = (Tarifa::find(11)->valor1)/100;

      $id_radica = $request->session()->get('key');//Obtiene el número de radicación por session
      $Escritura = Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get();
      foreach ($Escritura as $esc) {
        $num_escritura = $esc->num_esc;
      }
      //$num_escritura = $request->session()->get('num_esc');
      $request->session()->put('num_esc', $num_escritura);

      $prefijo_fact = $request->session()->get('prefijo_fact');
      $num_factura = $request->session()->get('numfactura');
      $fecha_factura = $request->session()->get('fecha_fact');
      $fecha_escritura = $request->session()->get('fecha_esc');

      $rtf = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->first(['retefuente']);
      if($rtf->retefuente > 0){
        $totalretencion = $rtf->retefuente;
        $actoscliente_radica = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get();
        foreach ($actoscliente_radica as $acr) {
          if($acr->porcentajecli1 > 0){
            $id_actoperrad = $acr->id_actoperrad;
            $cuantia = $acr->cuantia;
            $identificacion_cli = $acr->identificacion_cli;
            $nombre_cli = $this->Trae_Nombres($identificacion_cli);
            $porcentaje_cli = ($acr->porcentajecli1) / 100;
            $total_retenido_cli = round((($cuantia * $porcentaje_rtf) * $porcentaje_cli));
            $Certificado_rtf = new Certificado_rtf();
            $Certificado_rtf->num_escritura = $num_escritura;
            $Certificado_rtf->id_radica = $id_radica;
            $Certificado_rtf->anio_gravable = $anio_trabajo;
            $Certificado_rtf->identificacion_contribuyente = $identificacion_cli;
            $Certificado_rtf->nombre_contribuyente = $nombre_cli;
            $Certificado_rtf->prefijo = $prefijo_fact;
            $Certificado_rtf->num_factura = $num_factura;
            $Certificado_rtf->fecha_factura = $fecha_factura;
            $Certificado_rtf->valor_venta = $cuantia;
            $Certificado_rtf->total_retenido = $total_retenido_cli;
            $Certificado_rtf->total_retencion = $total_retenido_cli;
            $Certificado_rtf->ciudad = $nombre_ciud;
            $Certificado_rtf->fecha_escritura = $fecha_escritura;
            $Certificado_rtf->save();
            //echo 1;

            /******Cuando hay vendedores adicionales********/
            if($acr->porcentajecli1 < 100 ){
              $vendedores = Otorgante::where('id_actoperrad', $id_actoperrad)->get();
              foreach ($vendedores as $ven) {
                $Certificado_rtf = new Certificado_rtf();
                $Certificado_rtf->num_escritura = $num_escritura;
                $Certificado_rtf->id_radica = $id_radica;
                $Certificado_rtf->anio_gravable = $anio_trabajo;
                $Certificado_rtf->identificacion_contribuyente = $ven->identificacion_cli;
                $Certificado_rtf->nombre_contribuyente = $this->Trae_Nombres($ven->identificacion_cli);
                $Certificado_rtf->prefijo = $prefijo_fact;
                $Certificado_rtf->num_factura = $num_factura;
                $Certificado_rtf->fecha_factura = $fecha_factura;
                $Certificado_rtf->valor_venta = $cuantia;
                $porcentaje_ven = ($ven->porcentaje_otor) / 100;
                $total_retenido_cli = round((($cuantia * $porcentaje_rtf) * $porcentaje_ven));
                $Certificado_rtf->total_retenido = $total_retenido_cli;
                $Certificado_rtf->total_retencion = $total_retenido_cli;
                $Certificado_rtf->ciudad = $nombre_ciud;
                $Certificado_rtf->fecha_escritura = $fecha_escritura;
                $Certificado_rtf->save();
              }
            }
          }

        }
      }//rtf > 0

      $certificado = Certificado_rtf::where('id_radica', $id_radica)->where('anio_gravable', $anio_trabajo)->get()->toArray();

      return response()->json([
        "valida"=>1,
        "certificado_rtf"=>$certificado
       ]);

    }

    private function Trae_Nombres($identificacion){
      $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname");
      $nombre = Cliente::where('identificacion_cli', $identificacion)->select($raw)->get();
      foreach ($nombre as $nom) {
        $nom = $nom->fullname;
      }
      return $nom;
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

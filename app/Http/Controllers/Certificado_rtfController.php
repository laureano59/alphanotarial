<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Ciudad;
use App\Actosclienteradica;
use App\Otorgante;
use App\Cliente;
use App\Liq_recaudo;
use App\Tarifa;
use App\Escritura;
use App\Factura;
use App\Consecutivo_rtf;
use App\Consecutivo;


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
      $anio_trabajo = $notaria->anio_trabajo;
      $consecutivo = Consecutivo::find(1);
      $id_radica = $request->session()->get('key');

      $ordenar = '0';
      $request->session()->put('ordenar', $ordenar);
      
      $Escritura = Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get();
      foreach ($Escritura as $esc) {
        $num_escritura = $esc->num_esc;
      }

      $request->session()->put('num_esc', $num_escritura);
      $rtf = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->first(['retefuente']);      

       if($rtf->retefuente > 0){
          \DB::beginTransaction();
          try {
            
            $consecutivo_certificado_rtf = $consecutivo->certi_retencion_fuente;
            $id_con = $consecutivo_certificado_rtf + 1;
            $consecutivo->certi_retencion_fuente  = $id_con;
            $consecutivo->save();

            $totalretencion = $rtf->retefuente;
            $actoscliente_radica = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get();
             foreach ($actoscliente_radica as $acr) {
              if($acr->porcentajecli1 > 0){
                $id_actoperrad      = $acr->id_actoperrad;
                $cuantia            = $acr->cuantia;
                $identificacion_cli = $acr->identificacion_cli;
                $porcentaje_cli     = $acr->porcentajecli1;
                $Consecutivo_rtf = new Consecutivo_rtf();
                $Consecutivo_rtf->num_esc            = $num_escritura;
                $Consecutivo_rtf->anio_esc           = $anio_trabajo;
                $Consecutivo_rtf->id_con             = $id_con;
                $Consecutivo_rtf->identificacion_cli = $identificacion_cli;
                $Consecutivo_rtf->porcentaje_rtf     = $porcentaje_cli;
                $Consecutivo_rtf->id_radica          = $id_radica;
                $Consecutivo_rtf->save();

                /************Vendores Adicionales**************/
                if($acr->porcentajecli1 < 100 ){
                  $vendedores = Otorgante::where('id_actoperrad', $id_actoperrad)->get();

                  foreach ($vendedores as $ven) {
                    $consecutivo_certificado_rtf = $consecutivo->certi_retencion_fuente;
                    $id_con = $consecutivo_certificado_rtf + 1;
                    $consecutivo->certi_retencion_fuente  = $id_con;
                    $consecutivo->save();

                    $Consecutivo_rtf = new Consecutivo_rtf();
                    $Consecutivo_rtf->num_esc            = $num_escritura;
                    $Consecutivo_rtf->anio_esc           = $anio_trabajo;
                    $Consecutivo_rtf->id_con             = $id_con;
                    $Consecutivo_rtf->identificacion_cli = $ven->identificacion_cli;;
                    $Consecutivo_rtf->porcentaje_rtf     = $ven->porcentaje_otor;
                    $Consecutivo_rtf->id_radica          = $id_radica;
                    $Consecutivo_rtf->save();
                  }

                }
              }
             }

            \DB::commit();

            return response()->json([
              "valida"=>1             
            ]);


          } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                "validar"=> 1,
                'mensaje' => 'Error al guardar consecutivos rtf.', 'error' => $e->getMessage()], 500);
          }

        }    
      

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

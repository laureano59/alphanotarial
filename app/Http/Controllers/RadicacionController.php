<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RadicacionRequest;
use App\Radicacion;
use App\Liq_derecho;
use App\Detalle_liqderecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Factura;
use App\Notaria;
use App\Protocolista;
use App\Acto;
use App\Tipoidentificacion;
use App\Calidad1;
use App\Calidad2;
use App\Departamento;
use App\Facturascajarapida;
Use App\Actividad_economica;
Use App\Notas_credito_factura;

class RadicacionController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      // /*******TODO:Roles de usuario*********/
      // $request->user()->authorizeRoles(['radicacion','administrador']);
      //
      // $AnioTrabajo = Notaria::find(1);
      // $Protocolistas = Protocolista::all();
      // $Actos = Acto::all();
      // return view('radicacion.radicacion', compact('AnioTrabajo', 'Protocolistas', 'Actos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

       /*VALIDA SI HAY FACTURAS PARA ENVIAR A LA DIAN Y SACAR EL MENSAJE*/


       $facturas_dian = Factura::select(\DB::raw("prefijo, id_fact, TO_CHAR(fecha_fact, 'DD-MM-YYYY') AS fecha_fact"))
       ->where('status_factelectronica', '0')
       ->where('fecha_fact', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
       ->get();

       $facturas_dian_cr = Facturascajarapida::select(\DB::raw("prefijo, id_fact, TO_CHAR(fecha_fact, 'DD-MM-YYYY') AS fecha_fact"))
       ->where('status_factelectronica', '0')
       ->where('fecha_fact', '>=', \DB::raw("NOW() - INTERVAL '5 days'"))
       ->get();

       $Fact_Dian = '0';

       if ($facturas_dian->isEmpty()) {
      $Fact_Dian = '0';//No hay facturas para enviar
    } else {
      $Fact_Dian = '1';//Hay facturas para enviar
    }

    $request->session()->put('Fact_Dian', $Fact_Dian);

    $Fact_Dian_cr = '0';

    if ($facturas_dian_cr->isEmpty()) {
      $Fact_Dian_cr = '0';//No hay facturas para enviar
    } else {
      $Fact_Dian_cr = '1';//Hay facturas para enviar
    }

    $request->session()->put('Fact_Dian_cr', $Fact_Dian_cr);



      /*RADICACIÓN*/
      $request->user()->authorizeRoles(['radicacion','administrador']);
      $AnioTrabajo = Notaria::find(1);
      //$Protocolistas = Protocolista::all();
      $Protocolistas = Protocolista::where('estado', true)->get();
      $Actos = Acto::all();
      
      $calidad1 = Calidad1::all();
      $calidad1 = $calidad1->sortBy('nombre_cal1');
      
      $calidad2 = Calidad2::all();
      $calidad2 = $calidad2->sortBy('nombre_cal2');
      
      $Departamentos = Departamento::all();
      $Departamentos = $Departamentos->sortBy('nombre_depa');
      
      $Actividad_economica = Actividad_economica::All();
      $Actividad_economica = $Actividad_economica->sortBy('actividad');

       $TipoIdentificaciones = Tipoidentificacion::all();
       return view('radicacion.create', compact('AnioTrabajo', 'Protocolistas', 'Actos', 'TipoIdentificaciones', 'calidad1', 'calidad2', 'Departamentos', 'Actividad_economica'));
      
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if($request->ajax()){
        $radicacion = new Radicacion();
        $radicacion->anio_radica = $request->input('anio_radica');
        $radicacion->id_proto = $request->input('id_proto');
        $radicacion->id = Auth()->user()->id;
        $radicacion->save();
        return response()->json([
           //"mensaje"=> $request->all()
         "idradica"=> $radicacion->id_radica
       ]);
      }
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

      $anio_radica = $request->anio_radica;
      $id_proto = $request->id_proto;

      $radicacion = Radicacion::where("anio_radica","=",$anio_radica)->find($id);

      $radicacion->id_proto = $request->input('id_proto');
      $radicacion->save();
      return response()->json([
       "validar"=> 1,
       "mensaje"=> "Muy bien!. Se actualizó el protocolista de la radicación"
     ]);
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

    public function Liberar_Radicacion(Request $request){
      $anio_trabajo = Notaria::find(1)->anio_trabajo;
      $id_radica = $request->input('id_radica');

      if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
        if (Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->where('nota_credito', false)->exists()){
          return response()->json([
           "validar"=> "1",
           "mensaje"=> "La radicación ya está Facturada, No es posible liberarla"
         ]);
        }
          $flag = 0;
          $Fact = Factura::
            where('id_radica', $id_radica)
            ->where('anio_radica', $anio_trabajo)
            ->where('nota_credito', true)
            ->get();

            foreach ($Fact as $Factura) {
              $num_fact = $Factura->id_fact;
               if (Notas_credito_factura::
                where('id_fact', $num_fact)
                ->where('status_factelectronica', '0')            
                ->exists()){
                $flag = 1;               
              }
            } 

            if($flag == 1){
               return response()->json([
                  "validar"=> "1",
                  "mensaje"=> "La Nota Crédito referente a la radicación no se ha enviado a la DIAN"
                ]);

        }else{
          //Eliminar liquidación
          $raw = \DB::raw("id_liqd");
          $liqd = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw)->get();
          foreach ($liqd as $lq) {
            $id_liqd = $lq->id_liqd;
          }
          $detalle_liqderecho = Detalle_liqderecho::where("id_liqd","=",$id_liqd);
          $detalle_liqderecho->delete();

          $liq_concepto = Liq_concepto::where("id_radica", "=",$id_radica)->where("anio_radica","=",$anio_trabajo);
          $liq_concepto->delete();

          $liq_recaudo = Liq_recaudo::where("id_radica", "=",$id_radica)->where("anio_radica","=",$anio_trabajo);
          $liq_recaudo->delete();

          $liq_derecho = Liq_derecho::where("id_radica", "=",$id_radica)->where("anio_radica","=",$anio_trabajo);
          $liq_derecho->delete();

          return response()->json([
           "validar"=> "7",
           "mensaje"=> "Muy bien : La radicación se ha liberado Exitosamente"
         ]);


        }

      }else{
        return response()->json([
         "validar"=> "0",
         "mensaje"=> "La radicación no existe"
       ]);
      }

    }
  }

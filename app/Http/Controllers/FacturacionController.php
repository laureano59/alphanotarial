<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipoidentificacion;
use App\Notaria;
use App\Radicacion;
use App\Liq_derecho;
use App\Detalle_liqderecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Principalesfact_view;
use App\Otorgantefact_view;
use App\Comparecientefact_view;
use App\Factura;
use App\Detalle_factura;
use App\Escritura;
use App\Pago;
use App\Departamento;
use App\Concepto;
use App\Banco;
use App\Medios_pago;
use App\Factura_a_cargo_de_view;

class FacturacionController extends Controller
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
      $request->user()->authorizeRoles(['facturacion','administrador']);

      $opcion = $request->session()->get('opcion');//TODO:Session para tipo de factura
      $anio_trabajo = Notaria::find(1)->anio_trabajo;
      $id_radica = $request->session()->get('key');
      $TipoIdentificaciones = Tipoidentificacion::all();
      $Departamentos = Departamento::all();
      $Departamentos = $Departamentos->sortBy('nombre_depa'); //TODO:Ordenar por nombre
      $Banco = Banco::all();
      $Banco = $Banco->Sort();
      
      $MediosdePago = Medios_pago::all();
      $MediosdePago = $MediosdePago->Sort();

        if($opcion == 1){
          /*******TODO:Unica Factura***********/
          if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            $liq_dere = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
            foreach ($liq_dere as $key => $value) {
              $id_liqd = $value['id_liqd'];
            }
            $Conceptos = Concepto::all();
            $Conceptos = $Conceptos->sortBy('id_concep');
             return view('facturacion.facturacionunica', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos', 'Banco', 'MediosdePago'));
            }else{
              	//return redirect('/home');
                return view('/home');
            }
          }else if($opcion == 2){
              /*******TODO:Factura Otorgante Compareciente***********/
              $Conceptos = Concepto::all();
              $Conceptos = $Conceptos->sortBy('id_concep');
              return view('facturacion.facturaotorcompa', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos'));
          }else if($opcion == 3){
              /*******TODO:Factura Multiple***********/
              if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
                $liq_dere = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
                foreach ($liq_dere as $key => $value) {
                  $id_liqd = $value['id_liqd'];
                }
                $Conceptos = Concepto::all();
                $Conceptos = $Conceptos->sortBy('id_concep');
                 return view('facturacion.facturamultiple', compact('TipoIdentificaciones', 'Departamentos', 'Conceptos', 'Banco', 'MediosdePago'));
                }else{
                  	//return redirect('/home');
                    return view('/home');
                }
            }else{//Dafault
                return view('/home');
            }
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
    public function store(Request $request){
      $opcion = $request->session()->get('opcion');//TODO:Session para tipo de factura
      $prefijo_fact = Notaria::find(1)->prefijo_fact;

      if($request->doc_acargo_de == ''){
        $doc_acargo_de = $request->identificacion_cli1;
      }else{
        $doc_acargo_de = $request->doc_acargo_de;
      }

      if($request->detalle_acargo_de == ''){
        $detalle_acargo_de = "Sin datos";
      }else{
        $detalle_acargo_de = $request->detalle_acargo_de;
      }
      
      $fecha_manual = Notaria::find(1)->fecha_fact;
      $fecha_automatica = Notaria::find(1)->fecha_fact_automatica;
      if($fecha_automatica == true){
        $fecha_factura = date("Y-m-d H:i:s");//date("Y/m/d");
      }else if($fecha_automatica == false){
        $fecha_factura = $fecha_manual;
      }

      if($opcion == 1){//TODO:Factura Unica
        $id_radica = $request->input('id_radica');
        $anio_radica = Notaria::find(1)->anio_trabajo;
        if (Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->where('nota_credito', false)->exists()){
          return response()->json([
             "validar"=>0,
             "mensaje"=>"La radicación ya está facturada"
           ]);
        }else{

          if (Factura::where('id_radica', $id_radica)
              ->where('anio_radica', $anio_radica)
              ->where('nota_credito', true)
              ->exists()){

            $fact = Factura::where('id_radica', $id_radica)
                    ->where('anio_radica', $anio_radica)
                    ->where('nota_credito', true)
                    ->get()
                    ->toArray();

            foreach ($fact as $key => $f) {
              $fecha_fact = $f['fecha_fact'];
              //$id_fact_otroperiodo = $f['id_fact_otroperiodo'];
            }

            $fecha_actual = date("Y-m-d");
        
            $periodo_actual = date("Y-m", strtotime($fecha_actual));
            $periodo_factura = date("Y-m", strtotime($fecha_fact));

            $anio_actual = date("Y", strtotime($fecha_actual));
            $anio_fact = date("Y", strtotime($fecha_fact));

            if($anio_actual == $anio_fact){//mismo año
              if($periodo_actual == $periodo_factura){//mismo periodo
                $nota_periodo = 7;
              }else if($periodo_actual != $periodo_factura){//diferente periodo
                $nota_periodo = 0;
                //$id_fact_otroperiodo = 
              }
            }else{//diferente año
              $nota_periodo = 8;
            }
          }else{
            $nota_periodo = 7;
          }

          $factura = new Factura();
          $factura->prefijo = $prefijo_fact;
          $factura->id_radica = $id_radica;
          $factura->anio_radica = $anio_radica;
          $factura->fecha_fact = $fecha_factura;
          $factura->usuario_fact = auth()->user()->name;
          $factura->a_nombre_de = $request->input('identificacion_cli1');
          $factura->total_derechos = $request->input('total_derechos');
          $factura->total_conceptos = $request->input('total_conceptos');
          $factura->total_iva = $request->input('total_iva');
          $factura->total_rtf = $request->input('total_rtf');
          $factura->total_reteconsumo = $request->input('total_reteconsumo');
          $factura->total_aporteespecial = $request->input('total_aporteespecial');
          $factura->total_fondo = $request->input('total_fondo');
          $factura->total_super = $request->input('total_super');
          $factura->total_fact = $request->input('total_fact');
          $factura->deduccion_reteiva = $request->input('reteiva');
          $factura->deduccion_retertf = $request->input('retertf');
          $factura->deduccion_reteica = $request->input('reteica');
          $factura->credito_fact = $request->input('formapago');
          $factura->a_cargo_de = $doc_acargo_de;
          $factura->detalle_acargo_de = $detalle_acargo_de;
          $factura->nota_periodo = $nota_periodo;
                    
          if($request->input('formapago') == 'true' ){
            $factura->dias_credito = 30;
            $factura->saldo_fact = $request->input('total_fact');
          }else if($request->input('formapago') == 'false' ){
            $factura->dias_credito = 0;
            $factura->saldo_fact = 0;
          }
          
          $factura->save();

          $prefijo = $factura->prefijo;
          $num_fact = $factura->id_fact;
          $fecha_fact = $factura->fecha_fact;
          $request->session()->put('numfactura', $num_fact);//Session para factura
          $request->session()->put('fecha_fact', $fecha_fact);//Session para fecha factura
          $request->session()->put('prefijo_fact', $prefijo);

          $pago = new Pago();
          $pago->codigo_ban = $request->input('id_banco');
          $pago->id_fact = $num_fact;
          $pago->prefijo = $prefijo;
          $pago->codigo_med = $request->mediopago;
          $valor = $request->input('valor');
          $valor = str_replace(",", " ", $valor);//TODO:Reemplaza las comas por espacios
          $valor = str_replace(" ", "", $valor);//TODO:elimina los espacios
          $pago->valor = $valor;

          $pago->numcheque = $request->input('numcheque');
          $pago->save();

          return response()->json([
            "validar"=>1,
            "prefijo_fact"=>$prefijo,
            "num_fact"=>$num_fact,
            "fecha_fact"=>$fecha_fact
           ]);
        }
      } else if($opcion == 3){//TODO:Factura Multiple
        $id_radica = $request->input('id_radica');
        $anio_radica = Notaria::find(1)->anio_trabajo;
        if (Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->where('nota_credito', false)->where('factmultiple', false)->exists()){
          return response()->json([
             "validar"=>0,
             "mensaje"=>"La radicación ya está facturada"
           ]);
        }else{

          if (Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->where('nota_credito', true)->exists()){

            $fact = Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->where('nota_credito', true)->get()->toArray();

            foreach ($fact as $key => $f) {
              $fecha_fact = $f['fecha_fact'];
            }

            $fecha_actual = date("Y-m-d");
        
            $periodo_actual = date("Y-m", strtotime($fecha_actual));
            $periodo_factura = date("Y-m", strtotime($fecha_fact));

            $anio_actual = date("Y", strtotime($fecha_actual));
            $anio_fact = date("Y", strtotime($fecha_fact));

            if($anio_actual == $anio_fact){//mismo año
              if($periodo_actual == $periodo_factura){//mismo periodo
                $nota_periodo = 7;
              }else if($periodo_actual != $periodo_factura){//diferente periodo
                $nota_periodo = 0;
              }
            }else{//diferente año
              $nota_periodo = 8;
            }
          }else{
             $nota_periodo = 7;
          }

         

          $factura = new Factura();
          $factura->prefijo = $prefijo_fact;
          $factura->id_radica = $id_radica;
          $factura->anio_radica = $anio_radica;
          $factura->fecha_fact = $fecha_factura;
          $factura->usuario_fact = auth()->user()->name;
          $factura->a_nombre_de = $request->input('identificacion_cli1');
          $factura->total_derechos = $request->input('total_derechos');
          $factura->total_conceptos = $request->input('total_conceptos');
          $factura->total_iva = $request->input('total_iva');
          $factura->total_rtf = $request->input('total_rtf');
          $factura->total_reteconsumo = $request->input('total_reteconsumo');
          $factura->total_fondo = $request->input('total_fondo');
          $factura->total_super = $request->input('total_super');
          $factura->total_aporteespecial = $request->input('total_aporteespecial');
          $factura->total_impuesto_timbre = $request->input('total_impuesto_timbre');
          $factura->total_fact = $request->input('total_fact');
          $factura->deduccion_reteiva = $request->input('reteiva');
          $factura->deduccion_retertf = $request->input('retertf');
          $factura->deduccion_reteica = $request->input('reteica');
          $factura->credito_fact = $request->input('formapago');
          $factura->a_cargo_de = $doc_acargo_de;
          $factura->detalle_acargo_de = $detalle_acargo_de;
          $factura->nota_periodo = $nota_periodo;

          if($request->input('formapago') == 'true' ){
            $factura->dias_credito = 30;
            $factura->saldo_fact = $request->input('total_fact');
          }else if($request->input('formapago') == 'false' ){
            $factura->dias_credito = 0;
            $factura->saldo_fact = 0;
          }

          $factura->save();

          $prefijo = $factura->prefijo;
          $num_fact = $factura->id_fact;
          $fecha_fact = $factura->fecha_fact;
          $request->session()->put('numfactura', $num_fact);//TODO:Session para factura
          $request->session()->put('fecha_fact', $fecha_fact);//TODO:Session para fecha factura
          $request->session()->put('prefijo_fact', $prefijo);
          //-------------------------
          $Conceptos = Concepto::all();
          $Conceptos = $Conceptos->sortBy('id_concep');
          $detalle_fact = new Detalle_factura();
          $detalle_fact->prefijo = $prefijo;
          $detalle_fact->id_fact = $num_fact;

          foreach ($Conceptos as $clave => $valor) {
            $total = 'total'.$valor['atributo'].'iden';
            $totalatributo = 'total'.$valor['atributo'];
            $detalle_fact->$totalatributo = $request->input($total);
          }
          $detalle_fact->save();
          //-------------------------

          $pago = new Pago();
          $pago->codigo_ban = $request->input('id_banco');
          $pago->id_fact = $num_fact;
          $pago->prefijo = $prefijo;
          $pago->codigo_med = $request->mediopago;
          $valor = $request->valor;
          $valor = str_replace(",", " ", $valor);//TODO:Reemplaza las comas por espacios
          $valor = str_replace(" ", "", $valor);//TODO:elimina los espacios
          $pago->valor = $valor;
          $pago->numcheque = $request->input('numcheque');
          $pago->save();

          return response()->json([
            "validar"=>1,
            "prefijo_fact"=>$prefijo,
            "num_fact"=>$num_fact,
            "fecha_fact"=>$fecha_fact
           ]);
        }
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
        $prefijo_fact = Notaria::find(1)->prefijo_fact;
        $factura = Factura::where("prefijo","=",$prefijo_fact)->find($id);
        $opcion = $request->opcion;

        $fecha_actual = date("Y-m-d");
        $fecha_factura = $factura->fecha_fact;

        $periodo_actual = date("Y-m", strtotime($fecha_actual));
        $periodo_factura = date("Y-m", strtotime($fecha_factura));

        $anio_actual = date("Y", strtotime($fecha_actual));
        $anio_factura = date("Y", strtotime($fecha_factura));

        if($anio_actual == $anio_factura){//mismo año
          if($periodo_actual == $periodo_factura){//mismo periodo
            $nota_periodo = 1;
          }else if($periodo_actual != $periodo_factura){//diferente periodo
            $nota_periodo = 0;
          }
        }else{//diferente año
          $nota_periodo = 8;
        }

        if($opcion == 'solocartera'){
          $factura->saldo_fact = $request->nuevosaldo;
          $factura->save();
          return response()->json([
            "validar"=>1,
            "mensaje"=>'Muy bien! Abono realizado'
           ]);

        }else{
          if($factura){
            $id_radica = $factura->id_radica;
            $factura->nota_credito = true;
            $factura->nota_periodo = $nota_periodo;
            $factura->save();
            return response()->json([
              "validar"=>1,
              "id_radica"=>$id_radica
            ]);
          }else{
            return response()->json([
              "validar"=>0,
              "mensaje"=>'Esta Factura no Existe en el Sistema'
            ]);
          }
        }
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

    public function DerechosLiquidados(Request $request){
      if($request->ajax()){
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $id_radica = $request->input('id_radica');
        if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
          $liq_dere = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
          foreach ($liq_dere as $key => $value) {
            $id_liqd = $value['id_liqd'];
          }
          $actos = Detalle_liqderecho::where('id_liqd', $id_liqd)->get()->toArray();
          $liq_conceptos = Liq_concepto::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
          $liq_recaudos = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();

          return response()->json([
            "validarliqd"=> "1",
            "anio"=>$anio_trabajo,
            "actos"=>$actos,
            "conceptos"=>$liq_conceptos,
            "recaudos"=>$liq_recaudos
            ]);

        }else{
          return response()->json([
             "validarliqd"=> "0",
             "mensaje"=>"La radicación no ha sido liquidada"
           ]);
        }
      }

    }

    public function AnombreDe(Request $request){
      if($request->ajax()){
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $id_radica = $request->input('id_radica');

        $raw = \DB::raw("(identificacion_cli1)as id, CONCAT(pmer_nombre_cli1, sgndo_nombre_cli1, pmer_apellido_cli1, sgndo_apellido_cli1, empresa_cli1) as fullname, (autoreteiva_cli1) as autoreteiva, (autoretertf_cli1) as autoretertf, (autoreteica_cli1) as autoreteica, (id_ciud_cli1) as id_ciud, (porcentajecli1) as porcentajertf");
        $principales1 = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw)->get()->toArray();
        $principales1 = $this->unique_multidim_array($principales1,'id');

        $raw2 = \DB::raw("(identificacion_cli2)as id, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as fullname, (autoreteiva_cli2) as autoreteiva, (autoretertf_cli2) as autoretertf, (autoreteica_cli2) as autoreteica, (id_ciud_cli2) as id_ciud");
        $principales2 = Principalesfact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw2)->get()->toArray();
        $principales2 = $this->unique_multidim_array($principales2,'id');

        $principales = array_merge($principales1, $principales2);
        $principales = $this->unique_multidim_array($principales,'id');

        $raw3 = \DB::raw("(identificacion_cli)as id, CONCAT(pmer_nombre_cli, ' ', sgndo_nombre_cli, ' ', pmer_apellido_cli, ' ', sgndo_apellido_cli, empresa_cli) as fullname, autoreteiva, autoretertf, autoreteica, id_ciud, (porcentaje_otor) as porcentajertf");
        $otorgantes = Otorgantefact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw3)->get()->toArray();
        $otorgantes = $this->unique_multidim_array($otorgantes,'id');

        $raw4 = \DB::raw("(identificacion_cli2)as id, CONCAT(pmer_nombre_cli2, ' ', sgndo_nombre_cli2, ' ', pmer_apellido_cli2, ' ', sgndo_apellido_cli2, empresa_cli2) as fullname, (autoreteiva_cli2) as autoreteiva, (autoretertf_cli2) as autoretertf, (autoreteica_cli2) as autoreteica, (id_ciud_cli2) as id_ciud");
        $comparecientes = Comparecientefact_view::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->select($raw4)->get()->toArray();
        $comparecientes = $this->unique_multidim_array($comparecientes,'id');

        $secundarios = array_merge($otorgantes, $comparecientes);
        $secundarios = $this->unique_multidim_array($secundarios,'id');

        $anombrede = array_merge($principales, $secundarios);
        $anombrede = $this->unique_multidim_array($anombrede,'id');

        return response()->json([
          "anombrede"=>$anombrede
          ]);

      }
    }

    public function A_cargo_De(Request $request){
      $num_fact = $request->num_fact;
      $prefijo = $request->prefijo;

      if (Factura::where('prefijo', $prefijo)->where('id_fact', $num_fact)->exists()){
         $factura = Factura_a_cargo_de_view::where('prefijo', $prefijo)
                ->where('id_fact', $num_fact)
                ->get();

      $request->session()->put('factura', $factura);
      return response()->json([
             "validar"=> "7"
           ]);


      }else{
        return response()->json([
             "validar"=> "1",
             "mensaje"=> "La factura ingresada no existe"
           ]);

      }
    
    }

    public function Update_a_cargo_de_Editar(Request $request){
      $identificacion = $request->identificacion;
      $detalle = $request->detalle;

      $Fact = $request->session()->get('factura');

       foreach ($Fact as $value) {
          $prefijo = $value['prefijo'];
          $id = $value['id_fact'];
       }

      $factura = Factura::where("prefijo","=",$prefijo)->find($id);
      $factura->a_cargo_de = $identificacion;
      $factura->detalle_acargo_de = $detalle;
      $factura->save();
      $factura = Factura_a_cargo_de_view::where('prefijo', $factura->prefijo)
                ->where('id_fact', $factura->id_fact)
                ->get();

      $request->session()->put('factura', $factura);

       return response()->json([
             "validar"=> "1",
             "mensaje"=> "Muy bien!. Factura Actualizada"
           ]);

    }

    

/********TODO:Elimina duplicados de un array********/

    private function unique_multidim_array($array, $key) {
      $temp_array = array();
      $i = 0;
      $key_array = array();
      foreach($array as $val) {
          if (!in_array($val[$key], $key_array)) {
              $key_array[$i] = $val[$key];
              $temp_array[$i] = $val;
          }
          $i++;
      }
      return $temp_array;
    }
}

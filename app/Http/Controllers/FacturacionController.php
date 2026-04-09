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
use App\Bono;
use App\Factura_a_cargo_de_view;
use App\Tipo_acta_deposito;
Use App\Actividad_economica;
Use App\Detalle_derechos_factura;
use Illuminate\Support\Facades\DB;
use App\Tarifa;
use App\Acto;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use App\Factura_consecutivo;
use App\Consecutivo_rtf;
use App\Otorgante;
use App\Cliente;
use App\Actosclienteradica;
use App\Actas_deposito_egreso_view;
use App\Egreso_acta_deposito;
use App\Actas_deposito;
use App\Jobs\EnviarFacturaDianJob;
use App\Redondeos;
use App\Http\Controllers\EinvoiceController;

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

      //$TipoDeposito = Tipo_acta_deposito::all();
      //$TipoDeposito = $TipoDeposito->sortBy('descripcion_tip');

     $TipoDeposito = Tipo_acta_deposito::whereIn('id_tip', [5])
                        ->orderBy('descripcion_tip')
                        ->get();

      $Actividad_economica = Actividad_economica::All();
      $Actividad_economica = $Actividad_economica->sortBy('actividad');
      
      //$MediosdePago = Medios_pago::all();
      //$MediosdePago = $MediosdePago->Sort();        
             
          if($opcion == 3){
              /*******TODO:Factura Multiple***********/
              if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
                $liq_dere = Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
                foreach ($liq_dere as $key => $value) {
                  $id_liqd = $value['id_liqd'];
                }
                $Conceptos = Concepto::all();
                $Conceptos = $Conceptos->sortBy('id_concep');
               //facturamultiple
                 return view('facturacion.facturar', compact('id_radica', 'TipoIdentificaciones', 'Departamentos', 'Conceptos', 'Banco', 'TipoDeposito', 'Actividad_economica'));
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
   
   public function store(Request $request)
{
    $notaria      = Notaria::find(1);
    $anio_radica  = $notaria->anio_trabajo;      
    $prefijo_fact = preg_replace('/\s+/', '', $notaria->prefijo_fact);
    $id_radica    = $request->session()->get('key');
    $identificacion_cli = $request->cli_doc;
    $opcion       = 'F1';

    if ($request->ajax()) {

        // 🔹 Obtener intento
        $intento_id = $request->session()->get('intento_id');

        if (!$intento_id) {
            return response()->json([
                "validar" => 0,
                "mensaje" => "No se encontró el intento de factura."
            ]);
        }

        // 🔒 Clave única del intento
        $key = 'factura_' . $id_radica . '_' . $intento_id;

        // 🔍 Revisar estado en cache
        $estado = cache()->get($key);

        if ($estado) {

            if ($estado['status'] === 'terminado') {
                return response()->json($estado['response']);
            }

            if ($estado['status'] === 'procesando') {
                return response()->json([
                    "validar" => 0,
                    "mensaje" => "La factura ya se está procesando, espera un momento..."
                ]);
            }
        }

        // 🔒 Marcar como procesando
        cache()->put($key, [
            'status' => 'procesando'
        ], 30);

        \DB::beginTransaction();

    
        try {

            // 🔹 Guardar factura
            $factura    = $this->save_facturas($request);
            $id_fact    = $factura['id_fact'];
            $fecha_fact = Carbon::parse($factura['fecha_fact'])->format('d/m/Y');
            $rtf        = $factura['rtf'];

            // 🔹 Detalles
            $this->save_detalle_derechos_factura($request->detalle_derechos, $prefijo_fact, $id_fact);
            $this->save_detalle_factura($request->detalle_conceptos, $prefijo_fact, $id_fact);

            // 🔹 Medios de pago
            $this->save_medios_pago(
                $request->efectivo,
                $request->transferencia,
                $request->pse,
                $request->tarjetaCredito,
                $request->tarjetaDebito,
                $request->consignacion_bancaria,
                $request->mediopactadeposito,
                $request->valorBono,
                $prefijo_fact,
                $id_fact
            );

            // 🔹 Bonos
            if ($request->totalBono > 0) {
                $this->save_bonos(
                    $request->valorBono,
                    $request->totalBono,
                    $request->tipoBono,
                    $request->codigo_bono,
                    $prefijo_fact,
                    $id_fact,
                    $id_radica,
                    $anio_radica
                );
            }

            // 🔹 Acta depósito
            if ($request->mediopactadeposito > 0) {
                $this->saveEgresoActaDeposito($request->abonosporactasdeposito, $id_fact, $id_radica);
            }

            // 🔹 Escritura
            if (!Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->exists()) {
                $num_escr = $this->save_escritura($id_radica, $anio_radica);
            } else {
                $num_escr = Escritura::where('id_radica', $id_radica)
                    ->where('anio_radica', $anio_radica)
                    ->value('num_esc');
            }

            // 🔹 RTF
            if ($rtf > 0) {
                $this->save_certificado_rete($id_radica, $num_escr, $anio_radica, $identificacion_cli);
            }

            // 🔹 Número factura
            $num_fact = $prefijo_fact . ' - ' . $id_fact;

            // 🔹 Sesión
            $request->session()->put('numfactura', $id_fact);
            $request->session()->put('fecha_fact', $fecha_fact);
            $request->session()->put('prefijo_fact', $prefijo_fact);

            \DB::commit();

            // 🔹 DIAN
            $requestDian = request();
            $requestDian->merge([
                'num_fact' => $id_fact,
                'opcion'   => $opcion
            ]);

            $controladorDian   = new EinvoiceController();
            $respuestaDian     = $controladorDian->index($requestDian);
            $datosDian         = $respuestaDian->getData(true);

            // 🔹 Respuesta final
            $response = [
                "validar"      => 7,
                "id_fact"      => $num_fact,
                "num_escr"     => $num_escr,
                "fecha_fact"   => $fecha_fact,
                "total_rtf"    => $rtf,
                "mensaje"      => "Se ha generado la factura No. " . $num_fact,
                "dian_status"  => $datosDian['status'] ?? null,
                "dian_mensaje" => $datosDian['mensaje'] ?? null
            ];

            // 🔒 Guardar resultado
            cache()->put($key, [
                'status'   => 'terminado',
                'response' => $response
            ], 60);

            return response()->json($response);

        } catch (Exception $e) {

            \DB::rollback();

            // 🔓 Liberar candado
            cache()->forget($key);

            return response()->json([
                'codigo' => $e->getCode() ?: 500,
                'mensaje' => $e->getMessage(),
                'http_status' => 500
            ], 500);
        }
    }
}



  private function save_detalle_derechos_factura($detalle_derechos, $prefijo_fact, $id_fact)
  {    

    //foreach ($detalle_derechos as $item) {
    foreach (($detalle_derechos ?? []) as $item) {

      $detalle = new Detalle_derechos_factura();

      $detalle->valor_derechos = (float) $item['valor'];
      $detalle->saldo_derechos = (float) $item['valor']; // o tu cálculo
      $detalle->prefijo        = $prefijo_fact;
      $detalle->id_fact        = $id_fact;
      $detalle->id_detalleliqd = (int) $item['id_detalleliqd'];
      $detalle->save();

    }    
  }



  private function save_detalle_factura($detalle_conceptos, $prefijo_fact, $id_fact)
  {

    $detalle = new Detalle_factura();
    $detalle->prefijo = $prefijo_fact;
    $detalle->id_fact = $id_fact;


    //foreach ($detalle_conceptos as $item) {
      foreach (($detalle_conceptos ?? []) as $item) {
        $campo = 'total' . $item['nombre_acto'];

        // Redondear y convertir a número
        $detalle->$campo = round((float) $item['valor'], 0);

      }

    $detalle->save();

  }



  private function save_facturas($request)
  {

    $notaria          = Notaria::find(1);
    $anio_radica      = $notaria->anio_trabajo;
    //$prefijo_fact     = trim($notaria->prefijo_fact);
    $prefijo_fact     = preg_replace('/\s+/', '', $notaria->prefijo_fact);
    $id_radica        = $request->session()->get('key');
    $opcion           = $request->session()->get('opcion');//Session para tipo de factura
    $fecha_manual     = $notaria->fecha_fact;
    $fecha_automatica = $notaria->fecha_fact_automatica;   

    $cli_doc              = $request->cli_doc;
    $doc_acargo_de        = $request->doc_acargo_de;
    $detalle_acargo_de    = $request->detalle_acargo_de; 
    $cli_nombre           = $request->cli_nombre;
    $detalle_derechos     = $request->detalle_derechos  ?? [];
    $detalle_conceptos    = $request->detalle_conceptos  ?? [];
    $detalle_recaudos     = $request->detalle_recaudos  ?? [];
    $detalle_deducciones  = $request->detalle_deducciones  ?? [];
    $total_deducciones    = $request->total_deducciones;   
    $subtotal             = (int) round((float) $request->subtotal);//$request->subtotal;
    $total_iva            = (int) round((float) $request->total_iva);//$request->total_iva;
    $total_recaudos       = $request->total_recaudos;
    $total_all            = $request->total_all;


    //$total_iva  = (int) round((float) $total_iva);
    $total_fact = (int) $total_all;//(int) round((float) $total_all);

    // 1️⃣ Convertir SIEMPRE a boolean real
    $creditoFact = (bool) $request->forma_pago;
    // 2️⃣ Si viene algo raro o vacío, lo manejas (opcional pero recomendado)
    $creditoFact = $creditoFact ?? false;

     /*Forma de pago, validación para cartera*/
    if($creditoFact === true ){
      $dias_credito = 30;
      $saldo_fact   = $total_fact; 
      $creditoFact  = 'true';       
    }else if($creditoFact === false ){
        $dias_credito = 0;
        $saldo_fact   = 0;
        $creditoFact  = 'false'; 
    } 
   
    
    if (blank($doc_acargo_de)) {
      $doc_acargo_de = $cli_doc;
    }

            
    if($fecha_automatica == true){
         $fecha_factura = date("Y-m-d H:i:s");//date("Y/m/d");
    }else if($fecha_automatica == false){
            $fecha_factura = $fecha_manual;
    }

    /***********************Valida el periodo de la factura****************************/

    $hoy = Carbon::today();
    $escritura = Escritura::where('id_radica', $id_radica)
    ->where('anio_radica', $anio_radica)
    ->first();

    // Caso 1: No existe escritura (primera vez)
    if (!$escritura) {
      $nota_periodo = 7;
    } else {
      $fecha_esc = Carbon::parse($escritura->fecha_esc);
      // Caso 2: Existe escritura
      if ($fecha_esc->year != $hoy->year) {
          // Año diferente
          $nota_periodo = 8;
      } elseif ($fecha_esc->format('Y-m') === $hoy->format('Y-m')) {
          // Mismo año y mismo periodo
          $nota_periodo = 7;
      } else {
        // Mismo año pero distinto periodo
        $nota_periodo = 0;
      }
    }   

        
    /*Autonumerico*/   
    $consecutivo = $this->getConsecutivoFactura('Factura', $prefijo_fact);

    
   
   
    /*Derechos notariales*/
    $derechos = 0;
    foreach ($detalle_derechos as $item) {
      $derechos += (float) $item['valor'];
    }
    $derechos = (int) $derechos;//round($derechos);

    
    /*Conceptos*/
    $conceptos = 0;
    foreach ($detalle_conceptos as $item) {
      $conceptos += (float) $item['valor'];
    }
    $conceptos = (int) $conceptos;//round($conceptos);

   
    /*Recaudos*/
    $recaudos = [];
    foreach ($detalle_recaudos as $reca) {
      // Validar que exista el campo destino
      if (empty($reca['nombre_campo_fact'])) {
          continue;
      }

    $campo_reca = $reca['nombre_campo_fact'];
    // Valor numérico redondeado
    $recaudos[$campo_reca] = (float) $reca['valor']; //round((float) $reca['valor']);
    }

    $camposRecaudos = [
      'total_rtf',
      'total_fondo',
      'total_super',
      'total_aporteespecial',
      'total_impuesto_timbre',
      'total_timbrec',
    ];
   

    /*Deducciones*/
   $deducciones = [];
  foreach ($detalle_deducciones as $dedu) {
    if (empty($dedu['campo_fact'])) {
        continue;
    }   

    $campo_dedu = $dedu['campo_fact'];
   
    // Valor numérico redondeado
    $deducciones[$campo_dedu] = (int) $dedu['valor'];//round((float) $dedu['valor']);    
  }

  $camposDeducciones = [
    'deduccion_reteiva',
    'deduccion_reteica',
    'deduccion_retertf',
  ];

  

    $factura = new Factura();
    $factura->prefijo               = $prefijo_fact;
    $factura->id_fact               = $consecutivo;
    $factura->id_radica             = $id_radica;
    $factura->anio_radica           = $anio_radica;
    $factura->fecha_fact            = $fecha_factura;
    $factura->usuario_fact          = auth()->user()->name;
    $factura->a_nombre_de           = $cli_doc;   
    $factura->total_derechos        = $derechos;
    $factura->total_conceptos       = $conceptos;
    $factura->total_iva             = $total_iva;
    $factura->total_fact            = $total_fact;
    $factura->nota_credito          = false;
    $factura->credito_fact          = $creditoFact;
    $factura->dias_credito          = $dias_credito;
    $factura->saldo_fact            = $saldo_fact;
    
    foreach ($camposRecaudos as $campre) {
      $factura->$campre = $recaudos[$campre] ?? 0;      
    }    

    foreach ($camposDeducciones as $campde) {
      $factura->$campde = $deducciones[$campde] ?? 0;       
    }  
   
    $factura->a_cargo_de            = $doc_acargo_de;
    $factura->detalle_acargo_de     = $detalle_acargo_de;
    $factura->nota_periodo          = $nota_periodo;   

    $factura->save();

    
    return [
        'id_fact'      => $factura->id_fact,
        'fecha_fact'   => $factura->fecha_fact,
        'rtf'          => $factura->total_rtf,
    ];

  }

  private function save_medios_pago($efectivo, $transferencia, $pse, $tarjetaCredito, $tarjetaDebito,
                                    $consignacion_bancaria, $mediopactadeposito, $valorBono, $prefijo_fact,  $id_fact)
  {

    $pago = new Pago();
    $pago->prefijo = $prefijo_fact;
    $pago->id_fact = $id_fact;

    $pago->efectivo               = round((float) $efectivo, 0);
    $pago->pse                    = round((float) $pse, 0);
    $pago->transferencia_bancaria = round((float) $transferencia, 0);
    $pago->tarjeta_credito        = round((float) $tarjetaCredito, 0);
    $pago->tarjeta_debito         = round((float) $tarjetaDebito, 0);
    $pago->consignacion_bancaria  = round((float) $consignacion_bancaria, 0);
    $pago->acta_deposito          = round((float) $mediopactadeposito, 0);
    $pago->bono                   = round((float) $valorBono, 0);

    $pago->save();


  }

  private function save_bonos($valorBono, $totalBono, $tipoBono, $codigo_bono, $prefijo_fact, $id_fact,  
                              $id_radica, $anio_radica)
  {

    $bono = new Bono();
    $bono->codigo_bono  = $codigo_bono; // Asumo que este es el código
    $bono->id_fact      = $id_fact;
    $bono->prefijo      = $prefijo_fact;
    $bono->id_radica    = $id_radica;
    $bono->anio_radica  = $anio_radica;
    $bono->valor_bon    = round((float) $valorBono, 0);
    $bono->saldo_bon    = round((float) $totalBono, 0);
    $bono->id_tip       = $tipoBono;
    $bono->usuario      = auth()->user()->name;
    $bono->save();

  }
  

  private function save_escritura($id_radica, $anio_radica): int
  {

     $notaria = Notaria::find(1);
     $fecha_manual     = $notaria->fecha_fact;
     $fecha_automatica = $notaria->fecha_fact_automatica;

      if($fecha_automatica == true){
          $fecha_escritura = date("Y-m-d H:i:s");//date("Y/m/d");
      }else if($fecha_automatica == false){
                $fecha_escritura = $fecha_manual;
      }    

        /*Autonumerico*/   
      $consecutivo = $this->getConsecutivoFactura('Escritura', '0');
       
      $escritura = new Escritura();
      $escritura->num_esc     = $consecutivo;
      $escritura->anio_esc    = $anio_radica;
      $escritura->id_radica   = $id_radica;
      $escritura->anio_radica = $anio_radica;
      $escritura->fecha_esc   = $fecha_escritura;
      $escritura->save();
      $num_esc = $escritura->num_esc;
      $fecha_esc = $escritura->fecha_esc;          

      return $num_esc;

  }

  private function saveEgresoActaDeposito($abonosporactasdeposito, $id_fact, $id_radica)
  {  

     $notaria = Notaria::find(1);
     $fecha_manual     = $notaria->fecha_fact;
     $fecha_automatica = $notaria->fecha_fact_automatica;
     $anio_trabajo     = $notaria->anio_trabajo;
     $prefijo_fact     = preg_replace('/\s+/', '', $notaria->prefijo_fact);
     
      if($fecha_automatica == true){
          $fecha_egreso = date("Y/m/d");
      }else if($fecha_automatica == false){
                $fecha_egreso = $fecha_manual;
      }  
     
      $concepto_egreso = 1;

     foreach (($abonosporactasdeposito ?? []) as $item) {
        
        $id_acta    = $item['id_acta'];
        $descuento  = round((float) $item['descuento'], 0);
        $nuevosaldo = round((float) $item['saldo'], 0);       
       
        $concepto_egreso = 1;
       
        $Egreso = new Egreso_acta_deposito();
        $Egreso->fecha_egreso = $fecha_egreso;
        $Egreso->id_con       = $concepto_egreso;
        $Egreso->id_radica    = $id_radica;
        $Egreso->anio_radica  = $anio_trabajo;
        $Egreso->id_act       = $id_acta;
        $Egreso->egreso_egr   = $descuento;
        $Egreso->saldo        = $nuevosaldo;
        $Egreso->usuario      = auth()->user()->name;
        $Egreso->prefijo      = $prefijo_fact;
        $Egreso->id_fact      = $id_fact;
        $Egreso->save();


        $actas_deposito = Actas_deposito::find($id_acta);
        $actas_deposito->saldo = $nuevosaldo;
        $actas_deposito->save();        

      }


         


  }
  

  private function save_certificado_rete($id_radica, $num_escr, $anio_radica, $identificacion_cli)
  {
    $existe = Consecutivo_rtf::where('num_esc', $num_escr)
        ->where('anio_esc', $anio_radica)
        ->where('identificacion_cli', $identificacion_cli)
        ->exists();

    if (!$existe) {

        $actoscliente_radica = Actosclienteradica::where('id_radica', $id_radica)
            ->where('anio_radica', $anio_radica)
            ->get();

        foreach ($actoscliente_radica as $acr) {

            if ($acr->porcentajecli1 > 0) {

                $id_actoperrad      = $acr->id_actoperrad;
                $identificacion_cli = $acr->identificacion_cli;
                $porcentaje_cli     = $acr->porcentajecli1;

                try {

                    /*Autonumerico*/
                    $consecutivo = $this->getConsecutivoFactura('Consecutivo_rtf', '0');

                    $Consecutivo_rtf = new Consecutivo_rtf();
                    $Consecutivo_rtf->num_esc            = $num_escr;
                    $Consecutivo_rtf->anio_esc           = $anio_radica;
                    $Consecutivo_rtf->id_con             = $consecutivo;
                    $Consecutivo_rtf->identificacion_cli = $identificacion_cli;
                    $Consecutivo_rtf->porcentaje_rtf     = $porcentaje_cli;
                    $Consecutivo_rtf->id_radica          = $id_radica;
                    $Consecutivo_rtf->save();

                } catch (\Illuminate\Database\QueryException $e) {

                    // 🔥 Si es duplicado (PK), lo ignoramos
                    if ($e->getCode() == 23505) {
                        continue;
                    }

                    // ❌ Otro error sí debe escalar
                    throw $e;
                }

                /************ VENDEDORES ADICIONALES **************/
                if ($acr->porcentajecli1 < 100) {

                    $vendedores = Otorgante::where('id_actoperrad', $id_actoperrad)->get();

                    foreach ($vendedores as $ven) {

                        try {

                            /*Autonumerico*/
                            $consecutivo = $this->getConsecutivoFactura('Consecutivo_rtf', '0');

                            $Consecutivo_rtf = new Consecutivo_rtf();
                            $Consecutivo_rtf->num_esc            = $num_escr;
                            $Consecutivo_rtf->anio_esc           = $anio_radica;
                            $Consecutivo_rtf->id_con             = $consecutivo;
                            $Consecutivo_rtf->identificacion_cli = $ven->identificacion_cli;
                            $Consecutivo_rtf->porcentaje_rtf     = $ven->porcentaje_otor;
                            $Consecutivo_rtf->id_radica          = $id_radica;
                            $Consecutivo_rtf->save();

                        } catch (\Illuminate\Database\QueryException $e) {

                            if ($e->getCode() == 23505) {
                                continue;
                            }

                            throw $e;
                        }
                    }
                }
            }
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
            $status_fact = $factura->status_factelectronica;
            if($status_fact == '1'){
              $id_radica = $factura->id_radica;
              $factura->nota_credito = true;
              $factura->nota_periodo = $nota_periodo;
              $factura->save();
              return response()->json([
                "validar"=>1,
                "id_radica"=>$id_radica
              ]);
            }else if($status_fact == '0'){
              return response()->json([
                "validar"=>7,
                "mensaje"=>'Esta Factura no tiene CUFE'
              ]);
            }
           
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
      // Verificar si el usuario tiene el rol de administrador
      if (!$request->user()->hasRole('administrador')) {
            return response()->json([
              "validar"=> "8",
              "mensaje"=> "Acceso denegado. No tienes permiso para realizar esta acción."
            ]);
      }

      // Si el usuario tiene el rol de administrador, continuar con la lógica del controlador
      $num_fact = $request->num_fact;
      $prefijo = $request->prefijo;

      if (Factura::where('prefijo', $prefijo)
          ->where('id_fact', $num_fact)->exists()){
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




 public function SumaSaldosDerechos(Request $request){

    $id_liq = $request->id_liq;

    $saldo = Detalle_derechos_factura::where('id_detalleliqd', $id_liq)
    ->where('status_nc', false)
    ->sum('valor_derechos');

    return response()->json([
             "saldo"=> $saldo            
            ]); 

 }

 public function SumaSaldosConceptos(Request $request)
{
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $prefijo_fact = $notaria->prefijo_fact;

    $conceptos_liq = $request->input('conceptos', []);
    $id_radica = $request->session()->get('key');

    // Blindaje 1: si no hay conceptos
    if (!is_array($conceptos_liq) || empty($conceptos_liq)) {
        return response()->json([
            'saldos' => []
        ]);
    }

    $resultados = []; //Blindaje 2: inicializar

    foreach ($conceptos_liq as $value) {

        // Blindaje 3: estructura válida
        if (
            !isset($value['atributo'], $value['total']) ||
            $value['atributo'] === ''
        ) {
            continue;
        }

        $concepto_factu  = 'total' . $value['atributo'];
        $conceptos_saldo = 'saldo' . $value['atributo'];
        $valor_liq = (float) $value['total'];

        try {
            $valor = DB::table('facturas as f')
                ->join('detalle_facturas as d', function ($join) {
                    $join->on('f.prefijo', '=', 'd.prefijo')
                         ->on('f.id_fact', '=', 'd.id_fact');
                })
                ->where('f.id_radica', $id_radica)
                ->where('f.anio_radica', $anio_trabajo)
                ->where('f.prefijo', $prefijo_fact)
                ->where('f.nota_credito', false)
                ->sum(DB::raw("COALESCE(d.$concepto_factu, 0)"));

            $resultados[$conceptos_saldo] = $valor_liq - (float)$valor;

        } catch (\Throwable $e) {
            // Blindaje 4: si una columna no existe, no tumba todo
            $resultados[$conceptos_saldo] = $valor_liq;
        }
    }

    return response()->json([
        "saldos" => $resultados
    ]);
}



 

 public function SumaSaldosRecaudos(Request $request){

  $notaria = Notaria::find(1);
  $anio_trabajo = $notaria->anio_trabajo;
  $prefijo_fact = $notaria->prefijo_fact;
  $recaudos_liq = $request->recaudos_liq;  

  $num_fact = $request->session()->get('numfactura');
  $id_radica = $request->session()->get('key');

  // Consulta correcta (prefijo bien usado)
  $totales = Factura::where('prefijo', $prefijo_fact)    
    ->where('id_radica', $id_radica)
    ->where('anio_radica', $anio_trabajo)
    ->where('nota_credito', false)
    ->selectRaw('
        COALESCE(SUM(total_rtf), 0)                AS total_rtf,
        COALESCE(SUM(total_fondo), 0)              AS total_fondo,
        COALESCE(SUM(total_super), 0)              AS total_super,
        COALESCE(SUM(total_aporteespecial), 0)     AS total_aporteespecial,
        COALESCE(SUM(total_impuesto_timbre), 0)    AS total_impuesto_timbre,
        COALESCE(SUM(total_timbrec), 0)            AS total_timbrec
    ')
    ->first();

  
  // Inicializar resultado
  $resultado = [];

  $liq = $recaudos_liq[0];

  $resultado['saldoretefuente'] =
    (float)($liq['retefuente'] ?? 0)
    - (float)($totales->total_rtf ?? 0);

  $resultado['saldorecasuper'] =
    (float)($liq['recsuper'] ?? 0)
    - (float)($totales->total_super ?? 0);

  $resultado['saldorecafondo'] =
    (float)($liq['recfondo'] ?? 0)
    - (float)($totales->total_fondo ?? 0);

  $resultado['saldoaportespecial'] =
    (float)($liq['aporteespecial'] ?? 0)
    - (float)($totales->total_aporteespecial ?? 0);

  $resultado['saldoimpuestotimbr'] =
    (float)($liq['impuestotimbre'] ?? 0)
    - (float)($totales->total_impuesto_timbre ?? 0);

  $resultado['saldotimbreca'] =
    (float)($liq['timbrec'] ?? 0)
    - (float)($totales->total_timbrec ?? 0);
  

  return response()->json([
             "saldos"=> $resultado           
           ]);

 }

 

 public function CalcularIva_Derechos(Request $request){    

    $porcentaje = (Tarifa::find(9)->valor1)/100;
    $iva = 0;

     $id_acto       = $request->id_acto;
     $valor         = $request->valor;
     $conporcentaje = $request->conporcentaje;
     $idDetalle     = $request->idDetalle;

    
    if($conporcentaje == 1){
      $derechos = Detalle_liqderecho::where('id_detalleliqd', $idDetalle)    
      ->value('derechos');

      $valor = $valor / 100;
      $derechos = $derechos * $valor;
      $valor = $derechos;

    }       

     $Acto = Acto::find($id_acto);

     $flash_iva = $Acto->iva;

     if($flash_iva == true){
       $iva = $valor * $porcentaje;
       $iva = $iva;


     }elseif($flash_iva == false){
       $iva = 0;
     }     


     return response()->json([
             "iva"=> $iva,
             "valor" =>$valor        
           ]);
    
 }
 

 public function CalcularIvaConceptos(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;  

    $porcentaje = (Tarifa::find(9)->valor1)/100;
    $iva = 0;

     $valor         = $request->valor;
     $conporcentaje = $request->conporcentaje;
     $concepto      = $request->concepto;
     $atributo      = 'total'.$concepto;
     $id_radica     = $request->session()->get('key');     

    
    if($conporcentaje == 1){
      $concepto_liq = Liq_concepto::
      where('id_radica', $id_radica) 
      ->where('anio_radica', $anio_trabajo)   
      ->value($atributo);

      $valor = $valor / 100;
      $valor_concepto = $concepto_liq * $valor;
      $valor = $valor_concepto;
    }  

     
       $iva = $valor * $porcentaje;
       $iva = $iva;     


     return response()->json([
             "iva"=> $iva,
             "valor" =>$valor        
           ]);

 }


  public function Validaciones(Request $request){
    $notaria = Notaria::find(1);
    $anio_trabajo = $notaria->anio_trabajo;
    $id_radica = $request->session()->get('key');

    $derechos  = $request->detalle_derechos ?? [];
    $conceptos = $request->detalle_conceptos ?? [];
    $recaudos  = $request->detalle_recaudos ?? [];


    $request->session()->put('intento_id', generarIntentoId());//Genera sesion para evitar doble facturación  
    
   
    $alertas = [];


    foreach ($recaudos as $item) {

      $campoFactura = $item['nombre_campo_fact']; // ej: total_rtf
      $campoLiq     = $item['nombre_campo_liq'];  // ej: retefuente
      $valorArray   = (float) $item['valor'];

      // 1️⃣ SUMA en Factura
      $sumaFactura = 
          Factura::where('id_radica', $id_radica)
              ->where('anio_radica', $anio_trabajo)
              ->where('nota_credito', false)
              ->sum($campoFactura);
          

      // 2️⃣ SUMA + valor del array
      $totalComparar = $sumaFactura + $valorArray;

      // 3️⃣ CONSULTA Liq_recaudo (registro único)
      $valorLiqRecaudo = 
          Liq_recaudo::where('id_radica', $id_radica)
              ->where('anio_radica', $anio_trabajo)
              ->value($campoLiq); 

      // 4️⃣ COMPARACIÓN FINAL
      
      $rango = $totalComparar - $valorLiqRecaudo;


      $round_reca = Redondeos::find(3)->valor;
      $round_reca = (float) $round_reca / 100;

      //if ($totalComparar > $valorLiqRecaudo) {
        if ($rango >= $round_reca) {

          $alertas[] = [
              'nombre_acto' => $item['nombre_acto'],
              'mensaje' => 'El valor acumulado del recaudo supera el total permitido según la liquidación registrada.'
          ];
      }
  }  


    foreach ($conceptos as $con) {

      $nombreActo = $con['nombre_acto'];
      $campoTotal = 'total' . $nombreActo;
      $valorArray = round((float) $con['valor'], 0);


      // 1️⃣ SUMA desde Factura + Detalle_factura
      $sumaFacturas = round(
          Factura::join('detalle_facturas', function ($join) {
                  $join->on('facturas.prefijo', '=', 'detalle_facturas.prefijo')
                       ->on('facturas.id_fact', '=', 'detalle_facturas.id_fact');
              })
              ->where('facturas.id_radica', $id_radica)
              ->where('facturas.anio_radica', $anio_trabajo)
              ->where('facturas.nota_credito', false)
              ->sum("detalle_facturas.$campoTotal"),
          0
      );



      // 2️⃣ SUMA + valor del array
      $totalComparar = $sumaFacturas + $valorArray;

      // 3️⃣ CONSULTA Liq_concepto
      $valorLiqConcepto = round(
          Liq_concepto::where('id_radica', $id_radica)
              ->where('anio_radica', $anio_trabajo)
              ->value($campoTotal),
          0
      );
   

      // 4️⃣ COMPARACIÓN FINAL
       $rango = $totalComparar - $valorLiqConcepto;

      $round_conc = Redondeos::find(2)->valor;
      $round_conc = (float) $round_conc / 100;

      //if ($totalComparar > $valorLiqConcepto) {
        if ($rango >= $round_conc) {

          $alertas[] = [
              'nombre_acto' => ucfirst($nombreActo),
              'mensaje' => 'El valor acumulado del concepto supera el total permitido según la liquidación registrada.'
          ];
      }
  }



    foreach ($derechos as $der) {

        $idDetalle  = $der['id_detalleliqd'];
        $valorArray = (float) $der['valor'];

        // Suma Detalle_derechos_factura
        $sumaDerechosFactura = Detalle_derechos_factura::
        where('id_detalleliqd', $idDetalle)
        ->where('status_nc', false)
        ->sum('valor_derechos');

        $totalDerechos = $sumaDerechosFactura + $valorArray;

        // Suma Detalle_liqderechos
        $sumaLiqDerechos = Detalle_liqderecho::where('id_detalleliqd', $idDetalle)
                ->sum('derechos');


        // Validación
         $rango = $totalDerechos - $sumaLiqDerechos;


        $round_dere = Redondeos::find(1)->valor;
        $round_dere = (float) $round_dere / 100;


        //if ($totalDerechos > $sumaLiqDerechos) {
         if ($rango >= $round_dere) {

          $alertas[] = [
            'nombre_acto' => $der['nombre_acto'],
            'mensaje' => 'La suma de los derechos asociados a este acto excede el valor total liquidado para el mismo.'
          ];
        }
    }

    if (count($alertas) > 0) {
      // Hay errores → se devuelven las alertas
      return response()->json([
        'status' => 'warning',
        'alertas' => $alertas
      ], 200);

    } else {


      /*******************Si los derechos, los conceptos y los recaudos están en orden*******************/
      /************entonces validamos si hay actas de deposito y luego continiua con lo demás***********/

      $identificacion_cli = $request->identificacion;
       

      $actas_deposito = Actas_deposito_egreso_view::where('identificacion_cli', $identificacion_cli)
                          ->where('anulada', '<>', true)
                          ->where('id_tip', 2)
                          ->where('deposito_escrituras', '>', 0)
                          ->select(
                          'id_act',
                          \DB::raw("to_char(fecha_acta, 'DD/MM/YYYY') as fecha_acta"),
                          'proyecto',
                          'descripcion_tip as tipo_deposito',
                          'identificacion_cli',
                          'id_egr',
                          'deposito_escrituras',
                          'deposito_boleta',
                          'deposito_registro',
                          'deposito_act',
                          'saldo',
                          // 🔥 AQUÍ AGREGAMOS LA SUMA AGRUPADA
                          \DB::raw("
                          SUM(egreso_egr) OVER (
                          PARTITION BY id_act, identificacion_cli
                          ) as total_egresos_por_acta
                          ")
                          )
                          ->orderBy('id_act')
                          ->get();

          //var_dump($actas_deposito);
          if(count($actas_deposito) >= 1){           
               $actas = '1';                           
          }else{
            $actas = '0';
          }



      // TODO correcto en TODOS los ítems
      return response()->json([
        'status'          => 'ok',
        'actas'           => $actas,
        'actas_deposito'  =>  $actas_deposito,
        'mensaje'         => 'Todos los actos fueron validados correctamente. No se encontraron inconsistencias en los valores de derechos.'
      ], 200);
    }
   
    
  }


  private function getConsecutivoFactura(string $modelo, string $prefijo): int
  {

    $modelo  = trim($modelo);
    $prefijo = trim($prefijo);

    // blindaje extra
    $prefijo = preg_replace('/\s+/', '', $prefijo);

    return \DB::transaction(function () use ($modelo, $prefijo) {       

        $row = Factura_consecutivo::where('modelo', $modelo)
            ->where('prefijo', $prefijo)           
            ->lockForUpdate()
            ->first();
      

        if (!$row) {
            $row = new Factura_consecutivo();
            $row->modelo      = $modelo;
            $row->prefijo     = $prefijo;           
            $row->consecutivo = 1;
            $row->save();
            return 1;
        }

         

      $row->consecutivo++;
      $row->consecutivo = (int) $row->consecutivo;
      $row->save();
       

        return $row->consecutivo;
    });
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


/**********Intendo para evitar doble factura***********/
function generarIntentoId()
{
    // Fecha y hora: YYYYMMDDHHMMSS
    $fecha = date('YmdHis');

    // Número aleatorio (0 - 9999)
    $random = mt_rand(0, 9999);

    return $fecha . '_' . $random;
}

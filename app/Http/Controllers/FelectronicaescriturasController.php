<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use App\Notaria;
use App\Actosclienteradica;
use App\Otorgante;
use App\Actoscuantia;
use App\derechos_view;
use App\Cliente;
use App\Radicacion;
use App\Protocolista;
use App\Principales_radica;
use App\Notario;
use App\Principalesfact_view;
use App\Factura;
use App\Escritura;
use App\Detalle_factura;
use App\Liq_derecho;
use App\Liq_concepto;
use App\Liq_recaudo;
use App\Detalle_liqderecho;
use App\Certificado_rtf;
use App\Actas_deposito_view;
use App\Concepto;
use App\Notas_credito_factura;
use App\Detalle_notas_debito;
use App\Notas_debito_factura;
use App\Cajadiariogeneral_view;
use App\Cruces_actas_deposito_view;
use App\Estadisticonotarial_view;
use App\Estadisticonotarial_unicas_view;
use App\Estadisticonotarial_repetidas_view;
use App\Estadisticonotarial_repetidas_solo_radi_view;
use App\Info_cliente_factura_electronica_view;
use App\Pago;
use App\Medios_pago;
use App\Tarifa;
use App\Services\Dian\XmlBuilder\FacturaXmlBuilder;
use Illuminate\Support\Facades\File;

class FelectronicaescriturasController extends Controller
{
    public function Envio_FE(Request $request)
    {
        // Notaría y datos generales
        $notaria = Notaria::find(1);
        $prefijo_fact = trim($notaria->prefijo_fact);
        $numfact = $request->num_fact;
        $nit = $notaria->nit;
        $digito_verifi_n13 =  $notaria->digito_verificacion;
        $nombre_nota = strtoupper($notaria->nombre_nota);
        $nombre_comercial = $notaria->nombre_comercial;
        $direccion_nota = $notaria->direccion_nota;
        $ciudad = $notaria->ciudad;
        $codigo_ciudad = $notaria->id_ciud;
        $departamento = $notaria->departamento;
        $codigo_departamento = $notaria->codigo_departamento;
        $responsabilidad_fiscal = $notaria->responsabilidad_fiscal;
        $IdSoftware = $notaria->SoftwareId;    // CORREGIDO: variable correcta
        $pinfactDian = $notaria->pin;          // CORREGIDO: variable correcta
        $resolucion = $notaria->resolucion;
        $NumDesde = trim($notaria->numiniciofact);
        $NumHasta = trim($notaria->numfinfact);
        $StarFecha = $notaria->fecha_iniciofact;
        $EndFecha = $notaria->fecha_finfact;





        // Tipo de documento
        if (isset($request->opcion) && $request->opcion === 'NC') {
            $tipo_documento = '91'; // nota crédito
            $documentType = 'CreditNote';
        } elseif (isset($request->opcion) && $request->opcion === 'ND') {
            $tipo_documento = '92'; // nota débito
            $documentType = 'DebitNote';
        } else {
            $tipo_documento = '01'; // factura
            $documentType = 'Invoice';
        }
       

        # =============================================
        # =           DATOS DE LA FACTURA             =
        # =============================================
        
        $factura = Factura::where('prefijo', $prefijo_fact)
                          ->where('id_fact', $numfact)
                          ->first();

        if (! $factura) {
            
            return response()->json(['error' => 'Factura no encontrada'], 404);
        }

        $fecha_fact             = Carbon::parse($factura->fecha_fact)->format('Y-m-d');
        $fecha_fact_completa    = $factura->fecha_fact;
        $hora_fact              = Carbon::parse($factura->fecha_fact)->format('H:i:s');
        $StarPeriodo            = Carbon::parse($fecha_fact)->firstOfMonth()->format('Y-m-d');
        $EndPeriodo             = Carbon::parse($fecha_fact)->endOfMonth()->format('Y-m-d');

        $identificacioncli  = $factura->a_nombre_de;
        $TipodePago         = $factura->credito_fact;
        $TotalFactura       = $factura->total_fact;
        $TotalDerechos      = $factura->total_derechos;
        $TotalConceptos     = $factura->total_conceptos;
        $TotalIva           = $factura->total_iva;
        $TotalRtf           = $factura->total_rtf;
        $TotalReteIva       = $factura->deduccion_reteiva;
        $TotalReteIca       = $factura->deduccion_reteica;
        $TotalReteRtf       = $factura->deduccion_retertf;
        $TotalFondo         = $factura->total_fondo;
        $TotalSuper         = $factura->total_super;
        $AporteEspecial     = $factura->total_aporteespecial;
        $ImpuestoTimbre     = $factura->total_impuesto_timbre;
        $total_timbrec      = $factura->total_timbrec;
        $id_radica          = $factura->id_radica;
        $comentarios_fact   = $factura->comentarios_fact;
        $diascredito_fact   = $factura->dias_credito;
        $nota_credito       = $factura->nota_credito;
        $anio_trabajo       = $factura->anio_radica;

        $TotalAntesdeIva = $TotalDerechos + $TotalConceptos;

        $TipoPago = $TipodePago ? '2' : '1';
        
        $paymentmethod = 10;

        // 1. Tomamos la fecha original de la factura:
        $issueDate = Carbon::parse($fecha_fact);

        // 2. Determinamos si es crédito o contado
        $isCredit = (bool) $TipodePago;

        // 3. Calculamos la fecha de vencimiento:
        if ($isCredit) {
            $paymentDueDate = $issueDate->copy()->addDays(30)->format('Y-m-d');
        } else {
            $paymentDueDate = $issueDate->format('Y-m-d'); // contado
        }

        # =============================================
        # =           INFORMACIÓN DEL CLIENTE         =
        # =============================================

        $infocliente = Info_cliente_factura_electronica_view::where('identificacion_cli', $identificacioncli)->first();
        if ($infocliente) {
            $nombre_cliente                 = $infocliente->nombre_cli;
            $pmer_nombre                    = $infocliente->pmer_nombrecli;
            $sgdo_nombre                    = $infocliente->sgndo_nombrecli;
            $pmer_apellido                  = $infocliente->pmer_apellidocli;
            $sgdo_apellido                  = $infocliente->sgndo_apellidocli;
            $telefono_cliente               = $infocliente->telefono_cli;
            $direccion_cliente              = $infocliente->direccion_cli;
            $email_cliente                  = $infocliente->email_cli;
            $CodPostalCiud_cliente          = $infocliente->id_ciud;
            $CodPostalDepartamento_cliente  = $infocliente->id_depa;
            $CodPostalPais_cliente          = $infocliente->id_pais;
            $NombreCiud_cliente             = $infocliente->nombre_ciud;
            $NombreDepartamento_cliente     = $infocliente->nombre_depa;
            $NombrePais_cliente             = $infocliente->nombre_pais;
            $Tipo_identificacion            = $infocliente->id_tipoident;
            $digito_verif                   = $infocliente->digito_verif;
        } else {
            
            $nombre_cliente = $direccion_cliente = $telefono_cliente = $email_cliente = null;
            $CodPostalCiud_cliente = $CodPostalDepartamento_cliente = $CodPostalPais_cliente = null;
            $NombreCiud_cliente = $NombreDepartamento_cliente = $NombrePais_cliente = null;
            $Tipo_identificacion = $digito_verif = null;
        }

        #===============================================
        #   Porcentajes y valores de tarifas
        #===============================================
        $IVA = Tarifa::find(9);
        $iva = $IVA ? (float) $IVA->valor1 : 0.0; 
        $PorcentIva = round($iva / 100, 2);      

        $ReteIca = Tarifa::find(27);
        $PorcentReteIca = $ReteIca ? round($ReteIca->valor1 / 10, 2) : 0.0; // para expresarlo en %

        $ReteIva = Tarifa::find(26);
        $PorcentReteIva = $ReteIva ? round($ReteIva->valor1 * 100, 2) : 0.0;

        $ReteRtf = Tarifa::find(28);
        $PorcentReteRtf = $ReteRtf ? round($ReteRtf->valor1 * 100, 2) : 0.0;

        # =============================================
        # =           DETALLE DE LA FACTURA           =
        # =============================================

        $conceptos_mul = Detalle_factura::where('id_fact', $numfact)->get()->toArray();
        $atributos = Concepto::orderBy('id_concep')->get();

        $detalles = [];
        $contador = 1;

        // Agregar el total de Derechos como primer detalle
        if (isset($TotalDerechos) && $TotalDerechos > 0) {
            $detalles[] = [
                'conteo'      => $contador,
                'item_id'     => $contador,
                'descripcion' => 'Derechos',
                'qtyship'     => 1,
                'price'       => $TotalDerechos
            ];
            $contador++;
        }

        foreach ($conceptos_mul as $conc) {
            foreach ($atributos as $atri) {
                $atributoNombre = $atri->nombre_concep;
                $campoTotal = 'total' . $atri->atributo;

                if (!empty($conc[$campoTotal]) && $conc[$campoTotal] > 0) {
                    $detalles[] = [
                        'conteo'      => $contador,
                        'item_id'     => $contador,
                        'descripcion' => $atributoNombre,
                        'qtyship'     => 1,
                        'price'       => $conc[$campoTotal]
                    ];
                    $contador++;
                }
            }
        }


        # =============================================
        # =              IMPUESTOS IVA                =
        # =============================================

        $impuestos = [];
        $contador = 1;
        $Iva_global = 0;

        foreach ($detalles as $item) {
            $concepto = $item['descripcion'];
            $total    = $item['price'];
            $tieneIva = ($concepto !== 'Registro_Civil');
            $Iva_global += $tieneIva ? ($total * $PorcentIva) : 0.00;

            $impuestos[] = [
                'id'     => $contador,
                'item'   => $contador,
                'codigo' => "01",
                'rate'   => $tieneIva ? $iva : 0.00,
                'name'   => "IVA",
                'base' => $total,
                'amount'   => $tieneIva ? ($total * $PorcentIva) : 0.00,
            ];
            $contador++;
        }

       

        # =============================================
        # =             OTROS CARGOS                  =
        # =============================================

        $otroscargos = [];

        $listaCargos = [
            ['name' => 'Retencion en la Fuente', 'monto' => $TotalRtf],
            ['name' => 'Super',                  'monto' => $TotalSuper],
            ['name' => 'Fondo',                  'monto' => $TotalFondo],
            ['name' => 'Aporte especial',        'monto' => $AporteEspecial],
            ['name' => 'Impuesto timbre',        'monto' => $ImpuestoTimbre],
            ['name' => 'Timbre Decreto 175',     'monto' => $total_timbrec],
        ];

        foreach ($listaCargos as $c) {
            if (!empty($c['monto']) && $c['monto'] > 0) {
                $otroscargos[] = [
                    'name'      => $c['name'],
                    'base'      => $c['monto'],
                    'amount'    => $c['monto'],
                    'indicator' => "true"
                ];
            }
        }

        # =============================================
        # =               DEDUCCIONES                 =
        # =============================================
        
        $deducciones = [];

        if ($TotalReteIva > 0) {
            $deducciones[] = [
                "name" => "Rete Iva",
                "tax"  => $TotalReteIva,
                "base" => $Iva_global,//$TotalIva,
                "rate" => $PorcentReteIva,
                "id"   => "05"
            ];
        }

        if ($TotalReteIca > 0) {
            $deducciones[] = [
                "name" => "Rete Ica",
                "tax"  => $TotalReteIca,
                "base" => $TotalAntesdeIva,
                "rate" => $PorcentReteIca,
                "id"   => "07"
            ];
        }

        if ($TotalReteRtf > 0) {
            $deducciones[] = [
                "name" => "Rete Fuente",
                "tax"  => $TotalReteRtf,
                "base" => $TotalAntesdeIva,
                "rate" => $PorcentReteRtf,
                "id"   => "06"
            ];
        }

        

        # =============================================
        # =            ARMAR ESTRUCTURA FINAL         =
        # =============================================


        $todo = [
            'encabezado' => [
                'prefijo'           => $prefijo_fact,
                'numero'            => $numfact,
                'fecha'             => $fecha_fact,
                'hora'              => $hora_fact,
                'fecha_completa'    => $fecha_fact_completa,
                'pago'              => $TipoPago,           // 1 contado, 2 crédito
                'medio_pago'        => $paymentmethod,      // 10 o 48
                'payment_due_date'  => $paymentDueDate,     // fecha de vencimiento
                'inicio_periodo'    => $StarPeriodo,
                'fin_periodo'       => $EndPeriodo,
                'notas'             => $comentarios_fact,
                'invoice_type_code' => $tipo_documento,     // 01, 91, 92
            ],

            'empresa' => [
                'nit'                    => $nit,
                'dv_empresa'             =>$digito_verifi_n13,
                'nombre'                 => $nombre_nota,
                'nombre_comercial'       => $nombre_comercial,
                'direccion'              => $direccion_nota,
                'ciudad'                 => $ciudad,
                'codigo_ciudad'          => $codigo_ciudad,
                'departamento'           => $departamento,
                'codigo_departamento'    => $codigo_departamento,
                'responsabilidad_fiscal' => $responsabilidad_fiscal,
                'software_id'            => $IdSoftware,
                'pin'                    => $pinfactDian,
                'resolucion' => [
                    'numero'       => $resolucion,
                    'desde'        => $NumDesde,
                    'hasta'        => $NumHasta,
                    'fecha_inicio' => $StarFecha,
                    'fecha_fin'    => $EndFecha,
                ],
            ],

            'cliente' => [
                'id'                  => $identificacioncli,
                'dv'                  => $digito_verif,
                'tipo_doc'            => $Tipo_identificacion,
                'nombre'              => $nombre_cliente,
                'direccion'           => $direccion_cliente,
                'telefono'            => $telefono_cliente,
                'email'               => $email_cliente,
                'ciudad'              => $NombreCiud_cliente,
                'codigo_ciudad'       => $CodPostalCiud_cliente,
                'departamento'        => $NombreDepartamento_cliente,
                'codigo_departamento' => $CodPostalDepartamento_cliente,
                'pais'                => $NombrePais_cliente,
            ],

            'totales' => [
                'subtotal_sin_iva' => $TotalAntesdeIva,
                'iva'              => $Iva_global,//$TotalIva,
                'reteiva'          => $TotalReteIva,
                'reteica'          => $TotalReteIca,
                'retertf'          => $TotalReteRtf,
                'total_factura'    => $TotalFactura,
            ],

            'detalle'     => $detalles,
            'impuestos'   => $impuestos,
            'otroscargos' => $otroscargos,
            'deducciones' => $deducciones,
        ];



        // 1. Construir XML
        $builder = new FacturaXmlBuilder();        
        $xml = $builder->generarXML($todo, $documentType);

       
        // =====================================
        // GUARDAR XML EN MODO DESARROLLO
        // =====================================
       /* $dir = storage_path('app/XML');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0775, true);
        }

$filename = "{$todo['encabezado']['prefijo']}{$todo['encabezado']['numero']}_{$documentType}_DEV.xml";
File::put($dir . DIRECTORY_SEPARATOR . $filename, $xml);*/

// -------------------------------------
// Aquí después dejamos el validador
// -------------------------------------     

        // 2. VALIDAR XSD (antes de guardar el archivo)
        $validator = new \App\Services\Dian\XsdValidator\DianXsdValidator();
        $resp = $validator->validate($xml, $documentType);
        dd($resp);

        if (!$resp['success']) {

            // Si falla, retornamos los errores sin guardar nada
            return response()->json([
                'status'  => 'ERROR_XSD',
                    'mensaje' => 'La validación XSD falló. El XML no cumple la estructura DIAN.',
                'errores' => $resp['errors']
            ], 422);
        }

        // 3. SI LLEGÓ AQUÍ = XML VÁLIDO → guardarlo
        $dir = storage_path('app/XML');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0775, true);
        }

        $filename = "{$todo['encabezado']['prefijo']}{$todo['encabezado']['numero']}_{$documentType}.xml";
        File::put($dir . DIRECTORY_SEPARATOR . $filename, $xml);

        // (opcional) guardar ruta BD en factura_electronica
        // FacturaElectronica::create([...]);

        return response($xml, 200)->header('Content-Type', 'application/xml');


    }
}

<?php

namespace App\Exports;

//use App\Retencionesaplicadas_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Detalle_factura;
use App\Notascredito_facturas_interfaz_view;
use App\Concepto;
use App\Conceptos_cajarapida;
use App\Cuentas_adicionales;
use Carbon\Carbon;

class ExcelDataXExportNC implements FromCollection,WithHeadings
{
    private $fecha1;
    private $fecha2;

    public function __construct($fecha1, $fecha2, $conEncabezado) 
    {
        $this->fecha1           = $fecha1;
        $this->fecha2           = $fecha2;
        $this->conEncabezado    = $conEncabezado;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {

       
        if (!$this->conEncabezado) {        
            return []; // sin encabezado
        }

        return [
            'CÓDIGO EMPRESA',
            'C.U',
            'TIPO FOLDER/COMPROBANTE',
            'NÚMERO FOLDER',
            'FECHA FACTURA',
            'CUENTA',
            'TERCERO',
            'TIPO DOCUMENTO',
            'NUMERO DOCUMENTO',
            'TIPO TRANSACION',
            'VALOR',
            'DETALLE 1',
            'DETALLE 2',
            'CENTRO DE COSTOS',
            'DOCUMENTO BANCO',
            'DOCUMENTO CRUCE',
            'NUMERO DOC CRUCE',
            'NUM CUOTA',
            'FECHA VENCIMIENTO',
            'NIT TERCERO',
            'NOMRE/RAZON SOCI.',
            'TIPO IDENT.',
            'DIRECCION',
            'TELEFONOS',
            'APARTADO AEREO',
            'REPRE LEGAL',
            'COD CIUDAD DIAN',
            'ZONA',
            'COD VENDEDOR',
            'SOCIO',
            'EMPLEADO',
            'CLIENTE',
            'PROVEEDOR',
            'ACREEDOR',
            'EXTERIOR',
            'INTERNO',
            'OTROS',
            'DIAS CREDITO',
            'CUPO',
            'NUM REGISTRO',
            'CU 2',
        ];
    }
    
    public function collection()
    {

        $fecha1 = $this->fecha1;
        $fecha2 = $this->fecha2;

        
            /***************************************************/
            /*            CONSULTA FACTURA ESCRI               */
            /***************************************************/                    

        $FacturasEscr = Notascredito_facturas_interfaz_view::select([
            'prefijo',
            'id_fact',
            'usuario_fact',
            'fecha_fact',
            'prefijo_ncf',
            'id_ncf',
            'fecha_ncf',
            'a_nombre_de',
            'total_derechos',
            'total_conceptos',
            'total_iva',
            'total_rtf',
            'total_reteconsumo',
            'total_fondo',
            'total_super',
            'total_impuesto_timbre',
            'total_timbrec',
            'total_fact',
            'credito_fact',
            'deduccion_reteiva',
            'deduccion_reteica',
            'deduccion_retertf',
            'nota_credito',
            'diascredito',
            'status_factelectronica',
            'a_cargo_de',
            'efectivo',
            'consignacion_bancaria',
            'pse',
            'transferencia_bancaria',
            'tarjeta_credito',
            'tarjeta_debito',
            'bono',
            'identificacion_cli',
            'nombre_cli',
            'identificacion_cli2',
            'nombre_cli2',
            'telefono_cli',
            'direccion_cli',
            'email_cli',   
            'id_tipoident',
            'digito_verif',
            'id_ciud'
        	])->whereDate('fecha_ncf', '>=', $fecha1)
        		->whereDate('fecha_ncf', '<=', $fecha2)        
        		->get();
           

        $atributos = Concepto::all();
        $atributos = $atributos->sortBy('id_concep');
        $data[] = [];

        $i = 1;     


        $cuenta_cont_derechos = Cuentas_adicionales::
             where('id_cue', 28)->value('cuenta_contab');


        $CodigoEmpresa = Cuentas_adicionales::
             where('id_cue', 18)->value('cuenta_contab');

        $CU = Cuentas_adicionales::
             where('id_cue', 19)->value('cuenta_contab');

        $TIPOFOLDER = Cuentas_adicionales::
             where('id_cue', 20)->value('cuenta_contab');

        $NUMFOLDER_ESCR_NC = Cuentas_adicionales::
             where('id_cue', 22)->value('cuenta_contab');

        $TIPODOCUMENTO_ESCR_NC = Cuentas_adicionales::
             where('id_cue', 33)->value('cuenta_contab');

        $DOCUMENTO_CRUCE_ESCR_NC = Cuentas_adicionales::
             where('id_cue', 35)->value('cuenta_contab');


        foreach ($FacturasEscr as $Fesc) {


             $cod_ciud = "169";
            
            $detalle_Fesc = Detalle_factura::
            where('id_fact', $Fesc->id_fact)
            ->where('prefijo', $Fesc->prefijo)
            ->get()->toArray();
            
            $j = 1;

             $cod_ciud = $cod_ciud . $Fesc->id_ciud;            

             $Fecha_credito = Carbon::parse($Fesc->fecha_fact)
                      ->addDays(30)                
                      ->format('Y-m-d H:i:s');
                     
            if ($Fesc->total_derechos > 0){
                if ($Fesc->credito_fact == true){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_derechos, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_derechos), '', '', '', '', '', '', '', $Fecha_credito, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                }elseif ($Fesc->credito_fact == false){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_derechos, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_derechos), '', '', '', '', '', '', '', $Fesc->fecha_ncf, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                }
            }
            



            /***************************************************/
            /*                   ITEM FACTURA                  */
            /***************************************************/

            $j = $j + 1;//Para Item de conceptos

            foreach ($detalle_Fesc as $key => $detfes) {
                foreach ($atributos as $key => $atri) {
                    $atributo = $atri['nombre_concep'];
                    $totalatributo = 'total'.$atri['atributo'];
                    
                    if($detfes[$totalatributo] > 0){
                        $dataconcept[$j]['concepto'] = $atributo;
                        $dataconcept[$j]['cuenta'] = $atributo;//revisar logica
                        $cuenta_cont = Concepto::where('nombre_concep', $atributo)
                        ->value('cuenta_contab_nc');

                        $dataconcept[$j]['total'] = $detfes[$totalatributo];
                        $j = $j + 1;

                        if ($Fesc->credito_fact == true){

                        $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', $detfes[$totalatributo], '', '', '', '', '', '', '', $Fecha_credito,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                         }elseif ($Fesc->credito_fact == false){

                             $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', $detfes[$totalatributo], '', '', '', '', '', '', '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                         }                        
                       
                    } //if
                }//for atributos              
            }//for detalle_Fesc

            
            /***************************************************/
            /*               ITEM TERCEROS FACTURA             */
            /***************************************************/
            
             $cuenta_cont_recau_fond = Cuentas_adicionales::
             where('concepto', 'Recaudo Fondo')->value('cuenta_contab');

            $cuenta_cont_recau_sup = Cuentas_adicionales::
             where('concepto', 'Recaudo Super')->value('cuenta_contab');

           
             $cuenta_cont_iva_escr = Cuentas_adicionales::
             where('id_cue', 29)->value('cuenta_contab');

             $cuenta_a_credito = Cuentas_adicionales::
             where('concepto', 'CLIENTE- CUENTA POR COBRAR CAJA RAP')->value('cuenta_contab');

            $cuenta_contado = Cuentas_adicionales::
             where('concepto', 'CAJA GENERAL- CONTADO- EFECTIVO ESCR')->value('cuenta_contab');

             $cuenta_banco = Cuentas_adicionales::
             where('concepto', 'BANC DAVIVIEND CTA UNIC CONTAD - TANSF-DATAF-CONSG')->value('cuenta_contab');

              $cuenta_deduc_iva = Cuentas_adicionales::
             where('concepto', 'Deducion de IVA-Impuesto a las ventas retenido')->value('cuenta_contab');

             $cuenta_deduc_ica = Cuentas_adicionales::
             where('concepto', 'Deduci de ICA-Impuesto de Industr y Comerc Ret')->value('cuenta_contab');

             $cuenta_deduc_rtf = Cuentas_adicionales::
             where('concepto', 'Deducion de Rtf-Honorarios 11%')->value('cuenta_contab');

              $cuenta_rtf = Cuentas_adicionales::
             where('concepto', 'Enajenacion de act.fij.de personas n RTE-FTE')->value('cuenta_contab');

             $cuenta_timbre1 = Cuentas_adicionales::where('concepto', 'Timbre 1')->value('cuenta_contab');
             $cuenta_timbre2 = Cuentas_adicionales::where('concepto', 'Timbre 2 Catatumbo')->value('cuenta_contab');


             if ($Fesc->total_fondo > 0){
                 $j = $j + 1;//para Recaudo Fondo

                if ($Fesc->credito_fact == true){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_recau_fond, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', $Fesc->total_fondo, '', '', '', '', '', '', '', $Fecha_credito,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                }elseif ($Fesc->credito_fact == false){

                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_recau_fond, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', $Fesc->total_fondo, '', '', '', '', '','', '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
                }

             }

            
             if ($Fesc->total_super > 0){
                $j = $j + 1;//para Recaudo Super            

                if ($Fesc->credito_fact == true){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_recau_sup, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', $Fesc->total_super, '', '', '', '', '', '', '', $Fecha_credito, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                }elseif ($Fesc->credito_fact == false){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_recau_sup, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', $Fesc->total_super, '', '', '', '', '', '', '', $Fesc->fecha_ncf, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                }
             }

             
             if($Fesc->total_iva > 0){
                 $j = $j + 1;//para IVA            

                if ($Fesc->credito_fact == true){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_iva_escr, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_iva), '', '', '', '', '', '', '', $Fecha_credito, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                }elseif ($Fesc->credito_fact == false){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_cont_iva_escr, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_iva), '', '', '', '', '', '', '', $Fesc->fecha_ncf, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
                }
             }

            

             
        
        if($Fesc->total_rtf > 0){
            $j = $j + 1;//para Retefuente
             if ($Fesc->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_rtf, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_rtf), '', '', '', '', '', '', '', $Fecha_credito,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fesc->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_rtf, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_rtf), '', '', '', '', '', '', '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }
        }

        if($Fesc->total_impuesto_timbre > 0){
            $j = $j + 1;//para Impuesto timbre
             if ($Fesc->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_timbre1, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_impuesto_timbre), '', '', '', '', '', '', '', $Fecha_credito,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fesc->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_timbre1, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_impuesto_timbre), '', '', '', '', '', '', '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }
        }


        if($Fesc->total_timbrec > 0){
            $j = $j + 1;//para Impuesto timbre
             if ($Fesc->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_timbre2, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_timbrec), '', '', '', '', '', '', '', $Fecha_credito,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fesc->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_timbre2, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'D', round($Fesc->total_timbrec), '', '', '', '', '', '', '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }
        }

        
            /***************************************************/
            /*         ITEM FACTURA DEDUCCIONES                */
            /***************************************************/

        if($Fesc->deduccion_reteiva > 0){
            $j = $j + 1;//para IVA            

            if ($Fesc->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_deduc_iva, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->deduccion_reteiva), '', '', '', '', '', '', '', $Fecha_credito, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fesc->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_deduc_iva, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->deduccion_reteiva), '', '', '', '', '', '', '', $Fesc->fecha_ncf, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }


        }        

      
        if($Fesc->deduccion_reteica > 0){
             $j = $j + 1;//para IVA            

            if ($Fesc->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_deduc_ica, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->deduccion_reteica), '', '', '', '', '', '', '', $Fecha_credito, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fesc->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_deduc_ica, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->deduccion_reteica), '', '', '', '', '', '', '', $Fesc->fecha_ncf, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
            }

        }
        if($Fesc->deduccion_retertf > 0){
             $j = $j + 1;//para IVA            

            if ($Fesc->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_deduc_rtf, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->deduccion_retertf), '', '', '', '', '', '', '', $Fecha_credito, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fesc->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_deduc_rtf, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->deduccion_retertf), '', '', '', '', '', '', '', $Fesc->fecha_ncf, $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }

        }


        /*************************************************************/
        /***********************TOTALES*******************************/       
          
        if ($Fesc->credito_fact == true){ //Si es a credito
            $j = $j + 1;
            $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_a_credito, $Fesc->a_cargo_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->total_fact), '', '', '', '', $DOCUMENTO_CRUCE_ESCR_NC,  $Fesc->id_fact, '', $Fecha_credito,  $Fesc->a_cargo_de, $Fesc->nombre_cli2, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);


        }else if ($Fesc->credito_fact == false){ 

            $total_medios_pago = $Fesc->consignacion_bancaria +
            $Fesc->pse +
            $Fesc->transferencia_bancaria +
            $Fesc->tarjeta_credito +
            $Fesc->tarjeta_debito;          


            if($total_medios_pago > 0){
                if( $Fesc->efectivo > 0){                    
                    $j = $j + 1; //Para efectivo
            
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_contado, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->efectivo), '', '', '', '', $DOCUMENTO_CRUCE_ESCR_NC, $Fesc->id_fact, '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                     $j = $j + 1; //Para la suma de otros medios depago

                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_banco, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($total_medios_pago), '', '', '', '', $DOCUMENTO_CRUCE_ESCR_NC, $Fesc->id_fact, '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
                }else{

                     $j = $j + 1; //Para la suma de otros medios depago                       


                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_banco, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($total_medios_pago), '', '', '', '', $DOCUMENTO_CRUCE_ESCR_NC, $Fesc->id_fact, '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                }

            }else{

                $j = $j + 1; //Para solo efectivo
            
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_ESCR_NC, $Fesc->fecha_ncf, $cuenta_contado, $Fesc->a_nombre_de, $TIPODOCUMENTO_ESCR_NC, $Fesc->id_ncf, 'C', round($Fesc->total_fact), '', '', '', '', $DOCUMENTO_CRUCE_ESCR_NC, $Fesc->id_fact, '', $Fesc->fecha_ncf,  $Fesc->a_nombre_de, $Fesc->nombre_cli, $Fesc->id_tipoident, $Fesc->direccion_cli, $Fesc->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }
        }

            $i = $i + 1;                  
        }//for FacturasEscr       


        $Informe = collect($data)->map(function ($item) { 
            return collect($item)->map(function ($subItem) {
                if (!empty($subItem['FECHA_FACTURA'])) {
                    $subItem['FECHA_FACTURA'] = \Carbon\Carbon::parse($subItem['FECHA_FACTURA'])->format('Ymd');
                }
                if (!empty($subItem['FECHA_VENCIMIENTO'])) {
                    $subItem['FECHA_VENCIMIENTO'] = \Carbon\Carbon::parse($subItem['FECHA_VENCIMIENTO'])->format('Ymd');
                }
                return $subItem;
            })->toArray();
        });

        return $Informe;
       

    }

     public function cargar_informe(&$data, $codigo_empresa, $c_u, $tipo_folder_comprobante,
            $número_folder, $fecha_factura, $cuenta, $tercero, $tipo_documento,
            $numero_documento, $tipo_transacion, $valor, $detalle_1, $detalle_2,
            $centro_de_costos, $documento_banco, $documento_cruce, $numero_doc_cruce,
            $num_cuota, $fecha_vencimiento, $nit_tercero, $nomre_razon_soci,
            $tipo_ident, $direccion, $telefonos, $apartado_aereo, $repre_legal,
            $cod_ciudad_dian, $zona, $cod_vendedor, $socio, $empleado, $cliente,
            $proveedor, $acreedor, $exterior, $interno, $otros, $dias_credito, 
            $cupo, $num_registro, $cu_2, $i, $j)
    {        
          

            $data[$i][$j]['CÓDIGO EMPRESA']             =   $codigo_empresa;
            $data[$i][$j]['C.U']                        =   $c_u;
            $data[$i][$j]['TIPO FOLDER/COMPROBANTE']    =   $tipo_folder_comprobante;
            $data[$i][$j]['NÚMERO FOLDER']              =   $número_folder;
            $data[$i][$j]['FECHA_FACTURA']              =   $fecha_factura;
            $data[$i][$j]['CUENTA']                     =   $cuenta;                   
            $data[$i][$j]['TERCERO']                    =   $tercero;
            $data[$i][$j]['TIPO DOCUMENTO']             =   $tipo_documento;
            $data[$i][$j]['NUMERO DOCUMENTO']           =   $numero_documento;
            $data[$i][$j]['TIPO TRANSACION']            =   $tipo_transacion;        
            $data[$i][$j]['VALOR']                      =   $valor;
            $data[$i][$j]['DETALLE 1']                  =   $detalle_1;
            $data[$i][$j]['DETALLE 2']                  =   $detalle_2;
            $data[$i][$j]['CENTRO DE COSTOS']           =   $centro_de_costos;
            $data[$i][$j]['DOCUMENTO BANCO']            =   $documento_banco;
            $data[$i][$j]['DOCUMENTO CRUCE']            =   $documento_cruce;
            $data[$i][$j]['NUMERO DOC CRUCE']           =   $numero_doc_cruce;
            $data[$i][$j]['NUM CUOTA']                  =   $num_cuota;
            $data[$i][$j]['FECHA_VENCIMIENTO']          =   $fecha_vencimiento; 
            $data[$i][$j]['NIT TERCERO']                =   $nit_tercero;   
            $data[$i][$j]['NOMRE/RAZON SOCI.']          =   $nomre_razon_soci;
            $data[$i][$j]['TIPO IDENT.']                =   $tipo_ident;   
            $data[$i][$j]['DIRECCION']                  =   $direccion;   
            $data[$i][$j]['TELEFONOS']                  =   $telefonos;
            $data[$i][$j]['APARTADO AEREO']             =   $apartado_aereo;
            $data[$i][$j]['REPRE LEGAL']                =   $repre_legal;
            $data[$i][$j]['COD CIUDAD DIAN']            =   $cod_ciudad_dian;
            $data[$i][$j]['ZONA']                       =    $zona;
            $data[$i][$j]['COD VENDEDOR']               =   $cod_vendedor;
            $data[$i][$j]['SOCIO']                      =   $socio;
            $data[$i][$j]['EMPLEADO']                   =   $empleado;
            $data[$i][$j]['CLIENTE']                    =   $cliente;
            $data[$i][$j]['PROVEEDOR']                  =   $proveedor;
            $data[$i][$j]['ACREEDOR']                   =   $acreedor;
            $data[$i][$j]['EXTERIOR']                   =   $exterior;
            $data[$i][$j]['INTERNO']                    =   $interno;
            $data[$i][$j]['OTROS']                      =   $otros;
            $data[$i][$j]['DIAS CREDITO']               =   $dias_credito;
            $data[$i][$j]['CUPO']                       =   $cupo;
            $data[$i][$j]['NUM REGISTRO']               =   $num_registro;
            $data[$i][$j]['CU 2']                       =   $cu_2;

          
    }
}
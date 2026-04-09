<?php

namespace App\Exports;

//use App\Retencionesaplicadas_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Detalle_cajarapidafacturas;
use App\Factura_cajarapida_interfaz_view;
use App\Conceptos_cajarapida;
use App\Cuentas_adicionales;
use Carbon\Carbon;

class ExcelDataXExportCJ implements FromCollection,WithHeadings
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

        $Facturascajarapida = Factura_cajarapida_interfaz_view::select([
            'prefijo',
            'id_fact',
            'usuario_fact',
            'fecha_fact',
            'a_nombre_de',
            'total_iva',
            'total_fact',
            'credito_fact',
            'deduccion_reteiva',
            'deduccion_reteica',
            'deduccion_retertf',
            'nota_credito',
            'dias_credito',
            'status_factelectronica',
            'efectivo',
            'consignacion_bancaria',
            'pse',
            'transferencia_bancaria',
            'tarjeta_credito',
            'tarjeta_debito',
            'identificacion_cli',
            'nombre_cli',
            'telefono_cli',
            'direccion_cli',
            'email_cli',   
            'id_tipoident',
            'digito_verif',
            'id_ciud'
        	])->whereDate('fecha_fact', '>=', $fecha1)
        		->whereDate('fecha_fact', '<=', $fecha2)        
        		->get();
           

        $atributos = Conceptos_cajarapida::all();
        $atributos = $atributos->sortBy('id_concep');

        $CodigoEmpresa = Cuentas_adicionales::
             where('id_cue', 18)->value('cuenta_contab');

        $CU = Cuentas_adicionales::
             where('id_cue', 19)->value('cuenta_contab');

        $TIPOFOLDER = Cuentas_adicionales::
             where('id_cue', 20)->value('cuenta_contab');

        $NUMFOLDER_CR = Cuentas_adicionales::
             where('id_cue', 23)->value('cuenta_contab');

        $TIPODOCUMENTOCR = Cuentas_adicionales::
             where('id_cue', 27)->value('cuenta_contab');

        $DOCUMENTO_CRUCE_CR = Cuentas_adicionales::
             where('id_cue', 32)->value('cuenta_contab');



        $data[] = [];

        $i = 1;
        $j = 0;
        

        foreach ($Facturascajarapida as $Fcjr) {


             $cod_ciud = "169";
            
            $detalle_Fcjr = Detalle_cajarapidafacturas::
            where('id_fact', $Fcjr->id_fact)
            ->where('prefijo', $Fcjr->prefijo)
            ->get()->toArray();
            
           

             $cod_ciud = $cod_ciud . $Fcjr->id_ciud;            

             $Fecha_credito = Carbon::parse($Fcjr->fecha_fact)
                      ->addDays(30)                
                      ->format('Y-m-d H:i:s');  

       

            /***************************************************/
            /*                   ITEM FACTURA                  */
            /***************************************************/

            //$j = $j + 1;//Para Item de conceptos

            foreach ($detalle_Fcjr as $key => $detfes) {
                $id_concepto = $detfes['id_concep'];
                $cuenta_cont = Conceptos_cajarapida::where('id_concep', $id_concepto)
                        ->value('cuenta_contab');

                $j = $j + 1;
                if ($Fcjr->credito_fact == true){
                   
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_cont, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'C', $detfes['subtotal'], '', '', '', '', '',  '', '', $Fecha_credito,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                }elseif ($Fcjr->credito_fact == false){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_cont, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'C', $detfes['subtotal'], '', '', '', '', '',  '', '', $Fcjr->fecha_fact,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                }                       
                          
            }//for detalle_Fcjr

            
            /***************************************************/
            /*               ITEM TERCEROS FACTURA             */
            /***************************************************/
            

            $cuenta_cont_iva_cr = Cuentas_adicionales::
             where('concepto', 'Iva Caja Rapida')->value('cuenta_contab');

             $cuenta_a_credito = Cuentas_adicionales::
             where('concepto', 'CLIENTE- CUENTA POR COBRAR CAJA RAP')->value('cuenta_contab');

            $cuenta_contado = Cuentas_adicionales::
             where('concepto', 'CAJA GENERAL- CONTADO- EFECTIVO CAJA RAPIDA')->value('cuenta_contab');

             $cuenta_banco = Cuentas_adicionales::
             where('concepto', 'BANC DAVIVIEND CTA UNIC CONTAD - TANSF-DATAF-CONSG')->value('cuenta_contab');

            $cuenta_deduc_iva = Cuentas_adicionales::
             where('concepto', 'Deducion de IVA-Impuesto a las ventas retenido')->value('cuenta_contab');

            $cuenta_deduc_ica = Cuentas_adicionales::
             where('concepto', 'Deduci de ICA-Impuesto de Industr y Comerc Ret')->value('cuenta_contab');

             $cuenta_deduc_rtf = Cuentas_adicionales::
             where('concepto', 'Deducion de Rtf-Honorarios 11%')->value('cuenta_contab');        

             
             if($Fcjr->total_iva > 0){
                 $j = $j + 1;//para IVA            

                if ($Fcjr->credito_fact == true){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_cont_iva_cr, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'C', round($Fcjr->total_iva), '', '', '', '', '',  '', '', $Fecha_credito, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

                }elseif ($Fcjr->credito_fact == false){
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_cont_iva_cr, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'C', round($Fcjr->total_iva), '', '', '', '', '',  '', '', $Fcjr->fecha_fact, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
                }
             }
            


        
            /***************************************************/
            /*         ITEM FACTURA DEDUCCIONES                */
            /***************************************************/

        if($Fcjr->deduccion_reteiva > 0){
            $j = $j + 1;//para IVA            

            if ($Fcjr->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_deduc_iva, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->deduccion_reteiva), '', '', '', '', '',  '', '', $Fecha_credito, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fcjr->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_deduc_iva, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->deduccion_reteiva), '', '', '', '', '',  '', '', $Fcjr->fecha_fact, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }


        }        

      
        if($Fcjr->deduccion_reteica > 0){
             $j = $j + 1;//para IVA            

            if ($Fcjr->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_deduc_ica, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->deduccion_reteica), '', '', '', '', '',  '', '', $Fecha_credito, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fcjr->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_deduc_ica, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->deduccion_reteica), '', '', '', '', '',  '', '', $Fcjr->fecha_fact, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
            }

        }
        if($Fcjr->deduccion_retertf > 0){
             $j = $j + 1;//para IVA            

            if ($Fcjr->credito_fact == true){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_deduc_rtf, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->deduccion_retertf), '', '', '', '', '',  '', '', $Fecha_credito, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);

            }elseif ($Fcjr->credito_fact == false){
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_deduc_rtf, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->deduccion_retertf), '', '', '', '', '',  '', '', $Fcjr->fecha_fact, $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

            }

        }


        /*************************************************************/
        /***********************TOTALES*******************************/       
          
        if ($Fcjr->credito_fact == true){ //Si es a credito
            $j = $j + 1;
            $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_a_credito, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->total_fact), '', '', '', '', $DOCUMENTO_CRUCE_CR,  $Fcjr->id_fact, '', $Fecha_credito,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);


        }else if ($Fcjr->credito_fact == false){ 

            $total_medios_pago = $Fcjr->consignacion_bancaria +
            $Fcjr->pse +
            $Fcjr->transferencia_bancaria +
            $Fcjr->tarjeta_credito +
            $Fcjr->tarjeta_debito;          


            if($total_medios_pago > 0){
                if( $Fcjr->efectivo > 0){                    
                    $j = $j + 1; //Para efectivo
            
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_contado, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->efectivo), '', '', '', '', '',  '', '', $Fcjr->fecha_fact,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                     $j = $j + 1; //Para la suma de otros medios depago

                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_banco, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($total_medios_pago), '', '', '', '', '',  '', '', $Fcjr->fecha_fact,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);
                }else{

                     $j = $j + 1; //Para la suma de otros medios depago                       


                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_banco, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($total_medios_pago), '', '', '', '', '',  '', '', $Fcjr->fecha_fact,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

                }

            }else{

                $j = $j + 1; //Para solo efectivo
            
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_CR, $Fcjr->fecha_fact, $cuenta_contado, $Fcjr->a_nombre_de, $TIPODOCUMENTOCR, $Fcjr->id_fact, 'D', round($Fcjr->total_fact), '', '', '', '', '',  '', '', $Fcjr->fecha_fact,  $Fcjr->a_nombre_de, $Fcjr->nombre_cli, $Fcjr->id_tipoident, $Fcjr->direccion_cli, $Fcjr->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '01', '', '', '01', $i, $j);

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
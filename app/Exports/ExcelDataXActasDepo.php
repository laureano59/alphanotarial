<?php

namespace App\Exports;

//use App\Retencionesaplicadas_view;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Actas_deposito_interfaz_view;
use App\Cuentas_adicionales;
use App\Escritura;
use Carbon\Carbon;

class ExcelDataXActasDepo implements FromCollection,WithHeadings
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

        $Actasdeposito = Actas_deposito_interfaz_view::select([
            'id_act',
            'id_tip',
            'identificacion_cli',
            'nombre_cli',
            'proyecto',
            'deposito_act',
            'observaciones_act',
            'efectivo',
            'cheque',
            'tarjeta_credito',
            'num_cheque',
            'num_tarjetacredito',
            'saldo',
            'created_at',
            'updated_at',
            'usuario',
            'id_radica',
            'anio_radica',
            'anulada',
            'fecha_acta',
            'transferencia_bancaria',
            'consignacion_bancaria',
            'pse',
            'tarjeta_debito',
            'motivo_anulacion',
            'bono',
            'deposito_boleta',
            'deposito_registro',
            'deposito_escrituras',
            'credito_act',
            'telefono_cli',
            'direccion_cli',
            'email_cli',   
            'id_tipoident',
            'digito_verif',
            'id_ciud'
        	])->whereDate('fecha_acta', '>=', $fecha1)
        		->whereDate('fecha_acta', '<=', $fecha2)        
        		->get();

               /*  dump(
   collect($Actasdeposito)->map(function ($Adp) {
        return [
            'identificacion_cli' => $Adp->identificacion_cli,
            'nombre_cli' => $Adp->nombre_cli,
        ];
    })
);*/


        $CodigoEmpresa = Cuentas_adicionales::
             where('id_cue', 18)->value('cuenta_contab');

        $CU = Cuentas_adicionales::
             where('id_cue', 19)->value('cuenta_contab');

        $TIPOFOLDER = Cuentas_adicionales::
             where('id_cue', 20)->value('cuenta_contab');

        $NUMFOLDER_AD = Cuentas_adicionales::
             where('id_cue', 37)->value('cuenta_contab');

        $TIPODOCUMENTOAD = Cuentas_adicionales::
             where('id_cue', 38)->value('cuenta_contab');



        $data[] = [];

        $i = 1;
        $j = 0;
        


        foreach ($Actasdeposito as $Adp) {          

             $j = $j + 1;

             $cod_ciud = "16976001";

             //$cod_ciud = $cod_ciud . $Adp->id_ciud;            

       

            /***************************************************/
            /*                   ITEM ACTAS DEP                */
            /***************************************************/           

           
               
            $cuenta_cont_item       = Cuentas_adicionales::
                                        where('id_cue', 17)->value('cuenta_contab');

            $cuenta_cont_tot_item   = Cuentas_adicionales::
                                        where('id_cue', 14)->value('cuenta_contab');

            $cuenta_cont_cr         = Cuentas_adicionales::
                                        where('id_cue', 13)->value('cuenta_contab');

            $numEsc = Escritura::where('id_radica', $Adp->id_radica)
            ->where('anio_radica', $Adp->anio_radica)
            ->value('num_esc');

            $detalle1 = 'RD-' . $Adp->id_radica . ' ES-' . $numEsc;



            $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_AD, $Adp->fecha_acta, $cuenta_cont_item, $Adp->identificacion_cli, $TIPODOCUMENTOAD, $Adp->id_act, 'C', $Adp->deposito_act, $detalle1, '', '', '', 'AD',  $Adp->id_act, '', $Adp->fecha_acta,  $Adp->identificacion_cli, $Adp->nombre_cli, $Adp->id_tipoident, $Adp->direccion_cli, $Adp->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);            
          
             $i = $i + 1;

             /********TOTALES***********/
             if($Adp->credito_act == true){ //Si es a credito
                $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_AD, $Adp->fecha_acta, $cuenta_cont_cr, $Adp->identificacion_cli, $TIPODOCUMENTOAD, $Adp->id_act, 'D', $Adp->deposito_act, $detalle1, '', '', '', '',  '', '', $Adp->fecha_acta,  $Adp->identificacion_cli, $Adp->nombre_cli, $Adp->id_tipoident, $Adp->direccion_cli, $Adp->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j);            
          
                    $i = $i + 1;
             }else if($Adp->credito_act == false){
              
                $total_medios_pago = $Adp->consignacion_bancaria +
                $Adp->pse +
                $Adp->transferencia_bancaria +
                $Adp->tarjeta_credito +
                $Adp->tarjeta_debito;          


                if($total_medios_pago > 0){
                    if( $Adp->efectivo > 0){                    
                        $j = $j + 1; //Para efectivo
            
                        $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_AD, $Adp->fecha_acta, $cuenta_cont_tot_item, $Adp->identificacion_cli, $TIPODOCUMENTOAD, $Adp->id_act, 'D', $Adp->efectivo, $detalle1, '', '', '', '',  '', '', $Adp->fecha_acta,  $Adp->identificacion_cli, $Adp->nombre_cli, $Adp->id_tipoident, $Adp->direccion_cli, $Adp->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j); 

                            $j = $j + 1; //Para la suma de otros medios depago

                        $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_AD, $Adp->fecha_acta, $cuenta_cont_tot_item, $Adp->identificacion_cli, $TIPODOCUMENTOAD, $Adp->id_act, 'D', $total_medios_pago, $detalle1, '', '', '', '',  '', '', $Adp->fecha_acta,  $Adp->identificacion_cli, $Adp->nombre_cli, $Adp->id_tipoident, $Adp->direccion_cli, $Adp->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j); 
                    }else{

                        $j = $j + 1; //Para la suma de otros medios depago                       


                        $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_AD, $Adp->fecha_acta, $cuenta_cont_tot_item, $Adp->identificacion_cli, $TIPODOCUMENTOAD, $Adp->id_act, 'D', $total_medios_pago, $detalle1, '', '', '', '',  '', '', $Adp->fecha_acta,  $Adp->identificacion_cli, $Adp->nombre_cli, $Adp->id_tipoident, $Adp->direccion_cli, $Adp->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j); 

                    }

                }else{

                    $j = $j + 1; //Para solo efectivo
            
                    $this->cargar_informe($data, $CodigoEmpresa, $CU, $TIPOFOLDER, $NUMFOLDER_AD, $Adp->fecha_acta, $cuenta_cont_tot_item, $Adp->identificacion_cli, $TIPODOCUMENTOAD, $Adp->id_act, 'D', $Adp->deposito_act, $detalle1, '', '', '', '',  '', '', $Adp->fecha_acta,  $Adp->identificacion_cli, $Adp->nombre_cli, $Adp->id_tipoident, $Adp->direccion_cli, $Adp->telefono_cli, '', '', $cod_ciud, '', '', 'N', 'N', 'S', 'N', 'N', 'N', 'N', 'N', '30', '', '', '01', $i, $j); 

                }

             }                  
                          
            }//for detalle_Adp
                              
       

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
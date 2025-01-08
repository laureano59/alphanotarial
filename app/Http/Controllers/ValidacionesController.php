<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notaria;
use App\Radicacion;
use App\Actosclienteradica;
use App\Liq_derecho;
use App\Liq_recaudo;
use App\Factura;
use App\Escritura;
use App\Cliente;
use App\Actas_deposito;
use App\Actas_deposito_egreso_view;
use App\Calidad1;
use App\Otorgante;
use App\Compareciente;
use App\Tarifa;
use App\Facturascajarapida;
use App\Detalle_cajarapidafacturas;
use App\Reportados;

class ValidacionesController extends Controller
{
    /*******TODO:Valida la Radicación Para que sea liquidada*********/
    public function ValidarRadicacion(Request $request){
      if($request->ajax()){
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $id_radica = $request->input('id_radica');
        if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
          if($id_radica == 0){
            return response()->json([
                 "validar"=> "2"//TODO:Significa que la Radicación está lista para liquidar
               ]);
            exit;
          }
            $validartodo = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
            $validar = '';
            foreach ($validartodo as $key => $value) {
              if($value['identificacion_cli'] == '' || $value['identificacion_cli2'] == ''){
                $validar = 'ok';
                 break;
              }
            }
            if($validar == ''){
              return response()->json([
                 "validar"=> "2"//TODO:Significa que la Radicación está lista para liquidar
               ]);
            }else if($validar == 'ok'){
              return response()->json([
                 "validar"=> "1",
                 "mensaje"=> "Los Actos deben tener como mínimo Sus Otorgantes y Comparecientes Principales"
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

    /*******TODO:Valida la Radicación Para que sea Facturada*********/
    public function ValidarRadicacionFact(Request $request){
      if($request->ajax()){
        $anio_trabajo = Notaria::find(1)->anio_trabajo;
        $id_radica = $request->input('id_radica');
        if (Radicacion::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
            $validartodo = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->get()->toArray();
            $validar = '';
            foreach ($validartodo as $key => $value) {
              if($value['identificacion_cli'] == '' || $value['identificacion_cli2'] == ''){
                $validar = 'ok';
                 break;
              }
            }
            if($validar == ''){//Significa que la radicación está completa y lista para liquidar
              /******TODO:Se averigua que la liquidación esté completa***********/
              if (Liq_derecho::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->exists()){
                $request->session()->put('key', $id_radica); //TODO:Inicia Variable de Session con la radicacion
                $opcion = $request->input('opcion');//TODO:Opción para tipo de factura
                $request->session()->put('opcion', $opcion);//TODO:Session para tipo de factura

                return response()->json([
                   "validar"=> "3" //TODO:Vía libre para facturar
                 ]);
              }else{
                return response()->json([
                   "validar"=> "2",
                   "mensaje"=> "La radicación no se ha liquidado"
                 ]);
              }
            }else if($validar == 'ok'){
              return response()->json([
                 "validar"=> "1",
                 "mensaje"=> "Los Actos deben tener como mínimo Sus Otorgantes y Comparecientes Principales"
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

    public function ValidarRadFacturada(Request $request){
      $id_radica = $request->input('id_radica');
      $anio_radica = Notaria::find(1)->anio_trabajo;
      if (Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->exists()){

        $algo = Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->get()->toArray();
        $i = 0;
        unset($arr);
        $arr = array();
        foreach ($algo as $key => $al) {
          if($al['nota_credito'] == false){
            $arr[$i] = "0";
          }else if($al['nota_credito'] == true){
            $arr[$i] = "1";
          }
          
          $i++;
        }


        if (in_array("1", $arr)){
          return response()->json([
             "validar"=>0
           ]);
        }else{
          $raw = \DB::raw("prefijo, id_fact, fecha_fact, a_nombre_de, credito_fact, deduccion_reteiva, deduccion_reteica, deduccion_retertf, total_fact");
          $factura = Factura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->select($raw)->get();
         
          foreach ($factura as $fact) {
            $prefijo = $fact->prefijo;
            $id_fact = $fact->id_fact;
            $fecha_fact = $fact->fecha_fact;
            $request->session()->put('prefijo', $prefijo);
            $request->session()->put('numfactura', $id_fact);//TODO:Session para factura
            $request->session()->put('fecha_fact', $fecha_fact);//TODO:Session fecha para factura
            $identificacion_cli = $fact->a_nombre_de;
            $credito_fact = $fact->credito_fact;
            $deduccion_reteiva = $fact->deduccion_reteiva;
            $deduccion_reteica = $fact->deduccion_reteica;
            $deduccion_retertf = $fact->deduccion_retertf;
            $total_fact = $fact->total_fact;
          }
          $raw = \DB::raw("CONCAT(pmer_nombrecli, ' ', sgndo_nombrecli, ' ', pmer_apellidocli, ' ', sgndo_apellidocli, empresa) as fullname");
          $nombre = Cliente::where('identificacion_cli', $identificacion_cli)->select($raw)->get();
          foreach ($nombre as $nom) {
            $nom = $nom->fullname;
          }

          $raw2 = \DB::raw("num_esc, fecha_esc");
          $escritura = Escritura::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->select($raw2)->get();
          foreach ($escritura as $esc) {
            $num_esc = $esc->num_esc;
            $fecha_esc = $esc->fecha_esc;
            $request->session()->put('num_esc', $num_esc);//TODO:Session para escritura
            $request->session()->put('fecha_esc', $fecha_esc);//TODO:Session fecha para escritura
          }

          return response()->json([
             "validar"=>1,
             "prefijo"=>$prefijo,
             "id_fact"=>$id_fact,
             "fecha_fact"=>$fecha_fact,
             "identificacion_cli"=>$identificacion_cli,
             "nombrede"=>$nom,
             "deduccion_reteiva"=>$deduccion_reteiva,
             "deduccion_reteica"=>$deduccion_reteica,
             "deduccion_retertf"=>$deduccion_retertf,
             "total_fact"=>$total_fact,
             "credito_fact"=>$credito_fact,
             "num_esc"=>$num_esc,
             "mensaje"=>"La radicación ya está facturada"
           ]);
      }

      }else{
          return response()->json([
             "validar"=>0
           ]);
        }
        

        
      

      
    }

      public function ValidarCiudadCliente(Request $request){
        $id_ciud_cli = $request->input('id_ciud');
        $id_ciud_nota = Notaria::find(1)->id_ciud;

        if($id_ciud_cli == $id_ciud_nota){
          return response()->json([
             "validar"=>1
           ]);
        }else if($id_ciud_cli != $id_ciud_nota){
          return response()->json([
             "validar"=>0
           ]);
        }
      }

        public function ValidarRtfMayCero(Request $request){
          $id_radica = $request->session()->get('key');//TODO:Obtiene el número de radicación por session
          $notaria = Notaria::find(1);
          $anio_trabajo = $notaria->anio_trabajo;
          $rtf = Liq_recaudo::where('id_radica', $id_radica)->where('anio_radica', $anio_trabajo)->first(['retefuente']);
          if($rtf->retefuente > 0){
            return response()->json([
               "validar"=>true
             ]);
          }else if($rtf->retefuente < 1){
            return response()->json([
               "validar"=>false
             ]);
          }
        }

        public function Validar_Actas_Factura(Request $request){
          $identificacion_cli = $request->input('identificacion_cli');
          $raw = \DB::raw("id_act, (to_char(fecha_acta, 'DD/MM/YYYY'::text)) AS fecha_acta,
                    proyecto, (descripcion_tip) AS tipo_deposito, identificacion_cli,
                    deposito_act, saldo, id_egr");
          $actas_deposito = Actas_deposito_egreso_view::
            where('identificacion_cli', $identificacion_cli)
          ->where("anulada","<>",true)
          ->where("id_tip","<>",2)
          ->select($raw)->get();

          //var_dump($actas_deposito);
          if(count($actas_deposito) >= 1){
            return response()->json([
               "validar"=>1,
               "actas_deposito"=>$actas_deposito
             ]);
          }else{
            return response()->json([
               "validar"=>0
             ]);
          }

          foreach ($actas_deposito as $act) {
            //$nom = $nom->fullname;
          }
        }

        public function ValidarCalidadDestino(Request $request){
          $id = $request->input('id_cal1');
          $raw = \DB::raw("almacena");
          $calidad = Calidad1::where('id_cal1', $id)->select($raw)->get();
          foreach ($calidad as $cal) {
            $almacena = $cal->almacena;
          }

          return response()->json([
             "almacena"=>$almacena
           ]);

        }

        public function Porcentaje_Rtf_Vendedores(Request $request){
         
          $rtfcliente = 0;
          $identificacion_cli = $request->input('identificacion_cli');
          $ValidarEmpresa = cliente::where('identificacion_cli', $identificacion_cli)->get();
          foreach ($ValidarEmpresa as $value) {
            $tipo_identif = $value['id_tipoident'];
          }


                  if($tipo_identif == 31){
                    $rtfcliente = 0;
                    return response()->json([
                      "validar"=>1,
                      "rtfcliente"=>$rtfcliente
                    ]);
                    exit;
                  }


          $id_radica = $request->session()->get('key');


          $anio_radica = Notaria::find(1)->anio_trabajo;
          $rtf_porcentaje = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->where('identificacion_cli', $identificacion_cli)->whereIn('id_cal1', [5, 11, 14])->get()->toArray();
          $porcentajevendedor = 0;
          if(empty($rtf_porcentaje)) { //Si identificacion_cli está vacío entra a validar con cli2
            $rtf_porcentaje = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->where('identificacion_cli2', $identificacion_cli)->whereIn('id_cal2', [23, 19])->get()->toArray();
            if(empty($rtf_porcentaje)) {//Si identificacion_cli2 está vacío pasa a otorgantes
              /****Pasa a evaluar en otorgantes****/
              $id_actoperrad = Actosclienteradica::where('id_radica', $id_radica)->where('anio_radica', $anio_radica)->get()->toArray();
                if(empty($id_actoperrad)){
                  return response()->json([
                     "validar"=>0
                   ]);
                }else{

                    $id_radica = $request->session()->get('key');
                    $rtf_porcentaje = Otorgante::where('id_radica', $id_radica)->where('identificacion_cli', $identificacion_cli)->where('id_cal1', 5)->get()->toArray();

                    if(empty($rtf_porcentaje)) {
                      // return response()->json([
                      //    "validar"=>0
                      //  ]);
                      //  break;
                    }else{


                      $rtfcliente = 0;

                      
                     foreach ($rtf_porcentaje as $key => $value) {
                        $porcentaje = $value['porcentaje_otor'];
                        if($porcentaje > 0){
                          $porcentajevendedor = $porcentaje;
                          $porcen = $porcentajevendedor/100;//0.5
                          $tarifa = Tarifa::find(11);//:Tarifa de ReteFuente
                          $rete = $tarifa['valor1'] / 100;//0.01
                          $valor_cuantia = $value['cuantia'];
                          $tradicion = $value['tradicion'];

                          $retencion = round(($valor_cuantia * $porcen) * $rete);

                          $rtfcliente += $this->DescuentoRtf($tradicion, $retencion);
                          

                          //$rtfcliente += round(($valor_cuantia * $porcen) * $rete);
                        }

                      }
                    }


                }
            }else{
              foreach ($rtf_porcentaje as $key => $value) {
                $porcentaje = $value['porcentajecli2'];
                if($porcentaje > 0){
                  $porcentajevendedor = $porcentaje;
                  $porcen = $porcentajevendedor/100;
                  $tarifa = Tarifa::find(11);//:Tarifa de ReteFuente
                  $rete = $tarifa['valor1'] / 100;
                  $tradicion = $value['tradicion'];
                  $retencion = round(($value['cuantia'] * $porcen) * $rete);
                  
                  $rtfcliente += $this->DescuentoRtf($tradicion, $retencion);
                  
                  //$rtfcliente = round(($value['cuantia'] * $porcen) * $rete);
                  
                }
              }
            }
          }else{
            $rtfcli = 0;
            $rtf_otor = 0;

            foreach ($rtf_porcentaje as $key => $value) {
              $id_actoradica = $value['id_actoperrad'];
              $id_radica = $request->session()->get('key');
              $valor_cuantia = $value['cuantia'];
              $request->session()->put('valor_cuantia', $valor_cuantia);
              $porcentaje = $value['porcentajecli1'];

              if($porcentaje > 0){
                $porcentajevendedor = $porcentaje;
                $porcen = $porcentajevendedor/100;
                $tarifa = Tarifa::find(11);//:Tarifa de ReteFuente
                $rete = $tarifa['valor1'] / 100;

                $tradicion = $value['tradicion'];
                $retencion = round(($value['cuantia'] * $porcen) * $rete);
                  
                $rtfcli += $this->DescuentoRtf($tradicion, $retencion);

                //$rtfcli += round(($value['cuantia'] * $porcen) * $rete);


                  //77777777777777

                  $porcentaje2 = 0;
                  $rtf_otorgante = Otorgante::where('id_radica', $id_radica)->where('identificacion_cli', $identificacion_cli)->where('id_cal1', 5)->get()->toArray();

                    if(empty($rtf_otorgante)) {
                      // return response()->json([
                      //    "validar"=>0
                      //  ]);
                      //  break;
                    }else{
                      foreach ($rtf_otorgante as $key => $value) {
                        $porcentaje2 = $value['porcentaje_otor'];
                        if($porcentaje2 > 0){
                          $porcentajevendedor = $porcentaje2;
                          $porcen = $porcentajevendedor/100;//0.5
                          $tarifa = Tarifa::find(11);//:Tarifa de ReteFuente
                          $rete = $tarifa['valor1'] / 100;//0.01
                          $valor_cuantia = $value['cuantia'];
                          $tradicion = $value['tradicion'];

                          $retencion = round(($valor_cuantia * $porcen) * $rete);

                          $rtf_otor += $this->DescuentoRtf($tradicion, $retencion);

                          //$rtf_otor += round(($valor_cuantia * $porcen) * $rete);
                          
                          $ValidarEmpresa = cliente::where('identificacion_cli', $identificacion_cli)->get();
                          foreach ($ValidarEmpresa as $value) {
                            $tipo_identif = $value['id_tipoident'];
                          }

                          
                        }

                        }

                      }

                  //77777777777777

              }
            }
           
                  
                  $rtfcliente = $rtf_otor + $rtfcli;
                


          }

          return response()->json([
                   "validar"=>1,
                   "rtfcliente"=>$rtfcliente
                 ]);

        

        }


        public function DescuentoRtf($tradicion, $retencion){
          $op = 0;
          if($tradicion == 1986){
              $retencion = $retencion * 0.9;
              $valor = $retencion;
              $op = 1;
            }
            
            if($tradicion == 1985){
              $retencion = $retencion * 0.8;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1984){
              $retencion = $retencion * 0.7;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1983){
              $retencion = $retencion * 0.6;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1982){
              $retencion = $retencion * 0.5;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1981){
              $retencion = $retencion * 0.4;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1980){
              $retencion = $retencion * 0.3;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1979){
              $retencion = $retencion * 0.2;
              $valor = $retencion;
              $op = 1;
            }

            if($tradicion == 1978){
              $retencion = $retencion * 0.1;
              $valor = $retencion;
              $op = 1;
            }

            for ($i=1900; $i <= 1977 ; $i++) { 
              if($tradicion == $i){
                $retencion = 0;
                $valor = $retencion;
                $op = 1;
              }
              
            }

            if($op == 1){
              return $valor;
            }else if($op == 0){
              return $retencion;
            }
            

        }

        public function ExisteReportado(Request $request){
          $identificacion = $request->identificacion_rep;
         
          if (Reportados::where('identificacion_rep', $identificacion)->exists()) {
            // El registro existe
            $registros = Reportados::where('identificacion_rep', $identificacion)->get();
            return response()->json([
              "validar"=>1,
              "reportado"=>$registros,
              "mensaje"=>"El documento ingresado existe, si quiere actualizar solo haz clic en alguno de la lista y realiza los cambios en cada campo y guarda"
             ]);
          } else {
          // El registro no existe
             return response()->json([
              "validar"=>0
             ]);
          }
        }

        public function ExisteFactura(Request $request){
          $id = $request->num_factura;
          $anio_trabajo = $request->anio_trabajo;
          $tipo_certificado = $request->tipo_certificado;
          $prefijo_fact = Notaria::find(1)->prefijo_fact;
          $factura = Factura::where("prefijo","=",$prefijo_fact)->find($id);

          if($factura){
            $request->session()->put('tipo_certificado', $tipo_certificado);
            $request->session()->put('anio_trabajo', $anio_trabajo);
            $request->session()->put('numfact', $id);

            return response()->json([
              "validar"=>1
             ]);
          }else{
            return response()->json([
              "validar"=>0,
              "mensaje"=>'La factura no exixte para el año fiscal ingresado'
             ]);
          }
        }

         public function ExisteFacturaCajaRapida(Request $request){
          $id = $request->num_factura;
          $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
          $factura = Facturascajarapida::where("prefijo","=",$prefijo_fact)->find($id);
          if($factura){
            $request->session()->put('numfact', $id);

            return response()->json([
              "validar"=>1
             ]);
          }else{
            return response()->json([
              "validar"=>0,
              "mensaje"=>'Esta Factura no Existe en el Sistema'
             ]);
          }
        }

        public function ValidarparaEditarFacturaCajaRapida(Request $request){
          $request->session()->forget('numfactrapida'); 
          $id = $request->num_factura;
          $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
          $factura = Facturascajarapida::where("prefijo","=",$prefijo_fact)
                    ->where("id_fact","=",$id)
                    ->where("status_factelectronica", "<>", 1)
                    ->get();

          $cont = count ($factura, 0);


          $detalle = Detalle_cajarapidafacturas::where('prefijo', $prefijo_fact)
                    ->where('id_fact', $id)
                    ->get();

          $subtotal_all = 0;
          $total_iva = 0;
          $total_all = 0;

          foreach ($detalle as $value) {
            $subtotal_all += $value['subtotal'];
            $total_iva += $value['iva'];
            $total_all += $value['total'];
          }


          if($cont > 0){
            $request->session()->put('numfactrapida', $id);
            $prefijo_fact = Notaria::find(1)->prefijo_facturarapida;
            Detalle_cajarapidafacturas::
            where("prefijo","=",$prefijo_fact)
            ->where("id_fact","=", $id)->delete();
            
            return response()->json([
              "validar"=>1,
              "detalle"=>$detalle,
              "subtotal"=>$subtotal_all,
              "total_iva"=>$total_iva,
              "total"=>$total_all
             ]);
          }else{
            return response()->json([
              "validar"=>0,
              "mensaje"=>'Esta Factura no Existe en el Sistema o ya está en la DIAN'
             ]);
          }
        }

        public function TotalFact_TotalLiq(Request $request){
          $id_radica = $request->session()->get('key');
          $anio_radica = Notaria::find(1)->anio_trabajo;
          $raw = \DB::raw("SUM(total_fact) AS totalfact");
          $total = Factura::
            where('id_radica', $id_radica)
            ->where('anio_radica', $anio_radica)
            ->where("nota_credito","<>",true)
            ->select($raw)->get()->toArray();
          foreach ($total as $key => $to) {
            $total_factura = $to['totalfact'];
          }

          $raw2 = \DB::raw("grantotalliq");
          $total2 = Liq_recaudo::
            where('id_radica', $id_radica)
            ->where('anio_radica', $anio_radica)
            ->select($raw2)->get()->toArray();

          foreach ($total2 as $key => $to2) {
            $total_liquidacion = $to2['grantotalliq'];
          }

          if($total_factura > $total_liquidacion){
            $totalgeneral = $total_factura - $total_liquidacion;
          }else{
            $totalgeneral = $total_liquidacion - $total_factura;
          }

          if($totalgeneral < 10){
            return response()->json([
              "validar"=>0,
              "mensaje"=>'La radicación actual ya está facturada completamente'
             ]);
          }else{
            return response()->json([
              "validar"=>1
             ]);
          }

        }


         public function Validar_liquidacion_provisional(Request $request){
         
            $tipo_impre_liq = $request->tipo_impresion;
            $request->session()->put('tipo_impre_liq', $tipo_impre_liq);

            return response()->json([
              "validar"=>1
             ]);

        }

          public function Validar_Num_Cuenta_Cobro_pdf(Request $request){
         
            $id_cce = $request->id_cce;
            $request->session()->put('id_cuentacobro', $id_cce);

            return response()->json([
              "validar"=>1
             ]);

        }

    }

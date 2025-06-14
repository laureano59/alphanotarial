<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EnviarEmailCajaRapida;
use App\Services\EnviarEmailEscr;

class EnviaremailController extends Controller
{
     public function EnviarCorreo(Request $request){

          $cf            = $request->session()->get('CUFE_SESION');
          $numerofactura = $request->session()->get('numfactrapida');
          $opcion        = $request->session()->get('opcionfactura');
          $email_cliente = $request->session()->get('email_cliente');
     

          $Enviar = new EnviarEmailCajaRapida();
          $respuesta = $Enviar->EnviarCorreoSegundoPlano($cf, $numerofactura, $opcion, $email_cliente);

     }

      public function EnviarCorreoEscr(Request $request){

          $cf            = $request->session()->get('CUFE_SESION');
          $numerofactura = $request->session()->get('numfactura');
          $opcion        = $request->session()->get('opcionfactura');
          $email_cliente = $request->session()->get('email_cliente');
     

          $Enviar = new EnviarEmailEscr();
          $respuesta = $Enviar->EnviarCorreoSegundoPlano($cf, $numerofactura, $opcion, $email_cliente);

     }
     

      public function enviarfactura(Request $request){
          $opcion =  $request->opcion;
          $opcion2 = $request->opcion2;
          
          if($opcion2 == 1){
               if($opcion == 'F1'){
                    $titulo = "FACTURA No.";
          }else if($opcion == 'NC'){
               $titulo = "Nota Credito No.";
          }else if($opcion == 'ND'){
               $titulo = "Nota Debito No.";
          }
          $nombre_factura = $request->num_fact.'_'.$opcion.'.pdf';
          $nombre_xml = $request->num_fact.'_'.$opcion.'_AttachedDocument'.'.xml';

          /*Crear carpeta*/
          
          $nombre_carpeta = $request->num_fact.'_'.$opcion;
          mkdir("cliente/".$nombre_carpeta, 0700);

          $zip = new ZipArchive();
          $paquete_zip = "cliente/".$nombre_carpeta.'/'.$request->num_fact.'.zip';

          $zip = new ZipArchive();

          $archivo = "cliente/".$nombre_carpeta.'/'.'FACTURA'.'_'.$request->num_fact.'_'.$opcion.".zip";

          sleep(10);//da tiempo de generar el PDF
          
          if($zip->open(public_path($archivo), ZipArchive::CREATE)== true){
               $files = File::files(public_path('cliente'));
               foreach ($files as $key => $value) {
                    $relativeName = basename($value);
                    $ext = pathinfo($relativeName, PATHINFO_EXTENSION);
                    if($ext != 'zip'){
                         $zip->addFile($value, $relativeName);
                    }
                    
               }
               $zip->close();

          }else{

          }

          /*Elimina ficheros de un directorio*/

          $files = glob('cliente/*');
          foreach ($files as $file) {
               if(is_file($file))
                    unlink(public_path($file));
          }

            
          $Enviar = array();
          $Enviar = [
               'num_fact' => $request->num_fact.'_'.$opcion,
               'titulo' => $titulo,
               'archivo' => $archivo
          ];
          
          Mail::to($request->email_cliente)->queue(new FacturaElectronica($Enviar));

          }else if($opcion2 == 2){

          if($opcion == 'F1'){
               $titulo = "FACTURA No.";
          }else if($opcion == 'NC'){
               $titulo = "Nota Credito No.";
          }else if($opcion == 'ND'){
               $titulo = "Nota Debito No.";
          }
          $nombre_factura = $request->num_fact.'_'.$opcion.'.pdf';
          $nombre_xml = $request->num_fact.'_'.$opcion.'_AttachedDocument'.'.xml';

           /*Crear carpeta*/
          
          $nombre_carpeta = $request->num_fact.'_'.$opcion;
          mkdir("cliente_cajarapida/".$nombre_carpeta, 0700);


          $zip = new ZipArchive();
          $paquete_zip = "cliente_cajarapida/".$nombre_carpeta.'/'.$request->num_fact.'.zip';

          $zip = new ZipArchive();
          $archivo = "cliente_cajarapida/".$nombre_carpeta.'/'.'FACTURA'.'_'.$request->num_fact.'_'.$opcion.".zip";

          sleep(10);//da tiempo de generar el PDF
          
          if($zip->open(public_path($archivo), ZipArchive::CREATE)== true){
               $files = File::files(public_path('cliente_cajarapida'));
               foreach ($files as $key => $value) {
                    $relativeName = basename($value);
                    $ext = pathinfo($relativeName, PATHINFO_EXTENSION);
                    if($ext != 'zip'){
                         $zip->addFile($value, $relativeName);
                    }
                    
               }
               $zip->close();

          }else{

          }

         /*Elimina ficheros del directorio cliente*/

         $files = glob('cliente_cajarapida/*');

          foreach ($files as $file) {
               if(is_file($file))
                    unlink(public_path($file));
          }
    
          $Enviar = array();
          $Enviar = [
               'num_fact' => $request->num_fact.'_'.$opcion,
               'titulo' => $titulo,
               'archivo' => $archivo
          ];
          
          Mail::to($request->email_cliente)->queue(new FacturaElectronica($Enviar));

          }

     }
}

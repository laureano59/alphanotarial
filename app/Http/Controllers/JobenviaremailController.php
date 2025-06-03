<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mail\FacturaElectronica;
use App\Factura;
use App\Cliente;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\Services\PdfService;


class JobenviaremailController extends Controller
{
     public function Enviarfactura(Request $request){
         
          $fecha_factura = date("Y-m-d");
                  
          $facturas = Factura::whereDate('fecha_fact', '>=', $fecha_factura)
                              ->whereDate('fecha_fact', '<=', $fecha_factura)
                              ->get();                            

          foreach ($facturas as $ft) {
               if($ft->status_envio_email == '0'){
                    $cufe          = $ft->cufe;
                    $numfact       = $ft->id_fact;
                    $anio_trabajo  = $ft->anio_radica;
                    $a_nombre_de   = $ft->a_nombre_de;
                    $opcion        = 'F1';
                    $titulo        = "FACTURA No.";

                    $Cliente = Cliente::where('identificacion_cli', '=', $a_nombre_de)
                    ->get();

                    foreach ($Cliente as $cl) {
                         $email_cliente = $cl->email_cli;
                    }


                    $directorio = $this->Generar_XML($cufe, $numfact, $opcion);
                                      
                    $pdfService = new PdfService();
                    $pdf = $pdfService->generarCopiaFactura($anio_trabajo, $numfact, $directorio);


                    $archivo = $this->Comprimir_Zip($directorio, $numfact, $opcion);
              
                    $nombre_fact =  $numfact.'_'.$opcion;
                    $this->Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente);

                    $ft->status_envio_email = '1';
                    $ft->save();

                    var_dump($ft->status_envio_email);               


               }
          }          
     }


     private function Generar_XML($cufe, $numerofactura, $opcion){
          $downloadUrl = "https://notaria13cali.binario.shop/factura/get-attached/{$cufe}";

          try {
              $client = new Client([
                 'cookies' => true,
                 'verify' => public_path('cacert.pem'),
                 'headers' => [
                    'User-Agent' => 'Mozilla/5.0',
                    ]
               ]);

        // 1. Obtener CSRF token
              $loginPage = $client->get('https://notaria13cali.binario.shop/panel/login/');
              $html = (string) $loginPage->getBody();
              $crawler = new Crawler($html);
              $csrfToken = $crawler->filter('input[name="csrfmiddlewaretoken"]')->attr('value');

        // 2. Login con token
              $loginResponse = $client->post('https://notaria13cali.binario.shop/panel/login/', [
                 'form_params' => [
                    'username' => 'facturacion',
                    'password' => 'notaria13cali',
                    'csrfmiddlewaretoken' => $csrfToken,
                    'next' => '/factura/list/',
                    ],
                    'headers' => [
                    'Referer' => 'https://notaria13cali.binario.shop/panel/login/',
                    ]
               ]);

        // 3. Descargar XML autenticado
              $xmlResponse = $client->get($downloadUrl);
              $contenido = $xmlResponse->getBody()->getContents();
              $AttachedDocument = $contenido;

              $carpeta_destino_cliente = public_path("cliente/");
              $nombre_directorio = $numerofactura . '_' . $opcion;

              if(file_exists($carpeta_destino_cliente)) {

                    // Crea el subdirectorio si no existe
                    $ruta_subdirectorio = $carpeta_destino_cliente . $nombre_directorio;
                    if (!file_exists($ruta_subdirectorio)) {
                         mkdir($ruta_subdirectorio, 0777, true); // Crea la carpeta con permisos
                    }

                    // Guarda el archivo XML en el subdirectorio
                    $fh = fopen($ruta_subdirectorio . '/' . $numerofactura . '_' . $opcion . "_AttachedDocument.xml", 'w') 
                         or die("Se produjo un error al crear el archivo");
                    $texto = preg_replace("/[\r\n|\n|\r]+/", " ", $AttachedDocument);
                    fwrite($fh, $texto) or die("No se pudo escribir en el archivo");
                    fclose($fh);

                    // 4️⃣ Retorna la ruta del subdirectorio
                    return $nombre_directorio;

               } else {
                         echo "No existe el directorio cliente";
                    }

          } catch (\Exception $e) {
              
          }
     }


     private function Comprimir_Zip($directorio, $numfact, $opcion){
          // 1. Nombre del archivo ZIP final
          $nombreZip = "FACTURA_{$numfact}_{$opcion}.zip";
          //$rutaZip = $directorio . '/' . $nombreZip;
          $rutaZip = public_path("cliente/{$directorio}/{$nombreZip}");
         

          // 2. Instanciar el objeto ZipArchive
          $zip = new ZipArchive();

          if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true){

               // 3. Buscar los archivos PDF y XML en el directorio
               /*$archivos = glob(public_path('cliente/'.$directorio).'/*.{pdf,xml}', GLOB_BRACE); */

               $archivos = glob(public_path("cliente/{$directorio}/*.{pdf,xml}"), GLOB_BRACE); 

               foreach ($archivos as $archivo) {
                   
                    // Obtener el nombre del archivo sin la ruta
                    $nombreArchivo = basename($archivo);

                    // Agregar el archivo al ZIP
                    $zip->addFile($archivo, $nombreArchivo);
               }

               // 4. Cerrar el ZIP
               $zip->close();

               // 5. Eliminar los archivos sueltos (PDF y XML)
               foreach ($archivos as $archivo) {
                    unlink($archivo);
               }

               // 6. Guardar el ZIP en una variable para luego enviarlo por correo
               $rutaPublica = "cliente/{$directorio}/{$nombreZip}";
               return $rutaPublica;

               //echo "Archivo ZIP creado y archivos originales eliminados exitosamente: " . $archivo;

          } else {
               //echo "No se pudo crear el archivo ZIP.";
               }
     }


     private function Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente){
         
          $Enviar = array();
          $Enviar = [
               'num_fact' => $nombre_fact,
               'titulo' => $titulo,
               'archivo' => $archivo
          ];

          Mail::to($email_cliente)->queue(new FacturaElectronica($Enviar));

     }
}

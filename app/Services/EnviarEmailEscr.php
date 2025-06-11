<?php

namespace App\Services;

use App\Credenciales_api;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use App\mail\FacturaElectronica;
use App\Facturas;
use ZipArchive;
use File;
use Illuminate\Support\Facades\Mail;
use App\Services\PdfService;

class EnviarEmailEscr
{
    public function EnviarCorreoSegundoPlano($cf, $numerofactura, $opcion, $email_cliente)
    {

    	$titulo = "FACTURA No.";  	
       
        $directorio = $this->Generar_XML($cf, $numerofactura, $opcion);
        $factura = \App\Facturas::find($numerofactura);
        $anio_trabajo = $factura->anio_radica;
       

        if (!$directorio) {
            // Falla en generar XML
            return;
        }

        $pdfService = new PdfService();
        if($opcion == 'F1'){
            $pdfService->generarCopiaFactura($anio_trabajo, $numerofactura, $directorio);
        }elseif($opcion == 'NC'){
            $pdfService->GenerarCopiaNotaCredito($numerofactura, $directorio);
        }        

        $archivo = $this->Comprimir_Zip($directorio, $numerofactura, $opcion);
        $nombre_fact = $numerofactura . '_' . $opcion;
        $this->Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente);

        // Actualiza estado de la factura
        if ($factura) {
            $factura->status_envio_email = '1';
            $factura->save();
        }

         return response()->json([
      			"status"=>1      		
    		]);


    }

     private function Generar_XML($cufe, $numerofactura, $opcion)
    {
        try {
            $Credenciales = Credenciales_api::find(1);
            $url       = rtrim($Credenciales->url_cufe_escr, '/') . '/';
            $url_login = rtrim($Credenciales->url_cufe_login, '/') . '/';
            $usuario   = $Credenciales->user_cufe_escr;
            $password  = $Credenciales->pwd_cufe_escr;
            $downloadUrl = $url . $cufe;

            $client = new Client([
                'cookies' => true,
                'verify' => public_path('cacert.pem'),
                'headers' => ['User-Agent' => 'Mozilla/5.0']
            ]);

            $loginPage = $client->get($url_login);
            $html = (string) $loginPage->getBody();
            $crawler = new Crawler($html);
            $csrfToken = $crawler->filter('input[name="csrfmiddlewaretoken"]')->attr('value');

            $client->post($url_login, [
                'form_params' => [
                    'username' => $usuario,
                    'password' => $password,
                    'csrfmiddlewaretoken' => $csrfToken,
                    'next' => '/factura/list/',
                ],
                'headers' => ['Referer' => $url_login]
            ]);

            $xmlResponse = $client->get($downloadUrl);
            $AttachedDocument = $xmlResponse->getBody()->getContents();

            $carpeta_destino_cliente = public_path("cliente/");
            $nombre_directorio = $numerofactura . '_' . $opcion;
            $ruta_subdirectorio = $carpeta_destino_cliente . $nombre_directorio;

            if (!file_exists($ruta_subdirectorio)) {
                mkdir($ruta_subdirectorio, 0777, true);
            }

            $filePath = $ruta_subdirectorio . '/' . $numerofactura . '_' . $opcion . "_AttachedDocument.xml";
            file_put_contents($filePath, preg_replace("/[\r\n|\n|\r]+/", " ", $AttachedDocument));

            return $nombre_directorio;

        } catch (\Exception $e) {
            // log o ignorar
            return null;
        }
    }

     private function Comprimir_Zip($directorio, $numfact, $opcion)
    {
        $nombreZip = "FACTURA_{$numfact}_{$opcion}.zip";
        $rutaZip = public_path("cliente/{$directorio}/{$nombreZip}");

        $zip = new ZipArchive();

        if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $archivos = glob(public_path("cliente/{$directorio}/*.{pdf,xml}"), GLOB_BRACE);

            foreach ($archivos as $archivo) {
                $zip->addFile($archivo, basename($archivo));
            }

            $zip->close();

            foreach ($archivos as $archivo) {
                unlink($archivo);
            }

            return "cliente/{$directorio}/{$nombreZip}";
        }

        return null;
    }

     private function Enviar_mail($nombre_fact, $titulo, $archivo, $email_cliente)
    {
        $Enviar = [
            'num_fact' => $nombre_fact,
            'titulo' => $titulo,
            'archivo' => $archivo
        ];

        Mail::to($email_cliente)->queue(new FacturaElectronica($Enviar));
    }

}
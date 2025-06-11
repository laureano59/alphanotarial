<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\Credenciales_api;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;


class GenerarxmlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
              
    }

    public function GenerarXml(Request $request)
    {

          $Credenciales = Credenciales_api::find(1);
          $url       = $Credenciales->url_cufe_escr;
          $url_login = $Credenciales->url_cufe_login;
          $usuario   = $Credenciales->user_cufe_escr;
          $password  = $Credenciales->pwd_cufe_escr;
          $url_login = rtrim($url_login, '/') . '/';
          $url       = rtrim($url, '/') . '/';
                 

    $anio_trabajo = $request->session()->get('anio_trabajo');
    $num_fact = $request->session()->get('numfact');

    $factura = Factura::where('id_fact', $num_fact)
                ->where('anio_radica', $anio_trabajo)
                ->first();

    if (!$factura || !$factura->cufe) {
        return response()->json(['error' => 'Factura no encontrada o sin CUFE'], 404);
    }

    $cufe = $factura->cufe;
    $fechaActual = date('Y-m-d'); // Puedes usar otro formato si prefieres
    $nomarchi = $num_fact . '_' . $fechaActual;
    $downloadUrl = $url . $cufe; 

    try {
        $client = new Client([
            'cookies' => true,
            'verify' => public_path('cacert.pem'),
            'headers' => [
                'User-Agent' => 'Mozilla/5.0',
            ]
        ]);

        // 1. Obtener CSRF token
        $loginPage = $client->get($url_login);
        $html = (string) $loginPage->getBody();
        $crawler = new Crawler($html);
        $csrfToken = $crawler->filter('input[name="csrfmiddlewaretoken"]')->attr('value');

        // 2. Login con token
        $loginResponse = $client->post($url_login, [
            'form_params' => [
                'username' => $usuario,
                'password' => $password,
                'csrfmiddlewaretoken' => $csrfToken,
                'next' => '/factura/list/',
            ],
            'headers' => [
                'Referer' => $url_login,
            ]
        ]);

        // 3. Descargar XML autenticado
        $xmlResponse = $client->get($downloadUrl);
        $contenido = $xmlResponse->getBody()->getContents();

        $directorio = public_path("cliente/xml");
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }

        $rutaCompleta = "{$directorio}/{$nomarchi}.xml";
        file_put_contents($rutaCompleta, $contenido);

        return response()->json([
            'message' => 'XML descargado correctamente.',
            'archivo' => $rutaCompleta,
            'url_publica' => asset("cliente/xml/{$nomarchi}.xml")
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Error durante el proceso.',
            'detalle' => $e->getMessage()
        ], 500);
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
        //
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
}

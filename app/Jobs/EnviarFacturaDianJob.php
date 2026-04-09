<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Controllers\EinvoiceController;
use App\Http\Controllers\FelectronicaescriturasController;
use Illuminate\Http\Request;


class EnviarFacturaDianJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;      // Reintentos automáticos
    public $timeout = 180;  // Tiempo máximo por intento (segundos)

    protected $num_fact;
    protected $opcion;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($num_fact, $opcion)
    {
        $this->num_fact = $num_fact;
        $this->opcion   = $opcion;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         try {

            // Simulamos el request que tú usas normalmente
            $request = new Request();
            $request->merge([
                'num_fact' => $this->num_fact,
                'opcion'   => $this->opcion
            ]);

            // Instanciamos tu controlador real
            $controller = new EinvoiceController();
            //$controller = new FelectronicaescriturasController();

            // Llama al método que ya tienes para enviar la FE
            //$controller->index($request);
             return $controller->index($request); 
             //$controller->Envio_FE($request);
            

        } catch (\Exception $e) {

            \Log::error("Error enviando factura DIAN: " . $this->num_fact);
            \Log::error($e->getMessage());

            throw $e; // importante para que reintente
        }
    }
}


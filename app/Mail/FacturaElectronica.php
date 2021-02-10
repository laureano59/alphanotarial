<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FacturaElectronica extends Mailable
{
    use Queueable, SerializesModels;
    public $Enviar;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($Enviar)
    {
        $this->Enviar = $Enviar;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.factura_electronica')
                ->attach(public_path('/').$this->Enviar['archivo']);
    }
}

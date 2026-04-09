<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Dian\XmlBuilder\FacturaXmlBuilder;

class Factura extends Model
{
    protected $primaryKey = 'id_fact';

    /**
     * Genera el XML UBL 2.1 sin firmar de esta factura.
     */
    public function generarXmlSinFirmar()
    {
        return app(FacturaXmlBuilder::class)->generar($this);
    }
}

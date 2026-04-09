<?php

namespace App\Services\FEL;

use DOMDocument;
use RobRichards\XMLSecLibs\XMLSecurityDSig;
use RobRichards\XMLSecLibs\XMLSecurityKey;

class FirmaFELService
{
    private string $privateKeyPath;
    private string $certificatePath;

    public function __construct()
    {
        $this->privateKeyPath = config('fel.private_key');
        $this->certificatePath = config('fel.certificate');
    }

    public function firmarXML(string $xmlSinFirmar): string
    {
        // 1. Cargar XML
        $doc = new DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = true;
        $doc->loadXML($xmlSinFirmar);

        // 2. Crear firma digital
        $objDSig = new XMLSecurityDSig();
        $objDSig->setCanonicalMethod(XMLSecurityDSig::EXC_C14N);
        $objDSig->addReference(
            $doc,
            XMLSecurityDSig::SHA256,
            ['http://www.w3.org/2000/09/xmldsig#enveloped-signature']
        );

        // 3. Cargar llave privada
        $objKey = new XMLSecurityKey(XMLSecurityKey::RSA_SHA256, ['type' => 'private']);
        $objKey->loadKey($this->privateKeyPath, true);

        // 4. Firmar
        $objDSig->sign($objKey);

        // 5. Agregar certificado público
        $objDSig->add509Cert(file_get_contents($this->certificatePath));

        // 6. Insertar firma en el nodo raíz
        $objDSig->appendSignature($doc->documentElement);

        // 7. Retornar XML firmado
        return $doc->saveXML();
    }
}

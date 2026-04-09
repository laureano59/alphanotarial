<?php

namespace App\Services\Dian\XsdValidator;

use DOMDocument;

class DianXsdValidator
{
    protected string $mainDocPath;

    public function __construct()
    {
        // Carpeta real donde tienes los XSD de maindoc
        $this->mainDocPath = storage_path('app/dian/xsd/maindoc/');
    }

    /**
     * Valida un XML contra los XSD de DIAN (Invoice / CreditNote / DebitNote)
     */
    public function validate(string $xmlContent, string $documentType = 'Invoice'): array
    {
        libxml_use_internal_errors(true);

        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = false;

        if (!$doc->loadXML($xmlContent)) {
            return [
                'success' => false,
                'errors'  => ['No se pudo cargar el XML.']
            ];
        }

        // Selecciona el XSD correcto desde maindoc/
        if ($documentType === 'CreditNote') {
            $xsdFile = 'UBL-CreditNote-2.1.xsd';
        } elseif ($documentType === 'DebitNote') {
            $xsdFile = 'UBL-DebitNote-2.1.xsd';
        } else {
            // Default: Factura
            $xsdFile = 'UBL-Invoice-2.1.xsd';
        }

        $fullPath = $this->mainDocPath . $xsdFile;

        if (!file_exists($fullPath)) {
            return [
                'success' => false,
                'errors'  => ["No se encontró el archivo XSD: $fullPath"]
            ];
        }

        // Validación
        $valid = $doc->schemaValidate($fullPath);

        if (!$valid) {
            $formatted = $this->formatErrors(libxml_get_errors());
            libxml_clear_errors();

            return [
                'success' => false,
                'errors'  => $formatted
            ];
        }

        return [
            'success' => true,
            'errors'  => []
        ];
    }

    /**
     * Limpia errores de libxml para devolverlos en texto entendible.
     */
    private function formatErrors(array $errors): array
    {
        $msgs = [];

        foreach ($errors as $error) {
            $msgs[] = "Línea {$error->line}: " . trim($error->message);
        }

        return $msgs;
    }
}

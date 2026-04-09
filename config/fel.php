<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Ambiente FEL
    |--------------------------------------------------------------------------
    | 'habilitacion' para pruebas / 'produccion' para vivo
    */
    'ambiente' => env('FEL_AMBIENTE', 'habilitacion'),

    /*
    |--------------------------------------------------------------------------
    | Endpoints (WSDL / SOAP) por ambiente
    |--------------------------------------------------------------------------
    | RUTA WSDL/endpoint que te entrega la DIAN. Reemplaza las urls
    | por las que te entregue DIAN en habilitación/producción.
    */
    'endpoints' => [
        'habilitacion' => env('FEL_ENDPOINT_HAB', 'https://wstest.dian.gov.co/Carpeta/ServicioHabilitacion?wsdl'),
        'produccion'   => env('FEL_ENDPOINT_PROD', 'https://www.dian.gov.co/Carpeta/ServicioProduccion?wsdl'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Operación SOAP por defecto
    |--------------------------------------------------------------------------
    | Nombre de la operación en el WSDL que se usará para enviar el zip/xml.
    | Ajusta a la operación real que indique el WSDL de DIAN (ej: SendBill).
    */
    'ws_operation' => env('FEL_WS_OPERATION', 'SendBill'),

    /*
    |--------------------------------------------------------------------------
    | Rutas a certificados (por defecto en storage/app/fel/certs)
    |--------------------------------------------------------------------------
    | No dejes estos archivos en el repo. En producción usa Vault/KMS si es posible.
    */
    'cert' => env('FEL_CERT_PATH', storage_path('app/fel/certs/cert.pem')),
    'priv_key' => env('FEL_PRIV_KEY_PATH', storage_path('app/fel/certs/priv.key')),

    /*
    |--------------------------------------------------------------------------
    | NIT emisor y correo recepción (informativo)
    |--------------------------------------------------------------------------
    */
    'nit' => env('FEL_NIT', ''),
    'correo_recepcion' => env('FEL_EMAIL_RECEPCION', ''),

    /*
    |--------------------------------------------------------------------------
    | Modelo de factura (ajusta si tu modelo está en otro namespace)
    |--------------------------------------------------------------------------
    */
    'factura_model' => env('FEL_FACTURA_MODEL', 'App\\Factura'),

    /*
    |--------------------------------------------------------------------------
    | Storage disk para archivos FEL (usar disk configurado en filesystems.php)
    |--------------------------------------------------------------------------
    */
    'storage_disk' => env('FEL_STORAGE_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Opciones adicionales
    |--------------------------------------------------------------------------
    */
    'log_soap_requests' => env('FEL_LOG_SOAP', false),

];

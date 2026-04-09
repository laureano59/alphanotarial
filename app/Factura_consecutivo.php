<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura_consecutivo extends Model
{
    protected $table = 'factura_consecutivos';

    public $timestamps = false;

    protected $casts = [
        'consecutivo' => 'integer',
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
  protected $table = 'departamento';
  protected $primaryKey = 'id_depa';

  public $incrementing = false;
  protected $keyType = 'string';
  
}

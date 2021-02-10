<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  //Retorna la relación de los usuarios con los roles
  public function users(){
    return $this->belongsTomany('App\User');//Relación muchos a muchos
  }
}

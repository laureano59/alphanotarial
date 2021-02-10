<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    //Retorna la relación de los roles con el usuario
    public function roles(){
      return $this->belongsTomany('App\Role');//Relación muchos a muchos
    }

    /*********Validamos si el usuario es autorizado*********/
    public function authorizeRoles($roles){
      if($this->hasAnyRole($roles)){
        return true;
      }
      abort(401,'Esta acción no está autorizada para su usuario');
    }

    /**********Validamos si el usuario tiene uno o varios roles***********/

    public function hasAnyRole($roles){
      if(is_array($roles)){
        foreach ($roles as $role) {
          if($this->hasRole($role)){
            return true;
          }
        }
      } else{
        if($this->hasRole($roles)){
          return true;
        }
      }
      return false;
    }

    /********Valida si el usuario tiene asignado un rol********/

    public function hasRole($role){
      if($this->roles()->where('name',$role)->first()){
        return true;
      }
      return false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'telefono', 'direccion', 'cargo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

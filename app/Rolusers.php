<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rolusers extends Model
{
    protected $table = 'role_user';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'role_id'];
}

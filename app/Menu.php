<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillable = [
        'nombre',
        'icono',
        'ruta',
        'html_id',
        'parent_id',
        'orden',
        'activo'
    ];

    // Hijos
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id')
                    ->where('activo', 1)
                    ->orderBy('orden');
    }

    // Relación recursiva 🔥
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }
}
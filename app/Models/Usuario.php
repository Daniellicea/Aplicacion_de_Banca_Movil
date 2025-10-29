<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    // 👇 Permitir asignación masiva en estos campos
    protected $fillable = [
        'nombre', 'correo', 'contrasena',
    ];

    protected $hidden = [
        'contrasena',
    ];
}

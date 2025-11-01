<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    public $timestamps = true;

    // ✅ Coincidir con columnas reales
    protected $fillable = ['nombre', 'correo', 'contrasena'];

    // ✅ Ocultar contraseña real
    protected $hidden = ['contrasena', 'remember_token'];

    // ✅ Laravel usa este campo como contraseña
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    // ✅ Por si usas recuperación
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }
}

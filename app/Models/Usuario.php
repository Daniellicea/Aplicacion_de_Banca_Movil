<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Usuario extends Authenticatable
{
    use Notifiable, CanResetPassword;

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

    // ✅ Indicar a Laravel que el campo de correo se llama 'correo'
    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }

    // ✅ Sobrescribir el campo de autenticación principal (username)
    public function getAuthIdentifierName()
    {
        return 'correo';
    }
}

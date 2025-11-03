<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $fillable = [
        'usuario_id', 'descripcion', 'monto', 'tipo', 'fecha'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}

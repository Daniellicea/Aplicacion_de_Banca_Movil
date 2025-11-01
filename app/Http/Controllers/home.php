<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class Home extends Controller
{
    public function home()
    {
        // Toma el id guardado por tu middleware/login
        $id = session('usuario_id');

        // Carga el usuario fresco desde la BD
        $usuario = $id ? Usuario::find($id) : null;

        // Cargar la vista correcta del dashboard
        return view('home.dashboard', compact('usuario'));
    }
}

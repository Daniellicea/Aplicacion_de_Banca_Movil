<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class HomeController extends Controller
{
    public function home()
    {
        // Toma el id guardado por tu middleware/login
        $id = session('usuario_id');

        // Carga el usuario fresco desde la BD
        $usuario = $id ? Usuario::find($id) : null;

        // Inicializar saldo real si no existe (para pruebas)
        if (!session()->has('saldo_real')) {
            session(['saldo_real' => 5000.00]);
        }
        $saldo_real = session('saldo_real');

        // Otros datos opcionales del dashboard
        $totalIngresos = 8500.00;
        $totalGastos = 545.50;

        // Retornar vista con usuario y saldo
        return view('home.dashboard', compact('usuario', 'saldo_real', 'totalIngresos', 'totalGastos'));
    }
}

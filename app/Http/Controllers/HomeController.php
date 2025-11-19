<?php

namespace App\Http\Controllers;

use App\Models\Usuario;

class HomeController extends Controller
{
    public function home()
    {
        // Obtener usuario autenticado correctamente
        $usuario = auth()->user();  // ← ESTA ES LA FORMA CORRECTA EN LARAVEL

        // Inicializar saldo real si no existe (solo para pruebas o demo)
        if (!session()->has('saldo_real')) {
            session(['saldo_real' => 5000.00]);
        }

        $saldo_real = session('saldo_real');

        // Otros datos opcionales del dashboard
        $totalIngresos = 8500.00;
        $totalGastos = 545.50;

        // Pasar datos a la vista del dashboard
        return view('home.dashboard', compact(
            'usuario',
            'saldo_real',
            'totalIngresos',
            'totalGastos'
        ));
    }
}

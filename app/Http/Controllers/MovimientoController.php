<?php
namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'monto' => 'required|numeric',
            'tipo' => 'required|in:abono,cargo'
        ]);

        Movimiento::create([
            'usuario_id' => session('usuario_id'),
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'tipo' => $request->tipo
        ]);

        return redirect()->route('users.account')->with('success', 'Movimiento creado');
    }

    public function update(Request $request, Movimiento $movimiento)
    {
        $request->validate([
            'descripcion' => 'required|string',
            'monto' => 'required|numeric',
            'tipo' => 'required|in:abono,cargo'
        ]);

        $movimiento->update($request->all());

        return redirect()->route('users.account')->with('success', 'Movimiento actualizado');
    }

    public function destroy(Movimiento $movimiento)
    {
        $movimiento->delete();

        return redirect()->route('users.account')->with('success', 'Movimiento eliminado');
    }
}

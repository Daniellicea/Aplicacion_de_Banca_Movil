<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // PERFIL DEL USUARIO LOGUEADO
    public function profile()
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);
        return view('users.index', compact('usuario'));
    }

    public function updateProfile(Request $request)
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'correo'   => "required|email|unique:usuarios,correo,{$usuario->id}",
            'password' => 'nullable|min:8|confirmed',
        ]);

        $usuario->nombre = $request->nombre;

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('users.profile')->with('success', 'Perfil actualizado correctamente.');
    }

    public function updatePassword(Request $request)
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $usuario->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        $usuario->password = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('users.profile')->with('success', 'Contraseña actualizada correctamente.');
    }

    public function destroyAccount()
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        session()->flush();
        $usuario->delete();

        return redirect()->route('welcome')->with('success', 'Tu cuenta ha sido eliminada.');
    }

    // ✅ Vista de cuentas CON SALDO Y MOVIMIENTOS
    public function account()
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        // Obtener saldo total del usuario
        $balance = \App\Models\Movimiento::where('usuario_id', $id)
            ->selectRaw("SUM(CASE WHEN tipo = 'abono' THEN monto ELSE -monto END) as balance")
            ->value('balance') ?? 0;

        // Definir cuenta del usuario (puedes ampliar después)
        $accounts = [
            [
                'type' => 'Cuenta de Débito',
                'name' => $usuario->nombre,
                'number' => '****' . str_pad($usuario->id, 4, '0', STR_PAD_LEFT),
                'balance' => $balance
            ]
        ];

        // Obtener movimientos reales
        $transactions = \App\Models\Movimiento::where('usuario_id', $id)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('users.accounts', compact('usuario', 'accounts', 'transactions'));
    }

    // CRUD ADMIN DE USUARIOS
    public function index()
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        $usuarios = Usuario::orderBy('id', 'desc')->paginate(10);

        return view('users.index', compact('usuario', 'usuarios'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'correo'   => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:8|confirmed',
        ]);

        Usuario::create([
            'nombre'   => $request->nombre,
            'correo'   => $request->correo,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('users.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'correo'   => "nullable|email|unique:usuarios,correo,{$id}",
            'password' => 'nullable|min:8|confirmed',
        ]);

        $usuario->nombre = $request->nombre;

        if ($request->filled('correo')) {
            $usuario->correo = $request->correo;
        }

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}

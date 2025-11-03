<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ==========================
    // PERFIL DEL USUARIO LOGUEADO
    // ==========================
    public function profile()
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        // Cargamos la vista unificada (perfil + formularios)
        return view('users.index', compact('usuario'));
    }

    public function updateProfile(Request $request)
    {
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre'   => 'required|string|max:255',
            // El correo llega como hidden (porque el input visible está disabled)
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

    // Vista de cuentas (dashboard card)
public function account()
{
    $id = session('usuario_id');
    $usuario = Usuario::findOrFail($id);

    // ==========================
    // Datos simulados de cuentas
    // ==========================
    $accounts = [
        [
            'type' => 'Cuenta de Ahorro',
            'name' => 'Ahorros personales',
            'number' => '1234 5678 9012',
            'balance' => 15250.75,
        ],
        [
            'type' => 'Cuenta Corriente',
            'name' => 'Gastos diarios',
            'number' => '9876 5432 1098',
            'balance' => 2980.00,
        ],
    ];

    // ==========================
    // Movimientos simulados
    // ==========================
    $transactions = [
        [
            'description' => 'Depósito Nómina',
            'date' => '2025-10-28',
            'amount' => 8500.00,
            'type' => 'credit',
        ],
        [
            'description' => 'Pago de Luz CFE',
            'date' => '2025-10-26',
            'amount' => -480.50,
            'type' => 'debit',
        ],
        [
            'description' => 'Compra en OXXO',
            'date' => '2025-10-24',
            'amount' => -65.00,
            'type' => 'debit',
        ],
    ];

    // ==========================
    // Retornar vista con datos
    // ==========================
    return view('users.accounts', [
        'usuario' => $usuario,
        'accounts' => $accounts,
        'transactions' => $transactions,
    ]);
}


    // ==========================
    // CRUD ADMIN DE USUARIOS
    // ==========================
    public function index()
    {
        // Para la vista unificada que muestra el perfil arriba
        $id = session('usuario_id');
        $usuario = Usuario::findOrFail($id);

        // Lista para la tabla de administración (si la usas en esa misma vista)
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
            // Para admin: permitir correo editable, respetando unicidad
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra la lista de todos los usuarios (Read - R)
     * GET /usuarios
     */
    public function index()
    {
        $usuarios = Usuario::all();

        // ✅ ahora busca la vista en /resources/views/users/index.blade.php
        return view('users.index', compact('usuarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario (Create - C)
     * GET /usuarios/create
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Guarda un nuevo usuario en la base de datos (Store - C)
     * POST /usuarios
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|string|max:255',
            'correo'    => 'required|email|unique:usuarios,correo',
            'password'  => 'required|min:8|confirmed',
        ]);

        Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'contrasena' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', '✅ Usuario creado exitosamente.');
    }

    /**
     * Muestra un usuario específico (Show - R)
     * GET /usuarios/{usuario}
     */
    public function show(Usuario $usuario)
    {
        return view('users.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar un usuario (Edit - U)
     * GET /usuarios/{usuario}/edit
     */
    public function edit(Usuario $usuario)
    {
        return view('users.edit', compact('usuario'));
    }

    /**
     * Actualiza un usuario en la base de datos (Update - U)
     * PUT/PATCH /usuarios/{usuario}
     */
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'correo'   => "required|email|unique:usuarios,correo,{$usuario->id}",
            'password' => 'nullable|min:8|confirmed',
        ]);

        $data = [
            'nombre' => $request->nombre,
            'correo' => $request->correo,
        ];

        if ($request->filled('password')) {
            $data['contrasena'] = Hash::make($request->password);
        }

        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', '✏️ Usuario actualizado exitosamente.');
    }

    /**
     * Elimina un usuario (Delete - D)
     * DELETE /usuarios/{usuario}
     */
    public function destroy(Usuario $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')
            ->with('success', '🗑️ Usuario eliminado exitosamente.');
    }

    /**
     * Página de cuentas del usuario (ya la tenías en tu sistema)
     */
    public function account()
    {
        $accounts = [
            [
                'type' => 'Cuenta de Ahorro',
                'name' => 'Ahorros Personales',
                'number' => '**** 4582',
                'balance' => 15230.75,
            ],
            [
                'type' => 'Cuenta Corriente',
                'name' => 'Cuenta Principal',
                'number' => '**** 9923',
                'balance' => 8740.00,
            ],
        ];

        $transactions = [
            [
                'description' => 'Depósito en efectivo',
                'date' => '2025-10-21',
                'type' => 'credit',
                'amount' => 2000.00,
            ],
            [
                'description' => 'Pago de servicios',
                'date' => '2025-10-20',
                'type' => 'debit',
                'amount' => -450.00,
            ],
            [
                'description' => 'Transferencia recibida',
                'date' => '2025-10-19',
                'type' => 'credit',
                'amount' => 1250.00,
            ],
        ];

        return view('users.accounts', [
            'accounts' => $accounts,
            'transactions' => $transactions,
        ]);
    }
}

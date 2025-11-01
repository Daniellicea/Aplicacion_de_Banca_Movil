<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'correo'   => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $request->correo)->first();

        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {

            $request->session()->regenerate();

            session([
                'usuario_id'     => $usuario->id,
                'usuario_nombre' => $usuario->nombre,
                'usuario_correo' => $usuario->correo,
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'correo' => 'Correo o contraseña incorrectos.',
        ])->withInput(['correo' => $request->correo]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'correo'   => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:8|confirmed',
        ]);

        $usuario = Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'contrasena' => Hash::make($request->password),
        ]);

        $request->session()->regenerate();

        session([
            'usuario_id'     => $usuario->id,
            'usuario_nombre' => $usuario->nombre,
            'usuario_correo' => $usuario->correo,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->forget(['usuario_id', 'usuario_nombre', 'usuario_correo']);

        return redirect()->route('login.form');
    }

    public function security()
    {
        return view('auth.security');
    }
}

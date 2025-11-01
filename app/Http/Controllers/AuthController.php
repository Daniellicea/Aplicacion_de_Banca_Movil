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
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $usuario = Usuario::where('correo', $request->email)->first();

        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {

            // Seguridad: regenerar la sesión
            $request->session()->regenerate();

            // Guardar en sesión
            session([
                'usuario_id'     => $usuario->id,
                'usuario_nombre' => $usuario->nombre,
            ]);

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Correo o contraseña incorrectos.'
        ])->withInput(['email' => $request->email]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:usuarios,correo',
            'password' => 'required|min:6|confirmed'
        ]);

        $usuario = Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->email,
            'contrasena' => Hash::make($request->password),
        ]);

        // Seguridad: regenerar la sesión
        $request->session()->regenerate();

        session([
            'usuario_id'     => $usuario->id,
            'usuario_nombre' => $usuario->nombre,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        // Invalida y regenera token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Limpia claves propias
        session()->forget(['usuario_id', 'usuario_nombre']);

        return redirect()->route('login.form');
    }

    public function security()
    {
        return view('auth.security');
    }
}

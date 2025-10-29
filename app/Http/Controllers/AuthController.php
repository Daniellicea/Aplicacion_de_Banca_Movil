<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        // Buscar usuario por correo
        $usuario = Usuario::where('correo', $request->email)->first();

        // Verificar contraseña hasheada en columna 'contrasena'
        if ($usuario && Hash::check($request->password, $usuario->contrasena)) {
            // Guardar sesión (si no usas guards de Auth)
            session(['usuario_id' => $usuario->id]);

            return redirect()->route('dashboard'); // o ->to('/dashboard')
        }

        return back()
            ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
            ->withInput(['email' => $request->email]);
    }

    public function logout() {
        session()->flush();
        return redirect()->route('login.form'); // o ->to('/login')
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'                  => ['required','string','max:255'],
            'email'                 => ['required','email','max:255','unique:usuarios,correo','confirmed'],
            'password'              => ['required','string','min:8','confirmed'],
        ]);

        Usuario::create([
            'nombre'     => $request->name,
            'correo'     => $request->email,
            'contrasena' => Hash::make($request->password),
        ]);

        return redirect()->route('login.form')
            ->with('success', 'Usuario registrado correctamente.');
    }
}

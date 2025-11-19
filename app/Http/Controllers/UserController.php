<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ==========================
    // PERFIL
    // ==========================
    public function profile()
    {
        $usuario = auth()->user();

        return view('users.profile', compact('usuario'));
    }

    public function updateProfile(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => "required|email|unique:usuarios,correo,{$usuario->id}",
        ]);

        $usuario->nombre = $request->nombre;
        $usuario->save();

        session(['usuario_nombre' => $usuario->nombre]);

        return redirect()->route('users.profile')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    // ==========================
    // CONTRASEÑA
    // ==========================
    public function updatePassword(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $usuario->contrasena)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        $usuario->contrasena = Hash::make($request->password);
        $usuario->save();

        return redirect()->route('users.profile')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    // ==========================
    // ELIMINAR CUENTA
    // ==========================
    public function destroyAccount()
    {
        $usuario = auth()->user();

        session()->flush();
        $usuario->delete();

        return redirect()->route('login.form')
            ->with('success', 'Tu cuenta ha sido eliminada.');
    }

    // ==========================
    // AVATAR
    // ==========================
    public function uploadAvatar(Request $request)
    {
        $usuario = auth()->user();

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
        ]);

        if ($usuario->avatar_url) {
            $path = str_replace('/storage/', '', $usuario->avatar_url);
            Storage::disk('public')->delete($path);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $usuario->avatar_url = '/storage/' . $path;
        $usuario->save();

        return back()->with('success', '¡Foto de perfil actualizada con éxito!');
    }

    public function deleteAvatar()
    {
        $usuario = auth()->user();

        if ($usuario->avatar_url) {
            $path = str_replace('/storage/', '', $usuario->avatar_url);
            Storage::disk('public')->delete($path);

            $usuario->avatar_url = null;
            $usuario->save();

            return back()->with('success', 'Foto de perfil eliminada correctamente.');
        }

        return back()->with('error', 'No hay foto de perfil para eliminar.');
    }

    // ==========================
    // CUENTAS
    // ==========================
    public function account()
    {
        $usuario = auth()->user();

        $accounts = [
            ['type' => 'Cuenta de Ahorro', 'name' => 'Ahorros personales', 'number' => '1234 5678 9012', 'balance' => 15250.75],
            ['type' => 'Cuenta Corriente', 'name' => 'Gastos diarios', 'number' => '9876 5432 1098', 'balance' => 272.50],
        ];

        $transactions = [
            ['description' => 'Depósito Nómina', 'date' => '2025-10-28', 'amount' => 8500.00, 'type' => 'credit'],
            ['description' => 'Pago de Luz CFE', 'date' => '2025-10-26', 'amount' => -480.50, 'type' => 'debit'],
            ['description' => 'Compra en OXXO', 'date' => '2025-10-24', 'amount' => -65.00, 'type' => 'debit'],
        ];

        return view('users.accounts', compact('usuario', 'accounts', 'transactions'));
    }

    // ==========================
    // CRUD DESACTIVADO
    // ==========================
    public function index()
    {
        return redirect()->route('users.profile');
    }

    public function create() { abort(404); }
    public function store(Request $request) { abort(404); }
    public function edit($id) { abort(404); }
    public function update(Request $request, $id) { abort(404); }
    public function destroy($id) { abort(404); }
}

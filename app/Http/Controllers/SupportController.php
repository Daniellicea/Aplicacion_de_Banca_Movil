<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.support');
    }

    public function store(Request $request)
    {
        // Aquí validarás y guardarás el mensaje
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Luego lo puedes enviar por correo o guardar en BD
        // Por ahora dejamos un demo
        return back()->with('success', 'Tu mensaje ha sido enviado. ¡Gracias por contactarnos!');
    }
}

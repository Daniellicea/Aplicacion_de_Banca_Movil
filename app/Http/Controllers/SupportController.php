<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Muestra la vista de soporte
     */
    public function index()
    {
        return view('support.support');
    }

    /**
     * Recibe y procesa el formulario de soporte
     */
    public function store(Request $request)
    {
        // Validación del formulario
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'subject.required' => 'El asunto es obligatorio.',
            'message.required' => 'El mensaje es obligatorio.',
        ]);

        // Aquí puedes guardar en BD o enviar por correo
        // Ejemplo para futura implementación:
        /*
        SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
        ]);
        */

        // Respuesta temporal
        return back()->with('success', 'Tu mensaje ha sido enviado. ¡Gracias por contactarnos!');
    }
}

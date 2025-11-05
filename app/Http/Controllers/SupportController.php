<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    // Mostrar vista de soporte y FAQs
    public function support()
    {
        $faqs = [
            ['question' => '¿Cómo cambio mi contraseña?', 'answer' => 'Puedes cambiar tu contraseña desde la sección Mi Perfil.'],
            ['question' => '¿Cómo reporto un problema?', 'answer' => 'Completa el formulario de soporte y un agente te asistirá.'],
            ['question' => '¿Puedo abrir más de una cuenta?', 'answer' => 'Sí, puedes gestionar múltiples cuentas desde tu panel.'],
        ];

        return view('support.support', compact('faqs'));
    }

    // Procesar formulario de soporte
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:1000'
        ]);

        // En el futuro podemos guardar en DB o mandar email
        return back()->with('success', '✅ Tu mensaje fue enviado exitosamente. Pronto nos pondremos en contacto contigo.');
    }
}

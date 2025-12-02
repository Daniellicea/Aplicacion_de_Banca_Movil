@extends('layouts.app')

@section('title', 'Soporte - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 antialiased">

        {{-- Header Mejorado --}}
        <header class="border-b border-gray-200 bg-white/80 backdrop-blur-sm sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 text-gray-500 hover:text-blue-600 transition-colors p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm uppercase tracking-wider font-bold hidden sm:inline">Volver</span>
                </a>
                <h1 class="text-xl font-extrabold text-gray-900">Soporte y Contacto</h1>
                <div class="w-12"></div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-12 md:py-16 animate-fade-in-up">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Centro de <span class="text-blue-600">Ayuda</span>
            </h2>
            <p class="text-xl text-gray-500 mb-12 max-w-3xl">
                Respuestas a tus preguntas más frecuentes y contacto directo con nuestro equipo de expertos 24/7.
            </p>

            {{-- Mensajes (Integración con variables) --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-400 text-green-700 rounded-xl font-semibold shadow-md flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-10">

                {{-- 1. Formulario de contacto --}}
                <div class="bg-white shadow-3xl shadow-blue-200/50 rounded-3xl p-8 md:p-10 border border-gray-200/70 transition-shadow duration-300 hover:shadow-blue-300/60">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-6 flex items-center gap-3">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 4v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7"></path></svg>
                        Contáctanos
                    </h3>
                    <p class="text-gray-500 mb-8 text-lg">Reporta un problema o realiza una consulta detallada. Te responderemos lo antes posible.</p>

                    <form method="POST" action="{{ route('support.store') }}" class="space-y-6">
                        @csrf

                        {{-- Input Asunto --}}
                        <div class="space-y-2">
                            <label for="subject" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Asunto
                            </label>
                            <input
                                id="subject"
                                name="subject"
                                type="text"
                                placeholder="¿En qué podemos ayudarte?"
                                class="w-full h-12 px-4 text-base bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none"
                                required
                            />
                        </div>

                        {{-- Textarea Mensaje --}}
                        <div class="space-y-2">
                            <label for="message" class="block text-xs font-bold text-gray-700 uppercase tracking-widest">
                                Mensaje
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                placeholder="Describe tu consulta o problema..."
                                class="w-full px-4 py-3 text-base bg-gray-50 border border-gray-300 rounded-xl shadow-inner-sm
                                       focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none resize-none"
                                required
                            ></textarea>
                        </div>

                        {{-- Botón Enviar (Estilo Primario Degradado) --}}
                        <button
                            type="submit"
                            class="w-full h-14 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                                   hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                                   shadow-xl shadow-blue-500/40 mt-8
                                   transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-blue-300"
                        >
                            Enviar Mensaje
                        </button>
                    </form>

                    {{-- Información de contacto --}}
                    <div class="mt-10 pt-8 border-t border-gray-200 space-y-5">
                        <p class="text-lg font-bold text-gray-900">Alternativas de Contacto</p>

                        {{-- Teléfono --}}
                        <div class="flex items-center gap-4 p-3 bg-gray-100 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.144a11.058 11.058 0 005.943 5.943l1.144-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Teléfono</p>
                                <p class="text-base font-semibold text-gray-900">01 800 BANKARIO</p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-center gap-4 p-3 bg-gray-100 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 4v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7"></path></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Email</p>
                                <p class="text-base font-semibold text-gray-900">soporte@bankario.com</p>
                            </div>
                        </div>

                        {{-- Horario --}}
                        <div class="flex items-center gap-4 p-3 bg-gray-100 rounded-xl">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Horario</p>
                                <p class="text-base font-semibold text-gray-900">24/7 disponible</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. Preguntas frecuentes --}}
                <div class="bg-white shadow-xl rounded-3xl p-8 md:p-10 border border-gray-200/70 transition-shadow duration-300 hover:shadow-lg">
                    <h3 class="text-3xl font-extrabold text-gray-900 mb-8 flex items-center gap-3">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9.247a1 1 0 01.768-.535h6.008a1 1 0 01.768.535l2.458 4.793A1 1 0 0118.008 15H5.992a1 1 0 01-.84-.96l2.458-4.793z"></path></svg>
                        Preguntas Frecuentes
                    </h3>

                    <div class="space-y-6">
                        {{-- Asegúrate de que $faqs esté definido y sea un array en tu controlador --}}
                        @php
                            // Simulación de datos FAQS si no están disponibles
                            $faqs = $faqs ?? [
                                ['question' => '¿Cómo puedo cambiar mi NIP?', 'answer' => 'Puedes actualizar tu Número de Identificación Personal (NIP) desde la sección "Mi Perfil" o llamando al 01 800 BANKARIO.'],
                                ['question' => '¿Qué hago si mi tarjeta fue robada?', 'answer' => 'Bloquea tu tarjeta de inmediato desde la app en la sección "Tarjetas" o llama a nuestro servicio de soporte 24/7.']
                            ];
                        @endphp

                        @foreach($faqs as $faq)
                            <div class="pb-6 border-b border-gray-200/70 last:border-b-0 last:pb-0 transition-colors duration-200 hover:bg-gray-100 rounded-lg p-3 -mx-3">
                                <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $faq['question'] }}</h4>
                                <p class="text-base text-gray-500">{{ $faq['answer'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Botón Ver Todas (Estilo Secundario/Outline) --}}
                    <button class="mt-8 w-full h-12 text-lg font-bold border-2 border-blue-400 text-blue-600 hover:border-blue-600 hover:bg-gray-100 transition-all rounded-xl shadow-md transform hover:scale-[1.005]">
                        Ver Todas las Preguntas
                    </button>
                </div>
            </div>
        </main>
    </div>

    {{-- CSS para Animación de Entrada --}}
    <style>
        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInSlideUp 0.6s ease-out forwards;
        }
    </style>
@endsection

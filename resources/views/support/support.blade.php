@extends('layouts.app')

@section('title', 'Soporte - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <!-- Header (Estilo BANKARIO) -->
        <header class="border-b border-gray-200 bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium hidden sm:inline">Volver</span>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Soporte</h1>
                <div class="w-12"></div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-6 py-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                Centro de <span class="text-blue-600">Ayuda</span>
            </h2>
            <p class="text-xl text-gray-500 mb-12">
                Respuestas a tus preguntas y contacto directo con nuestro equipo.
            </p>

            @if(session('success'))
                <div class="mb-8 p-4 text-sm text-green-700 bg-green-100 rounded-xl border border-green-300 shadow-md">
                    <p class="font-semibold">✅ {{ session('success') }}</p>
                </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-10">
                <!-- Formulario de contacto -->
                <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200">
                    <h3 class="text-3xl font-bold text-gray-800 mb-6">Contáctanos</h3>
                    <p class="text-gray-600 mb-8">Utiliza el formulario para reportar un problema o realizar una consulta detallada.</p>

                    <form method="POST" action="{{ route('support.store') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2">
                            <label for="subject" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Asunto
                            </label>
                            <input
                                id="subject"
                                name="subject"
                                type="text"
                                placeholder="¿En qué podemos ayudarte?"
                                class="w-full h-12 px-5 text-base bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors rounded-xl outline-none"
                                required
                            />
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-semibold text-gray-700 uppercase tracking-wider">
                                Mensaje
                            </label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                placeholder="Describe tu consulta o problema..."
                                class="w-full px-5 py-3 text-base bg-gray-50 border border-gray-300 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors rounded-xl outline-none resize-none"
                                required
                            ></textarea>
                        </div>

                        <button
                            type="submit"
                            class="w-full h-14 text-lg font-bold bg-blue-600 hover:bg-blue-700 text-white transition-all rounded-xl shadow-lg shadow-blue-300/50 transform hover:scale-[1.01] duration-300"
                        >
                            Enviar Mensaje
                        </button>
                    </form>

                    <!-- Información de contacto -->
                    <div class="mt-8 pt-8 border-t border-gray-200 space-y-4">
                        <p class="text-base font-bold text-gray-800 mb-2">Alternativas de Contacto</p>
                        <div class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.144a11.058 11.058 0 005.943 5.943l1.144-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Teléfono</p>
                                <p class="text-base font-semibold text-gray-900">01 800 BANKARIO</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-2 4v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7"></path></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Email</p>
                                <p class="text-base font-semibold text-gray-900">soporte@bankario.com</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <p class="text-xs uppercase tracking-wider text-gray-500">Horario</p>
                                <p class="text-base font-semibold text-gray-900">24/7 disponible</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preguntas frecuentes -->
                <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200">
                    <h3 class="text-3xl font-bold text-gray-800 mb-8">Preguntas Frecuentes</h3>

                    <div class="space-y-6">
                        @foreach($faqs as $faq)
                            <div class="pb-6 border-b border-gray-200 last:border-b-0 last:pb-0">
                                <h4 class="text-lg font-bold text-gray-900 mb-2">{{ $faq['question'] }}</h4>
                                <p class="text-base text-gray-600">{{ $faq['answer'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <button class="mt-8 w-full h-12 text-lg font-bold border border-gray-300 text-blue-600 hover:border-blue-500 hover:bg-blue-50 transition-all rounded-xl shadow-md">
                        Ver Todas las Preguntas
                    </button>
                </div>
            </div>
        </main>
    </div>
@endsection

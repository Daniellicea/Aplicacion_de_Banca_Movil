@extends('layouts.app')

@section('title', 'Seguridad - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">

        {{-- Header --}}
        <header class="border-b border-gray-200 bg-white shadow-sm sticky top-0 z-10"> {{-- Agregado sticky y z-10 --}}
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-gray-500 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm font-medium">Volver</span>
                </a>
                <h1 class="text-xl font-bold text-gray-900">Seguridad</h1>
                <div class="w-6"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-4 sm:px-6 py-12 md:py-16"> {{-- Ajustada la clase de padding --}}

            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-10 text-center md:text-left"> {{-- Centrado en móvil --}}
                Seguridad de tu <span class="text-blue-600">Cuenta</span>
            </h2>

            {{-- Mensajes --}}
            @if(session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-300 text-green-800 rounded-xl font-medium shadow-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-8 p-4 bg-red-50 border border-red-300 text-red-800 rounded-xl font-medium shadow-sm">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            {{-- CARD PRINCIPAL --}}
            <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8 md:p-10">

                @if(!$twoFactorEnabled)

                    <h3 class="text-3xl font-bold text-gray-900 mb-4 text-center md:text-left">Activar Autenticación de Dos Factores (2FA)</h3>
                    <p class="text-gray-500 mb-10 text-center md:text-left max-w-2xl mx-auto md:mx-0">
                        Añade una capa extra de protección a tu cuenta. Escanea el código QR con Google Authenticator o Authy.
                    </p>

                    {{-- Contenedor QR + Form --}}
                    <div class="flex flex-col md:flex-row gap-10 md:gap-16 items-center md:items-start justify-center">

                        {{-- QR y Clave --}}
                        <div class="flex flex-col items-center p-6 bg-gray-50 rounded-2xl border border-gray-200 shadow-inner w-full max-w-xs sm:max-w-sm"> {{-- Clases de tamaño y padding ajustadas --}}
                            <img src="{{ $qrCode }}" class="w-44 h-44 mb-5 rounded-lg shadow-xl border border-gray-300" alt="Código QR para 2FA" /> {{-- Tamaño y sombra ajustados --}}

                            <p class="text-base text-gray-700 font-mono bg-white p-3 rounded-lg border-2 border-dashed border-blue-200 select-all w-full text-center tracking-widest break-all"> {{-- Estilo de clave manual mejorado --}}
                                {{ $secret }}
                            </p>
                            <p class="text-xs text-gray-500 mt-3 text-center">Clave manual si no puedes escanear (haz clic para seleccionar).</p>
                        </div>

                        {{-- Formulario --}}
                        <div class="w-full max-w-md space-y-7">
                            <form method="POST" action="{{ route('security.2fa.enable') }}" class="space-y-6">
                                @csrf

                                {{-- Teléfono --}}
                                <div class="space-y-2">
                                    <label for="phone" class="block text-sm font-semibold text-gray-700">Número Telefónico (Opcional)</label> {{-- Añadido Opcional si no es estrictamente obligatorio --}}
                                    <input
                                        id="phone"
                                        type="tel"
                                        name="phone"
                                        {{-- required --}} {{-- Quitada la validación "required" si el 2FA es la prioridad --}}
                                        class="w-full h-12 px-4 rounded-xl border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white shadow-sm" {{-- Fondo blanco para mejor contraste --}}
                                        placeholder="+52 123 456 7890"
                                        value="{{ old('phone') }}" {{-- Mantenido el valor si falla la validación --}}
                                    />
                                </div>

                                {{-- Código 2FA --}}
                                <div class="space-y-2">
                                    <label for="code" class="block text-sm font-semibold text-gray-700">Código 2FA (6 dígitos)</label>
                                    <input
                                        id="code"
                                        type="text"
                                        inputmode="numeric" {{-- Sugerencia para teclados móviles --}}
                                        pattern="\d{6}" {{-- Para validación básica en el navegador --}}
                                        maxlength="6"
                                        name="code"
                                        required
                                        class="w-full h-12 px-4 rounded-xl border border-gray-300 text-center text-xl font-bold tracking-[0.5em] bg-white focus:ring-blue-500 focus:border-blue-500 shadow-sm" {{-- Espaciado entre letras y font-bold --}}
                                        placeholder="••••••"
                                    />
                                </div>

                                {{-- Botón --}}
                                <button type="submit" class="w-full h-14 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg transform hover:scale-[1.01] transition duration-300">
                                    Verificar Código y Activar 2FA
                                </button>

                            </form>
                        </div>
                    </div>

                @else
                    {{-- Vista 2FA ya activada --}}
                    <div class="text-center py-8 md:py-12 space-y-6"> {{-- Ajustado el padding vertical --}}
                        <svg class="w-16 h-16 text-green-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 100 20a10 10 0 000-20z"/>
                        </svg>

                        <h4 class="text-3xl font-extrabold text-gray-900">2FA Activado ✅</h4>
                        <p class="text-lg text-gray-600 max-w-lg mx-auto">Se solicitará un código adicional en cada inicio de sesión, añadiendo una seguridad robusta a tu cuenta.</p>

                        <form method="POST" action="{{ route('security.2fa.disable') }}">
                            @csrf
                            <button type="submit" class="mt-8 px-8 py-3 border-2 border-red-500 bg-red-50 text-red-600 hover:bg-red-100 rounded-xl transition font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5"> {{-- Estilo mejorado para el botón de desactivar --}}
                                Desactivar Autenticación de Dos Factores
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </main>
    </div>
@endsection

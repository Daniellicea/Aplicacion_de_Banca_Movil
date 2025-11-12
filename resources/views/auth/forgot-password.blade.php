@extends('layouts.app')

@section('title', 'Recuperar Contraseña - Bankario')

@section('content')
    {{-- Contenedor principal --}}
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 md:px-6">
        <div class="w-full max-w-md">

            {{-- Logo y título --}}
            <div class="text-center mb-12">
                <h1 class="text-7xl font-extrabold text-blue-600 mb-2 tracking-tighter">Bankario</h1>
                <p class="text-lg text-gray-500 uppercase tracking-widest font-medium">Banca Móvil</p>
            </div>

            {{-- Tarjeta principal --}}
            <div class="bg-white border border-gray-200 rounded-xl p-10 shadow-2xl shadow-blue-100/50">

                <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Recuperar Contraseña</h2>

                {{-- Instrucción --}}
                <p class="text-gray-600 text-sm mb-6 text-center">
                    Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                </p>

                {{-- Mensaje de éxito (después de enviar el correo) --}}
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-300 rounded-lg shadow-sm">
                        <p class="text-green-700 text-sm font-semibold">
                            {{ session('status') }}
                        </p>
                    </div>
                @endif

                {{-- Mensaje de error --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-300 rounded-lg shadow-sm">
                        <p class="text-red-700 text-sm font-semibold">{{ $errors->first() }}</p>
                    </div>
                @endif

                {{-- Formulario de recuperación --}}
                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    {{-- Campo correo --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-gray-700 uppercase tracking-widest mb-2">
                            Correo Electrónico
                        </label>
                        <input
                            id="correo"
                            name="correo"
                            type="email"
                            placeholder="tu@email.com"
                            value="{{ old('correo') }}"
                            class="w-full h-12 px-4 text-base bg-white border border-gray-300 text-gray-900 rounded-lg outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                            required
                            autofocus
                        />
                    </div>

                    {{-- Botón --}}
                    <button
                        type="submit"
                        class="w-full h-12 text-lg font-bold bg-blue-600 hover:bg-blue-700 text-white transition duration-200 rounded-lg shadow-lg shadow-blue-500/30 mt-6 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Enviar Enlace de Recuperación
                    </button>
                </form>

            </div>

            {{-- Enlace a login --}}
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    ¿Ya recordaste tu contraseña?
                    <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline transition-colors">
                        Iniciar Sesión
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

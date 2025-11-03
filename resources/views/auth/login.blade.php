@extends('layouts.app')

@section('title', 'Iniciar Sesión - Bankario')

@section('content')
    {{-- Contenedor principal con fondo muy claro --}}
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 md:px-6">
        <div class="w-full max-w-md">
            <div class="text-center mb-12">
                <h1 class="text-7xl font-extrabold text-blue-600 mb-2 tracking-tighter">Bankario</h1>
                <p class="text-lg text-gray-500 uppercase tracking-widest font-medium">Banca Móvil</p>
            </div>

            <div class="bg-white border border-gray-200 rounded-xl p-10 shadow-2xl shadow-blue-100/50">

                {{-- Bloque de errores --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-300 rounded-lg">
                        <p class="text-red-700 text-sm font-semibold">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Campo Correo Electrónico --}}
                    <div>
                        <label for="correo" class="block text-xs font-semibold text-gray-700 uppercase tracking-widest mb-2">
                            Correo Electrónico
                        </label>
                        <input
                            id="correo"
                            name="correo"
                            type="email"
                            placeholder="tu@email.com"
                            value="{{ old('correo') }}"
                            {{-- Estilos de input claros y enfocados --}}
                            class="w-full h-12 px-4 text-base bg-white border border-gray-300 text-gray-900 rounded-lg outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                            required
                            autofocus
                        />
                    </div>

                    {{-- Campo Contraseña --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-gray-700 uppercase tracking-widest mb-2">
                            Contraseña
                        </label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            {{-- Estilos de input claros y enfocados --}}
                            class="w-full h-12 px-4 text-base bg-white border border-gray-300 text-gray-900 rounded-lg outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200"
                            required
                        />
                    </div>

                    {{-- Botón Iniciar Sesión --}}
                    <button
                        type="submit"
                        {{-- Botón de acento azul vibrante --}}
                        class="w-full h-12 text-lg font-bold bg-blue-600 hover:bg-blue-700 text-white transition duration-200 rounded-lg shadow-lg shadow-blue-500/30 mt-6 transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-blue-300"
                    >
                        Iniciar Sesión
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <a href="#" class="text-sm text-gray-500 hover:text-blue-600 transition-colors">
                        ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    ¿No tienes cuenta?
                    <a href="{{ route('register.form') }}" class="text-blue-600 font-bold hover:underline transition-colors">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

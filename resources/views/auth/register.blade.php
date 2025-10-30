@extends('layouts.app')

@section('title', 'Registro - Bankario')

@section('content')
    {{-- Contenedor principal con fondo blanco/gris muy claro --}}
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        {{-- Tarjeta del formulario --}}
        <div class="w-full max-w-lg bg-white border border-gray-200 rounded-2xl p-10 shadow-2xl shadow-blue-500/10 transition duration-300 hover:shadow-2xl hover:shadow-blue-500/20">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 mb-8 tracking-tight">
                Crea tu cuenta <span class="text-blue-600">Bankario</span>
            </h1>

            @if ($errors->any())
                {{-- Diseño más sutil para errores --}}
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl">
                    <p class="font-bold text-sm mb-1">Error en el registro:</p>
                    <ul class="text-sm list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORMULARIO DE REGISTRO --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                {{-- Nombre completo --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                           placeholder="Ej. Juan Pérez"
                           class="w-full border border-gray-300 rounded-lg p-3 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                </div>

                {{-- Correo electrónico --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                               placeholder="tu.correo@ejemplo.com"
                               class="w-full border border-gray-300 rounded-lg p-3 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    </div>

                    {{-- Confirmar correo --}}
                    <div>
                        <label for="email_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar correo</label>
                        <input id="email_confirmation" type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" required
                               placeholder="Confirma tu correo"
                               class="w-full border border-gray-300 rounded-lg p-3 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    </div>
                </div>

                {{-- Contraseña --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Contraseña</label>
                        <input id="password" type="password" name="password" required
                               placeholder="Mínimo 8 caracteres"
                               class="w-full border border-gray-300 rounded-lg p-3 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirmar contraseña</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                               placeholder="Confirma tu contraseña"
                               class="w-full border border-gray-300 rounded-lg p-3 bg-white text-gray-900 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                    </div>
                </div>

                {{-- Botón de registro --}}
                <button type="submit"
                        class="w-full bg-blue-600 text-white font-bold py-3 mt-4 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition duration-150 transform hover:scale-[1.01]">
                    Registrarme
                </button>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login.form') }}" class="font-bold text-blue-600 hover:text-blue-700 hover:underline transition duration-150">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection

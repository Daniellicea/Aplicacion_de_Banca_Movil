@extends('layouts.app')

@section('title', 'Restablecer Contraseña - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8 border border-gray-200">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-3">🔐 Restablecer Contraseña</h2>
            <p class="text-center text-sm text-gray-500 mb-6">
                Ingresa tu nueva contraseña para tu cuenta Bankario.
            </p>

            {{-- Mensajes de error --}}
            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 rounded-lg text-red-700 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Mensajes de éxito --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 border border-green-400 rounded-lg text-green-700 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="correo" value="{{ $correo }}">

                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nueva Contraseña
                    </label>
                    <input id="password" name="password" type="password" required
                           class="w-full px-4 py-2 border rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                        Confirmar Contraseña
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="w-full px-4 py-2 border rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white font-bold py-2 rounded-lg hover:bg-blue-700 transition">
                    Guardar nueva contraseña
                </button>
            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                ¿Recordaste tu contraseña?
                <a href="{{ route('login.form') }}" class="text-blue-600 hover:underline font-medium">
                    Inicia sesión aquí
                </a>
            </p>
        </div>
    </div>
@endsection

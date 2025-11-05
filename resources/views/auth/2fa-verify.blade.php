@extends('layouts.app')

@section('title', 'Verificar Código 2FA')

@section('content')
    <div class="min-h-screen bg-gray-50 flex items-center justify-center px-6 py-16">

        <div class="bg-white shadow-xl border border-gray-200 rounded-3xl p-10 w-full max-w-md">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Autenticación requerida
                </h2>
                <p class="text-gray-500 mt-2 text-sm">
                    Ingresa el código de 6 dígitos generado por tu app
                </p>
            </div>

            {{-- Mensajes --}}
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-50 border border-red-300 text-red-700 rounded-xl">
                    ⚠️ {{ session('error') }}
                </div>
            @endif
            @if(session('info'))
                <div class="mb-4 p-3 bg-blue-50 border border-blue-300 text-blue-700 rounded-xl">
                    🔑 {{ session('info') }}
                </div>
            @endif

            <form method="POST" action="{{ route('security.2fa.verify') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="code" class="block text-sm font-semibold text-gray-700">
                        Código 2FA
                    </label>

                    <input type="text"
                           id="code"
                           name="code"
                           maxlength="6"
                           required
                           autofocus
                           class="w-full h-14 text-center text-2xl tracking-widest rounded-xl border border-gray-300 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="••••••">
                </div>

                <button
                    class="w-full h-14 bg-blue-600 text-white font-bold rounded-xl shadow-lg hover:bg-blue-700 transition-all transform hover:scale-[1.01]">
                    Verificar
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="text-sm text-gray-500 hover:text-gray-700 underline">
                    Cancelar y cerrar sesión
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>

        </div>

    </div>
@endsection

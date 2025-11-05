@extends('layouts.app')

@section('title', 'Mi Perfil - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 font-sans">
        <main class="max-w-4xl mx-auto px-6 py-16">

            <div class="mb-10 flex items-center justify-between">
                <div>
                    <h2 class="text-5xl font-extrabold text-gray-900 mb-2">Mi Perfil</h2>
                    <p class="text-xl text-gray-500">Consulta y actualiza tu información personal y de seguridad.</p>
                </div>

                <a href="{{ route('dashboard') }}"
                   class="px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium transition">
                    ← Volver al Dashboard
                </a>
            </div>

            {{-- Mensajes --}}
            @if (session('success'))
                <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li class="mb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Detalles --}}
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-5">Detalles del Usuario</h3>

                {{-- Se ha eliminado la visualización del ID --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Correo</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $usuario->correo }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm font-medium text-gray-500">Nombre</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $usuario->nombre }}</p>
                    </div>
                </div>
            </div>

            {{-- Editar --}}
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-5">Editar información</h3>

                <form method="POST" action="{{ route('users.update_profile') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="nombre" class="block mb-2 text-sm font-medium text-gray-700">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre"
                               class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-3 border-gray-300"
                               value="{{ old('nombre', $usuario->nombre) }}" required>
                    </div>

                    {{-- Correo deshabilitado pero enviado --}}
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Correo (no editable)</label>
                        <input type="email" value="{{ $usuario->correo }}" disabled
                               class="bg-gray-100 border text-gray-400 text-sm rounded-lg block w-full p-3 cursor-not-allowed border-gray-300">

                        <input type="hidden" name="correo" value="{{ $usuario->correo }}">

                        <p class="mt-2 text-xs text-gray-500">
                            No puedes cambiar tu correo.
                        </p>
                    </div>

                    <div class="flex justify-end pt-4 border-t mt-8">
                        <button type="submit"
                                class="text-white bg-blue-600 hover:bg-blue-700 rounded-lg text-lg px-8 py-3 shadow-md">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            {{-- Cambiar contraseña --}}
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-800 border-b pb-3 mb-5">Cambiar contraseña</h3>

                <form method="POST" action="{{ route('users.update_password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Contraseña actual</label>
                        <input type="password" name="current_password"
                               class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-3" required>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Nueva contraseña</label>
                        <input type="password" name="password"
                               class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-3" required>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="bg-gray-50 border text-gray-900 text-sm rounded-lg block w-full p-3" required>
                    </div>

                    <div class="flex justify-end pt-4 border-t mt-8">
                        <button type="submit"
                                class="text-white bg-red-600 hover:bg-red-700 rounded-lg text-lg px-8 py-3 shadow-md">
                            Actualizar contraseña
                        </button>
                    </div>
                </form>
            </div>

            {{-- Eliminar cuenta --}}
            <div class="bg-white shadow-xl rounded-xl p-8 border border-gray-200">
                <h3 class="text-2xl font-bold text-red-700 mb-4">Eliminar cuenta</h3>
                <p class="text-gray-600 mb-6">
                    Esta acción es irreversible. Se borrarán todos tus datos.
                </p>

                <form method="POST" action="{{ route('users.destroy_account') }}"
                      onsubmit="return confirm('⚠️ ¿Seguro que deseas eliminar tu cuenta permanentemente?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="text-white bg-red-800 hover:bg-red-900 rounded-lg text-lg px-8 py-3 shadow-md">
                        Eliminar cuenta
                    </button>
                </form>
            </div>

        </main>
    </div>
@endsection

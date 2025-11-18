@extends('layouts.app')

@section('title', 'Mi Perfil - Bankario')

@section('content')
    <div class="min-h-screen bg-gray-50 text-gray-900 antialiased">

        {{-- Header Mejorado con Navegación --}}
        <header class="border-b border-gray-200 bg-white/80 backdrop-blur-sm sticky top-0 z-30 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-end">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-semibold transition-colors text-gray-500 hover:text-gray-900">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" /></svg>
                    Volver al Dashboard
                </a>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-6 py-12 md:py-16 animate-fade-in-up">

            <div class="mb-10">
                <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-2">Mi <span class="text-blue-600">Perfil</span></h2>
                <p class="text-lg text-gray-500">Consulta y actualiza tu información personal y de seguridad de la cuenta.</p>
            </div>

            {{-- Mensajes de feedback (Mantienen colores funcionales: Verde/Rojo) --}}
            @if (session('success'))
                <div class="p-4 mb-8 text-base font-semibold text-green-700 bg-green-50 border border-green-400 rounded-xl shadow-md flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 mb-8 text-sm text-red-700 bg-red-50 border border-red-400 rounded-xl shadow-md">
                    <p class="font-bold mb-2">Se encontraron los siguientes errores:</p>
                    <ul class="list-disc list-inside space-y-1 ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                // Simulación de objeto usuario (MODIFICADA para incluir el avatar)
                $usuario = $usuario ?? (object)[
                    'nombre' => 'María Fernanda López',
                    'correo' => 'maria.lopez@example.com',
                    // Simulación de URL del avatar
                    'avatar_url' => 'https://i.pravatar.cc/150?img=47'
                ];

                // Función auxiliar para obtener las iniciales si no hay avatar
                $nameParts = explode(' ', $usuario->nombre);
                $initials = substr($nameParts[0] ?? 'U', 0, 1) . (substr($nameParts[1] ?? '', 0, 1));
                $initials = strtoupper(trim($initials));
            @endphp

            {{-- INICIO DEL BLOQUE DE FOTO DE PERFIL (AVATAR) --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 mb-10 flex flex-col md:flex-row items-center gap-8">

                {{-- VISUALIZACIÓN DEL AVATAR --}}
                <div class="w-24 h-24 rounded-full shadow-lg border-4 border-white ring-4 ring-blue-500/50 flex items-center justify-center overflow-hidden bg-gray-200 flex-shrink-0">
                    @if ($usuario->avatar_url)
                        {{-- Si hay URL, muestra la imagen --}}
                        <img src="{{ $usuario->avatar_url }}" alt="Foto de perfil de {{ $usuario->nombre }}" class="object-cover w-full h-full">
                    @else
                        {{-- Si no hay, muestra las iniciales --}}
                        <span class="text-3xl font-extrabold text-blue-700">{{ $initials }}</span>
                    @endif
                </div>

                {{-- FORMULARIO DE CARGA DE IMAGEN --}}
                <div class="flex-grow">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Foto de Perfil</h3>

                    {{-- Usamos # temporalmente en action para evitar RouteNotFoundException --}}
                    <form method="POST" action="#" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-start sm:items-end gap-4">
                        @csrf

                        <div class="flex-grow w-full">
                            <label for="avatar" class="block mb-2 text-sm font-medium text-gray-500">Selecciona una imagen (JPG, PNG)</label>
                            <input type="file" id="avatar" name="avatar" accept=".jpg,.jpeg,.png" required
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-gray-50 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-300">

                            @error('avatar')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                                class="h-10 text-base font-bold bg-blue-600 hover:bg-blue-700 text-white transition duration-300 rounded-xl
                                       px-6 shadow-md shadow-blue-500/30 flex-shrink-0">
                            Subir Foto
                        </button>
                    </form>

                    @if ($usuario->avatar_url)
                        {{-- Opción para eliminar el avatar --}}
                        <form method="POST" action="#" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 transition">
                                Eliminar foto actual
                            </button>
                        </form>
                    @endif
                </div>

            </div>
            {{-- FIN DEL BLOQUE DE FOTO DE PERFIL (AVATAR) --}}

            {{-- Detalles del Usuario (Card de visualización) --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-900 border-b border-gray-200/70 pb-3 mb-6">Información General</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Nombre Completo</p>
                        <p class="text-lg font-extrabold text-gray-900">{{ $usuario->nombre }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-gray-500 mb-1">Correo Electrónico</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $usuario->correo }}</p>
                    </div>
                </div>
            </div>

            {{-- Editar Información (Formulario) --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-900 border-b border-gray-200/70 pb-3 mb-6">Actualizar Datos</h3>

                <form method="POST" action="{{ route('users.update_profile') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="nombre" class="block mb-2 text-sm font-medium text-gray-500">Nombre completo</label>
                        <input type="text" id="nombre" name="nombre"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl block w-full p-3 shadow-inner-sm
                                      focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none"
                               value="{{ old('nombre', $usuario->nombre) }}" required>
                    </div>

                    {{-- Correo deshabilitado --}}
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-500">Correo (no editable)</label>
                        <input type="email" value="{{ $usuario->correo }}" disabled
                               class="bg-gray-200 border border-gray-300 text-gray-500 text-base rounded-xl block w-full p-3 cursor-not-allowed">

                        <input type="hidden" name="correo" value="{{ $usuario->correo }}">

                        <p class="mt-2 text-xs text-gray-500">
                            Para tu seguridad, el correo electrónico no puede ser modificado aquí.
                        </p>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200/70 mt-8">
                        <button type="submit"
                                class="h-12 text-lg font-extrabold bg-gradient-to-r from-blue-600 to-blue-700
                                       hover:from-blue-700 hover:to-blue-800 text-white transition duration-300 rounded-xl
                                       px-8 shadow-lg shadow-blue-500/40 transform hover:scale-[1.005] focus:outline-none focus:ring-4 focus:ring-blue-600/50">
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </div>

            {{-- Cambiar Contraseña (Formulario) --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-gray-200 mb-10">
                <h3 class="text-2xl font-bold text-gray-900 border-b border-gray-200/70 pb-3 mb-6">Cambiar Contraseña</h3>

                <form method="POST" action="{{ route('users.update_password') }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-500">Contraseña actual</label>
                        <input type="password" name="current_password"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl block w-full p-3 shadow-inner-sm
                                      focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none" required>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-500">Nueva contraseña</label>
                        <input type="password" name="password"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl block w-full p-3 shadow-inner-sm
                                      focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none" required>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-500">Confirmar nueva contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-xl block w-full p-3 shadow-inner-sm
                                      focus:border-blue-600 focus:ring-2 focus:ring-blue-300/50 transition duration-300 outline-none" required>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-200/70 mt-8">
                        {{-- Mantener el botón de Contraseña en rojo por ser una acción de seguridad crítica --}}
                        <button type="submit"
                                class="h-12 text-lg font-extrabold bg-red-600 hover:bg-red-700 text-white transition duration-300 rounded-xl
                                       px-8 shadow-lg shadow-red-500/40 transform hover:scale-[1.005] focus:outline-none focus:ring-4 focus:ring-red-500/50">
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>

            {{-- Eliminar Cuenta (Zona de peligro) --}}
            <div class="bg-white shadow-xl rounded-2xl p-8 border border-red-400/50">
                <h3 class="text-2xl font-bold text-red-700 mb-4">Zona de Peligro: Eliminar Cuenta</h3>
                <p class="text-gray-500 mb-6">
                    Esta acción es **irreversible**. Se eliminarán permanentemente todos tus datos y transacciones.
                </p>

                <form method="POST" action="{{ route('users.destroy_account') }}"
                      onsubmit="return confirm('⚠️ ADVERTENCIA: ¿Estás ABSOLUTAMENTE seguro de que deseas eliminar tu cuenta permanentemente?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="h-12 text-lg font-extrabold bg-red-800 hover:bg-red-900 text-white transition duration-300 rounded-xl
                                   px-8 shadow-lg shadow-red-800/40">
                        Eliminar Cuenta Permanentemente
                    </button>
                </form>
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

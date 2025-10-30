@extends('layouts.app')

@section('title', 'Usuarios Registrados - Bankario')

@section('content')
    <div class="max-w-5xl mx-auto mt-10 bg-white shadow-md rounded-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-foreground">Usuarios Registrados</h1>

            {{-- Botón que redirige al registro original --}}
            <a href="{{ route('register.form') }}"
               class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition">
                + Nuevo Usuario
            </a>
        </div>

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabla de usuarios sin ID --}}
        <table class="min-w-full border border-gray-200 text-left rounded-lg overflow-hidden">
            <thead class="bg-gray-100 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 font-semibold">Nombre</th>
                <th class="py-3 px-4 font-semibold">Correo</th>
                <th class="py-3 px-4 font-semibold text-center">Acciones</th>
            </tr>
            </thead>
            <tbody>
            @forelse($usuarios as $usuario)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="py-3 px-4">{{ strtoupper($usuario->nombre) }}</td>
                    <td class="py-3 px-4">{{ $usuario->correo }}</td>
                    <td class="py-3 px-4 text-center space-x-2">
                        <a href="{{ route('usuarios.show', $usuario->id) }}" class="text-blue-600 hover:underline">Ver</a>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" class="text-yellow-600 hover:underline">Editar</a>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-4 text-center text-gray-500">No hay usuarios registrados.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Detalle de Usuario - Bankario')

@section('content')
    <div class="min-h-screen bg-background p-8">
        <div class="max-w-md mx-auto bg-card border border-border rounded-xl p-6 shadow-md">
            <h1 class="text-2xl font-bold text-foreground mb-6">Detalles del Usuario</h1>

            <p><strong>ID:</strong> {{ $usuario->id }}</p>
            <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
            <p><strong>Correo:</strong> {{ $usuario->correo }}</p>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('usuarios.edit', $usuario) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Editar</a>
                <a href="{{ route('usuarios.index') }}" class="bg-muted-foreground/20 text-foreground px-4 py-2 rounded-lg hover:bg-muted-foreground/40 transition">Volver</a>
            </div>
        </div>
    </div>
@endsection

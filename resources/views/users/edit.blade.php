@extends('layouts.app')

@section('title', 'Editar Usuario - Bankario')

@section('content')
    <div class="min-h-screen bg-background p-8">
        <div class="max-w-md mx-auto bg-card border border-border rounded-xl p-6 shadow-md">
            <h1 class="text-2xl font-bold text-foreground mb-6">Editar Usuario</h1>

            <form action="{{ route('usuarios.update', $usuario) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-foreground mb-1">Nombre</label>
                    <input type="text" name="nombre" value="{{ $usuario->nombre }}" class="w-full border border-border rounded-lg p-2 bg-background text-foreground" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-foreground mb-1">Correo</label>
                    <input type="email" name="correo" value="{{ $usuario->correo }}" class="w-full border border-border rounded-lg p-2 bg-background text-foreground" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-foreground mb-1">Nueva Contraseña (opcional)</label>
                    <input type="password" name="password" class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-foreground mb-1">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="w-full border border-border rounded-lg p-2 bg-background text-foreground">
                </div>

                <button type="submit" class="w-full bg-primary text-primary-foreground py-2 rounded-lg hover:bg-primary/90 transition">
                    Actualizar Usuario
                </button>
            </form>
        </div>
    </div>
@endsection

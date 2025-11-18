@extends('layouts.app')

@section('title', 'Gestión de Tarjetas - Bankario')

@section('content')
    <div class="min-h-screen bg-background antialiased">
        <header class="border-b border-border bg-card sticky top-0 z-30 shadow-md"> {{-- Eliminadas la transparencia y el blur --}}
            <div class="max-w-7xl mx-auto px-6 py-5 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-muted-foreground hover:text-primary transition-colors p-2 rounded-full hover:bg-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="text-sm uppercase tracking-wider font-bold">Volver</span>
                </a>
                <h1 class="text-xl font-extrabold text-foreground">Gestión de Tarjetas</h1>
                <div class="w-24"></div>
            </div>
        </header>

        <main class="max-w-5xl mx-auto px-6 py-12 animate-fade-in-up">
            <h2 class="text-4xl md:text-5xl font-extrabold text-foreground mb-12">Mis Tarjetas</h2>

            {{-- Mensaje de Éxito adaptado a la paleta --}}
            @if(session('success'))
                <div class="mb-8 p-6 bg-green-500/10 border border-green-400 rounded-xl shadow-md">
                    <p class="text-green-600 font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid md:grid-cols-2 gap-8">
                @foreach($cards as $card)
                    {{-- Tarjeta de Crédito/Débito (Diseño Corporativo Azul) --}}
                    <div class="bg-gradient-to-br from-primary to-accent rounded-2xl p-8 text-primary-foreground shadow-2xl shadow-primary/50 transform hover:scale-[1.01] transition duration-300">
                        <div class="flex items-center justify-between mb-12">
                            <span class="text-sm uppercase tracking-wider opacity-80 font-bold">{{ $card['type'] }}</span>
                            <svg class="w-12 h-12 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2" stroke-width="2"/>
                                <line x1="1" y1="10" x2="23" y2="10" stroke-width="2"/>
                            </svg>
                        </div>

                        <p class="text-2xl font-mono tracking-wider mb-8">{{ $card['number'] }}</p>

                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-wider opacity-60 mb-1">Titular</p>
                                <p class="text-sm font-semibold">{{ $card['holder'] }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs uppercase tracking-wider opacity-60 mb-1">Vence</p>
                                <p class="text-sm font-semibold">{{ $card['expiry'] }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-primary-foreground/20 flex gap-4">
                            <form method="POST" action="{{ route('cards.toggle', $card['id']) }}" class="flex-1">
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full py-3 px-4 bg-primary-foreground/10 hover:bg-primary-foreground/20 rounded-xl text-sm font-bold transition-colors shadow-sm"
                                >
                                    {{ $card['status'] === 'active' ? 'Bloquear' : 'Desbloquear' }}
                                </button>
                            </form>
                            <button class="flex-1 py-3 px-4 bg-primary-foreground/10 hover:bg-primary-foreground/20 rounded-xl text-sm font-bold transition-colors shadow-sm">
                                Ver Detalles
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 bg-card border border-border rounded-2xl p-8 shadow-xl">
                <h3 class="text-2xl font-extrabold text-foreground mb-4">Solicitar Nueva Tarjeta</h3>
                <p class="text-muted-foreground mb-6">¿Necesitas una tarjeta adicional o de reemplazo? Solicítala de forma segura y rápida aquí.</p>

                {{-- Botón principal que usa el estilo de la paleta --}}
                <button class="w-full md:w-auto h-14 px-8 text-lg font-extrabold
                               bg-primary hover:bg-primary/90 text-primary-foreground
                               transition-all duration-300 rounded-xl
                               shadow-xl shadow-primary/40 transform hover:scale-[1.005]">
                    Solicitar Tarjeta
                </button>
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

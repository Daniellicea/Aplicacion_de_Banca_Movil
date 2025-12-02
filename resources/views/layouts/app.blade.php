<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Bankario - Banca Móvil')</title>

    {{-- Script de Configuración JIT de Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Configuración de Tailwind para usar un tema AZUL --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Aquí puedes definir tus colores principales si lo necesitas,
                        // pero por ahora usaremos los colores estándar 'blue', 'gray', 'green', 'red'.
                    },
                    boxShadow: {
                        // Sombra custom que imita la que usabas en el login
                        '3xl': '0 35px 60px -15px rgba(0, 0, 0, 0.3)',
                    }
                }
            }
        }
    </script>

    <style>
        /* Estilo base para el cuerpo (usamos un gris de Tailwind) */
        body {
            background-color: #f9fafb; /* bg-gray-50 */
            color: #1f2937; /* text-gray-800 */
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">


<main class="flex-1">
    @yield('content')
</main>

{{-- AÑADE ESTA LÍNEA PARA INCLUIR ALPINE.JS --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Ejecuta la migración.
     */
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre'); // Nombre completo
            $table->string('correo')->unique(); // Correo único
            $table->string('contrasena'); // Contraseña encriptada (sin ñ)
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};

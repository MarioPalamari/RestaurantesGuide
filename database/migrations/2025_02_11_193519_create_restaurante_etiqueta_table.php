<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurante_etiqueta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_restaurante')->constrained('restaurantes');
            $table->foreignId('id_etiqueta')->constrained('etiquetas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurante_etiqueta');
    }
};

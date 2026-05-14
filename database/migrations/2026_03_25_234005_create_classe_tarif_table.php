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
        Schema::create('classe_tarif', function (Blueprint $table) {
            $table->id();
            // La classe
            $table->foreignId('classe_id')
                ->constrained('classes')
                ->cascadeOnDelete();

            // Le tarif
            $table->foreignId('tarif_id')
                ->constrained('tarifs')
                ->cascadeOnDelete();

            // Si ce tarif est le tarif actif actuel pour la classe
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_tarif');
    }
};

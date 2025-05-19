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
        Schema::create('profissionals', function (Blueprint $table) {
          // Chave primária incremental
            $table->id();

            // Nome do profissional
            $table->string('nome');

            // FK para a barbearia que emprega este profissional
            $table->foreignId('barbearia_id')
                  ->constrained('barbearias')
                  ->onDelete('cascade');

            // Timestamps de criação e atualização
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissionals');
    }
};

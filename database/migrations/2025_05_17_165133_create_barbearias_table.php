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
        Schema::create('barbearias', function (Blueprint $table) {
            // Chave primária incremental
            $table->id();

            // Colunas conforme diagrama ER
            $table->string('nome');
            $table->string('endereco');
            $table->string('telefone');
            $table->string('email')->unique();

            // Timestamps de criação e atualização
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barbearias');
    }
};

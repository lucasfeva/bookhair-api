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
        Schema::create('servicos', function (Blueprint $table) {
            // Chave primária incremental
            $table->id();

            // FK para a barbearia que oferece o serviço
            $table->foreignId('barbearia_id')
                ->constrained('barbearias')
                ->onDelete('cascade');

            // Dados do serviço
            $table->string('nome');
            $table->string('descricao');
            $table->integer('duracao_minutos');
            $table->decimal('preco', 8, 2);

            // Timestamps de criação e atualização
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};

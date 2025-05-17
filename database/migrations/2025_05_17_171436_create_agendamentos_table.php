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
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();

            // FK para usuário (cliente)
            $table->foreignId('cliente_id')
                ->constrained('users')
                ->onDelete('cascade');

            // FK para profissional
            $table->foreignId('profissional_id')
                ->constrained('profissionals')
                ->onDelete('cascade');

            // FK para serviço
            $table->foreignId('servico_id')
                ->constrained('servicos')
                ->onDelete('cascade');

            // FK para barbearia
            $table->foreignId('barbearia_id')
                ->constrained('barbearias')
                ->onDelete('cascade');

            // Dados do agendamento
            $table->dateTime('data_hora');
            $table->string('status');

            // Timestamps padrão: criado_em, atualizado_em
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamentos');
    }
};

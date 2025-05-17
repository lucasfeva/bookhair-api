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
        Schema::create('profissional_servico', function (Blueprint $table) {
           $table->foreignId('profissional_id')
                  ->constrained('profissionals')
                  ->onDelete('cascade');

            // FK para servico
            $table->foreignId('servico_id')
                  ->constrained('servicos')
                  ->onDelete('cascade');

            // PK composta para evitar duplicatas
            $table->primary(['profissional_id', 'servico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profissional_servico');
    }
};

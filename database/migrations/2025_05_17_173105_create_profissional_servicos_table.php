<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profissional_servico', function (Blueprint $table) {
            $table->foreignId('profissional_id')->constrained('profissionals')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->foreignId('barbearia_id')->constrained('barbearias')->onDelete('cascade');
            $table->primary(['profissional_id', 'servico_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profissional_servico');
    }
};

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
        Schema::table('users', function (Blueprint $table) {
            // renomeia coluna password para senha
            $table->renameColumn('password', 'senha');
            // novos campos
            $table->string('telefone')->nullable()->after('senha');
            $table->string('endereco')->nullable()->after('telefone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // remove colunas adicionadas
            $table->dropColumn(['telefone', 'endereco']);
            // reverte nome da coluna
            $table->renameColumn('senha', 'password');
        });
    }
};

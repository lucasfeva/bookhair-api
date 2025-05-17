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
        Schema::table('barbearias', function (Blueprint $table) {
            // adiciona colunas de latitude e longitude após o endereço
            $table->decimal('latitude', 10, 7)
                  ->nullable()
                  ->after('endereco');
            $table->decimal('longitude', 10, 7)
                  ->nullable()
                  ->after('latitude');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barbearias', function (Blueprint $table) {
            $table->dropColumn(['latitude', 'longitude']);
        });
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servico;
use App\Models\Barbearia;

class ServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barbearias = Barbearia::all();
        Servico::factory()
            ->count(10)
            ->state(fn() => [
                'barbearia_id' => $barbearias->random()->id,
            ])
            ->create();
    }
}

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

        // Cada barbearia terá entre 3-8 serviços
        foreach ($barbearias as $barbearia) {
            Servico::factory()
                ->count(rand(3, 8))
                ->state(['barbearia_id' => $barbearia->id])
                ->create();
        }
    }
}

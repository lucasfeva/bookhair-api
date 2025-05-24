<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profissional;
use App\Models\Barbearia;
use App\Models\Servico;

class ProfissionaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barbearias = Barbearia::all();
        $servicos = Servico::all();

        $profissionais = Profissional::factory()
            ->count(6)
            ->state(fn() => [
                'barbearia_id' => $barbearias->random()->id,
            ])
            ->create();

        foreach ($profissionais as $prof) {
            $disponiveis = $servicos->where('barbearia_id', $prof->barbearia_id);

            if ($disponiveis->isEmpty()) {
                continue;
            }

            $attachCount = rand(1, min(3, $disponiveis->count()));

            $prof->servicos()->attach(
                $disponiveis
                    ->random($attachCount)
                    ->pluck('id')
                    ->toArray()
            );
        }
    }
}

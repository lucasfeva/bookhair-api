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

        // Cada barbearia terá entre 2-4 profissionais
        foreach ($barbearias as $barbearia) {
            $profissionais = Profissional::factory()
                ->count(rand(2, 4))
                ->state(['barbearia_id' => $barbearia->id])
                ->create();

            $servicosDaBarbearia = Servico::where('barbearia_id', $barbearia->id)->get();

            foreach ($profissionais as $prof) {
                if ($servicosDaBarbearia->isNotEmpty()) {
                    $attachCount = rand(1, min(3, $servicosDaBarbearia->count()));

                    $servicosParaAnexar = $servicosDaBarbearia
                        ->random($attachCount)
                        ->pluck('id')
                        ->toArray();

                    // Adicionar barbearia_id na tabela pivot
                    $syncData = [];
                    foreach ($servicosParaAnexar as $servicoId) {
                        $syncData[$servicoId] = ['barbearia_id' => $barbearia->id];
                    }

                    $prof->servicos()->sync($syncData);
                }
            }
        }
    }
}

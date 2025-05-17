<?php

namespace Database\Seeders;

use App\Models\User;

use App\Models\Barbearia;
use App\Models\Servico;
use App\Models\Profissional;
use App\Models\Agendamento;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1) Cria 5 clientes
        $clientes = User::factory()->count(5)->create();

        // 2) Cria 3 barbearias
        $barbearias = Barbearia::factory()->count(3)->create();

        // 3) Cria 10 serviços, cada um associado aleatoriamente a UMA das barbearias existentes
        $servicos = Servico::factory()
            ->count(10)
            ->state(fn() => [
                'barbearia_id' => $barbearias->random()->id
            ])
            ->create();

        // 4) Cria 6 profissionais, cada um associado aleatoriamente a UMA das barbearias existentes
        $profissionais = Profissional::factory()
            ->count(6)
            ->state(fn() => [
                'barbearia_id' => $barbearias->random()->id
            ])
            ->create();

        // 5) Anexa de 1 a 3 serviços DA MESMA barbearia para cada profissional
        foreach ($profissionais as $prof) {
            $servicosDaBarbearia = $servicos->where('barbearia_id', $prof->barbearia_id);
            $prof->servicos()->attach(
                $servicosDaBarbearia
                    ->random(rand(1, min(3, $servicosDaBarbearia->count())))
                    ->pluck('id')
                    ->toArray()
            );
        }
        
        // 6) Cria 15 agendamentos coerentes (cliente, profissional, serviço e barbearia)
        Agendamento::factory()
            ->count(15)
            ->state(function () use ($clientes, $profissionais) {
                $cliente     = $clientes->random();
                $profissional = $profissionais->random();
                $servico     = $profissional->servicos->random();

                return [
                    'cliente_id'      => $cliente->id,
                    'profissional_id' => $profissional->id,
                    'servico_id'      => $servico->id,
                    'barbearia_id'    => $profissional->barbearia_id,
                ];
            })
            ->create();
    }
}

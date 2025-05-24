<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Profissional;

class AgendamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientes = User::all();
        $profissionais = Profissional::with('servicos')
            ->get()
            ->filter(fn($p) => $p->servicos->count() > 0);

        Agendamento::factory()
            ->count(15)
            ->state(function () use ($clientes, $profissionais) {
                $cliente = $clientes->random();
                $profissional = $profissionais->random();
                $servico = $profissional->servicos->random();

                return [
                    'cliente_id' => $cliente->id,
                    'profissional_id' => $profissional->id,
                    'servico_id' => $servico->id,
                    'barbearia_id' => $profissional->barbearia_id,
                ];
            })
            ->create();
    }
}

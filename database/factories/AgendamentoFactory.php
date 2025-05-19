<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Barbearia;
use App\Models\Profissional;
use App\Models\Servico;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agendamento>
 */
class AgendamentoFactory extends Factory
{
    protected $model = Agendamento::class;

    public function definition(): array
    {
        return [
            'cliente_id'      => User::factory(),
            'profissional_id' => Profissional::factory(),
            'servico_id'      => Servico::factory(),
            'barbearia_id'    => Barbearia::factory(),
            'data_hora'       => $this->faker->dateTimeBetween('now', '+1 month'),
            'status'          => $this->faker->randomElement(['agendado', 'concluido', 'cancelado']),
        ];
    }
}

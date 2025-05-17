<?php

namespace Database\Factories;

use App\Models\Barbearia;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Servico>
 */
class ServicoFactory extends Factory
{

     protected $model = Servico::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'barbearia_id'    => Barbearia::factory(),

            'nome'            => $this->faker->word(),
            'descricao'       => $this->faker->sentence(),
            'duracao_minutos' => $this->faker->numberBetween(15, 120),
            'preco'           => $this->faker->randomFloat(2, 20, 200),
        ];
    }
}

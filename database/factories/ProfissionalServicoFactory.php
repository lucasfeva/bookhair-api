<?php

namespace Database\Factories;

use App\Models\Profissional;
use App\Models\ProfissionalServico;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfissionalServico>
 */
class ProfissionalServicoFactory extends Factory
{


    protected $model = ProfissionalServico::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'profissional_id' => Profissional::factory(),
            'servico_id' => Servico::factory(),
        ];
    }
}

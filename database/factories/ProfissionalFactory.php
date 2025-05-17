<?php

namespace Database\Factories;

use App\Models\Barbearia;
use App\Models\Profissional;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profissional>
 */
class ProfissionalFactory extends Factory
{

    protected $model = Profissional::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'          => $this->faker->name(),
            'barbearia_id'  => Barbearia::factory(),
        ];
    }
}

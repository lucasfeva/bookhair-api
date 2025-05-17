<?php

namespace Database\Factories;

use App\Models\Barbearia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barbearia>
 */
class BarbeariaFactory extends Factory


{

    protected $model = Barbearia::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome'     => $this->faker->company(),
            'endereco' => $this->faker->address(),
            'telefone' => $this->faker->phoneNumber(),
            'email'    => $this->faker->unique()->companyEmail(),
        ];
    }
}

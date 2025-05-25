<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Barbearia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'barbearia_id' => Barbearia::factory(),
            'nota' => $this->faker->numberBetween(1, 5),
            'comentario' => $this->faker->optional(0.8)->sentence(),
            'agendamento_id' => null,
        ];
    }
}

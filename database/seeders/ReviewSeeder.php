<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Review;
use App\Models\Barbearia;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barbearias = Barbearia::all();
        $usuarios = User::all();

        foreach ($barbearias as $barbearia) {
            $quantidadeAvaliacoes = rand(5, 10);

            $usuariosAleatorios = $usuarios
                ->random(min($quantidadeAvaliacoes, $usuarios->count()))
                ->pluck('id');

            foreach ($usuariosAleatorios as $userId) {
                Review::factory()->create([
                    'user_id' => $userId,
                    'barbearia_id' => $barbearia->id,
                ]);
            }
        }
    }
}

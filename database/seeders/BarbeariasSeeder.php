<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barbearia;

class BarbeariasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Barbearia::factory()->count(15)->create();
    }
}

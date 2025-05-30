<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            BarbeariasSeeder::class,
            ServicosSeeder::class,
            ProfissionaisSeeder::class,
            AgendamentosSeeder::class,
            ReviewSeeder::class,
        ]);
    }
}

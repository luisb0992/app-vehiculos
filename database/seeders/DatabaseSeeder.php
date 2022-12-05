<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (!User::count()) {
            \App\Models\Rol::factory()->create();
            \App\Models\User::factory()->create();
        }

        $this->call([
            BrandSeeder::class,
            ModelVehicleSeeder::class,
            ColorSeeder::class,
        ]);
    }
}

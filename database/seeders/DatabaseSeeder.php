<?php

namespace Database\Seeders;

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
        $this->call([
            BrandSeeder::class,
            ModelVehicleSeeder::class,
            ColorSeeder::class,
            WorkshopSeeder::class,
            RepairCategorySeeder::class,
            RepairSubCategorySeeder::class,
            RolSeeder::class,
            UserSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\RepairCategory;
use Illuminate\Database\Seeder;

class RepairCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (RepairCategory::count()) {
            return;
        }

        $categories = [
            ['name' => 'Carrocería'],
            ['name' => 'Vidrios'],
            ['name' => 'Suspensión'],
            ['name' => 'Interior'],
            ['name' => 'Detailing'],
        ];

        // insertar categorias
        foreach ($categories as $category) {
            RepairCategory::create($category);
        }
    }
}

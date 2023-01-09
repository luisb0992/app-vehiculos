<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Brand::count()) {
            return;
        }

        Brand::insert([
            ['name' => 'ACURA'],
            ['name' => 'HONDA'],
            ['name' => 'GEELY'],
        ]);
    }
}

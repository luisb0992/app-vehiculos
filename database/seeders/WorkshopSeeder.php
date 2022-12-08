<?php

namespace Database\Seeders;

use App\Models\Workshop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkshopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Workshop::count()) {
            return;
        }

        $workshops = [
            ['name' => 'CEDAUTO'],
            ['name' => 'TRUCK SERVICE'],
            ['name' => 'WHITE GLOVE'],
            ['name' => 'PRETTY CAR SHOP'],
            ['name' => 'AUTO COLLOR'],
            ['name' => 'ROLANDO MUÑOZ'],
        ];

        // insertar los talleres
        foreach ($workshops as $workshop) {
            Workshop::create($workshop);
        }
    }
}

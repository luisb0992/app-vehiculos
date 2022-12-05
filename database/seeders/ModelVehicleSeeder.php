<?php

namespace Database\Seeders;

use App\Models\ModelVehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModelVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ModelVehicle::count()) {
            return;
        }

        // insertar todos los modelos de vehículos de todas las marcas
        // agregadas en BrandSeeder, solo 2 modelos por marca
        ModelVehicle::insert([
            ['name' => '500', 'brand_id' => 1],
            ['name' => '595', 'brand_id' => 1],
            ['name' => 'ILX', 'brand_id' => 2],
            ['name' => 'MDX', 'brand_id' => 2],
            ['name' => '4C', 'brand_id' => 3],
            ['name' => 'Giulia', 'brand_id' => 3],
            ['name' => 'B3', 'brand_id' => 4],
            ['name' => 'B5', 'brand_id' => 4],
            ['name' => 'A110', 'brand_id' => 5],
            ['name' => 'A310', 'brand_id' => 5],
            ['name' => 'DB11', 'brand_id' => 6],
            ['name' => 'DBS', 'brand_id' => 6],
            ['name' => 'A1', 'brand_id' => 7],
            ['name' => 'A3', 'brand_id' => 7],
            ['name' => 'Mini', 'brand_id' => 8],
            ['name' => 'Mini Cooper', 'brand_id' => 8],
            ['name' => 'Arnage', 'brand_id' => 9],
            ['name' => 'Azure', 'brand_id' => 9],
            ['name' => 'Serie 1', 'brand_id' => 10],
            ['name' => 'Serie 3', 'brand_id' => 10],
            ['name' => 'Chiron', 'brand_id' => 11],
            ['name' => 'Veyron', 'brand_id' => 11],
            ['name' => 'ATS', 'brand_id' => 12],
            ['name' => 'CT6', 'brand_id' => 12],
            ['name' => '7', 'brand_id' => 13],
            ['name' => 'Roadster', 'brand_id' => 13],
            ['name' => 'Aveo', 'brand_id' => 14],
            ['name' => 'Camaro', 'brand_id' => 14],
            ['name' => '300', 'brand_id' => 15],
            ['name' => 'P 100', 'brand_id' => 15],
            ['name' => 'C3', 'brand_id' => 16],
            ['name' => 'C4', 'brand_id' => 16],
            ['name' => 'C8', 'brand_id' => 17],
            ['name' => 'C8 Spyder', 'brand_id' => 17],
            ['name' => 'Duster', 'brand_id' => 18],
            ['name' => 'Logan', 'brand_id' => 18],
            ['name' => 'Cuore', 'brand_id' => 19],
            ['name' => 'Sirion', 'brand_id' => 19],
            ['name' => 'Challenger', 'brand_id' => 20],
            ['name' => 'Charger', 'brand_id' => 20],
            ['name' => '4', 'brand_id' => 21],
            ['name' => '5', 'brand_id' => 21],
            ['name' => 'F8', 'brand_id' => 22],
            ['name' => 'F12', 'brand_id' => 22],
            ['name' => '500', 'brand_id' => 23],
            ['name' => 'Punto', 'brand_id' => 23],
            ['name' => 'Karma', 'brand_id' => 24],
            ['name' => 'Reventón', 'brand_id' => 24],
            ['name' => 'Fiesta', 'brand_id' => 25],
            ['name' => 'Focus', 'brand_id' => 25],
            ['name' => 'Accord', 'brand_id' => 26],
            ['name' => 'Civic', 'brand_id' => 26],
            ['name' => 'H2', 'brand_id' => 27],
            ['name' => 'H3', 'brand_id' => 27],
            ['name' => 'Accent', 'brand_id' => 28],
            ['name' => 'Elantra', 'brand_id' => 28],
            ['name' => 'EX', 'brand_id' => 29],
            ['name' => 'FX', 'brand_id' => 29],
            ['name' => 'Amigo', 'brand_id' => 30],
            ['name' => 'Hombre', 'brand_id' => 30],
            ['name' => 'A3', 'brand_id' => 31],
            ['name' => 'A4', 'brand_id' => 31],
            ['name' => 'A6', 'brand_id' => 32],
            ['name' => 'A8', 'brand_id' => 32],
            ['name' => 'Astra', 'brand_id' => 33],
            ['name' => 'Corsa', 'brand_id' => 33],
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\ModelVehicle;
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

            // marca acura
            ['name' => 'ILX', 'brand_id' => 1],
            ['name' => 'INTEGRA', 'brand_id' => 1],
            ['name' => 'MDX', 'brand_id' => 1],
            ['name' => 'NSX', 'brand_id' => 1],
            ['name' => 'RDX', 'brand_id' => 1],
            ['name' => 'RLX', 'brand_id' => 1],
            ['name' => 'TL', 'brand_id' => 1],
            ['name' => 'TLX', 'brand_id' => 1],

            // marca honda
            ['name' => 'ACCORD', 'brand_id' => 2],
            ['name' => 'ACCORD COUPE', 'brand_id' => 2],
            ['name' => 'ACCORD S/WAGON', 'brand_id' => 2],
            ['name' => 'BIG RED', 'brand_id' => 2],
            ['name' => 'C90CWV', 'brand_id' => 2],
            ['name' => 'CB', 'brand_id' => 2],
            ['name' => 'CB190R', 'brand_id' => 2],
            ['name' => 'CB250 TWISTER', 'brand_id' => 2],
            ['name' => 'CBF', 'brand_id' => 2],
            ['name' => 'CBX', 'brand_id' => 2],
            ['name' => 'CG', 'brand_id' => 2],
            ['name' => 'CGL', 'brand_id' => 2],
            ['name' => 'CITY', 'brand_id' => 2],
            ['name' => 'CIVIC', 'brand_id' => 2],
            ['name' => 'CIVIC COUPE', 'brand_id' => 2],
            ['name' => 'CIVIC HATCHBACK', 'brand_id' => 2],
            ['name' => 'CR', 'brand_id' => 2],
            ['name' => 'CRF', 'brand_id' => 2],
            ['name' => 'CROSSRUNNER', 'brand_id' => 2],
            ['name' => 'CROSSTOUR', 'brand_id' => 2],
            ['name' => 'CRV', 'brand_id' => 2],
            ['name' => 'CRX', 'brand_id' => 2],
            ['name' => 'CTX', 'brand_id' => 2],
            ['name' => 'ELITE', 'brand_id' => 2],
            ['name' => 'FIT', 'brand_id' => 2],
            ['name' => 'FJS', 'brand_id' => 2],
            ['name' => 'FOURWHEEL', 'brand_id' => 2],
            ['name' => 'FSC', 'brand_id' => 2],
            ['name' => 'GL', 'brand_id' => 2],
            ['name' => 'GL150', 'brand_id' => 2],
            ['name' => 'HONDA TALON D', 'brand_id' => 2],
            ['name' => 'HONDA TALON R', 'brand_id' => 2],
            ['name' => 'HONDA TALON X', 'brand_id' => 2],
            ['name' => 'HRV', 'brand_id' => 2],
            ['name' => 'INSIGHT', 'brand_id' => 2],
            ['name' => 'INTEGRA', 'brand_id' => 2],
            ['name' => 'LEGEND', 'brand_id' => 2],
            ['name' => 'MAGNA', 'brand_id' => 2],
            ['name' => 'MOTO', 'brand_id' => 2],
            ['name' => 'MUV7009', 'brand_id' => 2],
            ['name' => 'NAVI110', 'brand_id' => 2],
            ['name' => 'NC', 'brand_id' => 2],
            ['name' => 'NSR', 'brand_id' => 2],
            ['name' => 'NSX', 'brand_id' => 2],
            ['name' => 'NX4FALCON', 'brand_id' => 2],
            ['name' => 'NXR', 'brand_id' => 2],
            ['name' => 'ODYSSEY', 'brand_id' => 2],
            ['name' => 'OTROS MODELOS', 'brand_id' => 2],
            ['name' => 'PASSPORT', 'brand_id' => 2],
            ['name' => 'PILOT', 'brand_id' => 2],
            ['name' => 'PIONEER', 'brand_id' => 2],
            ['name' => 'PIONEER 1000', 'brand_id' => 2],
            ['name' => 'PRELUDE', 'brand_id' => 2],
            ['name' => 'REBEL', 'brand_id' => 2],
            ['name' => 'RIDGELINE', 'brand_id' => 2],
            ['name' => 'SHADOW', 'brand_id' => 2],
            ['name' => 'SXS700', 'brand_id' => 2],
            ['name' => 'TALON', 'brand_id' => 2],
            ['name' => 'TALON R', 'brand_id' => 2],
            ['name' => 'TRX', 'brand_id' => 2],
            ['name' => 'TRX250TE1N', 'brand_id' => 2],
            ['name' => 'TRX420FE', 'brand_id' => 2],
            ['name' => 'TRX420FM2N', 'brand_id' => 2],
            ['name' => 'TRX520FA7L', 'brand_id' => 2],
            ['name' => 'TRX520FA7P', 'brand_id' => 2],
            ['name' => 'TRX520FE2L', 'brand_id' => 2],
            ['name' => 'TRX520FM6P', 'brand_id' => 2],
            ['name' => 'VIGOR', 'brand_id' => 2],
            ['name' => 'VTR', 'brand_id' => 2],
            ['name' => 'XL', 'brand_id' => 2],
            ['name' => 'XLR', 'brand_id' => 2],
            ['name' => 'XR', 'brand_id' => 2],
            ['name' => 'XR150', 'brand_id' => 2],
            ['name' => 'XR250 TORNADO', 'brand_id' => 2],
            ['name' => 'XRE190', 'brand_id' => 2],
            ['name' => 'XRE300', 'brand_id' => 2],
            ['name' => 'XRV', 'brand_id' => 2],

            // marca GEELY
            ['name' => 'AZKARRA', 'brand_id' => 3],
            ['name' => 'COOLRAY', 'brand_id' => 3],
            ['name' => 'GEOMETRY', 'brand_id' => 3],
            ['name' => 'TUGELLA', 'brand_id' => 3],
        ]);
    }
}

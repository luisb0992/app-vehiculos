<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // listado de todas las marcas de vehículos +100
        Brand::insert([
            ['name' => 'Abarth'],
            ['name' => 'Acura'],
            ['name' => 'Alfa Romeo'],
            ['name' => 'Alpina'],
            ['name' => 'Alpine'],
            ['name' => 'Aston Martin'],
            ['name' => 'Audi'],
            ['name' => 'Austin'],
            ['name' => 'Bentley'],
            ['name' => 'BMW'],
            ['name' => 'Bugatti'],
            ['name' => 'Cadillac'],
            ['name' => 'Caterham'],
            ['name' => 'Chevrolet'],
            ['name' => 'Chrysler'],
            ['name' => 'Citroën'],
            ['name' => 'Corvette'],
            ['name' => 'Dacia'],
            ['name' => 'Daewoo'],
            ['name' => 'Daihatsu'],
            ['name' => 'Dodge'],
            ['name' => 'DS'],
            ['name' => 'Ferrari'],
            ['name' => 'Fiat'],
            ['name' => 'Fisker'],
            ['name' => 'Ford'],
            ['name' => 'Honda'],
            ['name' => 'Hummer'],
            ['name' => 'Hyundai'],
            ['name' => 'Infiniti'],
            ['name' => 'Isuzu'],
            ['name' => 'Iveco'],
            ['name' => 'Jaguar'],
            ['name' => 'Jeep'],
            ['name' => 'Kia'],
            ['name' => 'KTM'],
            ['name' => 'Lada'],
            ['name' => 'Lamborghini'],
            ['name' => 'Lancia'],
            ['name' => 'Land Rover'],
            ['name' => 'Landwind'],
            ['name' => 'Lexus'],
            ['name' => 'Ligier'],
            ['name' => 'Lincoln'],
            ['name' => 'Lotus'],
            ['name' => 'Mahindra'],
            ['name' => 'Maserati'],
            ['name' => 'Maybach'],
            ['name' => 'Mazda'],
            ['name' => 'McLaren'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'MG'],
            ['name' => 'Mini'],
            ['name' => 'Mits'],
            ['name' => 'Mitsubishi'],
            ['name' => 'Morgan'],
            ['name' => 'Nissan'],
            ['name' => 'Opel'],
            ['name' => 'Peugeot'],
            ['name' => 'Porsche'],
            ['name' => 'Proton'],
            ['name' => 'Renault'],
            ['name' => 'Rolls-Royce'],
            ['name' => 'Rover'],
            ['name' => 'Saab'],
            ['name' => 'Seat'],
            ['name' => 'Skoda'],
            ['name' => 'Smart'],
            ['name' => 'SsangYong'],
            ['name' => 'Subaru'],
            ['name' => 'Suzuki'],
            ['name' => 'Tata'],
            ['name' => 'Tesla'],
            ['name' => 'Toyota'],
            ['name' => 'Volkswagen'],
            ['name' => 'Volvo'],
            ['name' => 'Wiesmann'],
            ['name' => 'Zastava'],
            ['name' => 'Zotye'],
            ['name' => 'ZX Auto'],
        ]);
    }
}

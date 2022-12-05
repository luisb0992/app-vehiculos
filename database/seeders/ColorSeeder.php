<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Color::count()) {
            return;
        }

        // listado de todos los colores,solo los mas comunes
        Color::insert([
            ['name' => 'Blanco'],
            ['name' => 'Azul'],
            ['name' => 'Rojo'],
            ['name' => 'Verde'],
            ['name' => 'Amarillo'],
            ['name' => 'Naranja'],
            ['name' => 'Marrón'],
            ['name' => 'Gris'],
            ['name' => 'Plateado'],
            ['name' => 'Dorado'],
            ['name' => 'Purpura'],
            ['name' => 'Café'],
            ['name' => 'Negro'],
            ['name' => 'Rosa'],
            ['name' => 'Beige'],
            ['name' => 'Cían'],
            ['name' => 'Lila'],
            ['name' => 'Turquesa'],
            ['name' => 'Bronce'],
            ['name' => 'Fucsia'],
            ['name' => 'Lima'],
            ['name' => 'Magenta'],
            ['name' => 'Mandarina'],
            ['name' => 'Marfil'],
            ['name' => 'Menta'],
            ['name' => 'Mostaza'],
            ['name' => 'Ocre'],
            ['name' => 'Salmon'],
            ['name' => 'Topacio'],
            ['name' => 'Violeta'],
            ['name' => 'Zafiro'],
        ]);
    }
}

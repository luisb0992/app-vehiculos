<?php

namespace Database\Seeders;

use App\Models\RepairSubCategory;
use Illuminate\Database\Seeder;

class RepairSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (RepairSubCategory::count()) {
            return;
        }

        $subcategories = [

            // carrocería
            ['name' => 'DEFENSA DELANTERA', 'repair_category_id' => 1],
            ['name' => 'TAPA DE MOTOR', 'repair_category_id' => 1],
            ['name' => 'LAMPARA DELANTERA DERECHA', 'repair_category_id' => 1],
            ['name' => 'GUARDAFANGO DELANTERO DERECHO', 'repair_category_id' => 1],
            ['name' => 'PUERTA DELANTARA DERECHA', 'repair_category_id' => 1],
            ['name' => 'RETROVISOR DERECHO', 'repair_category_id' => 1],
            ['name' => 'MARCO DE PUERTA DELANTERA DERECHA', 'repair_category_id' => 1],
            ['name' => 'ROLLING DELANTERO DERECHO', 'repair_category_id' => 1],
            ['name' => 'PARAL DE LAS PUERTAS LADO DERECHO', 'repair_category_id' => 1],
            ['name' => 'PUERTA TRASERA DERECHA', 'repair_category_id' => 1],
            ['name' => 'MARCO DE PUERTA TRASERA DERECHA', 'repair_category_id' => 1],
            ['name' => 'ROLLIN TRASERO DERECHO', 'repair_category_id' => 1],
            ['name' => 'GUARDAFANGO TRASERO DERECHO', 'repair_category_id' => 1],
            ['name' => 'LAMPARA TRASERA DERECHA', 'repair_category_id' => 1],
            ['name' => 'DEFENSA TRASERA', 'repair_category_id' => 1],
            ['name' => 'TAPA DE MALATERO', 'repair_category_id' => 1],
            ['name' => 'SPOILER TRASERO', 'repair_category_id' => 1],
            ['name' => 'ANTENA', 'repair_category_id' => 1],
            ['name' => 'TECHO', 'repair_category_id' => 1],
            ['name' => 'LAMPARA TRASERA IZQUIERDA', 'repair_category_id' => 1],
            ['name' => 'GUARDAFANGO TRASERO IZQUIERDO', 'repair_category_id' => 1],
            ['name' => 'PUERTA TRASERA IZQUIERDA', 'repair_category_id' => 1],
            ['name' => 'MARCO DE PUERTA TRASERA IZQUIERDA', 'repair_category_id' => 1],
            ['name' => 'ROLLIN TRASERO IZQUIERDO', 'repair_category_id' => 1],
            ['name' => 'PARAL DE LAS PUERTAS LADO IZQUIERDO', 'repair_category_id' => 1],
            ['name' => 'PUERTA DELANTERA IZQUIERDA', 'repair_category_id' => 1],
            ['name' => 'MARCO DE PUERTA DELANTERA IZQUIERDA', 'repair_category_id' => 1],
            ['name' => 'ROLLIN DELANTERO IZQUIERDO', 'repair_category_id' => 1],
            ['name' => 'GUARDAFANGO DELANTERO IZQUIERDO', 'repair_category_id' => 1],
            ['name' => 'LAMPARA DELANTERA IZQUIERDA', 'repair_category_id' => 1],

            // vidrios
            ['name' => 'PARABRISAS DELANTERO', 'repair_category_id' => 2],
            ['name' => 'VENTANA DELANTERA DERECHA', 'repair_category_id' => 2],
            ['name' => 'VENTANA TRASERA DERECHA', 'repair_category_id' => 2],
            ['name' => 'VIDRIO FIJO DERECHO', 'repair_category_id' => 2],
            ['name' => 'PARABRISAS TRASERO', 'repair_category_id' => 2],
            ['name' => 'VIDRIO FIJO IZQUIERDO', 'repair_category_id' => 2],
            ['name' => 'VENTANA TRASERA IZQUIERDA', 'repair_category_id' => 2],
            ['name' => 'VENTANA DELANTERA IZQUIERDA', 'repair_category_id' => 2],

            // suspensión
            ['name' => 'LLANTAS DELANTERA DERECHA', 'repair_category_id' => 3],
            ['name' => 'RIN DELANTERO DERECHO', 'repair_category_id' => 3],
            ['name' => 'LLANTA TRASERA DERECHA', 'repair_category_id' => 3],
            ['name' => 'RIN TRASERO DERECHO', 'repair_category_id' => 3],
            ['name' => 'LLANTA TRASERA  IZQUIERDA', 'repair_category_id' => 3],
            ['name' => 'RIN TRASERO IZQUIERDO', 'repair_category_id' => 3],
            ['name' => 'LLANTA DELANTERA IZQUIERDA', 'repair_category_id' => 3],
            ['name' => 'RIN DELANTERO IZQUIERDO', 'repair_category_id' => 3],

            // interior
            ['name' => 'TECHO', 'repair_category_id' => 4],
            ['name' => 'SUN ROOF', 'repair_category_id' => 4],
            ['name' => 'TABLERO', 'repair_category_id' => 4],
            ['name' => 'CONSOLA CENTRAL', 'repair_category_id' => 4],
            ['name' => 'SILLÓN DELANTERO DERECHO', 'repair_category_id' => 4],
            ['name' => 'SILLONES TRASEROS SEGUNDA FILA', 'repair_category_id' => 4],
            ['name' => 'SILLONES TRASEROS TERCERA FILA', 'repair_category_id' => 4],
            ['name' => 'SILLÓN DELANTERO IZQUIERDO', 'repair_category_id' => 4],
            ['name' => 'CINTURÓN DE SEGURIDAD', 'repair_category_id' => 4],
            ['name' => 'RADIO', 'repair_category_id' => 4],
            ['name' => 'TIMÓN', 'repair_category_id' => 4],
            ['name' => 'PALANCA DE CAMBIO', 'repair_category_id' => 4],
            ['name' => 'MANIGUETA', 'repair_category_id' => 4],
            ['name' => 'AREA DE IGNICIÓN CON LLAVE', 'repair_category_id' => 4],
            ['name' => 'COVER PUERTA DELANTERA DERECHA', 'repair_category_id' => 4],
            ['name' => 'COVER PUERTA TRASERA DERECHA', 'repair_category_id' => 4],
            ['name' => 'COVER PLÁSTICO DE TAPA DEL MALETERO', 'repair_category_id' => 4],
            ['name' => 'COVER DEL COSTADO DERECHO', 'repair_category_id' => 4],
            ['name' => 'COVER DEL COSTADO IZQUIERDO', 'repair_category_id' => 4],
            ['name' => 'COVER DE PUERTA TRASERA IZQUIERDA', 'repair_category_id' => 4],
            ['name' => 'COVER DE PUERTA DELANTERA IZQUIERDA', 'repair_category_id' => 4],

            // detailing
            ['name' => 'PULIMIENTO COMPLETO', 'repair_category_id' => 5],
            ['name' => 'PULIMIENTO PIEZA CHICA', 'repair_category_id' => 5],
            ['name' => 'PULIMIENTO PIEZA MEDIANA', 'repair_category_id' => 5],
            ['name' => 'PULIMIENTO PIEZA GRANDE', 'repair_category_id' => 5],
            ['name' => 'LIMPIEZA DE INTERIORES', 'repair_category_id' => 5],
            ['name' => 'LAVADO DE MOTOR', 'repair_category_id' => 5],
        ];

        foreach ($subcategories as $repairCategory) {
            RepairSubCategory::create($repairCategory);
        }
    }
}

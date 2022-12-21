<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Rol::count()) {
            return;
        }

        $roles = [
            ['name' => 'SuperAdmin'],
            ['name' => 'Registrador'],
            ['name' => 'Supervisor'],
            ['name' => 'Proveedor'],
        ];

        // insertar categorias
        foreach ($roles as $r) {
            Rol::create($r);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'SuperAdmin',
                'email' =>'superadmin@gmail.com',
                'dni' => '123456',
                'last_name' => 'Root',
                'email_verified_at' => now(),
                'rol_id' => 1,
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Registrador',
                'email' =>'registrador@gmail.com',
                'dni' => '123456',
                'last_name' => 'Data',
                'email_verified_at' => now(),
                'rol_id' => 2,
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Supervisor',
                'email' =>'supervisor@gmail.com',
                'dni' => '123456',
                'last_name' => 'Reportes',
                'email_verified_at' => now(),
                'rol_id' => 3,
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Proveedor',
                'email' =>'proveedor@gmail.com',
                'dni' => '123456',
                'last_name' => 'Taller',
                'email_verified_at' => now(),
                'workshop_id' => 1,
                'rol_id' => 4, //proveedor / taller
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ]
        ];

        if (User::count()) {
            return;
        }

        foreach ($users as $u) {
            User::create($u);
        }
    }
}

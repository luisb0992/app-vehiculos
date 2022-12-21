<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'name' => fake()->name(),
                'email' =>'dev@gmail.com',
                'dni' => '123456',
                'last_name' => 'SuperAdmin',
                'email_verified_at' => now(),
                'workshop_id' => 1,
                'rol_id' => 1,
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ],
            [
                'name' => fake()->name(),
                'email' =>'registrador@gmail.com',
                'dni' => '123456',
                'last_name' => 'Registrador',
                'email_verified_at' => now(),
                'workshop_id' => 1,
                'rol_id' => 2,
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ],
            [
                'name' => fake()->name(),
                'email' =>'supervisor@gmail.com',
                'dni' => '123456',
                'last_name' => 'Supervisor',
                'email_verified_at' => now(),
                'workshop_id' => 1,
                'rol_id' => 3,
                'password' => 'password', // password
                'remember_token' => Str::random(10),
            ],
            [
                'name' => fake()->name(),
                'email' =>'proveedor@gmail.com',
                'dni' => '123456',
                'last_name' => 'Proveedor',
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\Rol;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $rol = Rol::create([
        //     'name' => 'Employee'
        // ]);

        // DB::table('users')->insert([
        //     'name' => 'Employee',
        //     'email' =>'employee@gmail.com',
        //     'dni' => '123456',
        //     'last_name' => 'Employee',
        //     'email_verified_at' => now(),
        //     'rol_id' => $rol->id,
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

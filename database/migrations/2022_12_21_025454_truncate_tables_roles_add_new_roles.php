<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET foreign_key_checks=0");
        Rol::truncate();
        DB::statement("SET foreign_key_checks=1");
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

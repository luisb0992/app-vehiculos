<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repair_vehicle_categories', function (Blueprint $table) {
            $table->boolean('warranty')->default(false)->after('repair_order_id');
            $table->boolean('dock')->default(false)->after('warranty');

            // remover columna vehicle_id
            $table->dropColumn('vehicle_id');
        });

        // remover columnas warranty, dock, bills, observation de la tabla repair_orders
        Schema::table('repair_orders', function (Blueprint $table) {
            $table->dropColumn('warranty');
            $table->dropColumn('dock');
            $table->dropColumn('bills');
            $table->dropColumn('observation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repair_vehicle_categories', function (Blueprint $table) {
            $table->dropColumn('warranty');
            $table->dropColumn('dock');

            // agregar columna vehicle_id
            $table->unsignedBigInteger('vehicle_id')->after('repair_order_id');
        });

        // agregar columnas warranty, dock, bills, observation de la tabla repair_orders
        Schema::table('repair_orders', function (Blueprint $table) {
            $table->boolean('warranty')->default(false)->after('send_date');
            $table->boolean('dock')->default(false)->after('warranty');
            $table->boolean('bills')->default(false)->after('dock');
            $table->text('observation')->nullable()->after('bills');
        });
    }
};

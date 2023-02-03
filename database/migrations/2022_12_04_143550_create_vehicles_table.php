<?php

use App\Enum\StatusVehicleEnum;
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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('model_id');
            $table->unsignedBigInteger('color_id');
            $table->string('chassis_number');
            $table->unsignedInteger('year');
            $table->string('mileage')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->text('observation')->nullable();

            // status
            $table->tinyInteger('status')->default(StatusVehicleEnum::ADD)
                ->comment('1: disponible, 2: pendiente, 3: en mantenimiento, 4: reparado, 5: eliminado');

            // softdelete
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
};

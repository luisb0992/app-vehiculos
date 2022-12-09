<?php

use App\Enum\StatusRepairOrderEnum;
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
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('workshop_id');
            $table->string('warranty')->nullable();
            $table->string('dock')->nullable();
            $table->string('bills')->nullable();
            $table->date('send_date')->nullable();
            $table->text('observation')->nullable();
            $table->tinyInteger('status')->default(StatusRepairOrderEnum::OPEN);

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
        Schema::dropIfExists('repair_orders');
    }
};

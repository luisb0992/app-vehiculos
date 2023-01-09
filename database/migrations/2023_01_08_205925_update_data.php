<?php

use App\Models\Brand;
use App\Models\Color;
use App\Models\GalleryVehicle;
use App\Models\ModelVehicle;
use App\Models\Quotation;
use App\Models\RepairOrder;
use App\Models\RepairVehicleCategory;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Models\Activity;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // vaciar tabla Vehiculos
        Vehicle::truncate();

        // vaciar galeria del vehículo
        GalleryVehicle::truncate();

        // vaciar tabla ordenes de reparación
        RepairOrder::truncate();

        // Vaciar tabla de cotizaciones
        Quotation::truncate();

        // vaciar tabla pivote de Vehiculos y categorias
        RepairVehicleCategory::truncate();

        // vaciar tablas marca y modelo
        Brand::truncate();
        ModelVehicle::truncate();

        // vaciar tabla de colores
        Color::truncate();

        // limpiar tabla usuarios
        User::truncate();

        // limpiar bitácora
        Activity::truncate();
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

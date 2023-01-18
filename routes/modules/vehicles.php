<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix vehicles
Route::middleware(['auth', 'is_superadmin_or_recorder'])
  ->prefix('vehicles')
  ->group(function () {

    // listar vehiculos
    Route::get('index', [VehicleController::class, 'index'])
      ->name('vehicle.index');

    // crear vehículo
    Route::get('create', [VehicleController::class, 'create'])
      ->name('vehicle.create');

    // guardar vehículo
    Route::post('store', [VehicleController::class, 'store'])
      ->name('vehicle.store');

    // solicitar reparación
    Route::get('repair/{id}', [VehicleController::class, 'repair'])
      ->name('vehicle.repair');

    // guardar datos de reparación
    Route::post('store-repair', [VehicleController::class, 'storeRepair'])
      ->name('vehicle.store.repair');

  });

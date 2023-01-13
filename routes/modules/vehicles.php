<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix vehicles
Route::middleware('auth')->prefix('vehicles')->group(function () {

  // crear vehículo
  Route::get('index', [VehicleController::class, 'index'])
    ->name('vehicle.index');

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

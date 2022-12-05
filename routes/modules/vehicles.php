<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix vehicles
Route::middleware('auth')->prefix('vehicles')->group(function () {
  Route::get('create', [VehicleController::class, 'create'])
    ->name('vehicle.create');

  Route::post('store', [VehicleController::class, 'store'])
    ->name('vehicle.store');
});

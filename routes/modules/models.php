<?php

use App\Http\Controllers\ModelVehicleController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix models
Route::middleware('auth')->prefix('models')->group(function () {

  // guardar un modelo asociado a una marca
  Route::post('store', [ModelVehicleController::class, 'store'])
    ->name('models.store');
});

<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix brands
Route::middleware(['auth', 'is_superadmin_or_recorder'])->prefix('external_api')->group(function () {

  // guardar un marca
  Route::post('search', [ApiController::class, 'searchVehicle'])
    ->name('external_api.search.vehicle');
});

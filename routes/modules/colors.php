<?php

use App\Http\Controllers\ColorController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix colors
Route::middleware(['auth', 'is_recorder'])->prefix('colors')->group(function () {

  // guardar un nuevo color
  Route::post('store', [ColorController::class, 'store'])
    ->name('colors.vehicle.store');
});

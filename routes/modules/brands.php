<?php

use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;

// rutas con middleware auth y prefix brands
Route::middleware(['auth', 'is_recorder'])->prefix('brands')->group(function () {

  // guardar un marca
  Route::post('store', [BrandController::class, 'store'])
    ->name('brands.store');
});

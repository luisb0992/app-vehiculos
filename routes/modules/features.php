<?php

use App\Http\Controllers\Vehicle\BrandController;
use App\Http\Controllers\Vehicle\ColorsController;
use App\Http\Controllers\Vehicle\ModelsController;
use Illuminate\Support\Facades\Route;

Route::name('utils.')
  ->middleware(['auth', 'is_superadmin'])
  ->prefix('utils')
  ->group(function () {
    Route::resource('colors', ColorsController::class);
    Route::resource('models', ModelsController::class);
    Route::resource('brands', BrandController::class);
  });

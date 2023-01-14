<?php

use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_superadmin'])
  ->prefix('rol')
  ->group(function () {
    Route::resource('roles', RolController::class);
  });

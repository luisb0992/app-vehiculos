<?php

use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'is_superadmin'])
    ->prefix('workshop')
    ->group(function () {
        Route::resource('workshops', WorkshopController::class);
    });
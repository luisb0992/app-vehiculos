<?php

use App\Http\Controllers\{RolController,WorkshopController};
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('rol')->group(function () {
    Route::resource('roles', RolController::class);
    Route::resource('workshops', WorkshopController::class);
});

Route::middleware('auth')->prefix('workshop')->group(function () {
    Route::resource('workshops', WorkshopController::class);
});


require __DIR__ . '/modules/profile.php';

require __DIR__ . '/modules/auth.php';

require __DIR__ . '/modules/vehicles.php';

require __DIR__ . '/modules/brands.php';

require __DIR__ . '/modules/models.php';

require __DIR__ . '/modules/colors.php';

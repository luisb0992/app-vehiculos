<?php

use App\Http\Controllers\{ActivityLogController, RolController, WorkshopController};
use App\Http\Controllers\Vehicle\{ColorsController, ModelsController, BrandController};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/dashboard', fn () => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('rol')->group(function () {
    Route::resource('roles', RolController::class);
});

Route::middleware('auth')->prefix('workshop')->group(function () {
    Route::resource('workshops', WorkshopController::class);
});

Route::name('utils.')->middleware('auth')->prefix('utils')->group(function () {
    Route::resource('colors', ColorsController::class);
    Route::resource('models', ModelsController::class);
    Route::resource('brands', BrandController::class);
});

Route::name('logs.')->middleware('auth')->prefix('logs')->group(function () {
    Route::get('log-activity', [ActivityLogController::class, 'index'])
        ->name('index');

    //export to PDF
    Route::get('log-activity/pdf', [ActivityLogController::class, 'downloadPDF'])->name('pdf');
     //export to excel
     Route::get('log-activity/excel', [ActivityLogController::class, 'downloadEXCEL'])->name('excel');
});

require __DIR__ . '/modules/profile.php';

require __DIR__ . '/modules/auth.php';

require __DIR__ . '/modules/vehicles.php';

require __DIR__ . '/modules/brands.php';

require __DIR__ . '/modules/models.php';

require __DIR__ . '/modules/colors.php';

require __DIR__ . '/modules/workshop_quotes.php';

require __DIR__ . '/modules/utils.php';

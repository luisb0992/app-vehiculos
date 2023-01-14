<?php

use App\Http\Controllers\{ActivityLogController, RolController, WorkshopController};
use App\Http\Controllers\Vehicle\{ColorsController, ModelsController, BrandController,ReportsVehicleController};
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

Route::name('reports.')->middleware('auth')->prefix('reports')->group(function () {
    // reports view
    Route::get('index', [ReportsVehicleController::class, 'index'])
    ->name('reports');

    // request reports
    Route::post('index', [ReportsVehicleController::class, 'queryReports'])
    ->name('post');

    //pdf reports vehicle
    Route::get('reports/pdf', [ReportsVehicleController::class, 'downloadPDF'])->name('pdf');

    //excel vehicle
    Route::get('reports/excel', [ReportsVehicleController::class, 'downloadEXCEL'])->name('excel');

    Route::post('brands/models', [ReportsVehicleController::class, 'modelsByBrands'])->name('brands.models');
});

require __DIR__ . '/modules/profile.php';

require __DIR__ . '/modules/auth.php';

require __DIR__ . '/modules/vehicles.php';

require __DIR__ . '/modules/brands.php';

require __DIR__ . '/modules/models.php';

require __DIR__ . '/modules/colors.php';

require __DIR__ . '/modules/workshop_quotes.php';

require __DIR__ . '/modules/utils.php';

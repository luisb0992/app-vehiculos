<?php

use App\Http\Controllers\Vehicle\ReportsVehicleController;
use Illuminate\Support\Facades\Route;

// TODO: @Simoleans agrega el middleware para que el admin y el usuario supervisor puedan verlos
Route::name('reports.')
    ->middleware('auth')
    ->prefix('reports')
    ->group(function () {
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

        Route::get('vehicle/reports/{id}', [ReportsVehicleController::class, 'printPDFVehicleByID'])->name('vehicle.pdf');
    });

require __DIR__ . '/modules/profile.php';

require __DIR__ . '/modules/auth.php';

require __DIR__ . '/modules/vehicles.php';

require __DIR__ . '/modules/brands.php';

require __DIR__ . '/modules/models.php';

require __DIR__ . '/modules/colors.php';

require __DIR__ . '/modules/workshop_quotes.php';

require __DIR__ . '/modules/workshops.php';

require __DIR__ . '/modules/roles.php';

require __DIR__ . '/modules/features.php';

require __DIR__ . '/modules/logs.php';

require __DIR__ . '/modules/artisan.php';

require __DIR__ . '/modules/api.php';
